<?= $this->extend('tu/index') ?>
<?= $this->section('content');
// dd($guru)
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Form Tambah Mapel </h1>
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
                Inpu Data Mapel
            </div>
            
            <form action="<?= base_url()?>/crud/tambah_mapel" method="post">
                <div class="form" style="padding: 2%;">
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Nama Mapel</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_mapel">
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
        </div>
    </div>
<?= $this->endSection(); ?>