<?php

namespace App\Controllers;

class Siswa extends BaseController
{
    public function __construct()
    {
        $this->siswa = new \App\models\M_getData();
        $this->guru = new \App\Models\M_guru();
        $this->kelas = new \App\Models\M_getKelas();
        $this->absen = new \App\Models\M_absen();
        $this->validasi = \Config\Services::validation();
        $this->mapel    = new \App\Models\M_mapel();
        $this->jadwal   = new \App\Models\M_jadwal();
        $this->tahun_akademik = new \App\Models\M_tahun_akademik();
        $this->kalender = new \App\Models\M_kalender();
        date_default_timezone_set('Asia/Jakarta');
        $this->nis = session()->get('nis');
        $this->nama_siswa = session()->get('nama_siswa');
        $this->id_kelas = session()->get('id_kelas');
        helper(['kelas', 'form']);
        // dd($kelas);
    }
    public function index(){
        if (session()->get('hak_akses') != 'siswa') {
            return redirect()->to(base_url('login'));
        }else{
            $kelas_siswa = $this->siswa->where('nama_siswa', session()->get('siswa'))->findAll();

            // dd($kelas_siswa);
            $data = [
                'parameter' => '',
                'nis'       => $this->nis,
                'kelas'     => $this->id_kelas,
                'nama_siswa'=> $this->nama_siswa,
            ];
            return view('siswa/content/dashboard', $data);
        }
    }
    public function detail_presensi_siswa($nis, $akademik, $id_kelas, $id_mapel){
        if (session()->get('hak_akses') != 'siswa') {
            return redirect()->to(base_url('login'));
        }else{
            // dd($daftar_mapel);
            $daftar_mapel = $this->jadwal->select('id_mapel')->where('id_kelas', $id_kelas)->groupBy('id_mapel')->findAll();

            $join = $this->siswa->join('daftar_kelas', 'daftar_kelas.id_kelas = tb_siswa.id_kelas', 'left')->find([$nis]);
            $nama_mapel = $this->mapel->where('id_mapel', $id_mapel)->first();
            $join_mapel = $this->mapel
            ->select('tb_presensi.id_presensi, tb_presensi.nis_siswa, tb_presensi.nip, tb_presensi.id_mapel, tb_presensi.id_kelas, tb_presensi.id_tahun, tb_presensi.status, tb_presensi.waktu_presensi, tb_presensi.tanggal_presensi, tb_mapel.nama_mapel, tb_guru.nama_guru, tb_siswa.nama_siswa')
            ->join('tb_presensi', 'tb_presensi.id_mapel = tb_mapel.id_mapel', 'right')
            ->join('tb_guru', 'tb_presensi.nip=tb_guru.nip')
            ->join('tb_siswa', 'tb_siswa.nis_siswa = tb_presensi.nis_siswa')
            ->where('tb_presensi.nis_siswa', $nis)
            ->where('id_tahun', $akademik)
            ->where('tb_presensi.id_mapel', $id_mapel)
            ->where('tb_presensi.keterangan', '-')
            ->findAll();
            
            $terlambat = $this->mapel
            ->select('tb_presensi.id_presensi, tb_presensi.nis_siswa, tb_presensi.nip, tb_presensi.id_mapel, tb_presensi.id_kelas, tb_presensi.id_tahun, tb_presensi.status, tb_presensi.waktu_presensi, tb_presensi.tanggal_presensi, tb_mapel.nama_mapel, tb_guru.nama_guru, tb_siswa.nama_siswa')
            ->join('tb_presensi', 'tb_presensi.id_mapel = tb_mapel.id_mapel', 'right')
            ->join('tb_guru', 'tb_presensi.nip=tb_guru.nip')
            ->join('tb_siswa', 'tb_siswa.nis_siswa = tb_presensi.nis_siswa')
            ->where('tb_presensi.nis_siswa', $nis)
            ->where('id_tahun', $akademik)
            ->where('tb_presensi.id_mapel', $id_mapel)
            ->where('tb_presensi.keterangan', 'presensi_terlambat')
            ->findAll();

            // dd($terlambat);
            $data_akademik = $this->tahun_akademik->where('id_tahun', $akademik)->first();

            $data = [
                'tahun_akademik'=> $data_akademik['tahun'],
                'id_akademik'   => $data_akademik['id_tahun'],
                'semester'      => $data_akademik['semester'],
                'parameter'     => 'Presensi',
                'nama_siswa'    => $join[0]['nama_siswa'],
                'jumlah_hadir'  => $this->absen->where('nis_siswa', $nis)->where('status', 'hadir')->where('id_mapel', $id_mapel)->countAllResults(),
                'jumlah_izin'   => $this->absen->where('nis_siswa', $nis)->where('status', 'izin')->where('id_mapel', $id_mapel)->countAllResults(),
                'jumlah_alpha'  => $this->absen->where('nis_siswa', $nis)->where('status', 'alpha')->where('id_mapel', $id_mapel)->countAllResults(),
                'nama_kelas'    => kelas($join[0]['kelas']). ' '.$join[0]['jurusan'].' '. $join[0]['kelompok'],
                'data'          => $join_mapel,
                'nama_mapel'    => $nama_mapel['nama_mapel'],
                'terlambat'     => $terlambat
            ];
            // dd($data);
            return view('siswa/content/detail_presensi_siswa', $data);
        }
    }

    public function jadwal_pelajaran(){
        if (session()->get('hak_akses') != 'siswa') {
            return redirect()->to(base_url('login'));
        }else{
            // dd($this->id_kelas);
            $nama_kelas = $this->kelas->where('id_kelas', $this->id_kelas)->first();
            $join = $this->jadwal
            ->join('daftar_kelas', 'daftar_kelas.id_kelas = jadwal_pelajaran.id_kelas',)
            ->join('tb_mapel', 'tb_mapel.id_mapel = jadwal_pelajaran.id_mapel')
            ->where('jadwal_pelajaran.id_kelas', $this->id_kelas)
            ->where('id_tahun', session()->get('id_akademik'))
            ->findAll();
            // dd($join, $nama_kelas);
            $data = [
                'parameter' => '',
                'nama_kelas'=> kelas($nama_kelas['kelas']). ' ' . $nama_kelas['jurusan'] .' ' . $nama_kelas['kelompok'],
                'jadwal'     => $join,
            ];   
            // dd($data);
            return view('siswa/content/jadwal_pelajaran', $data);
        }
    }

    public function informasi(){
        if(session()->get('hak_akses') != 'siswa'){
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'jadwal' => $this->kalender->where('id_tahun_akademik', session()->get('id_akademik'))->findAll()
            ];
            // dd($data);
            return view('siswa/content/informasi', $data);
        }
    }

    public function detail_presensi(){
        if (session()->get('hak_akses') != 'siswa') {
            return redirect()->to(base_url('login'));
        }else{
            $nk = $this->kelas->where('id_kelas', $this->id_kelas)->first();
            $join = $this->siswa
            ->join('daftar_kelas', 'daftar_kelas.id_kelas = tb_siswa.id_kelas', 'left')
            ->find([$this->nis]);

            $join_mapel = $this->absen
            ->join('tb_mapel', 'tb_mapel.id_mapel = tb_presensi.id_mapel', 'left')
            ->join('tb_guru', 'tb_presensi.nip = tb_guru.nip', 'left')
            ->join('tb_siswa', 'tb_presensi.nis_siswa = tb_siswa.nis_siswa')
            ->where('tb_presensi.nis_siswa', $this->nis)
            ->where('id_tahun', session()->get('id_akademik'))
            ->findAll();
            // dd($join_mapel, $nk);
            $data = [
                'nis'           => session()->get('nis'),
                'nama_siswa'    => session()->get('nama_siswa'),
                'jumlah_hadir'  => $this->absen->where('nis_siswa', $this->nis)->where('status', 'hadir')->where('id_tahun', session()->get('id_akademik'))->countAllResults(),
                'jumlah_izin'  => $this->absen->where('nis_siswa', $this->nis)->where('status', 'izin')->where('id_tahun', session()->get('id_akademik'))->countAllResults(),
                'jumlah_alpha'  => $this->absen->where('nis_siswa', $this->nis)->where('status', 'alpha')->where('id_tahun', session()->get('id_akademik'))->countAllResults(),
                'parameter'     => 'dashboard_daftar_hadir',
                'nama_kelas'    => kelas($nk['kelas']) .' '. $nk['jurusan'] .' '. $nk['kelompok'],
                'data'          => $join_mapel,
            ];
            // dd($data);
            return view('siswa/content/presensi', $data);
        }
    }

    public function list_daftar_mapel(){
        $nis = $this->nis;
        $akademik = session()->get('id_akademik');
        $id_kelas = $this->id_kelas;

        $daftar_mapel = $this->jadwal->select('jadwal_pelajaran.id_mapel, tb_mapel.nama_mapel')->join('tb_mapel', 'tb_mapel.id_mapel = jadwal_pelajaran.id_mapel', 'left')->where('jadwal_pelajaran.id_kelas', $id_kelas)->groupBy('jadwal_pelajaran.id_mapel')->findAll();

        $nama_siswa = $this->siswa->select('nama_siswa')->where('nis_siswa', $nis)->first();
        $total_presensi = $this->absen->select('id_mapel, count(id_mapel) as jumlah')->where('id_kelas', $id_kelas)->where('id_tahun', $akademik)->where('nis_siswa', $nis)->groupBy('id_mapel')->findAll();

        $hadir = $this->absen->select('id_mapel, count(id_mapel) as jumlah')->where('id_kelas', $id_kelas)->where('id_tahun', $akademik)->where('nis_siswa', $nis)->where('status', 'hadir')->groupBy('id_mapel')->findAll();
        $izin = $this->absen->select('id_mapel, count(id_mapel) as jumlah')->where('id_kelas', $id_kelas)->where('id_tahun', $akademik)->where('nis_siswa', $nis)->where('status', 'izin')->groupBy('id_mapel')->findAll();
        $alpha = $this->absen->select('id_mapel, count(id_mapel) as jumlah')->where('id_kelas', $id_kelas)->where('id_tahun', $akademik)->where('nis_siswa', $nis)->where('status', 'alpha')->groupBy('id_mapel')->findAll();
        
        $hasil = [];
        
        foreach ($daftar_mapel as $key => $value) {
            $hasil[$key]['id_mapel'] = $value['id_mapel'];
            $hasil[$key]['nama_mapel'] = $value['nama_mapel'];
            $hasil[$key]['total_presensi'] = 0;

            $hasil[$key]['persen'] = 0;
            
            $hasil[$key]['hadir'] = 0;
            $hasil[$key]['izin'] = 0;
            $hasil[$key]['alpha'] = 0;

            foreach ($total_presensi as $key2 => $value2) {
                if ($value['id_mapel'] == $value2['id_mapel']) {
                    $hasil[$key]['total_presensi'] = $value2['jumlah'];
                }
            }
            foreach ($hadir as $key2 => $value2) {
                if ($value['id_mapel'] == $value2['id_mapel']) {
                    $hasil[$key]['hadir'] = $value2['jumlah'];
                    $hasil[$key]['persen'] += $value2['jumlah'];
                }
            }
            foreach ($izin as $key2 => $value2) {
                if ($value['id_mapel'] == $value2['id_mapel']) {
                    $hasil[$key]['izin'] = $value2['jumlah'];
                }
            }
            foreach ($alpha as $key2 => $value2) {
                if ($value['id_mapel'] == $value2['id_mapel']) {
                    $hasil[$key]['alpha'] = $value2['jumlah'];
                }
            }

            if ($hasil[$key]['total_presensi'] == 0) {
                $hasil[$key]['persen'] = 0;
            }else{
                $hasil[$key]['persen'] = ($hasil[$key]['persen'] / $hasil[$key]['total_presensi']) * 100;
            }
        }

        $presensi_keseluruhan = count($total_presensi);

        $data = [
            'parameter' => 'Presensi', 
            'daftar_mapel' => $hasil,
            'jumlah_presensi' => $presensi_keseluruhan,
            'nis' => $nis,
            'nama_siswa' => $nama_siswa['nama_siswa'],
            'id_kelas' => $id_kelas,
            'akademik' => $akademik,
        ];
        // dd($data);
        return view('siswa/content/list_daftar_mapel', $data);
    }
}