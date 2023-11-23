<?php

namespace App\Models;

use CodeIgniter\Model;

class M_user extends Model
{
    protected $table      = 'tb_user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username','password', 'hak_akses'];
}