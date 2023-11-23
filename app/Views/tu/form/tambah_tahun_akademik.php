<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Form Tambah Tahun Akademik </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem </li>
        </ol>
        <?php
            $pesan 	= session()->getFlashdata('pesan');
            if(!empty($pesan)){
            ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $pesan?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
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
                Input Tahun Akademik
            </div>
            <form action="<?= base_url()?>/crud/tahun_akademik" method="post">
                <div class="form" style="padding: 2%;">
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="tahun">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Semester</label>
                        <div class="col-sm-9">
                            <!-- <input type="text" class="form-control" name="Semester"> -->
                            <select name="semester" class="form-select" id="">
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tanggal Mulai</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="tanggal_mulai">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tanggal Selesai</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="tanggal_selesai">
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
    </div>
<?= $this->endSection() ?>