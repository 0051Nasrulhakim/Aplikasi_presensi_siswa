<?= $this->extend('siswa/index') ?>
<?= $this->section('content') ?>
<div class="page" style="height: 92vh;">
    <div class="container-fluid px-4" style="margin-top: 5%;">
        <h1 class="mt-4">List Hasil Presensi Per-mapel</h1>
        <h5>Nama : <?= $nama_siswa?> </h5>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem </li>
            <!-- alert -->
        </ol>
        <div class="alert alert-info">
            Silahan Pilih Mapel Yang Akan di Lihat detail Presensi 
        </div>
        <div class="row" >
            <div class="col-9">
                <div class="table table-responsive" style="margin-left: 3%;">
                    <table class="table table-stripped table-responsive">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Mapel</th>
                                <th class="text-center">Total Presensi</th>
                                <th class="text-center">Hadir</th>
                                <th class="text-center">Izin</th>
                                <th class="text-center">Alpha</th>
                                <th class="text-center">Presentasi Kehadiran</th>
                                <th class="etxt-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($daftar_mapel as $mapel):?>
                            <tr>
                                    <td><?= $i++?></td>
                                    <td><?= $mapel['nama_mapel']?></td>
                                    <td class="text-center"><?= $mapel['total_presensi']?></td>
                                    <td class="text-center"><?= $mapel['hadir']?></td>
                                    <td class="text-center"><?= $mapel['izin']?></td>
                                    <td class="text-center"><?= $mapel['alpha']?></td>
                                    <td class="text-center" <?php if($mapel['total_presensi'] != 0 && $mapel['persen'] <= 50){echo 'style="background-color:red; color: white"';}?>>
                                    <?php
                                        if($mapel['total_presensi'] != 0){
                                            echo $mapel['persen'].'%';
                                        }else{
                                            echo '-';
                                        }
                                    ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url()?>/siswa/detail_presensi_siswa/<?= $nis.'/'.$akademik.'/'.$id_kelas.'/'.$mapel['id_mapel']?>">
                                            <button class="btn btn-primary btn-sm">Lihat</button>
                                        </a>
                                    </td>
                            </tr>     
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="logout text-center mt-5">
        <h4>Halaman Home <a href="<?= base_url()?>/siswa"><button class="btn btn-sm btn-warning">Kembali</button></a></h4>
    </div>
</div>
<?= $this->endSection()?>