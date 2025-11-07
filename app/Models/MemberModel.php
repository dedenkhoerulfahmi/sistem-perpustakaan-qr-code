<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
protected $allowedFields = [
    'uid',
    'member_no',      // 👈 nomor anggota
    'nomor_induk',    // NIS untuk siswa / NIP untuk guru
    'first_name',     // Nama lengkap
    'kelas',          // hanya untuk siswa
    'jurusan',        // siswa = jurusan, guru = mata pelajaran
    'phone',
    'address',
    'gender',
    'qr_code',
    'type'            // 'student' atau 'teacher'
];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation (opsional, bisa dikosongkan kalau pakai controller saja)
protected $validationRules = [
    'member_no'    => 'required|alpha_numeric_punct|max_length[20]', // ✅ ganti dari no_anggota
    'nomor_induk'  => 'required|alpha_numeric_punct|max_length[20]',
    'first_name'   => 'required|string|max_length[100]',
    'gender'       => 'required|in_list[L,P]',
];


    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
