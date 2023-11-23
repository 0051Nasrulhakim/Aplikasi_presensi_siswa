<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Form Edit Siswa </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem </li>
        </ol>
        <div class="err" style="width: 60rem; margin-left: 5%; margin-right: 5%; margin-bottom: -3%;">
            <?php
                $errors 	= session()->getFlashdata('errors');
                if(!empty($errors)){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <ul>    
                            <?php foreach($errors as $e):?>
                                <li><?= $e?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                <?php
                }
            ?>
        </div>
        <div class="card" style="width: 60rem; margin-left: 5%; margin-right: 5%; margin-top: 5%; margin-bottom: 5%;">
            <div class="card-header">
                Edit Data Siswa
            </div>
            <?php foreach($data as $value):?>
                <form action="<?= base_url()?>/crud/update_siswa" method="post">
                    <div class="form" style="padding: 2%;">
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">NIS Siswa</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nis_siswa" value="<?= $value['nis_siswa']?>">
                                <input type="text" class="form-control" name="key" value="<?= $value['nis_siswa']?>" hidden>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Nama Siswa</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_siswa" value="<?= $value['nama_siswa']?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="tanggal_lahir" value="<?= $value['tanggal_lahir']?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Kelas</label>
                            <div class="col-sm-9">
                                <select name="kelas" id="" class="form-select">
                                    <option value="">Pilih Jenis kelas</option>
                                    <?php foreach($kelas as $k):?>
                                        <option value="<?= $k['id_kelas']?>"<?php if($value['id_kelas'] == $k['id_kelas']){echo 'selected';}?>><?= kelas($k['kelas']).' '.$k['jurusan'].' '.$k['kelompok']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <select name="jenis_kelamin" id="" class="form-select">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" <?php if($value['jenis_kelamin']=='L'){echo 'selected';}?>>Laki - Laki</option>
                                    <option value="P" <?php if($value['jenis_kelamin']=='P'){echo 'selected';}?>>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select name="status" id="" class="form-select">
                                    <option value="">Pilih Status</option>
                                    <option value="aktif" <?php if($value['status']=='aktif'){echo 'selected';}?>>Aktif</option>
                                    <option value="tidak aktif" <?php if($value['status']=='tidak aktif'){echo 'selected';}?>>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-5 row">
                            <div class="col" style=" margin-left: 80%;">
                                <button class="btn btn-sm btn-danger"><i class="fa-solid fa-floppy-disk"></i> Hapus</button>
                                <button class="btn btn-sm btn-success"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endforeach;?>
        </div>
<?= $this->endSection()?>