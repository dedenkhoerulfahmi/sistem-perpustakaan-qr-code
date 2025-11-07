<?php

namespace App\Controllers\Teachers;

use App\Controllers\BaseController;
use App\Models\TeacherModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class TeachersController extends BaseController
{
    protected $teacherModel;

    public function __construct()
    {
        $this->teacherModel = new TeacherModel();
        helper('form');
    }

    public function index()
    {
        $teachers = $this->teacherModel->findAll();

        return view('teachers/index', [
            'teachers' => $teachers,
            'activeTab' => 'guru'
        ]);
    }

    public function new()
    {
        // Generate no_anggota otomatis
        $last = $this->teacherModel->orderBy('id', 'DESC')->first();
        $number = $last ? intval(substr($last['no_anggota'], 3)) + 1 : 1;
        $no_anggota = 'PG-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        return view('teachers/create', [
            'no_anggota' => $no_anggota,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function store()
    {
        if (!$this->validate([
            'no_anggota' => 'required|max_length[20]|is_unique[teachers.no_anggota]',
            'nama'       => 'required|max_length[100]',
            'alamat'     => 'required|max_length[255]',
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->teacherModel->save([
            'no_anggota' => $this->request->getVar('no_anggota'),
            'nama'       => $this->request->getVar('nama'),
            'alamat'     => $this->request->getVar('alamat')
        ]);

        session()->setFlashdata('msg', 'Guru berhasil ditambahkan');
        return redirect()->to('admin/members'); // Karena tab guru ada di halaman members
    }

    public function edit($id = null)
    {
        $teacher = $this->teacherModel->find($id);
        if (!$teacher) throw new PageNotFoundException('Guru tidak ditemukan');

        return view('teachers/edit', [
            'teacher' => $teacher,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id = null)
    {
        $teacher = $this->teacherModel->find($id);
        if (!$teacher) throw new PageNotFoundException('Guru tidak ditemukan');

        if (!$this->validate([
            'no_anggota' => "required|max_length[20]|is_unique[teachers.no_anggota,id,{$id}]",
            'nama'       => 'required|max_length[100]',
            'alamat'     => 'required|max_length[255]',
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->teacherModel->save([
            'id'         => $id,
            'no_anggota' => $this->request->getVar('no_anggota'),
            'nama'       => $this->request->getVar('nama'),
            'alamat'     => $this->request->getVar('alamat')
        ]);

        session()->setFlashdata('msg', 'Data guru berhasil diperbarui');
        return redirect()->to('admin/members');
    }

    public function delete($id = null)
    {
        $teacher = $this->teacherModel->find($id);
        if (!$teacher) throw new PageNotFoundException('Guru tidak ditemukan');

        $this->teacherModel->delete($id);
        session()->setFlashdata('msg', 'Guru berhasil dihapus');
        return redirect()->to('admin/members');
    }
}
