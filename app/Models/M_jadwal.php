<?php

namespace App\Models;

use CodeIgniter\Model;

class M_jadwal extends Model
{
    protected $table      = 'jadwal_pelajaran';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = ['hari','id_tahun','id_kelas','id_mapel','nip','jam_masuk','jam_selesai'];
    
    public function find_kelas($hari, $jam, $guru, $id_akademik){
        return $query = $this->db->query("SELECT * FROM jadwal_pelajaran WHERE jam_masuk <= '$jam' AND jam_selesai >= '$jam' AND nip = '$guru' AND hari = '$hari' AND id_tahun = '$id_akademik'")->getResultArray();
    }
    public function find_jadwal($hari, $kelas, $tahun, $id_mapel){
        return $query = $this->db->query("SELECT * FROM jadwal_pelajaran WHERE id_kelas = '$kelas' AND hari = '$hari' AND id_mapel = '$id_mapel' AND id_tahun = '$tahun'")->getResultArray();
    }
}