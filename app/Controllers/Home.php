<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        $this->M_getData = new \App\Models\M_getData();
        $this->M_absen = new \App\Models\M_absen();
        $this->M_getKelas = new \App\Models\M_getKelas();
        helper('form','array','url');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $kelas = 'X Teknik Elektronika';
        $data = [
            'matapelajaran'  => '',
            'parameter' => 'presensi',
            'kelas' => 'X Teknik Elektronika',
            'siswa' => $this->M_getData->where('kelas', $kelas)->findAll(),
        ];
        return view('guru/content/presensi', $data);
    }

    public function dashboard_daftar_hadir(){
        $data = [
            'parameter' => 'dashboard_daftar_hadir',
            'jumlah_siswa'=> $this->M_getData->findAll(),
            'data_kelas'=> $this->M_getKelas->findAll(),
        ];
        return view('guru/content/dashboard_daftar_kehadiran', $data);
    }

    public function laporan_presensi($kelas){
        $data = [
            'parameter' => 'dashboard_daftar_hadir',
            'presensi' => $this->M_absen->findAll(),
            'kelas'=> $kelas,
            'data_kelas'=> $this->M_getData->getKelas($kelas),
        ];
        return view('guru/content/daftar_kehadiran', $data);
    }

    public function detail_presensi($nis){
        $data = [
            'parameter' => 'dashboard_daftar_hadir',
            'nama_kelas'      => $this->M_getData->getNama_kelas($nis),
            'data'      => $this->M_absen->getDetailPresensi($nis),
        ];
        // dd($data);
        return view('guru/content/detail_presensi', $data);
    }
    
}
