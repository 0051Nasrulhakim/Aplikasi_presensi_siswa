<?= $this->extend('guru/index'); ?>
<?= $this->section('content');
    date_default_timezone_set('Asia/Jakarta');
    $jam = date('H:i');
    $date = date('D');
    // dd($date);
    $hari = ['Sun'=>'minggu', 'Mon'=>'senin', 'Tue' => 'selasa','Wed'=>'rabu', 'Thu'=>'kamis', 'Fri'=>'jumat', 'Sat'=>'sabtu'];
    $hari_ini = $hari[$date];
    // dd($hari_ini);
?>
<style>
    #contain .row{
        margin-left: auto;
        margin-right: auto;
        display: flex;
        background-color: #f5f5f5;
        justify-content: center;
        border: 1px solid #495579;
        border-radius: 9px;
        width: 95%;
    }
    .tombol-tengah{
        display: flex;
        justify-content: center;
    }
    .logo{
        display: flex;
        justify-content: center;
        margin-bottom: 7%;
        margin-top: 10%;
    }
    @media screen and (max-width:680px){
        #contain .row {
            margin-top: 20%;
            width: 100%;
            
        }
        .card{
            margin-left: auto;
            margin-right: auto;
            width: 17rem;
            margin-top: 10%;
            margin-bottom: 10%;
            height: 14rem;
        }
        #bungkus{
            width: auto;
        }
    }
    @media screen and (min-width:681px){
        #contain {
            width: 100%;
        }
        .card{
            width: 18rem;
            margin-top: 15%;
            margin-bottom: 15%;
            height: 14rem;
        }
        #bungkus{
            width: auto;
        }
    }
</style>
<div class="bungkus" id="bungkus">
    <div class="container-fluid px-4" id="contain">
        <h1 class="text-center">Selamat Datang <?= $nama_siswa?></h1>
        <h1 class="text-center">SMK Negeri 1 Warungasem</h1>
        <h3 class="text-center">Tahun Akademik <?= session()->get('tahun_akademik') . ' / ' . session()->get('tahun_akademik')+1?> Semester <?= session()->get('semester')?></h3>
        <div class="row mt-5">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Jadwal Pelajaran</h5>
                        <div class="logo">
                            <i class="fa-solid fa-calendar-days fa-5x"></i>
                        </div>
                        <div class="tombol-tengah">
                            <a href="<?= base_url()?>/siswa/jadwal_pelajaran"><button type="submit" class="btn btn-sm btn-primary">Lihat Jadwal</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Hasil Presensi</h5>
                        <div class="logo">
                            <i class="fa-solid fa-list-check fa-5x"></i>
                        </div>
                        <div class="tombol-tengah">
                            <!-- <a href="<?= base_url().'/siswa/detail_presensi'?>"><button type="submit" class="btn btn-sm btn-primary">Lihat</button></a> -->
                            <a href="<?= base_url().'/siswa/list_daftar_mapel'?>"><button type="submit" class="btn btn-sm btn-primary">Lihat</button></a>
                        </div>
                        <div class="tombol-tengah">
                            <span id="keterangan"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Informasi Pengumuman</h5>
                        <div class="logo">
                            <i class="fa-solid fa-circle-info fa-4x"></i>
                        </div>
                        <div class="tombol-tengah">
                            <a href="<?= base_url()?>/siswa/informasi"><button type="button" class="btn btn-sm btn-primary">Lihat</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="logout text-center mt-5" style="margin-bottom: 13%;">
            <h4>Keluar Dari Website <a href="<?= base_url()?>/login/logout"><button class="btn btn-sm btn-danger">Logout</button></a></h4>
        </div>
    </div>
</div>

<?php $this->endSection()?>