<?php

namespace App\Models;

use CodeIgniter\Model;

class M_token extends Model
{
    protected $table      = 'autentication_token';
    protected $primaryKey = 'token';
    protected $allowedFields = ['token','kategori','id_tahun', 'tanggal','kelas','nip','created_ad','expired'];
}