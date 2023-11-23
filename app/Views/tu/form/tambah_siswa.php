<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Form Tambah Siswa </h1>
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
                Inpu Data Siswa
            </div>
            
            <form action="<?= base_url()?>/crud/insert_siswa" method="post">
                <div class="form" style="padding: 2%;">
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">NIS Siswa</label>
                        <div class="col-sm-9">
                            <?php foreach($nis as $nis_siswa):?>
                                <input type="text" class="form-control" name="nis_siswa" value="<?= $nis_siswa['nis']+1?>">
                            <?php endforeach?>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tahun Masuk</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="tahun">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Nama Siswa</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_siswa">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="tanggal_lahir">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Kelas</label>
                        <div class="col-sm-9">
                            <select name="kelas" id="" class="form-select">
                                <option value="">Pilih Jenis kelas</option>
                                <?php foreach($data as $kelas):?>
                                    <option value="<?= $kelas['id_kelas']?>"><?= kelas($kelas['kelas']) . ' ' . $kelas['jurusan'] . ' ' . $kelas['kelompok']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <select name="jenis_kelamin" id="" class="form-select">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-5 row">
                        <div class="col" style=" margin-left: 85%;">
                            <button class="btn btn-sm btn-success"><i class="fa-solid fa-floppy-disk"></i> Tambahkan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
<?= $this->endSection()?>