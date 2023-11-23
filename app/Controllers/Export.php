<?php

namespace App\Controllers;

use function PHPSTORM_META\map;
// use dompdf

use CodeIgniter\HTTP\Response;
use Dompdf\Dompdf;



class Export extends BaseController
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
        helper(['form','array','url', 'kelas','hari']);
        date_default_timezone_set('Asia/Jakarta');
        $this->thn_akademik = session()->get('tahun_akademik');
        $this->semester = session()->get('semester');
        $this->jadwal_mengajar = new \App\Models\M_jadwal();
        $this->validasi =  \Config\Services::validation();
    }

    public function import_siswa(){
        // $file = $this->request->getFile('file');
        $file = $this->request->getFile('fileexcel');
        // dd($file);
        $extensi = $file->getClientExtension();
        if($extensi == 'xlsx' || $extensi == 'xls'){
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            // dd($sheetData);
            // cek kelas apakah 
            $data = [];
            foreach ($sheetData as $key => $value) {
                if($key > 0){
                    $kelas = $value[2].' '.$value[3].' '.$value[4];
                    // cek kelas apakah ada di database
                    $cek_kelas = $this->kelas->where('kelas', $value[2])->where('jurusan', $value[3])->where('kelompok', $value[4])->first();
                    if($cek_kelas == ''){
                        $pesan = 'Kelas Tidak Ada';
                        $id_kelas = '';
                    }else{
                        $pesan = '';
                        $id_kelas = $cek_kelas['id_kelas'];
                    }

                    $data[] = [
                        'nis_siswa'     => $value[0],
                        'nama_siswa'    => $value[1],
                        'kelas'         => $kelas,
                        // 'jurusan'       => $value[3],
                        // 'kelompok'      => $value[4],
                        'tanggal_lahir' => date('d-m-Y', strtotime($value[5])),
                        'tahun_masuk'   => $value[6],
                        'jenis_kelamin' => $value[7],
                        'status'        => $value[8],
                        'tahun_lulus'   => $value[9],
                        'informasi'     => $pesan,
                        'id_kelas'      => $id_kelas
                    ];
                }
            }
            $data = [
                'parameter' => "Tes",
                'data' => $data
            ];
            
        }
        return view('tu/content/preview_import', $data);

        // dd($data['data'][0]);
    }

    public function save(){

        $data = $this->request->getPost('data');
        foreach ($data as $key => $value) {
            if($value['id_kelas'] != ''){
                $cek_nis = $this->siswa->where('nis_siswa', $value['nis_siswa'])->first();
                if($cek_nis == ''){
                    $this->siswa->insert([
                        'nis_siswa'     => $value['nis_siswa'],
                        'nama_siswa'    => $value['nama_siswa'],
                        'id_kelas'      => $value['id_kelas'],
                        // tanggal lahir
                        'tanggal_lahir' => date('Y-m-d', strtotime($value['tanggal_lahir'])),
                        'tahun_masuk'   => $value['tahun_masuk'],
                        'jenis_kelamin' => $value['jenis_kelamin'],
                        'status'        => $value['status'],
                        'tahun_lulus'   => $value['tahun_lulus']
                    ]);
                }else{
                    $update = [
                        'nis_siswa'     => $value['nis_siswa'],
                        'nama_siswa'    => $value['nama_siswa'],
                        'id_kelas'      => $value['id_kelas'],
                        // tanggal lahir
                        'tanggal_lahir' => date('Y-m-d', strtotime($value['tanggal_lahir'])),
                        'tahun_masuk'   => $value['tahun_masuk'],
                        'jenis_kelamin' => $value['jenis_kelamin'],
                        'status'        => $value['status'],
                        'tahun_lulus'   => $value['tahun_lulus']
                    ];
                    $this->siswa->where('nis_siswa', $value['nis_siswa'])->set($value)->update();
                    
                }
            }
        }


        $response = [
            'status' => '200',
            'pesan' => 'Data Tersimpan'
        ];
        return $this->response->setJSON($response);
    }

    public function rekap_presensi(){
        $id_kelas = $this->request->getPost('id_kelas_rekap');
        $tahun = $this->request->getPost('tahun_akademik');
        $jenis_file = $this->request->getPost('jenis_file');
        
        // dd($id_kelas, $tahun, $jenis_file);
        $data =[
            'id_kelas' => $id_kelas,
            'tahun_akademik' => $tahun,
            'jenis_file' => $jenis_file
        ];
        
        $hasil_presensi = $this->absen->where('id_tahun', $tahun)->where('id_kelas', $id_kelas)->findAll();
        $kalender = $this->kalender->where('id_tahun_akademik', $tahun)->where('keterangan', 'Libur')->findAll();
        // dd($hasil_presensi, $kalender);
        // masukkan kalender libur kedalamn araay
        $kalender_mulai_libur = [];
        $kalender_selesai_libur = [];
        foreach ($kalender as $key => $value) {
            $kalender_mulai_libur[] = $value['tanggal_mulai'];
            $kalender_selesai_libur[] = $value['tanggal_selesai'];
        }
        // sisipkan tanggal libur kedalam array tanggal absen
        $tanggal_absen = [];
        foreach ($hasil_presensi as $key => $value) {
            $tanggal_absen[$key]['tanggal'] = $value['tanggal_presensi'];
            $tanggal_absen[$key]['status'] = $value['status'];
            $tanggal_absen[$key]['nis_siswa'] = $value['nis_siswa'];
            $tanggal_absen[$key]['id_mapel'] = $value['id_mapel'];
        }
        // dd($tanggal_absen);
        // create date range
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

        // buat libur berdasarkan tanggal mulai libur dan akhir
        foreach ($kalender_mulai_libur as $key => $value) {
            $tanggal_mulai_libur = $value;
            $tanggal_selesai_libur = $kalender_selesai_libur[$key];
            $tanggal_libur = createDateRangeArray($tanggal_mulai_libur, $tanggal_selesai_libur);

            foreach ($tanggal_libur as $key => $value) {
                // cari nama hari dari value
                $nama_hari = date('D', strtotime($value));
                $nama_hari = hari_ini($nama_hari);
                $mapel_libur = $this->jadwal_mengajar->select('id_mapel')->where('id_kelas', $id_kelas)->where('hari', $nama_hari)->where('id_tahun', $tahun)->first();
                if($mapel_libur != ''){
                    $mapel = $mapel_libur['id_mapel'];
                }else{
                    $mapel = '';
                }
                $tanggal_absen[] = [
                    'tanggal'   => $value,
                    'status'    => 'Libur',
                    'nis_siswa' => '',
                    'id_mapel'  => $mapel
                ];
            }

        }
        
        $val = [];
        foreach ($tanggal_absen as $key => $value) {
            $val[$key]['nis_siswa'] = $value['nis_siswa'];
            $val[$key]['id_mapel'] = $value['id_mapel'];
            $val[$key]['status'] = $value['status'];
            // urutkan tanggal
            $val[$key]['tanggal'] = date('d-m-Y', strtotime($value['tanggal']));
        }
        // dd($val);
        // mapping array
        $val = array_map("unserialize", array_unique(array_map("serialize", $val)));

        usort($val, function($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        $data =[
            'daftar_siswa'  => $this->siswa->where('id_kelas', $id_kelas)->findAll(),
            'data'          => $val,
            'parameter'     => 'Presensi',
            // 'daftar_mapel'  => $this->jadwal_mengajar->select('id_mapel')->where('id_kelas', $id_kelas)->where('id_tahun', $tahun)->groupBy('id_mapel')->findAll(),
            'daftar_mapel'  => $this->jadwal_mengajar->join('tb_mapel', 'tb_mapel.id_mapel = jadwal_pelajaran.id_mapel')->select('jadwal_pelajaran.id_mapel, tb_mapel.nama_mapel')->where('id_kelas', $id_kelas)->where('id_tahun', $tahun)->groupBy('jadwal_pelajaran.id_mapel')->findAll(),
        ];
        
        // dd($data);
        return view('tu/content/pdf', $data);
    }

    public function test_export(){
        $id_kelas = $this->request->getPost('id_kelas_rekap');
        $tahun = $this->request->getPost('tahun_akademik');
        $jenis_file = $this->request->getPost('jenis_file');
        
        // dd($id_kelas, $tahun, $jenis_file);
        $data =[
            'id_kelas' => $id_kelas,
            'tahun_akademik' => $tahun,
            'jenis_file' => $jenis_file
        ];
        // dd($data);
        $ta = $this->tahun_akademik->where('id_tahun', $tahun)->first();
        $hasil_presensi = $this->absen->where('id_tahun', $tahun)->where('id_kelas', $id_kelas)->findAll();
        // dd($hasil_presensi);
        $kalender = $this->kalender->where('id_tahun_akademik', $tahun)->where('keterangan', 'Libur')->findAll();
        // dd($hasil_presensi, $kalender);
        // masukkan kalender libur kedalamn araay
        $kalender_mulai_libur = [];
        $kalender_selesai_libur = [];
        foreach ($kalender as $key => $value) {
            $kalender_mulai_libur[] = $value['tanggal_mulai'];
            $kalender_selesai_libur[] = $value['tanggal_selesai'];
        }
        // sisipkan tanggal libur kedalam array tanggal absen
        $tanggal_absen = [];
        // dd($hasil_presensi);
        foreach ($hasil_presensi as $key => $value) {
            $tanggal_absen[$key]['tanggal'] = $value['tanggal_presensi'];
            $tanggal_absen[$key]['status'] = $value['status'];
            $tanggal_absen[$key]['nis_siswa'] = $value['nis_siswa'];
            $tanggal_absen[$key]['id_mapel'] = $value['id_mapel'];
        }
        // dd($tanggal_absen);
        // create date range
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

        // buat libur berdasarkan tanggal mulai libur dan akhir
        foreach ($kalender_mulai_libur as $key => $value) {
            $tanggal_mulai_libur = $value;
            $tanggal_selesai_libur = $kalender_selesai_libur[$key];
            $tanggal_libur = createDateRangeArray($tanggal_mulai_libur, $tanggal_selesai_libur);

            foreach ($tanggal_libur as $key => $value) {
                // cari nama hari dari value
                $nama_hari = date('D', strtotime($value));
                $nama_hari = hari_ini($nama_hari);
                $mapel_libur = $this->jadwal_mengajar->select('id_mapel')->where('id_kelas', $id_kelas)->where('hari', $nama_hari)->where('id_tahun', $tahun)->first();
                if($mapel_libur != ''){
                    $mapel = $mapel_libur['id_mapel'];
                }else{
                    $mapel = '';
                }
                $tanggal_absen[] = [
                    'tanggal'   => $value,
                    'status'    => 'Libur',
                    'nis_siswa' => '',
                    'id_mapel'  => $mapel
                ];
            }

        }
        
        $val = [];
        foreach ($tanggal_absen as $key => $value) {
            $val[$key]['nis_siswa'] = $value['nis_siswa'];
            $val[$key]['id_mapel'] = $value['id_mapel'];
            $val[$key]['status'] = $value['status'];
            // urutkan tanggal
            $val[$key]['tanggal'] = date('d-m-Y', strtotime($value['tanggal']));
        }

        // mapping array
        $val = array_map("unserialize", array_unique(array_map("serialize", $val)));

        usort($val, function($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        $gambar         = 'data:image;base64,'.base64_encode(@file_get_contents('assets/logo.jpg'));
        $daftar_siswa   = $this->siswa->where('id_kelas', $id_kelas)->findAll();
        $mapel          = $this->jadwal_mengajar
                        ->join('tb_mapel', 'tb_mapel.id_mapel = jadwal_pelajaran.id_mapel')
                        ->select('jadwal_pelajaran.id_mapel, tb_mapel.nama_mapel')
                        ->where('id_kelas', $id_kelas)
                        ->where('id_tahun', $tahun)
                        ->groupBy('jadwal_pelajaran.id_mapel')
                        ->findAll();

        if($ta['semester'] == '1'){
            $satuan = 'Ganjil';}
        else{
            $satuan = 'Genap';
        }
        $kelas = $this->kelas->where('id_kelas', $id_kelas)->first();
        // $kelas
        $kelas = kelas($kelas['kelas']) . ' ' . $kelas['jurusan'] . ' ' . $kelas['kelompok'];
        // dd($kelas);
        $data = [
            'kelas'         => $kelas,
            'tahun'         => $ta['tahun'],
            'semester'      => $ta['semester'],
            'satuan'        => $satuan,
            'gambar' => $gambar,
            'daftar_siswa'  => $daftar_siswa,
            'data'          => $val,
            'parameter'     => 'Presensi',
            'daftar_mapel'  => $mapel,
            'total_mapel'   => count($mapel)
        ];
        // dd($data);
        // dd(count($data['daftar_mapel']));

        $filename = 'Rekap Presensi Kelas' . $kelas . ' Tahun ' . $ta['tahun'] . ' Semester ' . $satuan;
        $html = view('tu/export/test', $data);
        $dompdf = new Dompdf();
        $dompdf->set_option("isPhpEnabled", true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'Potrait');
        $dompdf->render();
        $dompdf->stream($filename, array("Attachment" => false));
        exit(0);


        // return view('tu/export/test', $data);
    }
}