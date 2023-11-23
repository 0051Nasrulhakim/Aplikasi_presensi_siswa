<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Form Edit Kelas </h1>
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
                Edit Data Kelas
            </div>
            <?php foreach($data as $value):?>
            <form action="<?= base_url()?>/crud/edit_kelas" method="post">
                <div class="form" style="padding: 2%;">
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Kelas</label>
                        <div class="col-sm-9">
                            <select class="form-select form-select-sm" name="kelas" id="">
                                <option value="10" <?php if($value['kelas'] == 10){ echo 'Selected';}?>>X (Sepuluh)</option>
                                <option value="11" <?php if($value['kelas'] == 11){ echo 'Selected';}?>>XI (Sebelas)</option>
                                <option value="12" <?php if($value['kelas'] == 12){ echo 'Selected';}?>>XII (Duabelas)</option>
                            </select>
                            <!-- <input type="number" class="form-control" name="kelas"> -->
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Jurusan</label>
                        <div class="col-sm-9">
                            <input type="text" name="id_kelas" id="id_kelas" value="<?= $value['id_kelas']?>" hidden>
                            <input type="text" class="form-control" name="jurusan" value="<?= $value['jurusan']?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Kelompok</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="kelompok" value="<?= $value['kelompok']?>">
                        </div>
                    </div>
                    <div class="mb-5 row">
                        <div class="col" style=" margin-left: 80%;">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
            <?php endforeach?>
        </div>
    </div>
<?= $this->endSection(); ?>