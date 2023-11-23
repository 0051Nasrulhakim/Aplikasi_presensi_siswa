<?= $this->extend('siswa/index') ?>
<?= $this->section('content') ?>
<?php
date_default_timezone_set('Asia/Jakarta');
// dd();
$cek_tanggal = date('H:i');

$date = date('D');
 
// $date = date('Y-m-d');
$hari = ['Sun'=>'minggu', 'Mon'=>'senin', 'Tue' => 'selasa','Wed'=>'rabu', 'Thu'=>'kamis', 'Fri'=>'jumat', 'Sat'=>'sabtu'];
?>

<div class="bungkus" id="bungkus">
    <div class="container-fluid px-4" style="margin-top: 6%;">
    <h1 class="text-center">Selamat Datang <?= session()->get('nama_siswa')?></h1>
    <h4 class="text-center">SMK Negeri 1 Warungasem</h1>
    <h4 class="text-center">Tahun Akademik <?= session()->get('tahun_akademik') .'/' . session()->get('tahun_akademik')+1?> Semester <?= session()->get('semester')?></h3>
    <h4 class="text-center">Kelas : <?= $nama_kelas?></h1>
    

        <div class="row" style="margin-top: 4%;">
            <div class="col-md-4 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Senin</li>
                    <?php $i=0;foreach($jadwal as $row):?>
                        <?php if($row['hari'] == 'senin'){ 
                            $i=1; $hari_senin = 'Senin'?>
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari']=='senin' && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai']&& $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <span style="margin-right: 7%; width: 55%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
                            </li>
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
                    <?php $i=0; foreach($jadwal as $row):?>
                        <?php if($row['hari'] == 'selasa'){ $i=1; $hari_selasa = 'Selasa'?>
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari']=='selasa' && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai']&& $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <span style="margin-right: 7%; width: 55%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
                            </li>
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
                    <li class="list-group-item active text-center" aria-current="true" >Rabu</li>
                    <?php $i=0; foreach($jadwal as $row):?>
                        <?php if($row['hari'] == 'rabu'){ $i=1; $hari_rabu = 'rabu' ?>
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari']=='rabu' && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai']&& $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <span style="margin-right: 7%; width: 55%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
                            </li>
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
                    <?php $i=0; foreach($jadwal as $row):?>
                        <?php if($row['hari']== 'kamis'){ $i=1; $hari_kamis = 'Kamis'?>
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari']=='kamis' && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai']&& $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                               <span style="margin-right: 7%; width: 55%;"><?= $row['nama_mapel']?></span>
                               <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
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
                    <li class="list-group-item active text-center"  aria-current="true" >Jum'at</li>
                    <?php $i=0; foreach($jadwal as $row):?>
                        <?php if($row['hari']== "jum'at"){ $i=1; $hari_jumat = "jum'at"?>
                            <li class="list-group-item d-flex justify-content-between" <?php if($row['hari']=="jum'at" && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai']&& $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <span style="margin-right: 7%; width: 55%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
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
                    <?php $i=0; foreach($jadwal as $row):?>
                        <?php  if($row['hari']== 'sabtu'){ 
                            $i=1; $hari_sabtu = 'Sabtu'?>
                            <li class="list-group-item d-flex justify-content-between"  <?php if($row['hari']=='sabtu' && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai']&& $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <span style="margin-right: 7%; width: 55%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
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
                    <li class="list-group-item active text-center " aria-current="true" >Minggu</li>
                    <?php $i=0; foreach($jadwal as $row):?>
                        <?php  if($row['hari']== 'minggu'){ 
                            $i=1; $hari_sabtu = 'Minggu'?>
                            <li class="list-group-item d-flex justify-content-between"  <?php if($row['hari']=='minggu' && $row['jam_masuk']<=$cek_tanggal && $cek_tanggal<=$row['jam_selesai']&& $row['hari'] == $hari[$date]){
                                    echo 'style="background-color: #FF9F9F"';
                                }?>>
                                <span style="margin-right: 7%; width: 55%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
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
        <div class="logout text-center mt-3" style="margin-bottom: 13%;">
            <h4>Halaman Home <a href="<?= base_url()?>/siswa"><button class="btn btn-sm btn-warning">Kembali</button></a></h4>
        </div>
    </div>
</div>
<?= $this->endSection();?>