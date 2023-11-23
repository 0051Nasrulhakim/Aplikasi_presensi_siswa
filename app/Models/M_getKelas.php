<?php

namespace App\Models;

use CodeIgniter\Model;

class M_getKelas extends Model
{
    protected $table      = 'daftar_kelas';
    protected $primaryKey = 'id_kelas';
    protected $allowedFields = ['kelas','jurusan', 'kelompok'];
}