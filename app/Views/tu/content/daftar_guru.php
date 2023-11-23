<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">List Daftar Guru </h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">SMK Negeri 1 Warungasem </li>
    </ol>
        <?php
            $success_insert_guru 	= session()->getFlashdata('success_insert_guru');
            if(!empty($success_insert_guru)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $success_insert_guru?> <strong>Berhasil Ditambahkan</strong>
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
                    <?= $pesan?> <strong>Berhasil Di Update</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <?php
            $success_delete_guru 	= session()->getFlashdata('success_delete_guru');
            if(!empty($success_delete_guru)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $success_delete_guru?> <strong>Berhasil Dihapus</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
    <div class="row" style="margin-bottom: 2%;">
        <div class="col">
            <a href="<?= base_url()?>/tu/form_guru"><button class="btn btn-sm btn-primary">Tambah</button></a>
        </div>
    </div>
    <table class="table table-striped" id="guru">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <!-- style="vertical-align: middle; border: 1px solid" class="text-center" -->
                <th rowspan="2">Nip</th>
                <th rowspan="2">Nama Guru</th>
                <th colspan="2" class="text-center">Jam Mengajar</th>
                <th rowspan="2" class="text-center">Jenis Kelamin</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                <td class="text-center">Terpakai</td>
                <td class="text-center">MIN</td>
            </tr>
        </thead>
        <tbody>
            <?php $i= 1;foreach ($data as $value):?>
            <tr>
                <td><?= $i++?></td>
                <td><?= $value['nip']?></td>
                <td><?= $value['nama_guru']?></td>
                <td class="text-center" <?php if($value['jumlah_jam'] < $value['min_jam']){echo 'style="background-color: #EB455F; color:white"';}elseif($value['jumlah_jam'] > $value['min_jam']){echo 'style="background-color: #F7C04A; color:white"';}elseif($value['jumlah_jam'] = $value['min_jam']){echo 'style="background-color: #16FF00; color:white"';} ?>><?= $value['jumlah_jam']?></td>
                <td class="text-center"><?= $value['min_jam']?></td>
                <td class="text-center"><?= $value['jenis_kelamin']?></td>
                <td>
                    <a href="<?= base_url()?>/tu/edit_guru/<?= $value['nip']?>"><button class="btn btn-sm btn-warning">Ubah</button></a>
                    <a href="<?= base_url()?>/crud/hapus_guru/<?= $value['nip']?>"  onclick="return confirm('yakin Ingin Menghapus?')"><button class="btn btn-sm btn-danger">Hapus</button></a>
                </td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#guru').DataTable({
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