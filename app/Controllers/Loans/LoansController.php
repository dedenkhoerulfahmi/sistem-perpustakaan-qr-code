<?php

namespace App\Controllers\Loans;

use App\Libraries\QRGenerator;
use App\Models\BookModel;
use App\Models\LoanModel;
use App\Models\MemberModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;

class LoansController extends ResourceController
{
    protected LoanModel $loanModel;
    protected MemberModel $memberModel;
    protected BookModel $bookModel;

    public function __construct()
    {
        $this->loanModel = new LoanModel;
        $this->memberModel = new MemberModel;
        $this->bookModel = new BookModel;

        helper('upload');
    }

    public function index()
    {
        $itemPerPage = 20;
        $keyword = $this->request->getGet('search');

        $builder = $this->loanModel
            ->select('members.*, members.uid as member_uid, books.*, loans.*')
            ->join('members', 'loans.member_id = members.id', 'LEFT')
            ->join('books', 'loans.book_id = books.id', 'LEFT')
            ->where('loans.return_date', null)
            ->where('loans.deleted_at', null);

        if ($keyword) {
            $builder->groupStart()
                ->like('first_name', $keyword, insensitiveSearch: true)
                ->orLike('kelas', $keyword, insensitiveSearch: true)
                ->orLike('jurusan', $keyword, insensitiveSearch: true)
                ->orLike('title', $keyword, insensitiveSearch: true)
                ->orLike('slug', $keyword, insensitiveSearch: true)
                ->groupEnd();
        }

        $loans = $builder->paginate($itemPerPage, 'loans');

        $data = [
            'loans' => $loans,
            'itemPerPage' => $itemPerPage,
            'currentPage' => $this->request->getGet('page_loans') ?? 1,
            'pager' => $this->loanModel->pager,
            'search' => $keyword,
        ];

        return view('loans/index', $data);
    }

    public function show($identifier = null)
    {
        $isNumericId = is_numeric($identifier);

        $loan = $this->loanModel
            ->select('loans.*, members.first_name, members.kelas, members.jurusan, books.title, books.slug')
            ->join('members', 'members.id = loans.member_id')
            ->join('books', 'books.id = loans.book_id');

        $loan = $isNumericId
            ? $loan->where('loans.id', $identifier)->first()
            : $loan->where('loans.uid', $identifier)->first();

        if (empty($loan)) {
            throw PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getGet('update-qr-code') && $loan['return_date'] == null) {
            $qrCodeLabel = substr($loan['first_name'] . ($loan['kelas'] ? " {$loan['kelas']}" : ''), 0, 12) . '_' . substr($loan['title'], 0, 12);
            $qrCode = new QRGenerator($qrCodeLabel, base_url("admin/loans/{$loan['uid']}"));
            $qrCode->save();
        }

        return view('loans/show', ['loan' => $loan]);
    }

public function searchMember()
{
    if ($this->request->isAJAX()) {
        $keyword = trim($this->request->getVar('keyword'));

        if ($keyword === '') {
            return view('loans/member', [
                'msg' => '⚠ Masukkan nama atau nomor anggota terlebih dahulu'
            ]);
        }

        // Query builder
        $builder = $this->memberModel;

        $builder->groupStart()
                ->like('member_no', $keyword)     // nomor anggota
                ->orLike('nomor_induk', $keyword) // nomor induk
                ->orLike('first_name', $keyword)  // nama depan
                ->groupEnd();

        // filter soft-delete (karena kolom ada)
        $builder->where('deleted_at', null);

        $members = $builder->findAll();

        if (empty($members)) {
            return view('loans/member', [
                'msg' => '❌ Anggota tidak ditemukan'
            ]);
        }

        return view('loans/member', [
            'members' => $members
        ]);
    }

    return view('loans/search_member');
}

public function searchBook()
{
    if ($this->request->isAJAX()) {
        $param = trim($this->request->getVar('param'));
        $memberUid = $this->request->getVar('memberUid');

        if (!$param || !$memberUid) {
            return $this->response->setStatusCode(400)->setBody('Parameter pencarian atau UID anggota kosong.');
        }

        $books = $this->bookModel
            ->select('books.*, books.deleted_at, book_stock.quantity, categories.name as category, racks.name as rack, racks.floor')
            ->join('book_stock', 'books.id = book_stock.book_id', 'LEFT')
            ->join('categories', 'books.category_id = categories.id', 'LEFT')
            ->join('racks', 'books.rack_id = racks.id', 'LEFT')
            ->groupStart()
                ->like('title', $param)
                ->orLike('slug', $param)
                ->orLike('author', $param)
                ->orLike('publisher', $param)
            ->groupEnd()
            ->where('books.deleted_at', null)
            ->orderBy('title', 'ASC')
            ->findAll(20);

        if (empty($books)) {
            return view('loans/book', ['msg' => 'Buku tidak ditemukan']);
        }

        foreach ($books as &$book) {
            $book['stock'] = $this->getRemainingBookStocks($book);
        }

        return view('loans/book', [
            'books' => $books,
            'memberUid' => $memberUid
        ]);
    }

    // fallback jika bukan AJAX
    $memberUid = $this->request->getVar('member-uid');
    if (!$memberUid) {
        session()->setFlashdata(['msg' => 'Silakan pilih anggota terlebih dahulu', 'error' => true]);
        return redirect()->to('admin/loans/new/members/search');
    }

    $member = $this->memberModel->where('uid', $memberUid)->first();
    if (!$member) {
        session()->setFlashdata(['msg' => 'Data anggota tidak ditemukan', 'error' => true]);
        return redirect()->to('admin/loans/new/members/search');
    }

    return view('loans/search_book', ['member' => $member]);
}
protected function getRemainingBookStocks($book)
{
    // Ambil stok awal dari tabel book_stock
    $bookStock = model('BookStockModel')->where('book_id', $book['id'])->first();
    $totalStock = $bookStock['quantity'] ?? 0;

    // Hitung jumlah yang sedang dipinjam
    $loans = $this->loanModel->where([
        'book_id' => $book['id'],
        'return_date' => null
    ])->findAll();

    $loanCount = array_reduce($loans, fn($carry, $loan) => $carry + ($loan['quantity'] ?? 0), 0);

    return max(0, $totalStock - $loanCount);
}



    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */

public function new($validation = null, $oldInput = null)
{
    $memberUid = $this->request->getGet('member-uid');
    if (empty($memberUid) && is_array($oldInput) && isset($oldInput['member_uid'])) {
        $memberUid = $oldInput['member_uid'];
    }
    if (empty($memberUid)) {
        throw PageNotFoundException::forPageNotFound();
    }
    // Ambil data anggota
    $member = $this->memberModel->where('uid', $memberUid)->first();
    if (!$member) {
        throw PageNotFoundException::forPageNotFound();
    }
        // Ambil daftar buku yang dipilih user jika validasi gagal, atau semua buku jika baru
        if (is_array($oldInput) && isset($oldInput['slugs']) && is_array($oldInput['slugs']) && count($oldInput['slugs']) > 0) {
            $books = $this->bookModel
                ->select('books.*, books.slug, books.title, books.year, books.author, books.publisher, books.book_cover')
                ->whereIn('slug', $oldInput['slugs'])
                ->findAll();
        } else {
            $books = $this->bookModel
                ->select('books.*, books.slug, books.title, books.year, books.author, books.publisher, books.book_cover')
                ->findAll();
        }
        // Tambahkan stok tersisa ke setiap buku
        foreach ($books as &$book) {
            $book['stock'] = $this->getRemainingBookStocks($book);
        }
    return view('loans/create', [
        'member' => $member,
        'books' => $books,
        'validation' => $validation ?? \Config\Services::validation(),
        'oldInput' => $oldInput ?? [],
    ]);
}


public function create()
{
    $validation = \Config\Services::validation();

    $slugs = $this->request->getPost('slugs');
    $memberUid = $this->request->getPost('member_uid');

    if (empty($slugs) || empty($memberUid)) {
        throw PageNotFoundException::forPageNotFound();
    }

    // Ambil data anggota
    $member = $this->memberModel->where('uid', $memberUid)->first();
    if (!$member) {
        throw PageNotFoundException::forPageNotFound();
    }

    // Ambil semua buku berdasarkan slug
    $books = $this->bookModel->whereIn('slug', $slugs)->findAll();

    // Debug: pastikan data POST dan $books sudah benar
    // dd($this->request->getPost(), $books);

    // Cek apakah semua slug ditemukan di database
    $foundSlugs = array_column($books, 'slug');
    $missingSlugs = array_diff($slugs, $foundSlugs);
    if (!empty($missingSlugs)) {
        return redirect()->back()->withInput()->with('msg', 'Buku tidak ditemukan atau data tidak valid: ' . implode(', ', $missingSlugs));
    }

    // Tambahkan stok tersisa ke setiap buku
    foreach ($books as &$book) {
        $book['stock'] = $this->getRemainingBookStocks($book);
    }

    // Validasi dinamis untuk setiap buku
    $rules = [];
    foreach ($books as $book) {
        $slug = $book['slug'] ?? null;
        $maxStock = $book['stock'] ?? 0;
        if (!$slug) continue;
        $rules["quantity[$slug]"] = "required|integer|greater_than[0]|less_than_equal_to[$maxStock]";
        $rules["duration[$slug]"] = "required|in_list[1,2,3]";
    }
    $validation->setRules($rules);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->new($validation, $this->request->getPost());
    }

    // Ambil data POST untuk quantity dan duration
    $quantities = (array) $this->request->getPost('quantity');
    $durations = (array) $this->request->getPost('duration');

    // Cek apakah semua quantity dan duration terisi untuk setiap slug
    foreach ($books as $book) {
        $slug = $book['slug'];
        if (
            !isset($quantities[$slug]) ||
            $quantities[$slug] === '' ||
            !isset($durations[$slug]) ||
            $durations[$slug] === ''
        ) {
            return redirect()->back()->withInput()->with('msg', 'Pastikan semua jumlah dan lama pinjam diisi untuk setiap buku.');
        }
    }

    $quantities = $this->request->getPost('quantity');
    $durations = $this->request->getPost('duration');

    // Simpan setiap transaksi peminjaman
    foreach ($books as $book) {
        $slug = $book['slug'] ?? null;
        if (!$slug) continue;
        $quantity = $quantities[$slug] ?? null;
        $duration = isset($durations[$slug]) ? (int)$durations[$slug] : null;
        if (!$quantity || !$duration) continue;
        $uid = uniqid('loan_', true);
        $loanDate = Time::now('Asia/Jakarta');
        $deadline = $loanDate->addDays($duration);
        // Generate QR code
        $qrCodeLabel = substr($member['first_name'] . ($member['kelas'] ? " {$member['kelas']}" : ''), 0, 12) . '_' . substr($book['title'], 0, 12);
        $qrCode = new QRGenerator($qrCodeLabel, base_url("admin/loans/{$uid}"));
        $qrCode->save();
        // Simpan ke database
        $this->loanModel->insert([
            'uid' => $uid,
            'loan_qr_code' => $qrCode->getFilename(),
            'member_id' => $member['id'],
            'book_id' => $book['id'],
            'quantity' => $quantity,
            'loan_date' => $loanDate,
            'due_date' => $deadline,
            'deadline' => $duration,
        ]);
    }

    return redirect()->to(base_url('admin/loans'))->with('msg', 'Peminjaman berhasil dibuat.');
}
 public function delete($uid = null)
    {
        $loan = $this->loanModel->where('uid', $uid)->first();

        if (empty($loan)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->loanModel->delete($loan['id']);

        return redirect()->to(base_url('admin/loans'))->with('msg', 'Peminjaman berhasil dihapus.');
    }
}
