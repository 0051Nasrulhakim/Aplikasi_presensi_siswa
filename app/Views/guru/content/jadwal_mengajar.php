<?= $this->extend('guru/index'); ?>
<?= $this->section('content');
date_default_timezone_set('Asia/Jakarta');
// dd();
$cek_tanggal = date('H:i');

$date = date('D');
$hari = ['Sun'=>'minggu', 'Mon'=>'senin', 'Tue' => 'selasa','Wed'=>'rabu', 'Thu'=>'kamis', 'Fri'=>"jum'at", 'Sat'=>'sabtu'];
// dd()
?>
<div class="bungkus" id="bungkus">
    <div class="container-fluid px-4" id="contain">
        <h1 class="text-center">Selamat Datang <?= $guru?></h1>
        <h1 class="text-center">SMK Negeri 1 Warungasem</h1>
        <h3 class="text-center">Tahun Akademik <?= session()->get('tahun_akademik')?>. Semester <?= session()->get('semester')?></h3>
        <h3 style="margin-top:4%; margin-bottom: 2%;">Jadwal Mengajar 
        </h3>
        
            
        <?php
            $done 	= session()->getFlashdata('pesan');
            if(!empty($done)){
            ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?= $done?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <?php
            $absen 	= session()->getFlashdata('selesai_absen');
            if(!empty($absen)){
            ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?= $absen?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <div class="row">
            <div class="col-md-4 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Senin</li>
                    <?php $i=0;foreach($data as $row):?>
                        <?php if($row['hari'] == 'senin'){ 
                            $i=1; $hari_senin = 'Senin'?>
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari']=='senin' && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai']&& $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>

                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_senin?>" style="text-decoration: none; color: black;"><span><?= kelas($row['kelas']).' '. $row['jurusan']. ' ' . $row['kelompok'] ?> <?= $row['nama_mapel']?></span></a>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_senin?>" style="text-decoration: none; color: black;"><span><?= $row['jam_masuk'] . ' - ' . $row['jam_selesai']; ?></span></a>
                            </li></a>
                            <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Selasa</li>
                    <?php $i=0; foreach($data as $row):?>
                        <?php if($row['hari'] == 'selasa'){ $i=1; $hari_selasa = 'Selasa'?>
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari']=='selasa' && $row['jam_masuk'] < $cek_tanggal && $cek_tanggal < $row['jam_selesai'] && $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_selasa?>" style="text-decoration: none; color: black;"><span><?= kelas($row['kelas']).' '. $row['jurusan']. ' ' . $row['kelompok'] ?> <?= $row['nama_mapel']?></span></a>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_selasa?>" style="text-decoration: none; color: black;"><span><?= $row['jam_masuk'] . ' - ' . $row['jam_selesai']; ?></span></a>
                                
                            </li></a>
                        <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Rabu</li>
                    <?php $i=0; foreach($data as $row):?>
                        <?php if($row['hari']== 'rabu'){ $i=1; $hari_rabu = 'Rabu' ?>
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari'] =='rabu' && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai'] && $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_rabu?>" style="text-decoration: none; color: black;"><span><?= kelas($row['kelas']).' '. $row['jurusan']. ' ' . $row['kelompok'] ?> <?= $row['nama_mapel']?></span></a>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_rabu?>" style="text-decoration: none; color: black;"><span><?= $row['jam_masuk'] . ' - ' . $row['jam_selesai']; ?></span></a>
                            </li></a>
                        <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Kamis</li>
                    <?php $i=0; foreach($data as $row):?>
                        <?php if($row['hari']== 'kamis'){ $i=1; $hari_kamis = 'Kamis'?>
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari']=='kamis' && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai'] && $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_kamis?>" style="text-decoration: none; color: black;"><span><?= kelas($row['kelas']).' '. $row['jurusan']. ' ' . $row['kelompok'] ?> <?= $row['nama_mapel']?></span></a>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_kamis?>" style="text-decoration: none; color: black;"><span><?= $row['jam_masuk'] . ' - ' . $row['jam_selesai']; ?></span></a>
                            </li></a>
                        <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Jum'at</li>
                    <?php $i=0; foreach($data as $row):?>
                        <?php if($row['hari']== "jum'at"){ $i=1; $hari_jumat = "jum'at"?>
                            
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari'] == "jum'at" && $row['jam_masuk']<= $cek_tanggal && $cek_tanggal<=$row['jam_selesai'] && $row['hari'] == $hari[$date] ){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_jumat?>" style="text-decoration: none; color: black;"><span><?= kelas($row['kelas']).' '. $row['jurusan']. ' ' . $row['kelompok'] ?> <?= $row['nama_mapel']?></span></a>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_jumat?>" style="text-decoration: none; color: black;"><span> <?= $row['jam_masuk'] . ' - ' . $row['jam_selesai']; ?></span></a>
                            </li></a>
                        <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Sabtu</li>
                    <?php $i=0; foreach($data as $row):?>
                        <?php  if($row['hari']== 'sabtu'){ 
                            $i=1; $hari_sabtu = 'Sabtu'?>
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari']=='sabtu' && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai'] && $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_sabtu?>" style="text-decoration: none; color: black;"><span><?= kelas($row['kelas']).' '. $row['jurusan']. ' ' . $row['kelompok'] ?> <?= $row['nama_mapel']?></span></a>
                                <a href="<?=base_url().'/guru/presensi/'.$row['id_kelas']?>/<?= $row['id_mapel']?>/<?= $hari_sabtu?>" style="text-decoration: none; color: black;"><span> <?= $row['jam_masuk'] . ' - ' . $row['jam_selesai']; ?></span></a>
                            </li></a>
                        <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="logout text-center mt-5" style="margin-bottom: 13%;">
            <h4>Halaman Home <a href="<?= base_url()?>/guru"><button class="btn btn-sm btn-danger">Kembali</button></a></h4>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>