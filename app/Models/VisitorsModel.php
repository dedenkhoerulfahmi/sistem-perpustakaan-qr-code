<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorsModel extends Model
{
    protected $table      = 'visitors'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name', 'kelas', 'jurusan', 'visit_date', 'visit_time'
    ];
}
