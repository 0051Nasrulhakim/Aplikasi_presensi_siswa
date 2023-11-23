<?php

namespace App\Models;

use CodeIgniter\Model;

class M_absen extends Model
{
    protected $table      = 'tb_presensi';
    protected $primaryKey = 'id_presensi';
    protected $allowedFields = ['nis_siswa','id_tahun', 'status','id_kelas','tanggal_presensi','waktu_presensi','id_mapel','nip', 'keterangan'];

    public function getDetailPresensi($nis){
        return $query = $this->db->query('SELECT * FROM tb_presensi WHERE nis_siswa = '.$nis.'')->getResultArray();
    }
    // public function hadir($kelas){
    //     return $query = $this->db->query("SELECT nama_siswa, COUNT(status) as hadir FROM `tb_presensi` WHERE status = 'hadir' AND id_kelas = '$kelas' GROUP BY nama_siswa")->getResultArray();
    // }
    // public function alpha($kelas){
    //     return $query = $this->db->query("SELECT nama_siswa, COUNT(status) as alpha FROM `tb_presensi` WHERE status = 'alpha' AND id_kelas = '$kelas' GROUP BY nama_siswa")->getResultArray();
    // }
    // public function izin($kelas){
    //     return $query = $this->db->query("SELECT nama_siswa, COUNT(status) as izin FROM `tb_presensi` WHERE status = 'izin' AND id_kelas = '$kelas' GROUP BY nama_siswa")->getResultArray();
    // }
   
}