<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Kelas  </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem</li>
        </ol>
        <?php
            $success_insert_kelas 	= session()->getFlashdata('success_insert_mapel');
            if(!empty($success_insert_kelas)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $success_insert_kelas?> <strong>Berhasil Ditambahkan</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <?php
            $pesan 	= session()->getFlashdata('pesan');
            if(!empty($pesan)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $pesan?> <strong>Berhasil Dihapus</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <?php
            $pesan2 	= session()->getFlashdata('pesan2');
            if(!empty($pesan2)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $pesan2?> <strong>Berhasil Di Update</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <div class="row" style="margin-bottom: 2%;">
            <a href="<?= base_url()?>/tu/form_kelas"><div class="col"><button class="btn btn-sm btn-primary">Tambah</button></div></a>
        </div>
        <div class="table-responsive" style="width: 50%;">
            <table class="table table-striped"width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1; foreach($data as $value):?>
                        <tr>
                            <td><?= $i++?></td>
                            <!-- helper kelas -->
                            
                            <td><?= kelas($value['kelas']). ' ' .$value['jurusan'] . ' ' .$value['kelompok']?></td>
                            <td>
                                <a href="<?= base_url()?>/tu/edit_kelas/<?= $value['id_kelas']?>"><button class="btn btn-sm btn-warning mb-2">Edit</button></a>
                                <a href="<?= base_url()?>/crud/hapus_kelas/<?= $value['id_kelas']?>" onclick="return confirm('Yakin Hapus?')"><button class="btn btn-sm btn-danger mb-2">Hapus</button></a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection()?>