<?= $this->extend('tu/index'); ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Jadwal Pelajaran </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 01 Warungasem</li>
        </ol>
    
        <?php
            $success_insert_jadwal 	= session()->getFlashdata('success_insert_jadwal');
            if(!empty($success_insert_jadwal)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $success_insert_jadwal?> <strong>Berhasil Ditambahkan</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <?php
            $success_delete_jadwal 	= session()->getFlashdata('success_delete_jadwal');
            if(!empty($success_delete_jadwal)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $success_delete_jadwal?> <strong>Berhasil Dihapus</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <div class="row" style="margin-bottom: 2%;">
            <div class="col">
                <a href="<?= base_url()?>/tu/form_jadwal"><button class="btn btn-sm btn-primary">Tambah</button></a>
            </div>
        </div> 
        <div class="container">
            <div class="row">
                <?php foreach($kelas as $value):?>
                    <div class="card text-white bg-primary mb-3 me-3" style="max-width: 15rem;">
                        <div class="card-header " style="margin-left: -5%;"><?= kelas($value['kelas']).' '.$value['jurusan'].' '.$value['kelompok']?></div>
                        <div class="card-body">
                            <p class="card-text text-center">
                                <a href="<?= base_url()?>/tu/daftar_jadwal/<?= $value['id_kelas']?>"><button type="button" class="btn btn-warning">Tampilkan Jadwal</button></a>
                            </p>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        
        
    </div>
<?= $this->endSection()?>