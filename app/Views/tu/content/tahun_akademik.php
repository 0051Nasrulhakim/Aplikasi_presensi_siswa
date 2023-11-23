<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>



    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Tahun Akademik</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem</li>
        </ol>
        <?php

        // get flashdata
        $pesan = session()->getFlashdata('error');
        if (!empty($pesan)) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $pesan ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="container-fluid">
        <div class="row" style="margin-bottom: 2%;">
            <div class="col">
                <a href="<?= base_url()?>/tu/form_tahun_akademik"><button class="btn btn-sm btn-primary">Input Tahun akademik</button></a>
            </div>
        </div>
        <table class="table table-striped" id="guru">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Tahun Akademik</td>
                    <td>Semester</td>
                    <td>Tanggal Mulai</td>
                    <td>Tanggal Selesai</td>
                    <td class="text-center">status</td>
                    <td class="text-center">Action</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                if($tahun_akademik == null){
                    echo "<tr><td colspan='6' style='text-align: center;'>Data Tidak Ada</td></tr>";
                }else{
                    $no = 1;
                    foreach($tahun_akademik as $tahun):?>
                    <tr>
                        <td><?= $no++?></td>
                        <td><?= $tahun['tahun'] .' / '. $tahun['tahun']+1?></td>
                        <td><?= $tahun['semester']?></td>
                        <td><?= date("d-m-Y", strtotime($tahun['tanggal_mulai']))?></td>
                        <td><?= date("d-m-Y", strtotime($tahun['tanggal_selesai']))?></td>
                        <td class="text-center">
                            <?php if($tahun['status']==1){
                                    echo "Aktif";
                                }else{
                                    echo "-";
                                }
                            ?>
                        </td>
                        <td class="text-center">

                            <a href="<?=base_url()?>/crud/aktifkan_tahun/<?=$tahun['id_tahun']?>/1" onclick="return confirm('Aktifkan Tahun ini sebagai tahun akademik saat ini.?')"><button class="btn btn-sm btn-primary">Aktifkan</button></a>

                            <a href="<?= base_url()?>/crud/hapus_tahun/<?= $tahun['id_tahun']?>" onclick="return confirm('Yakin Hapus?')"><button class="btn btn-sm btn-danger">Hapus</button></a>
                        </td>
                    </tr>
                    <?php 
                    endforeach;
                }
                ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>