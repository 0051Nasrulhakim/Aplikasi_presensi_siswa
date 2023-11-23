<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Form Edit Guru </h1>
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
                Edit Data Guru
            </div>
            <?php foreach($data as $value):?>
                <form action="<?= base_url()?>/crud/update_guru" method="post">
                    <div class="form" style="padding: 2%;">
                        <div class="mb-3 row">
                            <input type="text" name="key" value="<?= $value['nip']?>" hidden>
                            <label for="staticEmail" class="col-sm-3 col-form-label">NIP Guru</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nip" value="<?= $value['nip']?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Nama Guru</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_guru" value="<?= $value['nama_guru']?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="tanggal_lahir" value="<?= $value['tanggal_lahir']?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Minimal Jam Mengajar</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="min_jam" value="<?= $value['min_jam']?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <select name="jenis_kelamin" id="" class="form-select">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" <?php if($value['jenis_kelamin']=='L'){echo 'selected';}else{'';}?>>Laki - Laki</option>
                                    <option value="P" <?php if($value['jenis_kelamin']=='P'){echo 'selected';}else{'';}?>>Perempuan</option>
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
            <?php endforeach?>
        </div>
    </div>
<?= $this->endSection();?>