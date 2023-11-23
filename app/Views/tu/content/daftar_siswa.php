<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Siswa</h1>
        <h4> <?php if($grup_kelas['id_kelas'] != ''){ echo ''.kelas($grup_kelas['kelas']). ' ' .$grup_kelas['jurusan'] .  ' '.$grup_kelas['kelompok'];}?></h4>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem </li>
        </ol>

        <?php
            $success_insert_siswa 	= session()->getFlashdata('success_insert_siswa');
            if(!empty($success_insert_siswa)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $success_insert_siswa?> <strong>Berhasil Ditambahkan</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <?php
            $success_delete_siswa 	= session()->getFlashdata('success_delete_siswa');
            if(!empty($success_delete_siswa)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $success_delete_siswa?> <strong>Berhasil Dihapus</strong>
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
                    <?= $pesan?> <strong>Berhasil di Update</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>

        <div class="action" style="display: flex; flex-direction: row; margin-bottom: 2%;">
            <div class="btn_tambah">
                <a href="<?= base_url()?>/tu/form_siswa"><div class="col"><button class="btn btn-sm btn-primary">Tambah</button></div></a>
            </div>
            <div style="margin-left: 1%;" class="btn_import">
                <div class="col"><button class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Import</button></div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 2%;">
            <form action="<?= base_url()?>/tu/daftar_siswa" method="POST" style="display: flex;">
                <div class="col-5" style="margin-right: 1%;">
                    <select class="from-select form-select-sm" style="width: 100%;" name="grup_kelas" id="">
                        <option value="">Semua Kelas</option>
                        <?php foreach($daftar_kelas as $kelas):?>
                            <option value="<?= $kelas['id_kelas']?>" <?php if($kelas['id_kelas']==$grup_kelas['id_kelas']){echo 'Selected';}?>><?= kelas($kelas['kelas']). ' ' .$kelas['jurusan'] . ' ' . $kelas['kelompok']?> </option>
                        <?php endforeach?>
                    </select>
                </div>
                <div class="col">
                    <button class="btn btn-sm btn-info" type="submit">Tampilkan</button>
                </div>
            </form>
        </div>
        <table class="table table-striped" id="siswa">
            <thead>
                <td>No</td>
                <td>NIS</td>
                <td>Nama Siswa</td>
                <td>Kelas</td>
                <td>status</td>
                <td>Action</td>
            </thead>
            <tbody>
                <?php $i=1; foreach($data as $value): ?>
                <tr>
                    <td><?= $i++?></td>
                    <td><?= $value['nis_siswa']?></td>
                    <td><?= $value['nama_siswa']?></td>
                    <td><?= kelas($value['kelas']).' '. $value['jurusan']. ' ' . $value['kelompok']?></td>
                    <td><?= $value['status']?></td>
                    <td>
                        <a href="<?= base_url()?>/tu/edit_siswa/<?= $value['nis_siswa']?>"><button class="btn btn-sm btn-warning">ubah</button></a>
                        <a href="<?= base_url()?>/crud/hapus_siswa/<?= $value['nis_siswa']?>" onclick="return confirm('Yakin Hapus?')"><button class="btn btn-sm btn-danger">Hapus</button></a>   
                    </td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
    <?= $this->include('/tu/modals/import');?>

    <script>
        $(document).ready(function() {
            $('#siswa').DataTable({
                dom: 'Bfrtip',
                paging: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tous"]],
                order: [[ 0, 'asc' ], [ 1, 'asc' ]],
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            });
        } );
    </script>
<?= $this->endSection()?>