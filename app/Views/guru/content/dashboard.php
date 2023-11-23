<?= $this->extend('guru/index'); ?>
<?= $this->section('content');
    date_default_timezone_set('Asia/Jakarta');
    $jam = date('H:i');
    $date = date('D');
    // dd($date);
    $hari = ['Sun'=>'minggu', 'Mon'=>'senin', 'Tue' => 'selasa','Wed'=>'rabu', 'Thu'=>'kamis', "Fri"=>"jum'at", 'Sat'=>'sabtu'];
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
            height: 15rem;
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
            height: 16rem;
        }
        #bungkus{
            width: auto;
        }
    }
</style>
<div class="bungkus" id="bungkus">
    <div class="container-fluid px-4" id="contain">
        <h1 class="text-center">Selamat Datang <?= $guru?></h1>
        <h1 class="text-center">SMK Negeri 1 Warungasem</h1>
        <h3 class="text-center">Tahun Akademik <?= $tahun_akademik?>. Semester <?= $semester?></h3>
        
        <?php
            $done 	= session()->getFlashdata('pesan');
            if(!empty($done)){
            ?>
                <div class="alert" style="width: 97%; margin-bottom: -3%; margin-left: auto; margin-right: auto;">
                    <div class="alert alert-info alert-dismissible fade show " role="alert">
                        <strong><?= $done?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php
            }
            $error 	= session()->getFlashdata('pesan_error');
            if(!empty($error)){
            ?>
                <div class="alert" style="width: 97%; margin-bottom: -3%; margin-left: auto; margin-right: auto;">
                    <div class="alert alert-danger alert-dismissible fade show " role="alert">
                        <strong><?= $error?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php
            }
        ?>
            
        <div class="row mt-5">
        <h5 id="notiv" style="padding: 4px; color:white"></h5>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Jadwal Mengajar</h5>
                        <div class="logo">
                            <i class="fa-solid fa-calendar-days fa-5x"></i>
                        </div>
                        <div class="tombol-tengah">
                            <a href="<?= base_url()?>/guru/jadwal_mengajar"><button type="submit" class="btn btn-sm btn-primary">Lihat Jadwal</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Presensi</h5>
                        <div class="logo">
                            <i class="fa-solid fa-user-check fa-5x"></i>
                        </div>
                        <div class="tombol-tengah">
                            <a href="<?= base_url().'/guru/cari_presensi/'. $jam.'/'. $hari_ini ?>"><button type="submit" class="btn btn-sm btn-primary">Presensi</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Lupa Presensi</h5>
                        <div class="logo">
                            <i class="fa-solid fa-user-clock fa-5x"></i>
                        </div>
                        <div class="tombol-tengah">
                            <!-- <button type="submit" class="btn btn-sm btn-primary">Presensi</button> -->
                            <button type="button" class="btn btn-sm btn-primary kelola" onclick="code()" id="kelola">Kelola</button>
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
                            <a href="<?= base_url()?>/guru/informasi"><button type="button" class="btn btn-sm btn-primary">Lihat</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="logout text-center mt-5" style="margin-bottom: 13%;">
            <h4>Keluar Dari Website <a href="<?= base_url()?>/login/logout"><button class="btn btn-sm btn-danger">Logout</button></h4></a>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_kode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Kode</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url()?>/guru/presensi_terlambat" method="post">
                <div class="modal-body">
                    <input type="text" name="id_kelas" id="id_kelas" hidden>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Masukkan Kode</label>
                        <div class="col-sm-7">
                            <input type="text" name="kode" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Lihat</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function code(){
        $('#modal_kode').modal('show');
    }
    function notiv(){
        var waktu = new Date();
        var jam = waktu.getHours();
        var get_hari = waktu.getDay();
        var menit = waktu.getMinutes();
        var detik = waktu.getSeconds();
        if (jam < 10) {
            jam = "0" + jam;
        }
        if (menit < 10) {
            menit = "0" + menit;
        }
        if (detik < 10) {
            detik = "0" + detik;
        }
        var waktu = jam + ":" + menit + ":" + detik;
        // alert(waktu)
        $.get("<?=base_url()?>/guru/notiv/"+get_hari+'/'+waktu, function(data, status){
            var hasil = JSON.parse(data);
            var notiv = hasil.nama_kelas;
            var status = hasil.status;
            var keterangan = hasil.keterangan;
            // alert(notiv);
            if(status == 'Libur'){
                $('#notiv').html('' + keterangan + '');
                $('#notiv').addClass('badge bg-danger text-center');
            }else{
                if (notiv != '') {
                    // $('#keterangan').html('<span class="badge bg-success" style="width:100%">Jadwal Presensi Di Kelas <br>'+ notiv+'</span>');
                    // $('#notiv')
                    // buat text notiv
                    $('#notiv').html('Ada Jadwal Presensi '+notiv);
                    $('#notiv').addClass('bg-success text-center');
                }else{
                    $('#notiv').html('* Tidak Ada Jadwal Presensi');
                    $('#notiv').addClass('badge bg-danger text-center');
                }
            }
        });
    }
    setInterval(notiv, 2500);
    // });
</script>

<?php $this->endSection()?>