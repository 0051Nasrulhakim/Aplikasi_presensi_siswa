<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function __construct()
    {
        $this->user    = new \App\Models\M_user();
        $this->guru    = new \App\Models\M_guru();
        $this->siswa   = new \App\Models\M_getData();
        $this->tahun_akademik = new \App\Models\M_tahun_akademik;
    }
    public function index(){
        return view('login/login');
    }
    public function null_tahun($data){
        return view('login/null_tahun');
    }

    public function cek_login(){
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $hak_akses = $this->request->getPost('hak_akses');
        
        if($hak_akses == ''){
            session()->setFlashdata('pesan', 'Pilih Hak Akses');
            return redirect()->to(base_url('login'));
        }elseif($username == ''){
            session()->setFlashdata('pesan', 'Username tidak boleh kosong');
            return redirect()->to(base_url('login'));
        }elseif($password == ''){
            session()->setFlashdata('pesan', 'Password tidak boleh kosong');
            return redirect()->to(base_url('login'));
        }else{
           
            $tahun = date('Y');
            $tanggal = date('Y-m-d');
            
            $data_akademik = $this->tahun_akademik->where('status', '1')->first();
            if($data_akademik == null || $data_akademik == ''){
                $data_akademik = $this->tahun_akademik->where('tanggal_mulai <=', $tanggal)->where('tanggal_selesai >=', $tanggal)->where('tahun', $tahun)->first();
            }
            if($data_akademik == null || $data_akademik == ''){
                $tahun = date('Y');
                $data_akademik = $this->tahun_akademik->select('*, MAX(tahun) as tahun')->where('tahun <=', $tahun)->first();
            } 
            
            

            // dd($data_akademik);
            if($hak_akses == 3){
                $cek = $this->user->where('username', $username)->first();
                if($cek){
                    $pass = $cek['password'];
                    if(password_verify($password, $pass)){
                        if($cek['hak_akses'] != "tu"){
                            // dd($cek, $ceh);
                            session()->setFlashdata('pesan', 'Password Hak Akses Anda Bukan TU');
                            return redirect()->to(base_url('login'));
                        }else{
                            $nama = $this->guru->where('nip', $username)->first();
                            $data = [
                                'nama_tu'       => $nama['nama_guru'],
                                'username'      => $cek['username'],
                                'hak_akses'     => $cek['hak_akses'],
                                'id_akademik'   => $data_akademik['id_tahun'],
                                'tahun_akademik'=> $data_akademik['tahun'],
                                'semester'      => $data_akademik['semester'],
                                'logged_in'     => TRUE
                            ];
                            session()->set($data);
                            return redirect()->to(base_url('tu'));
                        }
                    }else{
                        session()->setFlashdata('pesan', 'Password salah');
                        return redirect()->to(base_url('login'));
                    }
                }else{
                    session()->setFlashdata('pesan', 'Username tidak ditemukan');
                    return redirect()->to(base_url('login'));
                }
            }if($hak_akses == 2){
                $cek = $this->user->where('username', $username)->first();
                // dd($cek);
                if($cek){
                    $pass = $cek['password'];
                    if(password_verify($password, $pass)){
                        if($cek['hak_akses'] != "guru"){
                            session()->setFlashdata('pesan', 'Password Hak Akses Anda Bukan Guru');
                            return redirect()->to(base_url('login'));
                        }else{
                            $data_guru = $this->guru->where('nip', $username)->first();
                            $data = [
                                'username' => $cek['username'],
                                'nama_guru' => $data_guru['nama_guru'],
                                'nip' => $data_guru['nip'],
                                'hak_akses' => $cek['hak_akses'],
                                'id_akademik'   => $data_akademik['id_tahun'],
                                'tahun_akademik'=> $data_akademik['tahun'],
                                'semester'      => $data_akademik['semester'],
                                'logged_in' => TRUE
                            ];
                            session()->set($data);
                            return redirect()->to(base_url('guru'));
                        }
                    }else{
                        session()->setFlashdata('pesan', 'Password salah');
                        return redirect()->to(base_url('login'));
                    }
                }else{
                    session()->setFlashdata('pesan', 'Username tidak ditemukan');
                    return redirect()->to(base_url('login'));
                }
                
            }else{
                $cek = $this->user->where('username', $username)->first();
                if($cek){
                    $pass = $cek['password'];
                    if(password_verify($password, $pass)){
                        if($cek['hak_akses'] != "siswa"){
                            session()->setFlashdata('pesan', 'Password Hak Akses Anda Bukan Siswa');
                            return redirect()->to(base_url('login'));
                        }else{
                            $data_siswa = $this->siswa->where('nis_siswa', $username)->first();
                            $data = [
                                'id_akademik'   => $data_akademik['id_tahun'],
                                'tahun_akademik'=> $data_akademik['tahun'],
                                'semester'      => $data_akademik['semester'],
                                'username' => $cek['username'],
                                'hak_akses' => $cek['hak_akses'],
                                'nis'       => $data_siswa['nis_siswa'],
                                'id_kelas'  => $data_siswa['id_kelas'],
                                'nama_siswa'=> $data_siswa['nama_siswa'],
                                'logged_in' => TRUE
                            ];
                            session()->set($data);
                            return redirect()->to(base_url('siswa'));
                        }
                    }else{
                        session()->setFlashdata('pesan', 'Password salah');
                        return redirect()->to(base_url('login'));
                    }
                }else{
                    session()->setFlashdata('pesan', 'Username tidak ditemukan');
                    return redirect()->to(base_url('login'));
                }
            }
        }
    }
    public function logout(){
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}