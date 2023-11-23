<?php

namespace App\Models;

use CodeIgniter\Model;

class M_tahun_akademik extends Model
{
    protected $table      = 'tahun_pelajaran';
    protected $primaryKey = 'id_tahun';
    protected $allowedFields = ['id_tahun', 'tahun', 'semester', 'tanggal_mulai', 'tanggal_selesai', 'status'];
}