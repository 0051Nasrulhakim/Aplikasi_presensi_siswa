<?php

namespace App\Models;

use CodeIgniter\Model;

class M_guru extends Model
{
    protected $table      = 'tb_guru';
    protected $primaryKey = 'nip';
    protected $allowedFields = ['nip','nama_guru','tanggal_lahir','jenis_kelamin','password', 'min_jam'];

}