<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table            = 'loans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // ✅ Aktifkan soft delete
    protected $protectFields    = true;

    protected $allowedFields = [
        'uid',               // ✅ Tambahkan UID agar bisa disimpan
        'loan_qr_code',
        'book_id',
        'member_id',
        'loan_date',
        'return_date',
        'status',
        'deadline'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Ambil detail peminjaman berdasarkan ID
     */
    public function getLoanWithDetails($id)
    {
        return $this->select('
                loans.*,
                members.uid as member_uid,
                members.first_name,
                members.kelas,
                members.gender,
                books.slug,
                books.title,
                books.year
            ')
            ->join('members', 'members.id = loans.member_id')
            ->join('books', 'books.id = loans.book_id')
            ->where('loans.id', $id)
            ->where('loans.deleted_at', null) // ✅ Filter soft delete
            ->first();
    }

    /**
     * Ambil semua data peminjaman dengan relasi anggota dan buku
     */
    public function getAllLoansWithDetails()
    {
        return $this->select('
                loans.*,
                members.uid as member_uid,
                members.first_name,
                members.kelas,
                members.gender,
                books.slug,
                books.title,
                books.year
            ')
            ->join('members', 'members.id = loans.member_id')
            ->join('books', 'books.id = loans.book_id')
            ->where('loans.deleted_at', null) // ✅ Filter soft delete
            ->orderBy('loans.created_at', 'DESC')
            ->findAll();
    }
}
