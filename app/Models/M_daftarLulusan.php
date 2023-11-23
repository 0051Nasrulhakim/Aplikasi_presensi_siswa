<?php

namespace App\Models;

use CodeIgniter\Model;

class M_daftarLulusan extends Model
{
    protected $table      = 'daftar_lulusan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nis_siswa','tahun_lulus','asal_kelas'];
    
}