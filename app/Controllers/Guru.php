<?php

namespace App\Controllers;

class Guru extends BaseController
{
    public function __construct()
    {
        $this->absen = new \App\Models\M_absen();
        $this->siswa = new \App\Models\M_getData();
        $this->guru = new \App\Models\M_guru();
        $this->kelas = new \App\Models\M_getKelas();
        $this->mapel = new \App\Models\M_mapel();
        $this->jadwal = new \App\Models\M_jadwal();
        $this->kalender = new \App\Models\M_kalender();
        $this->token = new \App\Models\M_token();
        $this->tahun_akademik = new \App\Models\M_tahun_akademik();
        // $data = $this->guru->where('nip', session()->get('username'))->findAll();
        helper(['form','array','url', 'kelas']);
        $this->nama_guru = session()->get('nama_guru');
        $this->nip = session()->get('nip');
        date_default_timezone_set('Asia/Jakarta');
        $this->kalender = new \App\Models\M_kalender();
    }

    public function index(){
        if (session()->get('hak_akses') != 'guru') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter'         => '',
                'tahun_akademik'    => session()->get('tahun_akademik'),
                'semester'          => session()->get('semester'),
                'guru'              => $this->nama_guru,
                'mapel'             => $this->jadwal->where('nip', $this->nip)->findAll(),
            ];
            // dd($data);
            return view('guru/content/dashboard', $data);
        }
    }

    public function jadwal_mengajar(){
        if (session()->get('hak_akses') != 'guru') {
            return redirect()->to(base_url('login'));
        }else{
            $kelas = $this->jadwal
                     ->join('daftar_kelas', 'daftar_kelas.id_kelas = jadwal_pelajaran.id_kelas', 'left')
                     ->where('nip', $this->nip)
                     ->findAll();

            $join = $this->jadwal->join('daftar_kelas', 'daftar_kelas.id_kelas = jadwal_pelajaran.id_kelas',)
                    ->join('tb_mapel', 'tb_mapel.id_mapel = jadwal_pelajaran.id_mapel')
                    ->where('id_tahun', session()->get('id_akademik'))
                    ->where('jadwal_pelajaran.nip', $this->nip)
                    ->findAll();
            
            $data = [
                'parameter' => '',
                'guru'      => $this->nama_guru,
                'data'      => $join
            ];
            // dd($data);
            return view('guru/content/jadwal_mengajar', $data);
        }
    }

    public function informasi(){
        if (session()->get('hak_akses') != 'guru'){
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'jadwal' => $this->kalender->where('id_tahun_akademik', session()->get('id_akademik'))->findAll()
            ];
            return view('guru/content/informasi', $data);
        }
    }

    public function cari_presensi($jam, $hari){
        // dd($hari);
        if($hari == "jumat"){
            $hari = "jum\'\at";
        }
        if (session()->get('hak_akses') != 'guru'){
            return redirect()->to(base_url('login'));
        }else{
            if($hari == "jumat"){
                $hari = "jum\'\at";
            }else{
                $hari = $hari;
            }
            $jam        = date('H:i', strtotime('+1 minutes', strtotime($jam)));
            $guru       = session()->get('nip');
            $tanggal    = date('Y-m-d');
            $bulan      = date('m', strtotime($tanggal));
            $tahun      = date('Y', strtotime($tanggal));
            $id_akademik= session()->get('id_akademik');
            
            $data = $this->kalender
                    ->where('month(tanggal_mulai)', $bulan)
                    ->where('year(tanggal_mulai)', $tahun)
                    ->where('month(tanggal_selesai)', $bulan)
                    ->where('year(tanggal_selesai)', $tahun)
                    ->where('id_tahun_akademik', session()->get('id_akademik'))
                    ->findAll();
            // dd($data);
            function createDateRangeArray($strDateFrom,$strDateTo)
            {
                $aryRange=array();
                $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),substr($strDateFrom,8,2),substr($strDateFrom,0,4));
                $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),substr($strDateTo,8,2),substr($strDateTo,0,4));
                if ($iDateTo>=$iDateFrom)
                {
                    array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
                    while ($iDateFrom<$iDateTo)
                    {
                        $iDateFrom+=86400; // add 24 hours
                        array_push($aryRange,date('Y-m-d',$iDateFrom));
                    }
                }
                return $aryRange;
            }

            if($data != null){
                foreach ($data as $key => $value) {
                    $tanggal_mulai      = $value['tanggal_mulai'];
                    $tanggal_selesai    = $value['tanggal_selesai'];
                    $keterangan         = $value['keterangan'];
                    $id                 = $value['id'];
                    $nama_kegiatan      = $value['nama_kegiatan'];
                    $daftar_libur       = createDateRangeArray($tanggal_mulai, $tanggal_selesai);
                   foreach ($daftar_libur as $key => $value) {
                        $data[] = [
                            'tanggal_mulai' => $value,
                            'keterangan'    => $keterangan,
                            'id'            => $id,
                            'nama_kegiatan' => $nama_kegiatan,
                        ];
                    }
                }
                
                $data           = array_map("unserialize", array_unique(array_map("serialize", $data)));
                $cek_hari_libur = array_search($tanggal, array_column($data, 'tanggal_mulai'));
                $data           = array_filter($data, function($var) use ($tanggal) {
                    return ($var['tanggal_mulai'] == $tanggal);
    
                });
                // dd($data);
                $data = array_values($data);
                if($cek_hari_libur == true || $cek_hari_libur != ''){
                    return redirect()->to(base_url().'/guru')->with('pesan_error', 'Aktivitas Sekolah tanggal ' . date('d-m-Y', strtotime($tanggal)) . ' ' . $data[0]['keterangan'] . '. Karena ' . $data[0]['nama_kegiatan']);
                }else{
                    $jadwal     = $this->jadwal->find_kelas($hari, $jam, $guru, $id_akademik);
                    if($jadwal != null){
                        $kelas      = $this->kelas->find($jadwal[0]['id_kelas']); 
                        $nama_kelas = kelas($kelas['kelas']) . ' ' . $kelas['jurusan'] . ' ' . $kelas['kelompok'];
                        $id_kelas   = $kelas['id_kelas'];
                        $mapel      = $this->mapel->find($jadwal[0]['id_mapel']);
                        // dd($mapel);
                        $nama_mapel = $mapel['nama_mapel'];
                        $id_mapel   = $mapel['id_mapel'];
                        $kelas      = $id_kelas;
                        $cek = $this->absen
                             ->where('id_kelas', $id_kelas)
                             ->where('tanggal_presensi', $tanggal)
                             ->where('id_mapel', $id_mapel)
                             ->findAll();
        
                        if($cek != null){
                            session()->setFlashdata('pesan_error', 'Presensi kelas '. $nama_kelas . ' sudah dilakukan');
                            return redirect()->to(base_url().'/guru');
                        }else{
                            $data = [
        
                                    'parameter'     => 'presensi',
                                    'id_kelas'      => $id_kelas,
                                    'kelas'         => $nama_kelas,
                                    'id_mapel'      => $id_mapel,
                                    'nama_mapel'    => $nama_mapel,
                                    'siswa'         => $this->siswa->where('id_kelas', $id_kelas)->findAll(),
                                    'presensi'      => $this->absen->where('id_kelas', $id_kelas)->findAll(),
                                ];
                                // dd($data);
                            return view('guru/content/presensi', $data);
                        }
                    }else{
                        return redirect()->to(base_url().'/guru')->with('pesan_error', 'Tidak ada jadwal Presensi kelas Pada Waktu Ini');
                    }
                }
            }else{
                $jadwal     = $this->jadwal->find_kelas($hari, $jam, $guru, $id_akademik);
                // dd($hari);
                if($jadwal != null){
                    $kelas      = $this->kelas->find($jadwal[0]['id_kelas']); 
                    // dd($kelas);
                    $nama_kelas = kelas($kelas['kelas']) . ' ' . $kelas['jurusan'] . ' ' . $kelas['kelompok'];
                    $id_kelas   = $kelas['id_kelas'];
                    $mapel      = $this->mapel->find($jadwal[0]['id_mapel']);
                    // dd($mapel, $jadwal);
                    $nama_mapel = $mapel['nama_mapel'];
                    $id_mapel   = $mapel['id_mapel'];
                    $kelas      = $id_kelas;
                    $cek        = $this->absen
                                 ->where('id_kelas', $id_kelas)
                                 ->where('tanggal_presensi', $tanggal)
                                 ->where('id_mapel', $id_mapel)
                                 ->findAll();
    
                    if($cek != null){
                        session()->setFlashdata('pesan_error', 'Presensi kelas '. $nama_kelas . ' sudah dilakukan');
                        return redirect()->to(base_url().'/guru');
                    }else{
                        $data = [
    
                                'parameter'     => 'presensi',
                                'id_kelas'      => $id_kelas,
                                'kelas'         => $nama_kelas,
                                'id_mapel'      => $id_mapel,
                                'nama_mapel'    => $nama_mapel,
                                'siswa'        => $this->siswa->where('id_kelas', $id_kelas)->findAll(),
                                // 'presensi'      => $this->absen->where('id_kelas', $id_kelas)->findAll(),
                                'presensi'      => $this->absen->where('id_kelas', $id_kelas)->where('id_mapel', $id_mapel)->findAll(),
                            ];
                        // dd($data);
                        return view('guru/content/presensi', $data);
                    }
                }else{
                    return redirect()->to(base_url().'/guru')->with('pesan_error', 'Tidak ada jadwal Presensi kelas Pada Waktu Ini');
                }
            }           
        }
    }

    public function presensi_terlambat(){
        $days   = ['0'=>'singgu', '1'=>'senin', '2'=>'selasa', '3'=>'rabu', '4'=>'kamis', '5'=>"jum'at", '6'=>'sabtu'];
        $kode   = $this->request->getPost('kode');
        $cek    = $this->token->where('token', $kode)->findAll();
        if($cek != NULL){
            if($cek[0]['nip'] == session()->get('nip')){
                if($cek[0]['expired'] < date('Y-m-d H:i:s')){
                    session()->setFlashdata('pesan_error', 'Token Sudah Expired');
                    return redirect()->to(base_url().'/guru');
                }else{
                    $tanggal    = date('d', strtotime($cek[0]['tanggal']));
                    $nama_hari  = $days[date('w', strtotime($cek[0]['tanggal']))];
                    $mapel      = $this->jadwal
                        ->where('id_kelas', $cek[0]['kelas'])
                        ->where('hari', $nama_hari)
                        ->where('id_tahun', $cek[0]['id_tahun'])
                        ->where('nip', $cek[0]['nip'])
                        ->findAll();
                    $nama_mapel = $this->mapel
                        ->where('id_mapel', $mapel[0]['id_mapel'])
                        ->findAll();
                    $nama_kelas = $this->kelas
                        ->where('id_kelas', $cek[0]['kelas'])
                        ->first();
                    
                    if($cek != null){
                        $cek_absen = $this->absen
                        ->where('id_kelas', $cek[0]['kelas'])
                        ->where('tanggal_presensi', $cek[0]['tanggal'])
                        ->where('id_mapel',$mapel[0]['id_mapel'])
                        ->findAll();
                        // dd($cek, $kode, $nama_kelas, $cek_absen, $mapel);
                        // dd($cek_absen);
                        if($cek_absen != null){
                            // session()->setFlashdata('pesan_error', 'Presensi Sudah Dilakukan');
                            return redirect()->to(base_url().'/guru')->with('pesan_error', 'Presensi Sudah Dilakukan');
                        }else{
                            $data = [
                                'parameter'     => 'presensi',
                                'id_kelas'      => $cek[0]['kelas'],
                                'kelas'         => kelas($nama_kelas['kelas']). ' ' .$nama_kelas['jurusan'] . ' ' .$nama_kelas['kelompok'],
                                'id_mapel'      => $nama_mapel[0]['id_mapel'],
                                'waktu'         => $cek[0]['tanggal'],
                                'nama_mapel'    => $nama_mapel[0]['nama_mapel'],
                                'siswa'         => $this->siswa
                                                   ->where('id_kelas', $cek[0]['kelas'])
                                                   ->findAll(),
                                'presensi'      => $this->absen
                                                   ->where('id_kelas', $cek[0]['kelas'])
                                                   ->where('id_mapel')
                                                   ->findAll(),
                            ];
                            
                            return view('guru/content/presensi_terlambat', $data);
                        }
                    }else{
                        // session()->setFlashdata('pesan_error', 'Token Tidak Valid');
                        return redirect()->to(base_url().'/guru')->with('pesan_error', 'Token Tidak Valid');
                    }
                }
            }else{
                // session()->setFlashdata('pesan_error', 'Token Ini Bukan Milik Anda');
                return redirect()->to(base_url().'/guru')->with('pesan_error', 'Token Ini Bukan Milik Anda');
            }
        }else{
            return redirect()->to(base_url().'/guru')->with('pesan_error', 'Token TIDAK VALID');
        }
    }


    public function notiv($get_hari, $jam){
        $nama_hari  = Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "jum\'\at",'Sabtu');
        $hari       = $nama_hari[$get_hari];
        $guru       = session()->get('nip');
        $tanggal    = date('Y-m-d');
        $bulan      = date('m', strtotime($tanggal));
        $tahun      = date('Y', strtotime($tanggal));
        // dd($get_hari, $jam, $hari);

        // ambil data dari sql yang bulannya sama
        $data = $this->kalender
                ->where('month(tanggal_mulai)', $bulan)
                ->where('year(tanggal_mulai)', $tahun)
                ->where('month(tanggal_selesai)', $bulan)
                ->where('year(tanggal_selesai)', $tahun)
                ->where('id_tahun_akademik', session()->get('id_akademik'))
                ->findAll();

        function createDateRangeArray($strDateFrom,$strDateTo)
        {
            $aryRange   = array();
            $iDateFrom  = mktime(1,0,0,substr($strDateFrom,5,2),substr($strDateFrom,8,2),substr($strDateFrom,0,4));
            $iDateTo    = mktime(1,0,0,substr($strDateTo,5,2),substr($strDateTo,8,2),substr($strDateTo,0,4));
            if ($iDateTo >= $iDateFrom)
            {
                array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
                while ($iDateFrom<$iDateTo)
                {
                    $iDateFrom += 86400; // add 24 hours
                    array_push($aryRange,date('Y-m-d',$iDateFrom));
                }
            }
            return $aryRange;
        }
        // dd($data);
        if($data != null){
            foreach ($data as $key => $value) {
                $tanggal_mulai      = $value['tanggal_mulai'];
                $tanggal_selesai    = $value['tanggal_selesai'];
                $keterangan         = $value['keterangan'];
                $id                 = $value['id'];
                $nama_kegiatan      = $value['nama_kegiatan'];
                $daftar_libur       = createDateRangeArray($tanggal_mulai, $tanggal_selesai);

               foreach ($daftar_libur as $key => $value) {
                    $data[] = [
                        'tanggal_mulai' => $value,
                        'keterangan'    => $keterangan,
                        'id'            => $id,
                        'nama_kegiatan' => $nama_kegiatan,
                    ];
                }
            }
            
            $data           = array_map("unserialize", array_unique(array_map("serialize", $data)));
            $cek_hari_libur = array_search($tanggal, array_column($data, 'tanggal_mulai'));
            $data           = array_filter($data, function($var) use ($tanggal) {
                return ($var['tanggal_mulai'] == $tanggal);
            });

            $data = array_values($data);
            if($cek_hari_libur == true || $cek_hari_libur != ''){
                $data = [
                    'id_jadwal'     => '',
                    'hari'          => '',
                    'nama_mapel'    => '',  
                    'nama_kelas'    => '',
                    'status'        => 'Libur',
                    'keterangan'    => 'Hari Ini Tanggal ' . $tanggal .' '. $data[0]['keterangan'].'. Karena ' . $data[0]['nama_kegiatan'],
                ];
                echo json_encode($data);
            }else{
                $row            = $this->jadwal->find_kelas(`$hari`, $jam, $guru, session()->get('id_akademik'));
                
                // $row = $this->jadwal->where('jam_masuk <=', $jam)->findAll();
                if ($row != null) {
                    
                    $kelas      = $this->kelas->where('id_kelas', $row[0]['id_kelas'])->findAll();
                    $nama_kelas = kelas($kelas[0]['kelas']). ' ' .$kelas[0]['jurusan'] . ' ' .$kelas[0]['kelompok'];
                    $id_kelas   = $kelas[0]['id_kelas'];
                    $mapel      = $this->mapel->where('id_mapel', $row[0]['id_mapel'])->findAll();
                    $nama_mapel = $mapel[0]['nama_mapel'];
                    $id_mapel   = $mapel[0]['id_mapel'];
                    $data = [
                        'id_jadwal' => $row[0]['id_jadwal'],
                        'nama_kelas'=> $row[0]['hari'],
                        'id_kelas'  => $id_kelas,
                        'nama_kelas'=> $nama_kelas,
                        'id_mapel'  => $id_mapel,
                        'nama_mapel'=> $nama_mapel,
                        'status'    => '',
                        'keterangan'=> ''
                    ];
                    echo json_encode($data); 
                }else{
                    $data = [
                        'id_jadwal'     => '',
                        'hari'          => '',
                        'nama_mapel'    => '',  
                        'nama_kelas'    => '',
                        'status'        => '',
                        'keterangan'    => ''
                    ];
                    echo json_encode($data);
                }
            }
        }else{
            $row            = $this->jadwal->find_kelas($hari, $jam, $guru, session()->get('id_akademik'));
            
            if ($row != null) {
                
                $kelas      = $this->kelas->where('id_kelas', $row[0]['id_kelas'])->findAll();
                $nama_kelas = kelas($kelas[0]['kelas']) . ' ' . $kelas[0]['jurusan'] . ' ' .$kelas[0]['kelompok'];
                $id_kelas   = $kelas[0]['id_kelas'];
                $mapel      = $this->mapel->where('id_mapel', $row[0]['id_mapel'])->findAll();
                $nama_mapel = $mapel[0]['nama_mapel'];
                $id_mapel   = $mapel[0]['id_mapel'];
                $data = [
                    'id_jadwal' => $row[0]['id_jadwal'],
                    'nama_kelas'=> $hari,
                    'id_kelas'  => $id_kelas,
                    'nama_kelas'=> $nama_kelas,
                    'id_mapel'  => $id_mapel,
                    'nama_mapel'=> $nama_mapel,
                    'keterangan'=> ''
                ];
                echo json_encode($data); 
            }else{
                $data = [
                    'id_jadwal'     => '',
                    'hari'          => '',
                    'nama_mapel'    => '',  
                    'nama_kelas'    => '',
                    'keterangan'    => ''
                ];
                echo json_encode($data);
            }
        }
        
    }

    // public function notiv($get_hari, $jam){
    //     $nama_hari = Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat' ,'Sabtu');
    //     $hari = $nama_hari[$get_hari];
    //     $guru = session()->get('nip');

    //     $row        = $this->jadwal->find_kelas($hari, $jam, $guru, session()->get('id_akademik'));

    //     if ($row != null) {
    //         $kelas      = $this->kelas->where('id_kelas', $row[0]['id_kelas'])->findAll();
    //         $nama_kelas = $kelas[0]['nama_kelas'];
    //         $id_kelas   = $kelas[0]['id_kelas'];
    //         $mapel      = $this->mapel->where('id_mapel', $row[0]['id_mapel'])->findAll();
    //         $nama_mapel = $mapel[0]['nama_mapel'];
    //         $id_mapel   = $mapel[0]['id_mapel'];
    //         $data = [
    //             'id_jadwal' => $row[0]['id_jadwal'],
    //             'nama_kelas'=> $row[0]['hari'],
    //             'id_kelas'  => $id_kelas,
    //             'nama_kelas'=> $nama_kelas,
    //             'id_mapel'  => $id_mapel,
    //             'nama_mapel' => $nama_mapel,
    //         ];
    //         echo json_encode($data); 
    //     }else{
    //         $data = [
    //                 'id_jadwal' => '',
    //                 'hari'    => '',
    //                 'nama_mapel' => '',  
    //                 'nama_kelas' => ''
    //         ];
    //         echo json_encode($data);
    //     }
        
    //     // echo json_encode($data);
    // }

    public function presensi($kelas, $nama_mapel, $hari){
        if (session()->get('hak_akses') != 'guru') {
            return redirect()->to(base_url('login'));
        }else{
            $kelas      = $this->kelas->where('id_kelas', $kelas)->first();
            // dd($kelas, );
            $id_kelas   = $kelas['id_kelas'];
            $nama_kelas = $kelas['jurusan'];
            $tanggal    = date('Y-m-d');
            // dd($nama_mapel);
            $cek = $this->absen->where('id_kelas', $id_kelas)->where('id_mapel', $nama_mapel)->where('tanggal_presensi', $tanggal)->findAll();
            // dd($cek);
            if(hari_ini(date("D")) != $hari){
                session()->setFlashdata('pesan', 'Presensi kelas '. $nama_kelas . ' tidak bisa dilakukan karena hari ini bukan hari '. $hari);
                return redirect()->to(base_url().'/guru');
            }else{
                if($cek != null){
                    session()->setFlashdata('pesan', 'Presensi kelas '. $nama_kelas . ' sudah dilakukan');
                    return redirect()->to(base_url().'/guru');
                }else{
                    
                    $mapel      = $this->mapel->where('id_mapel', $nama_mapel)->first();
                    $id_mapel   = $mapel['id_mapel'];
                    $nama_mapel = $mapel['nama_mapel'];

                    $data = [
                        'parameter'     => 'presensi',
                        'id_kelas'      => $id_kelas,
                        'kelas'         => $nama_kelas,
                        'id_mapel'      => $id_mapel,
                        'nama_mapel'    => $nama_mapel,
                        'siswa'         => $this->siswa->where('id_kelas', $id_kelas)->findAll(),
                        // 'presensi'      => $this->absen->where('id_kelas', $id_kelas)->findAll(),
                        'presensi'      => $this->absen->where('id_kelas', $id_kelas)->where('id_mapel', $id_mapel)->findAll(),
                    ];
                    // dd($data);
                    return view('guru/content/presensi', $data);
                }
            }
        }
    }
}