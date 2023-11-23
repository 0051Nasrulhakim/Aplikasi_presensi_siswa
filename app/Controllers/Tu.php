<?php

namespace App\Controllers;

use SebastianBergmann\CodeUnit\FunctionUnit;

use function PHPSTORM_META\map;

class Tu extends BaseController
{
    public function __construct()
    {
        $this->absen = new \App\Models\M_absen();
        $this->siswa = new \App\Models\M_getData();
        $this->guru = new \App\Models\M_guru();
        $this->kelas = new \App\Models\M_getKelas();
        $this->mapel = new \App\Models\M_mapel();
        $this->jadwal = new \App\Models\M_jadwal();
        $this->tahun_akademik = new \App\Models\M_tahun_akademik();
        $this->kalender = new \App\Models\M_kalender();
        helper(['form','array','url', 'kelas', 'hari']);
        date_default_timezone_set('Asia/Jakarta');
        $this->thn_akademik = session()->get('tahun_akademik');
        $this->semester = session()->get('semester');
        $this->jadwal_mengajar = new \App\Models\M_jadwal();
        $this->validasi =  \Config\Services::validation();
        $this->token = new \App\Models\M_token();
    }

    public function index()
    {
        // dd(session()->get('tahun_akademik'));
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter' => '',
                'tahun_akademik' => $this->thn_akademik,
                'semester'       => $this->semester,
            ];
            return view('tu/content/index', $data);
        }
    }

    public function jadwal_mengajar(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter' => 'Jadwal Mengajar',
                'kelas'     => $this->kelas->orderBy('kelas', 'asc')->findAll(),
                // 'kelas'     => $this->kelas->findAll(),
                'data'      => $this->mapel->findAll()
            ];
            // dd($data);
            return view('tu/content/jadwal_mengajar', $data);
        }
    }
    public function form_jadwal(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'tahun_akademik' => $this->tahun_akademik->findAll(),
                'parameter' => 'Jadwal Mengajar',
                'kelas'     => $this->kelas->findAll(),
                'mapel'     => $this->mapel->findAll(),
                'guru'      => $this->guru->findAll(),
            ];
            return view('tu/form/tambah_jadwal', $data);
        }
    }

    public function tahun_akademik(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter'          => 'Tahun Akademik',
                'tahun_akademik'      => $this->tahun_akademik->orderBy('tahun', 'DESC')->findAll(),
            ];
            return view('tu/content/tahun_akademik', $data);
        }
    }

    public function form_tahun_akademik(){
        
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter' => 'Tahun Akademik'
            ];

            return view('tu/form/tambah_tahun_akademik', $data);
        }
    }

    public function daftar_guru(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{

            $jumlah_jam = $this->guru->join('jadwal_pelajaran', 'jadwal_pelajaran.nip = tb_guru.nip')->select('count(*) as jumlah_jam, tb_guru.nip')->groupBy('tb_guru.nip')->findAll();
            
            $jumlah_jam = array_column($jumlah_jam, 'jumlah_jam', 'nip');
            $data_guru = $this->guru->select('*, date_format(tanggal_lahir, "%d-%m-%Y") AS tanggal_lahir')->where('nip != 1')->findAll();
            // masukkan jumlah jam ke dalam array data guru

            foreach ($data_guru as $key => $value) {
                // jika nip sama masukkan jumlah jam
                if (array_key_exists($value['nip'], $jumlah_jam)) {
                    $data_guru[$key]['jumlah_jam'] = $jumlah_jam[$value['nip']];
                }else{
                    $data_guru[$key]['jumlah_jam'] = 0;
                }
            }

            $data = [
                'jumlah_jam'=> $jumlah_jam,
                'parameter' => 'Daftar Guru',
                'data'      => $data_guru
            ];
            // dd($data_guru);
            return view('tu/content/daftar_guru', $data);
        }
    }

    public function form_guru(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter' => 'Daftar Guru'
            ];
            return view('tu/form/tambah_guru', $data);
        }
    }

    public function edit_guru($nip){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter' => '',
                'data'      => $this->guru->where('nip', $nip)->findAll()
            ];
            return view('tu/form/edit_guru', $data);
        }
    }
    // ======================= kalender libur ================================

    public function kalender_libur(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'kalender'          => $this->kalender->where('id_tahun_akademik', session()->get('id_akademik'))->findAll(),
                'tahun_akademik'    => $this->tahun_akademik->findAll(),
                'parameter'         => 'Kalender Libur',
            ];
            return view('tu/content/kalender_libur', $data);
        }  
    }

    // ======================= End kalender libur ================================

    // kelas ================= controler kelas ====================================
    public function daftar_kelas(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter' => 'Daftar Kelas',
                'data'      => $this->kelas->findAll()
            ];
            return view('tu/content/daftar_kelas', $data);
        }
    }
    
    public function form_kelas(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter' => ''
            ];
            return view('tu/form/tambah_kelas', $data);
        }
    }

    public function edit_kelas($id){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter' => '',
                'data'      => $this->kelas->find([$id])
            ];
            return view('tu/form/edit_kelas', $data);
        }
    }
    // siswa ================= controler siswa ====================================
    public function form_siswa(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'nis'       => $this->siswa->getNimMax(),
                'parameter' => 'Daftar Siswa',
                'data'      => $this->kelas->findAll(),
                'tahun'     => $this->tahun_akademik->findAll()
            ];
            return view('tu/form/tambah_siswa', $data);
        }
    }
    
    public function daftar_siswa(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $grup_kelas = $this->request->getVar('grup_kelas') ?? '';
            // dd($grup_kelas);
            if($grup_kelas != ""){
                $join = $this->siswa->join('daftar_kelas', 'daftar_kelas.id_kelas = tb_siswa.id_kelas', 'left')->where('tb_siswa.id_kelas', $grup_kelas)->findAll();
                // dd($join);
                $data = [
                    'daftar_kelas' => $this->kelas->findAll(),
                    'parameter'    => 'Daftar Siswa',
                    'grup_kelas'   => $this->kelas->find($grup_kelas),
                    'data'         => $join
                ];
            }else{
                $join = $this->siswa->join('daftar_kelas', 'daftar_kelas.id_kelas = tb_siswa.id_kelas', 'left')->findAll();
                $data = [
                    'daftar_kelas'  => $this->kelas->findAll(),
                    'parameter'     => 'Daftar Siswa',
                    'grup_kelas'    => ['id_kelas' => null, 'nama_kelas' => ''],
                    'data'          => $join
                ];
            }
            return view('tu/content/daftar_siswa', $data);
        }
    }

    public function edit_siswa($nis){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $join = $this->siswa->join('daftar_kelas', 'daftar_kelas.id_kelas = tb_siswa.id_kelas', 'left')->find([$nis]);
            $data = [
                'parameter' => '',
                'kelas'     => $this->kelas->findAll(),
                'data'      => $join
            ];
            // dd($data);
            return view('tu/form/edit_siswa', $data);
        }
    }

    // end siswa ================= controler siswa ====================================

    // presensi ================= controler presensi siswa ==================================== 

    public function presensi(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'tahun_akademik' => $this->tahun_akademik->findAll(),
                'jumlah_siswa'=> $this->siswa->where('status', 'aktif')->findAll(),
                'mapel'     => $this->mapel->findAll(),
                'data'      => $this->kelas->findAll(),
                'parameter' => 'Presensi'
            ];
            return view('tu/content/presensi', $data);
        }
    }

    public function kelola_presensi(){
        $days = ['0'=>'singgu', '1'=>'senin', '2'=>'selasa', '3'=>'rabu', '4'=>'kamis', '5'=>"jum'at", '6'=>'sabtu'];
        $kategori = $this->request->getVar('kategori');
        $tahun_akademik = $this->request->getVar('tahun_akademik');
        $kategori = $this->request->getVar('kategori');
        $kelas = $this->request->getVar('id_kelas');
        $mapel = $this->request->getVar('mapel');
        $tanggal = $this->request->getVar('tanggal');
        $date = date('Y-m-d');
        $hari = date('w', strtotime($tanggal));
        $via = $this->request->getVar('via');
        $nomor = $this->request->getVar('nomor');
        $nama_hari= $days[$hari];
        // validasi
        $data = [
            'tahun' => $tahun_akademik,
            'kategori' => $kategori,
        ];
        if($this->validasi->run($data, 'kelola') == FALSE){
            session()->setFlashData('errors', $this->validasi->getErrors());
            return redirect()->to(base_url('tu/presensi'));
        }else{
            if($kategori == 'keterlambatan_presensi'){
                if($tanggal < $date){
                    $cek = $this->absen->where('id_kelas', $kelas)->where('id_kelas', $mapel)->where('tanggal_presensi', $tanggal)->findAll();
                    if ($cek != null) {
                        session()->setFlashdata('pesan', 'Data Presensi Sudah Ada');
                        return redirect()->to(base_url('tu/presensi'));
                    }else{
                        $find = $this->jadwal_mengajar->where('id_kelas', $kelas)->where('id_mapel', $mapel)->where('id_tahun', $tahun_akademik)->where('hari', $nama_hari)->findAll();
                        // $find = $this->jadwal_mengajar->find_jadwal($hari, $kelas, $tahun_akademik, $mapel);
                        // dd($mapel, $tahun_akademik, $nama_hari, $find, $kelas);
                        if($find != null){
                            $tanggal_token= date('ymd');
                            $jam  = date('Y-m-d H:i:s');
                            $expired = date('Y-m-d H:i:s', strtotime('+3 hours', strtotime($jam)));
                            $tex_num= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
                            $token  = substr(str_shuffle($tex_num), 0, 5);
                            $key    = $token.$tanggal_token;
                            // dd($key);
                            $data = [
                                'id_tahun' => $tahun_akademik,
                                'tanggal'   => $tanggal,
                                'token'     => $key,
                                'kategori'  => 'keterlambaran_presensi',
                                'nip'       => $find[0]['nip'],
                                'kelas'     => $kelas,
                                'created_ad'=> $jam,
                                'expired'   => $expired
                            ];
                            $this->token->insert($data);
                            if($via == 'wa'){
                                // echo '<script>window.location.replace("https://api.whatsapp.com/send?phone='.$nomor.'&text='.$key.'");</script>';
                                echo '<script>window.location.replace("https://kirimwa.id/'.$nomor.':'.$key.'");</script>';
                            }else{
                                session()->setFlashdata('pesan', 'TOKEN BERHASIL DIBUAT DENGAN KODE : '.$key);
                                return redirect()->to(base_url('tu/presensi'));
                            }
                        }else{
                            // flash data
                            session()->setFlashdata('pesan', 'Pada Tanggal Tersebut Tidak Ada Mapel Yang Dimaksud');
                            return redirect()->to(base_url('tu/presensi'));
                        }
                    }
                }else{
                    // flash data
                    session()->setFlashdata('pesan', 'Tanggal Presensi Tidak Boleh Lebih Dari Hari Ini');
                    return redirect()->to(base_url('tu/presensi'));
                }
            }
        }
    }

    public function laporan_presensi_kelas(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $kelas = $this->request->getVar('id_kelas');
            $tahun_akademik = $this->request->getVar('tahun_akademik');
            $find_kelas = $this->kelas->find([$kelas]);
            // dd($find_kelas);
            $akademik= $this->tahun_akademik->where('id_tahun', $tahun_akademik)->first();
            $data = [
                'akademik'     => $akademik,
                'parameter' => 'Presensi',
                'presensi' => $this->absen->where('id_kelas', $kelas)->where('id_tahun', $tahun_akademik)->findAll(),
                'kelas'=> kelas($find_kelas[0]['kelas']).' '.$find_kelas[0]['jurusan'].' '.$find_kelas[0]['kelompok'],
                'id_kelas' => $kelas,
                'data_kelas'=> $this->siswa->getKelas($kelas),
            ];
            // dd($data);
            return view('tu/content/daftar_kehadiran', $data);
        }
    }

    public function list_daftar_mapel($nis, $akademik, $id_kelas){

        $daftar_mapel = $this->jadwal
            ->select('jadwal_pelajaran.id_mapel, tb_mapel.nama_mapel')
            ->join('tb_mapel', 'tb_mapel.id_mapel = jadwal_pelajaran.id_mapel', 'left')
            ->where('jadwal_pelajaran.id_kelas', $id_kelas)
            ->where('tb_mapel.id_mapel = jadwal_pelajaran.id_mapel')
            ->groupBy('jadwal_pelajaran.id_mapel')
            ->findAll();
        // dd($daftar_mapel);

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
        return view('tu/content/list_daftar_mapel', $data);
    }

    public function detail_presensi_siswa($nis, $akademik, $id_kelas, $id_mapel){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $daftar_mapel = $this->jadwal->select('id_mapel')->where('id_kelas', $id_kelas)->groupBy('id_mapel')->findAll();
            // dd($daftar_mapel);
            $join = $this->siswa->join('daftar_kelas', 'daftar_kelas.id_kelas = tb_siswa.id_kelas', 'left')->find([$nis]);
            $nama_mapel = $this->mapel->where('id_mapel', $id_mapel)->first();
            // dd($nama_mapel);
            $nama_guru = $this->jadwal
            ->join('tb_guru', 'tb_guru.nip = jadwal_pelajaran.nip')
            ->where('id_mapel', $id_mapel)
            ->where('id_kelas', $id_kelas)
            ->first();
            $nama_guru = $nama_guru['nama_guru'];
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
                'nama_guru'     => $nama_guru,
                'terlambat'     => $terlambat
            ];
            // dd($data);
            return view('tu/content/detail_presensi_siswa', $data);
        }
    }

    // end presensi ================= controler presensi siswa ====================================

    // testing page


    public function testing($get_hari, $jam){
        $hari = 'kamis';
        $tanggal = '2023-03-11';
        $tanggal = date('Y-m-d', strtotime($tanggal));
        $guru = '196602121992032006';

        // ambil bulan dari tanggal
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

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
                $tanggal_mulai = $value['tanggal_mulai'];
                $tanggal_selesai = $value['tanggal_selesai'];
                $keterangan = $value['keterangan'];
                $id = $value['id'];
                $nama_kegiatan = $value['nama_kegiatan'];
                $daftar_libur = createDateRangeArray($tanggal_mulai, $tanggal_selesai);
                foreach ($daftar_libur as $key => $value) {
                    $data[$key]['id'] = $id;
                    $data[$key]['nama_kegiatan'] = $nama_kegiatan;
                    $data[$key]['tanggal_mulai'] = $value;
                    $data[$key]['tanggal_selesai'] = $tanggal_selesai;
                    $data[$key]['keterangan'] = $keterangan;
                }
            }

            $data = array_map("unserialize", array_unique(array_map("serialize", $data)));
            $cek_hari_libur = array_search($tanggal, array_column($data, 'tanggal_mulai'));
            $data = array_filter($data, function($var) use ($tanggal) {
                return ($var['tanggal_mulai'] == $tanggal);

            });

            $data = array_values($data);
            if($cek_hari_libur == true){
                $data = [
                    'id_jadwal'     => '',
                    'hari'          => '',
                    'nama_mapel'    => '',  
                    'nama_kelas'    => '',
                    'keterangan'    => 'Hari Ini Tanggal ' . $tanggal .' '. $data[0]['keterangan'].'. Karena' . $data[0]['nama_kegiatan'],
                ];
                echo json_encode($data);
            }else{
                $row        = $this->jadwal->find_kelas($hari, $jam, $guru, session()->get('id_akademik'));
                if ($row != null) {
                    $kelas      = $this->kelas->where('id_kelas', $row[0]['id_kelas'])->findAll();
                    $nama_kelas = $kelas[0]['nama_kelas'];
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
                        'nama_mapel' => $nama_mapel,
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
        }else{
            $row        = $this->jadwal->find_kelas($hari, $jam, $guru, session()->get('id_akademik'));
            if ($row != null) {
                $kelas      = $this->kelas->where('id_kelas', $row[0]['id_kelas'])->findAll();
                $nama_kelas = $kelas[0]['nama_kelas'];
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
                    'nama_mapel' => $nama_mapel,
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

    // mapel ================= controler mapel ====================================
    public function daftar_mapel(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $daftar_mapel = $this->mapel->findAll();
            // dd($daftar_mapel);
            $data = [
                'parameter' => 'Daftar Mapel',
                'data'      => $daftar_mapel
            ];
            return view('tu/content/daftar_mapel', $data);
        }
    }
    public function form_mapel(){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'guru'      => $this->guru->findAll(),
                'parameter' => 'Daftar Mapel'
            ];
            return view('tu/form/tambah_mapel', $data);
        }
    }

    public function daftar_jadwal($id){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $join = $this->jadwal
            ->join('daftar_kelas', 'daftar_kelas.id_kelas = jadwal_pelajaran.id_kelas',)
            ->join('tb_mapel', 'tb_mapel.id_mapel = jadwal_pelajaran.id_mapel')
            ->join('tb_guru', 'tb_guru.nip = jadwal_pelajaran.nip')
            ->where('jadwal_pelajaran.id_kelas', $id)
            ->where('id_tahun', session()->get('id_akademik'))
            ->orderBy('jadwal_pelajaran.jam_masuk', 'ASC')
            ->findAll();
            $data = [
                'parameter' => 'Daftar Jadwal',
                'kelas'     => $this->kelas->where('id_kelas', $id)->first(),
                'data'      => $join
            ];
            // dd($data);
            return view('tu/content/daftar_jadwal', $data);
        }
    }
    
    

    public function edit_mapel($id){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $data = [
                'parameter' => 'Daftar Mapel',
                'guru'      => $this->guru->findAll(),
                'data'      => $this->mapel->where('id_mapel', $id)->findAll()
            ];
            // dd($data);
            return view('tu/form/edit_mapel', $data);
        }
    }
    // end mapel ================= controler mapel ====================================

}
