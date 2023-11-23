<?php

namespace App\Models;

use CodeIgniter\Model;

class M_getData extends Model
{
    protected $table      = 'tb_siswa';
    protected $primaryKey = 'nis_siswa';
    protected $allowedFields = ['nis_siswa','nama_siswa','tanggal_lahir','id_kelas','jenis_kelamin', 'tahun_masuk', 'status', 'tahun_lulus'];
    protected $returnType     = 'array';

    public function getKelas($kelas){
        return $query = $this->db->query("SELECT * FROM tb_siswa WHERE id_kelas = '$kelas'")->getResultArray();
    }
    public function getNimMax(){
        return $query = $this->db->query("SELECT MAX(nis_siswa) as nis FROM tb_siswa;")->getResultArray();
    }
}