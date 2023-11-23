<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Mata Pelajaran </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem</li>
        </ol>
        <?php
            $success_insert_mapel 	= session()->getFlashdata('success_insert_mapel');
            if(!empty($success_insert_mapel)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $success_insert_mapel?> <strong>Berhasil Ditambahkan</strong>
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
                    <?= $pesan?> <strong>Berhasil Di Ubah</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <?php
            $success_delete_mapel 	= session()->getFlashdata('success_delete_mapel');
            if(!empty($success_delete_mapel)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $success_delete_mapel?> <strong>Berhasil Dihapus</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <div class="row" style="margin-bottom: 2%;">
            <div class="col">
                <a href="<?= base_url()?>/tu/form_mapel"><button class="btn btn-sm btn-primary">Tambah</button></a>
            </div>
        </div>
            <table class="table table-striped" id="mapel">
                <thead>
                    <tr>
                        <td>no</td>
                        <td>Nama Mapel</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <body>
                    <?php $i=1; foreach($data as $value):?>
                        <tr>
                            <td><?= $i++?></td>
                            <td><?= $value['nama_mapel']?></td>
                            <td>
                                <a href="<?=base_url()?>/tu/edit_mapel/<?=$value['id_mapel']?>"><button class="btn btn-sm btn-warning">Ubah</button></a>
                                <a href="<?=base_url()?>/crud/hapus_mapel/<?=$value['id_mapel']?>" onclick="return confirm('Yakin Ingin Hapus mapel.?')"><button class="btn btn-sm btn-danger">Hapus</button></a>
                            </td>       
                        </tr>
                    <?php endforeach?>
                </body>
            </table>        
    </div>
    <script>
        $(document).ready(function() {
            $('#mapel').DataTable({
                dom: 'Bfrtip',
                paging: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tous"]],
                order: [[ 0, 'asc' ], [ 1, 'asc' ]],
                buttons: [ 'copy', 'csv', 'print' ],
                rowGroup: {
                    emptyDataGroup: 'Data Guru Tidak Ada'
                }
            });
        } );
    </script>
<?= $this->endSection()?>