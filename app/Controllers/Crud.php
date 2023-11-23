<?php

namespace App\Controllers;

class Crud extends BaseController
{
    public function __construct()
    {
        $this->siswa            = new \App\models\M_getData();
        $this->guru             = new \App\Models\M_guru();
        $this->kelas            = new \App\Models\M_getKelas();
        $this->absen            = new \App\Models\M_absen();
        $this->validasi         = \Config\Services::validation();
        $this->mapel            = new \App\Models\M_mapel();
        $this->jadwal           = new \App\Models\M_jadwal();
        $this->kalender         = new \App\Models\M_kalender();
        $this->user             = new \App\Models\M_user();
        $this->tahun_akademik   = new \App\Models\M_tahun_akademik;
        $this->encrypter        = \Config\Services::encrypter();
        $this->jadwal_mengajar  = new \App\Models\M_jadwal();
        helper(['kelas']);
        date_default_timezone_set('Asia/Jakarta');
    }

    public function aktifkan_tahun($id, $params){

        $find   = $this->tahun_akademik->find($id);
        $cek    = $this->tahun_akademik->where('status', '1')->first();
        
        if($cek != null){
            $selisih =  $find['tahun'] - $cek['tahun'];
        }else{
            $selisih = 0;
        }
        
        if($selisih <= 1 && $selisih >= -1 ){
            if($cek){
                $this->tahun_akademik->update($cek['id_tahun'], ['status' => '0']);
            }
            $this->tahun_akademik->update($id, ['status' => '1']);
            $param ['new'] = $find['tahun'];
            $session_old = session()->get();
            $session_new = [
                'id_akademik' => $id,
                'tahun_akademik' => $find['tahun'],
                'semester' => $find['semester']
            ];
            $session = array_merge($session_old, $session_new);
            session()->set($session);
            return redirect()->to(base_url('/crud/naik/'));
        }else{
            return redirect()->to(base_url('/tu/tahun_akademik/'))->with('error', 'jarak menaikkan atau menurunkan tahun tidak boleh dari 1 tahun');
        }
    }
    
    public function naik(){
        $tahun_aktif        = $this->tahun_akademik->select('id_tahun, tahun, semester')->where('status', '1')->first();
        $daftar_kelas       = $this->kelas->findAll();
        $daftar_siswa       = $this->siswa->join('daftar_kelas', 'daftar_kelas.id_kelas = tb_siswa.id_kelas', 'left')->findAll();
        $masa_tempuh        = [];
        $update_kelas       = [];
        $id_kelas_tujuan    = [];
        
        foreach($daftar_siswa as $key => $siswa){
            $masa_belajar[$key]     = 3;
            $masa_tempuh[$key]['nis_siswa']         = $siswa['nis_siswa'];
            $masa_tempuh[$key]['masa_tempuh']       = $tahun_aktif['tahun'] - $siswa['tahun_masuk'];
            $masa_tempuh[$key]['kelas_sekarang']    = $siswa['kelas'];

            if($masa_tempuh[$key]['masa_tempuh'] == 0){
                $kelas_seharusnya = 10;
            }elseif($masa_tempuh[$key]['masa_tempuh'] == 1){
                $kelas_seharusnya = 11;
            }elseif($masa_tempuh[$key]['masa_tempuh'] == 2){
                $kelas_seharusnya = 12;
            }elseif($masa_tempuh[$key]['masa_tempuh'] >= 3){
                $kelas_seharusnya = $masa_tempuh[$key]['masa_tempuh'] + $masa_tempuh[$key]['kelas_sekarang'];
            }else{
                $kelas_seharusnya = 0;
            }
            
            $masa_tempuh[$key]['kelas_seharusnya'] = $kelas_seharusnya;

            if($masa_tempuh[$key]['kelas_seharusnya'] != 0 || $masa_tempuh[$key]['kelas_seharusnya'] < 13){
                // $masa_tempuh[$key]['selisih_kelas'] = $masa_tempuh[$key]['kelas_seharusnya'] - $masa_tempuh[$key]['kelas_sekarang'];
                $masa_tempuh[$key]['tidak_naik_kelas'] = $masa_tempuh[$key]['kelas_seharusnya'] - $siswa['kelas'];
                $masa_tempuh[$key]['status'] = 'aktif';
                if($masa_tempuh[$key]['masa_tempuh'] != 0){
                    $masa_tempuh[$key]['perkiraan_tahun_lulus'] = $siswa['tahun_masuk'] + $masa_tempuh[$key]['masa_tempuh'] + $masa_tempuh[$key]['tidak_naik_kelas'] + 1;   
                }else{
                    $masa_tempuh[$key]['perkiraan_tahun_lulus'] = $siswa['tahun_masuk'] + $masa_belajar[$key];
                }

            }elseif($masa_tempuh[$key]['kelas_seharusnya'] >= 13){
                $masa_tempuh[$key]['tidak_naik_kelas'] = $masa_tempuh[$key]['kelas_seharusnya'] - $siswa['kelas'];
                $masa_tempuh[$key]['status'] = 'aktif';
                $masa_tempuh[$key]['perkiraan_tahun_lulus'] = $siswa['tahun_masuk'] + $masa_tempuh[$key]['masa_tempuh'] + $masa_tempuh[$key]['tidak_naik_kelas'] + 1;
            }else{
                $masa_tempuh[$key]['status'] = 'lulus';
                $masa_tempuh[$key]['perkiraan_tahun_lulus'] = 'siswa telah lulus';
            }
            
            $update[$key]['nis']            = $siswa['nis_siswa'];
            $update[$key]['id_kelas_asal']  = $siswa['id_kelas'];
            $update[$key]['kelas']          = $siswa['kelas'];
            $update[$key]['jurusan']        = $siswa['jurusan'];
            $update[$key]['kelompok']       = $siswa['kelompok'];

            if($masa_tempuh[$key]['tidak_naik_kelas'] >= 0){
                if($masa_tempuh[$key]['tidak_naik_kelas'] != 0){
                    $update[$key]['kelas_tujuan'] = $masa_tempuh[$key]['kelas_seharusnya'] - $masa_tempuh[$key]['tidak_naik_kelas'] + 1;
                }else{
                    $update[$key]['kelas_tujuan'] = $masa_tempuh[$key]['kelas_seharusnya'];
                }
            }else{
                $update[$key]['kelas_tujuan'] = $masa_tempuh[$key]['kelas_sekarang'] + $masa_tempuh[$key]['tidak_naik_kelas'];
            }

            if($update[$key]['kelas_tujuan'] == 0){
                $update[$key]['kelas_tujuan'] = $siswa['kelas'];
                $update[$key]['status'] = 'tidak aktif';
            }else{
                $update[$key]['status'] = 'aktif';
            }

            if($update[$key]['kelas_tujuan'] >= 13){
                $update[$key]['kelas_tujuan']   = $siswa['kelas'];
                $update[$key]['status']         = 'lulus';
                $update[$key]['tahun_lulus']    = $masa_tempuh[$key]['perkiraan_tahun_lulus'] - $masa_tempuh[$key]['tidak_naik_kelas'] -1;
            }else{
                $update[$key]['status']         = 'aktif';
                $update[$key]['tahun_lulus']    = 0;
            }

            if($tahun_aktif['tahun'] < $siswa['tahun_masuk']) {
                $update[$key]['status'] = 'tidak aktif';
            }

            $kelas = $this->kelas
            ->select('id_kelas')
            ->where('kelas', $update[$key]['kelas_tujuan'])
            ->where('jurusan', $update[$key]['jurusan'])
            ->where('kelompok', $update[$key]['kelompok'])
            ->first();

            if($kelas== null){
                $insert = $this->kelas->insert([
                    'kelas'         => $update[$key]['kelas_tujuan'],
                    'jurusan'       => $siswa['jurusan'],
                    'kelompok'      => $siswa['kelompok'],
                ]);
                $kelas = $this->kelas->where('id_kelas', $insert)->first();
            }

            $update[$key]['id_kelas_tujuan'] = $kelas['id_kelas'];

            $this->siswa->update(
                $update[$key]['nis'],
                [
                    'id_kelas'      => $update[$key]['id_kelas_tujuan'],
                    'status'        => $update[$key]['status'],
                    'tahun_lulus'   => $update[$key]['tahun_lulus'],
                ]                
            );
        }
        return redirect()->to(base_url('/tu/tahun_akademik'));
    }

    // guru ================= controler guru ====================================

    public function get_guru(){
        $id_mapel   = $this->request->getPost('mapel');
        $join       = $this->mapel->join('tb_guru', 'tb_guru.nip = tb_mapel.nip', 'left')->where('id_mapel', $id_mapel)->findAll();
        // $data = $this->mapel->where('id_mapel', $id_guru)->findAll();
        // dd($join);
        echo json_encode($join);
    }

    public function insert_guru(){
        $nip            = $this->request->getPost('nip');
        $nama_guru      = $this->request->getPost('nama_guru');
        $tanggal_lahir  = $this->request->getPost('tanggal_lahir');
        $jenis_kelamin  = $this->request->getPost('jenis_kelamin');
        $min_jam        = $this->request->getPost('min_jam');
        $data = [
            'nip'           => $nip,
            'nama_guru'     => $nama_guru,
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'min_jam'       => $min_jam
        ];
        if($this->validasi->run($data, 'tambah_guru') == FALSE){
            session()->setFlashData('errors', $this->validasi->getErrors());
            return redirect()->to(base_url('/tu/form_guru'));
		}else{
            // dd($data);
            $tanggal    = explode('-', $tanggal_lahir);
            $password   = $tanggal[2].$tanggal[1].$tanggal[0];
            $this->user->insert([
                'username'      => $nip,
                'password'      => password_hash($password, PASSWORD_DEFAULT),
                'hak_akses'     => 'guru'
            ]);
            $this->guru->insert($data);
            session()->setFlashData('success_insert_guru', 'Guru dengan nama '. $nama_guru .' ' );
            return redirect()->to(base_url('/tu/daftar_guru'));
        }
    }

    public function update_guru(){
        $key            = $this->request->getPost('key');
        $nip            = $this->request->getPost('nip');
        $nama_guru      = $this->request->getPost('nama_guru');
        $tanggal_lahir  = $this->request->getPost('tanggal_lahir');
        $jenis_kelamin  = $this->request->getPost('jenis_kelamin');
        $min_jam        = $this->request->getPost('min_jam');

        $data = [
            'nip'           => $nip,
            'nama_guru'     => $nama_guru,
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'min_jam'       => $min_jam
        ];

        if($this->validasi->run($data, 'update_guru') == FALSE){
            session()->setFlashData('errors', $this->validasi->getErrors());
            return redirect()->to(base_url().'/tu/edit_guru/'.$nip);
        }else{
            $tanggal = explode('-', $tanggal_lahir);
            $password = $tanggal[2].$tanggal[1].$tanggal[0];
            // update username
            $this->user->where('username', $key)->set([
                'username'  => $nip,
                'password'  => password_hash($password, PASSWORD_DEFAULT),
                'hak_akses' => 'guru'
            ])->update();
            session()->setFlashData('pesan', 'Guru dengan nama '. $nama_guru .' ' );
            
            $this->guru->update($key, [
                'nip'           => $nip,
                'nama_guru'     => $nama_guru,
                'tanggal_lahir' => $tanggal_lahir,
                'jenis_kelamin' => $jenis_kelamin,
                'min_jam'       => $min_jam
            ]);
            
            return redirect()->to(base_url('/tu/daftar_guru'));
        }
    }

    public function hapus_jadwal($id, $id_kelas){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $this->jadwal->where('id_jadwal', $id)->delete();
            session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
            return redirect()->to(base_url('tu/daftar_jadwal/'.$id_kelas));
        }
    }

    public function detail_mapel($id_jadwal){
        // $id_mapel = $this->request->getPost('id_mapel');
        $data = $this->jadwal_mengajar->where('jadwal_pelajaran.id_jadwal', $id_jadwal)
        ->join('tb_mapel', 'tb_mapel.id_mapel = jadwal_pelajaran.id_mapel', 'left')
        ->join('daftar_kelas', 'daftar_kelas.id_kelas = jadwal_pelajaran.id_kelas', 'left')
        ->join('tb_guru', 'tb_guru.nip = jadwal_pelajaran.nip', 'left')
        ->first();
        // dd($data);
        $table = '<table class="table table-bordered table-striped">
                    <tr>
                        <th>Kelas</th>
                        <td>'. kelas($data['kelas']). ' ' . $data['jurusan'] .' '. $data['kelompok']  .'</td>
                    </tr>
                    <tr>
                        <th>Hari</th>
                        <td>'. $data['hari'] .'</td>
                    </tr>
                    <tr>
                        <th>Nama Mapel</th>
                        <td>'. $data['nama_mapel'] .'</td>
                    </tr>
                    <tr>
                        <th>Nama Guru</th>
                        <td>'. $data['nama_guru'] .'</td>
                    </tr>
                    <tr>
                        <th>Jam Masuk</th>
                        <td>'. $data['jam_masuk'] .'</td>
                    </tr>
                    <tr>
                        <th>Jam Selesai</th>
                        <td>'. $data['jam_selesai'] .'</td>
                    </tr>
                </table>';
        echo $table;
    }

    public function hapus_tahun($id){
        if (session()->get('hak_akses') != 'tu') {
            return redirect()->to(base_url('login'));
        }else{
            $cek = $this->tahun_akademik->where('id_tahun', $id)->first();
            // dd($cek);
            if($cek['status'] != '1'){
                $this->tahun_akademik->delete($id);
                return redirect()->to(base_url('tu/tahun_akademik'))->with('error', 'Tahun ajaran '. $cek['tahun']. ' Semester ' . $cek['semester'] . ' berhasil dihapus');
            }else{
                return redirect()->to(base_url('tu/tahun_akademik'))->with('error', 'Tidak bisa menghapus tahun yang sedang aktif');
            }
        }
    }

    public function hapus_guru($id_guru){
        session()->setFlashData('success_delete_guru', 'Guru dengan nama '. $this->guru->find($id_guru)['nama_guru'] .' ');
        $this->guru->delete($id_guru);
        return redirect()->to(base_url('/tu/daftar_guru'));
    }

    // end guru ================= controler guru =====================================

    // siswa ================= controler siswa ========================================

    public function insert_siswa(){
        $nis            = $this->request->getPost('nis_siswa');
        $nama_siswa     = $this->request->getPost('nama_siswa');
        $tanggal_lahir  = $this->request->getPost('tanggal_lahir');
        $kelas          = $this->request->getPost('kelas');
        $jenis_kelamin  = $this->request->getPost('jenis_kelamin');
        $tahun          = $this->request->getPost('tahun');
        $nama_siswa = strtolower($nama_siswa);
        $data = [
            'nis_siswa'     => $nis,
            'nama_siswa'    => ucfirst($nama_siswa),
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'id_kelas'      => $kelas,
            'tahun_masuk'   => $tahun,
        ];
        // dd($data);
        if($this->validasi->run($data, 'tambah_siswa') == FALSE){
            session()->setFlashData('errors', $this->validasi->getErrors());
            return redirect()->to(base_url('/tu/form_siswa'));
        }else{

            $tanggal        = explode('-', $tanggal_lahir);
            $password       = $tanggal[2].$tanggal[1].$tanggal[0];
            $this->siswa->insert($data);
            $this->user->insert([
                'username'  => $nis,
                'password'  => password_hash($password, PASSWORD_DEFAULT),
                'hak_akses' => 'siswa'
            ]);
            session()->setFlashData('success_insert_siswa', 'Siswa dengan nama '. $nama_siswa .' ' );
            return redirect()->to(base_url('/tu/daftar_siswa'));
        }
    }

    public function update_siswa(){
        $key            = $this->request->getPost('key'); 
        $nis            = $this->request->getPost('nis_siswa');
        $nama_siswa     = $this->request->getPost('nama_siswa');
        $tanggal_lahir  = $this->request->getPost('tanggal_lahir');
        $kelas          = $this->request->getPost('kelas');
        $jenis_kelamin  = $this->request->getPost('jenis_kelamin');
        $status         = $this->request->getPost('status');
        $data = [
            'nis_siswa'     => $nis,
            'nama_siswa'    => ucfirst($nama_siswa),
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'id_kelas'      => $kelas
        ];
        // dd($data);
        if($this->validasi->run($data, 'update_siswa') == FALSE){
            session()->setFlashData('errors', $this->validasi->getErrors());
            return redirect()->to(base_url().'/tu/edit_siswa/'. $nis);
        }else{
            // dd($data);
            session()->setFlashData('pesan', 'Siswa dengan nama '. $nama_siswa .' berhasil diubah' );
            $tanggal = explode('-', $tanggal_lahir);
            $password = $tanggal[2].$tanggal[1].$tanggal[0];

            $this->user->where('username', $key)->set([
                'username'  => $nis,
                'password'  => password_hash($password, PASSWORD_DEFAULT),
                'hak_akses' => 'siswa'
            ])->update();

            if($key == $nis){
                $this->siswa->update($key,[
                    'nama_siswa'    => ucfirst($nama_siswa),
                    'tanggal_lahir' => $tanggal_lahir,
                    'jenis_kelamin' => $jenis_kelamin,
                    'id_kelas'      => $kelas,
                    'status'        => $status
                ]);
            }else{
                $this->siswa->update($key,[
                    'nis_siswa'     => $nis,
                    'nama_siswa'    => ucfirst($nama_siswa),
                    'tanggal_lahir' => $tanggal_lahir,
                    'jenis_kelamin' => $jenis_kelamin,
                    'id_kelas'      => $kelas,
                    'status'        => $status
                ]);
            }
            return redirect()->to(base_url('/tu/daftar_siswa'));
        }
    }

    public function hapus_siswa($nis){
        session()->setFlashData('success_delete_siswa', 'Siswa dengan nama '. $this->siswa->find($nis)['nama_siswa'] .' ');
        $this->siswa->delete($nis);
        return redirect()->to(base_url('/tu/daftar_siswa'));
    }

    public function presensi(){
        $waktu_presensi = date('Y-m-d H:i:s');
        $mapel          = $this->request->getPost('mapel');
        $data           = $_POST['presensi'];
        $kelas          = $_POST['kelas'];
        $nama           = $_POST['nama'];
        $nk             = $this->kelas->where('id_kelas', $kelas)->first();
        $nama_kelas     = kelas($nk['kelas']). ' ' . $nk['jurusan']. ' ' . $nk['kelompok'];
        // dd($kelas, $nk, $nama_kelas);
        // dd($data);
        foreach($data as $key => $value){
            $d = [
                'id_mapel'         => $mapel,
                'nip'              => session()->get('nip'), 
                'tanggal_presensi' => date('Y-m-d'),
                'waktu_presensi'   => $waktu_presensi,
                'nis_siswa'        => $key,
                'status'           => $value,
                'id_kelas'         => $kelas,
                'id_tahun'         => session()->get('id_akademik')
            ];
            // dd($d);
            $this->absen->insert($d);
        }
    
        session()->setFlashdata('pesan', 'Presensi kelas '. $nama_kelas . ' berhasil di input');
        return redirect()->to(base_url('/guru'));
    }
    
    public function insert_presensi_terlambat(){
        $waktu_presensi = date('Y-m-d H:i:s');
        $tanggal = $this->request->getPost('tanggal_presensi');
        $mapel = $this->request->getPost('mapel');
        $data = $_POST['presensi'];
        $kelas = $_POST['kelas'];
        $nama = $_POST['nama'];
        $nk = $this->kelas->where('id_kelas', $kelas)->first();
        $nama_kelas = kelas($nk['kelas']). ' ' . $nk['jurusan']. ' ' . $nk['kelompok'];
        // dd($kelas, $nk, $nama_kelas);

        foreach($data as $key => $value){
            $d = [
                'id_mapel'         => $mapel,
                'nip'              => session()->get('nip'), 
                'tanggal_presensi' => $tanggal,
                'waktu_presensi'   => $waktu_presensi,
                'nis_siswa'        => $key,
                'status'           => $value,
                'id_kelas'         => $kelas,
                'id_tahun'         => session()->get('id_akademik'),
                'keterangan'       => 'presensi_terlambat'
            ];
            // dd($d);
            $this->absen->insert($d);
        }

        session()->setFlashdata('pesan', 'Presensi kelas '. $nama_kelas . ' berhasil di input');
        return redirect()->to(base_url('/guru'));
    }

    // end siswa ================= controler siswa ====================================

    // mapel ================= controler Mapel ====================================
    public function tambah_mapel(){
        $nama_mapel = $this->request->getPost('nama_mapel');
        $data = [
            'nama_mapel' => ucfirst($nama_mapel),
        ];
        // dd($data);
        if($this->validasi->run($data, 'tambah_mapel') == FALSE){
            session()->setFlashData('errors', $this->validasi->getErrors());
            return redirect()->to(base_url('/tu/form_mapel'));
        }else{
            $cek = $this->mapel->where('nama_mapel', $data['nama_mapel'])->first();
            if($cek != null){
                session()->setFlashData('inputs', $this->request->getVar());
                session()->setFlashData('errors', ['mapel' => 'Data Sudah Ada']);
                return redirect()->to(base_url('/tu/form_mapel'));
            }
            // dd($data);
            session()->setFlashData('success_insert_mapel', 'Mapel dengan nama '. $nama_mapel .' ' );
            $this->mapel->insert($data);
            return redirect()->to(base_url('/tu/daftar_mapel'));
        }
    }   
    public function update_mapel(){
        $id = $this->request->getPost('id_mapel');
        $nama_mapel = $this->request->getPost('nama_mapel');
        $data = [
            'nama_mapel' => ucfirst($nama_mapel),
        ];
        // dd($data);
        if($this->validasi->run($data, 'tambah_mapel') == FALSE){
            session()->setFlashData('errors', $this->validasi->getErrors());
            return redirect()->to(base_url().'/tu/edit_mapel/'.$id);
        }else{
            $cek = $this->mapel->where('nama_mapel', $data['nama_mapel'])->first();
            if($cek != null){
                session()->setFlashData('inputs', $this->request->getVar());
                session()->setFlashData('errors', ['mapel' => 'Data Sudah Ada']);
                return redirect()->to(base_url().'/tu/edit_mapel/'.$id);
            }else{
                session()->setFlashData('pesan', 'Mapel dengan nama '. $nama_mapel .' ' );
                $this->mapel->update($id, $data);
                return redirect()->to(base_url('/tu/daftar_mapel'));
            }
        }
    }
    public function hapus_mapel($id){
        $this->mapel->delete($id);
        session()->setFlashData('pesan', 'Data berhasil di hapus');
        return redirect()->to(base_url('/tu/daftar_mapel'));
    }
    // end mapel ================= controler Mapel ====================================

    //  ================= controler kalender =======================================
        public function insert_kalender(){
            $nama_kegiatan = $this->request->getPost('nama_kegiatan');
            $keterangan = $this->request->getPost('keterangan');
            $tanggal_mulai = $this->request->getPost('tanggal_mulai');
            $tanggal_selesai = $this->request->getPost('tanggal_selesai');
            $tahun_akademik = $this->request->getPost('tahun_akademik');
            $format_text = strtolower($nama_kegiatan);

            $data = [
                'nama_kegiatan'     => ucwords($format_text),
                'keterangan'        => $keterangan,
                'tanggal_mulai'     => $tanggal_mulai,
                'tanggal_selesai'   => $tanggal_selesai,
                'id_tahun_akademik' => $tahun_akademik
            ];
            // dd($data);
            $cek = $this->kalender->where('nama_kegiatan', $data['nama_kegiatan'])->where('keterangan', $data['keterangan'])->where('tanggal_mulai', $data['tanggal_mulai'])->where('tanggal_selesai', $data['tanggal_selesai'])->where('id_tahun_akademik', $data['id_tahun_akademik'])->first();
            if($cek != null){
                return redirect()->to(base_url('/tu/kalender_libur'));
            }else{
                $this->kalender->insert($data);
                return redirect()->to(base_url('/tu/kalender_libur'));
            }

        }
    // ========================= kalender


    // jadwal ================= controler kelas =======================================

    public function insert_kelas(){
        $kelas = $this->request->getPost('kelas');
        $jurusan = $this->request->getPost('jurusan');
        $kelompok = $this->request->getPost('kelompok');
        $format_text = strtolower($jurusan);

        $data = [
            'kelas'     => $kelas,
            'jurusan'   => ucwords($format_text),
            'kelompok'  => $kelompok
        ];

        if($this->validasi->run($data, 'tambah_kelas') == FALSE){
            session()->setFlashData('errors', $this->validasi->getErrors());
            return redirect()->to(base_url('/tu/form_kelas'));
        }else{

            $cek = $this->kelas->where('kelas', $data['kelas'])->where('jurusan', $data['jurusan'])->where('kelompok', $data['kelompok'])->first();

            if($cek != null){
                session()->setFlashData('errors', ['kelas' => 'Data Sudah Ada']);
                return redirect()->to(base_url('/tu/form_kelas'));
            }

            session()->setFlashData('success_insert_kelas', 'Kelas dengan nama '. $kelas .' ' );
            $this->kelas->insert($data);
            return redirect()->to(base_url('/tu/daftar_kelas'));
        }
    }

    public function tahun_akademik(){
        $tahun          = $this->request->getPost('tahun');
        $semester       = $this->request->getPost('semester');
        $tanggal_mulai  = $this->request->getPost('tanggal_mulai');
        $tanggal_selesai= $this->request->getPost('tanggal_selesai');

        $cek = $this->tahun_akademik->where('tahun', $tahun)->where('semester', $semester)->first();
        if($cek != null){
            session()->setFlashData('errors', ['tahun_akademik' => 'Data Sudah Ada']);
            return redirect()->to(base_url('/tu/form_tahun_akademik'));
        }else{
            if($tanggal_mulai > $tanggal_selesai){
                // flash data
                session()->setFlashData('pesan', 'Tanggal Mulai Tidak Boleh Lebih Besar Dari Tanggal Selesai');
                return redirect()->to(base_url('/tu/form_tahun_akademik'));
            }else{
                $data = [
                    'tahun' => $tahun,
                    'semester'       => $semester,
                    'tanggal_mulai'  => $tanggal_mulai,
                    'tanggal_selesai'=> $tanggal_selesai
                ];
                if($this->validasi->run($data, 'tahun_akademik') == FALSE){
                    session()->setFlashData('errors', $this->validasi->getErrors());
                    return redirect()->to(base_url().'/tu/form_tahun_akademik/');
                }else{
                    $this->tahun_akademik->insert($data);
                    session()->setFlashData('pesan', 'Data Berhasil Di Tambahkan');
                }
            }
        }
        return redirect()->to(base_url('/tu/tahun_akademik'));
    }

    public function insert_jadwal(){
        $tahun_akademik = $this->request->getPost('tahun_akademik');
        $kelas          = $this->request->getPost('kelas');
        $hari           = $this->request->getPost('hari');
        $mapel          = $this->request->getPost('nama_mapel');
        $nama_guru      = $this->request->getPost('nama_guru');
        $jam_mulai      = $this->request->getPost('jam_masuk');
        $jam_selesai    = $this->request->getPost('jam_selesai');
        if($jam_selesai < $jam_mulai){
            session()->setFlashData('limit_waktu', 'Jam Selesai Harus Lebih Besar Dari Jam Mulai');
            return redirect()->to(base_url('/tu/form_jadwal'));
        }
        $data = [
            'id_tahun'=> $tahun_akademik,
            'id_kelas'      => $kelas,
            'hari'          => $hari,
            'id_mapel'      => $mapel,
            'nip'           => $nama_guru,
            'jam_masuk'     => $jam_mulai,
            'jam_selesai'   => $jam_selesai
        ];
        // dd($data);
        if($this->validasi->run($data, 'jadwal_pelajaran') == FALSE){
            session()->setFlashData('errors', $this->validasi->getErrors());
            return redirect()->to(base_url('/tu/form_jadwal'));
        }else{
            $tahun = session()->get('id_akademik');
            $cek = $this->jadwal->where('hari', $data['hari'])->where('nip', $data['nip'])->where('id_mapel', $data['id_mapel'])->where('jam_masuk', $data['jam_masuk'])->where('id_tahun', session()->get('id_akademik'))->first();
            // $cek = $this->jadwal->query("SELECT * FROM jadwal_pelajaran WHERE nip='$nama_guru' AND hari='$hari' AND id_mapel='$mapel' AND jam_masuk='$jam_mulai' AND id_tahun= '$tahun';")->find();
            // dd($cek);
            if($cek != null){
                session()->setFlashData('errors', ['mapel' => 'Data Sudah Ada / guru tersebut sudah mengajar di kelas lain pada jam tersebut']);
                return redirect()->to(base_url('/tu/form_jadwal'));
            }
            $nama_guru = $this->guru->where('nip', $data['nip'])->first();
            $nama_guru = $nama_guru['nama_guru'];

            $max_jam_mengajar = $this->jadwal->where('nip', $data['nip'])->where('id_tahun', session()->get('id_akademik'))->countAllResults();
            $jam_max_guru  = $this->guru->where('nip', $data['nip'])->first();
            $jumlah_jam_guru = $jam_max_guru['min_jam'];

            // if($max_jam_mengajar > $jumlah_jam_guru){
            //     session()->setFlashData('errors', ['mapel' => 'Guru dengan nama '. $nama_guru .' Sudah Melebihi Batas Jam Mengajar. '. $nama_guru. ' hanya memiliki jatah jam sebanyak ' . $jumlah_jam_guru . ' Jam selama seminggu']);
            //     return redirect()->to(base_url('/tu/form_jadwal'));
            // }else{
                $this->jadwal->insert($data);
            // }
            
            $mapel = $this->mapel->where('id_mapel', $data['id_mapel'])->first();
            $mapel = $mapel['nama_mapel'];
            session()->setFlashData('success_insert_jadwal', 'Jadwal dengan nama mapel '. $mapel .' Guru ' . $nama_guru . ' waktu mulai ' . $jam_mulai . ' jam selesai ' . $jam_selesai . ' ');
            return redirect()->to(base_url('/tu/jadwal_mengajar'));
        }
    }

    public function edit_kelas(){
        $id = $this->request->getPost('id_kelas');
        $nama = $this->request->getPost('kelas');
        $jurusan = $this->request->getPost('jurusan');
        $kelompok = $this->request->getPost('kelompok');
        
        $data = [
            'kelas'  => $nama,
            'jurusan'=> $jurusan,
            'kelompok' => $kelompok
        ];

        if($this->validasi->run($data, 'tambah_kelas') == FALSE){
            session()->setFlashData('errors', $this->validasi->getErrors());
            return redirect()->to(base_url().'/tu/edit_kelas/'.$id);
        }else{
            $cek = $this->kelas->where('kelas', $data['kelas'])->where('jurusan', $data['jurusan'])->where('kelompok', $data['kelompok'])->first();
            if($cek != null){
                session()->setFlashData('errors', ['kelas' => 'Data Sudah Ada']);
                return redirect()->to(base_url().'/tu/edit_kelas/'.$id);
            }else{
                $this->kelas->update($id, 
                    [
                        'kelas' => $nama,
                        'jurusan' => $jurusan,
                        'kelompok' => $kelompok
                    ]);
                session()->setFlashData('pesan2', 'Kelas berhasil diubah' );
                return redirect()->to(base_url('/tu/daftar_kelas'));
            }
        }
    }
    
    public function hapus_kelas($id){
        $this->kelas->delete($id);
        session()->setFlashData('pesan', 'Kelas berhasil di hapus');
        return redirect()->to(base_url('/tu/daftar_kelas'));
    }
    // end jadwal ================= controler kelas ====================================
}