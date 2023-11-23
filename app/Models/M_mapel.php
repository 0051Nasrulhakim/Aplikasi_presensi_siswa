<?php

namespace App\Models;

use CodeIgniter\Model;

class M_mapel extends Model
{
    protected $table      = 'tb_mapel';
    protected $primaryKey = 'id_mapel';
    protected $allowedFields = ['id_mapel', 'nama_mapel'];

    public function select_nama_mapel(){
        return $this->db->query("SELECT * FROM `tb_mapel` GROUP BY nama_mapel")->getResultArray();
    }
}