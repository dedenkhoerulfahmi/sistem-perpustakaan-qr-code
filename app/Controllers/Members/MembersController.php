<?php

namespace App\Controllers\Members;

use App\Libraries\QRGenerator;
use App\Models\BookModel;
use App\Models\BookStockModel;
use App\Models\FineModel;
use App\Models\LoanModel;
use App\Models\MemberModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;

class MembersController extends ResourceController
{
    protected MemberModel $memberModel;
    protected BookModel $bookModel;
    protected BookStockModel $bookStockModel;
    protected LoanModel $loanModel;
    protected FineModel $fineModel;

    public function __construct()
    {
        $this->memberModel    = new MemberModel();
        $this->bookModel      = new BookModel();
        $this->bookStockModel = new BookStockModel();
        $this->loanModel      = new LoanModel();
        $this->fineModel      = new FineModel();

        helper('upload');
    }

    public function index()
    {
        $itemPerPage = 20;

        if ($this->request->getGet('search')) {
            $keyword = $this->request->getGet('search');
            $members = $this->memberModel
                ->like('first_name', $keyword, insensitiveSearch: true)
                ->orLike('kelas', $keyword, insensitiveSearch: true)
                ->orLike('jurusan', $keyword, insensitiveSearch: true)
                ->orLike('nomor_induk', $keyword, insensitiveSearch: true)
                ->paginate($itemPerPage, 'members');

            $members = array_filter($members, fn($m) => $m['deleted_at'] === null);
        } else {
            $members = $this->memberModel->paginate($itemPerPage, 'members');
        }

        $teachers = (new \App\Models\TeacherModel())->findAll();

        return view('members/index', [
            'members'     => $members,
            'teachers'    => $teachers,
            'pager'       => $this->memberModel->pager,
            'currentPage' => $this->request->getVar('page_categories') ?? 1,
            'itemPerPage' => $itemPerPage,
            'search'      => $this->request->getGet('search'),
            'activeTab'   => 'siswa',
        ]);
    }

    public function show($uid = null)
    {
        $member = $this->memberModel->where('uid', $uid)->first();
        if (!$member) {
            throw new PageNotFoundException('Member not found');
        }

        $loans = $this->loanModel->where([
            'member_id'   => $member['id'],
            'return_date' => null,
        ])->findAll();

        $fines = $this->loanModel
            ->select('loans.id, fines.amount_paid, fines.fine_amount, fines.paid_at')
            ->join('fines', 'loans.id=fines.loan_id', 'LEFT')
            ->where('member_id', $member['id'])
            ->findAll();

        $totalBooksLent = empty($loans)
            ? 0
            : array_sum(array_column($loans, 'quantity'));

        $return    = array_filter($loans, fn($l) => $l['return_date'] !== null);
        $lateLoans = array_filter($loans, fn($l) =>
            $l['return_date'] === null && Time::now()->isAfter(Time::parse($l['due_date']))
        );

        $totalFines = array_sum(array_column($fines, 'fine_amount'));
        $paidFines  = array_sum(array_column($fines, 'amount_paid'));
        $unpaidFines = $totalFines - $paidFines;

        if (!file_exists(MEMBERS_QR_CODE_PATH . $member['qr_code']) || empty($member['qr_code'])) {
            $qrGenerator = new QRGenerator();
            $qrCodeLabel = $member['first_name'] . ($member['kelas'] ? ' ' . $member['kelas'] : '');
            $qrCode = $qrGenerator->generateQRCode(
                $member['uid'],
                labelText: $qrCodeLabel,
                dir: MEMBERS_QR_CODE_PATH,
                filename: $qrCodeLabel
            );

            $this->memberModel->update($member['id'], ['qr_code' => $qrCode]);
            $member = $this->memberModel->where('uid', $uid)->first();
        }

        return view('members/show', [
            'member'         => $member,
            'totalBooksLent' => $totalBooksLent,
            'loanCount'      => count($loans),
            'returnCount'    => count($return),
            'lateCount'      => count($lateLoans),
            'unpaidFines'    => $unpaidFines,
            'paidFines'      => $paidFines,
        ]);
    }

public function new()
{
    return view('members/create', [
        'no_anggota' => $this->generateMemberNo(), // ✅ langsung pakai fungsi
        'validation' => \Config\Services::validation(),
        'oldInput'   => session()->getFlashdata('old') ?? [],
    ]);
}


public function create()
{
    $rules = [
        'nomor_induk'   => 'required|alpha_numeric_punct|max_length[20]',
        'first_name'    => 'required|alpha_numeric_punct|max_length[100]',
        'kelas'         => 'permit_empty|alpha_numeric_punct|max_length[100]',
        'jurusan'       => 'required|max_length[255]',
        'phone'         => 'required|alpha_numeric_punct|min_length[4]|max_length[20]',
        'address'       => 'required|min_length[5]|max_length[511]',
        'gender'        => 'required|in_list[L,P]' // ✅ pakai L/P
    ];

    if (!$this->validate($rules)) {
        session()->setFlashdata('old', $this->request->getPost());
        session()->setFlashdata('msg', 'Validasi gagal. Periksa kembali input Anda.');
        return $this->new();
    }

    // ✅ generate UID unik
    $uid = sha1(
        $this->request->getVar('first_name')
        . $this->request->getVar('jurusan')
        . $this->request->getVar('phone')
        . rand(0, 1000)
        . md5($this->request->getVar('gender'))
    );

    // ✅ generate QR Code
    $qrGenerator = new QRGenerator();
    $qrCodeLabel = $this->request->getVar('first_name')
        . ($this->request->getVar('kelas') ? ' ' . $this->request->getVar('kelas') : '');
    $qrCode = $qrGenerator->generateQRCode(
        $uid,
        labelText: $qrCodeLabel,
        dir: MEMBERS_QR_CODE_PATH,
        filename: $qrCodeLabel
    );

    // ✅ simpan ke database
    if (!$this->memberModel->save([
        'uid'           => $uid,
        'member_no'     => $this->generateMemberNo(), // 🔥 langsung pakai fungsi baru
        'nomor_induk'   => $this->request->getVar('nomor_induk'),
        'first_name'    => $this->request->getVar('first_name'),
        'kelas'         => $this->request->getVar('kelas'),
        'jurusan'       => $this->request->getVar('jurusan'),
        'phone'         => $this->request->getVar('phone'),
        'address'       => $this->request->getVar('address'),
        'gender'        => $this->request->getVar('gender'),
        'qr_code'       => $qrCode,
    ])) {
        session()->setFlashdata('msg', 'Insert failed: ' . implode(', ', $this->memberModel->errors()));
        session()->setFlashdata('old', $this->request->getPost());
        return $this->new();
    }

    session()->setFlashdata(['msg' => 'Insert new member successful']);
    return redirect()->to('admin/members');
}


public function edit($uid = null)
{
    $member = $this->memberModel->where('uid', $uid)->first();
    if (!$member) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Member not found');
    }

    // Jika member_no belum ada, generate otomatis
    if (empty($member['member_no'])) {
        $member['member_no'] = $this->generateMemberNo();
    }

    return view('members/edit', [
        'member'     => $member,
        'validation' => \Config\Services::validation(),
    ]);
}

public function update($uid = null)
{
    $member = $this->memberModel->where('uid', $uid)->first();
    if (!$member) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Member not found');
    }

    $validationRules = [
        'nomor_induk'   => 'required|alpha_numeric_punct|max_length[20]',
        'first_name'    => 'required|alpha_numeric_punct|max_length[100]',
        'kelas'         => 'permit_empty|alpha_numeric_punct|max_length[100]',
        'jurusan'       => 'required|max_length[255]',
        'phone'         => 'required|alpha_numeric_punct|min_length[4]|max_length[20]',
        'address'       => 'required|min_length[5]|max_length[511]',
        'gender'        => 'required|in_list[L,P]', // ✅ pakai L / P
    ];

    if (!$this->validate($validationRules)) {
        session()->setFlashdata('msg', 'Validasi gagal');
        session()->setFlashdata('old', $this->request->getPost());

        return view('members/edit', [
            'member'     => $member,
            'validation' => $this->validator,
            'oldInput'   => $this->request->getPost(),
        ]);
    }

    // Ambil input
    $input = $this->request->getPost([
        'nomor_induk', 'first_name', 'kelas', 'jurusan',
        'phone', 'address', 'gender'
    ]);

    // QR Code logic (jika nama/jurusan/phone berubah)
    $isChanged = (
        $input['first_name'] !== $member['first_name'] ||
        $input['jurusan']    !== $member['jurusan'] ||
        $input['phone']      !== $member['phone']
    );

    $qrCode = $member['qr_code'];
    if ($isChanged) {
        $qrGenerator = new QRGenerator();
        $qrCodeLabel = $input['first_name'] . ($input['kelas'] ? ' ' . $input['kelas'] : '');
        $qrCode = $qrGenerator->generateQRCode(
            $member['uid'], // ✅ tetap pakai UID lama
            labelText: $qrCodeLabel,
            dir: MEMBERS_QR_CODE_PATH,
            filename: $qrCodeLabel
        );
        deleteMembersQRCode($member['qr_code']);
    }

    // Simpan data
    $saveData = array_merge($input, [
        'id'        => $member['id'],
        'uid'       => $member['uid'], // ✅ tidak diubah
        'member_no' => $member['member_no'] ?? $this->generateMemberNo(),
        'qr_code'   => $qrCode,
    ]);

    if (!$this->memberModel->save($saveData)) {
        $errors = $this->memberModel->errors();
        session()->setFlashdata('msg', 'Update gagal: ' . implode(', ', $errors));
        return view('members/edit', [
            'member'     => $member,
            'validation' => $this->validator,
            'oldInput'   => $input,
        ]);
    }

    session()->setFlashdata('msg', 'Data anggota berhasil diperbarui');
    return redirect()->to('admin/members');
}

private function generateMemberNo()
{
    $lastMember = $this->memberModel->orderBy('id', 'DESC')->first();

    if ($lastMember && !empty($lastMember['member_no'])) {
        // Ambil angka dari format PS-ASH000001
        $lastNumber = intval(substr($lastMember['member_no'], 6));
    } else {
        $lastNumber = 0;
    }

    return 'PS-ASH' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
}


    public function delete($uid = null)
    {
        $member = $this->memberModel->where('uid', $uid)->first();
        if (!$member) {
            throw new PageNotFoundException('Member not found');
        }

        if (!$this->memberModel->delete($member['id'])) {
            session()->setFlashdata(['msg' => 'Failed to delete member', 'error' => true]);
            return redirect()->back();
        }

        deleteMembersQRCode($member['qr_code']);
        session()->setFlashdata(['msg' => 'Member deleted successfully']);
        return redirect()->to('admin/members');
    }
}
