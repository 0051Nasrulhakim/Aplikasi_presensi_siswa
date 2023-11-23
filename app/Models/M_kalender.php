<?php

namespace App\Models;

use CodeIgniter\Model;

class M_kalender extends Model
{
    protected $table      = 'kalender';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kegiatan','keterangan','tanggal_mulai', 'tanggal_selesai','id_tahun_akademik'];
}