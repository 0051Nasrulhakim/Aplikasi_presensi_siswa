<?= $this->extend('tu/index') ?>
<?= $this->section('content'); $total = 0 ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Kehadiran </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelas <?= $kelas?></li>
            <li class="breadcrumb-item active">Tahun Akademik <?= $akademik['tahun']?> Semester <?= $akademik['semester']?></li>
        </ol>

        <table class="table table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>NIS</td>
                    <td>Nama Siswa</td>
                    <td class="col-2 text-center">Jumlah hadir </td>
                    <td class="col-2 text-center">jumlah Alpha</td>
                    <td class="col-2 text-center">Jumlah Izin</td>
                    <td class="text-center">Action</td>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($data_kelas as $data_siswa):?>
                <?php
                    $hadir=0; $alpha=0; $izin=0; foreach($presensi as $P){
                        if($P['nis_siswa'] === $data_siswa['nis_siswa'] && $P['status'] === 'hadir'){
                            $hadir++;
                        }else if($P['nis_siswa'] === $data_siswa['nis_siswa'] && $P['status'] === 'alpha') {
                            $alpha++;
                        }else if($P['nis_siswa'] === $data_siswa['nis_siswa'] && $P['status'] === 'izin'){
                            $izin++;
                        }
                        $total = $hadir + $alpha + $izin;
                    }    
                ?>
                <tr>
                    <td><?= $i;?></td>
                    <td><?= $data_siswa['nis_siswa']?></td>
                    <td><?= $data_siswa['nama_siswa']?></td>
                    <td class="col-2 text-center">
                        <?= $hadir;?>
                    </td>
                    <td class="col-2 text-center" <?= $alpha > 3 ? 'style="color: red"' : '' ;?> >
                        <?= $alpha;?>
                    </td>
                    <td class="col-2 text-center">
                        <?= $izin?>
                    </td>
                    <td class="text-center">
                        <a href="<?=base_url()?>/tu/list_daftar_mapel/<?=$data_siswa['nis_siswa']?>/<?= $akademik['id_tahun']?>/<?= $id_kelas?>"><button class="btn btn-sm btn-primary">detail</button></a>
                    </td>
                </tr>
                <?php $i++; endforeach;?>
                <tr>
                    <td colspan="2"><b> total pertemuan <?= $total;?></b></td>
                </tr>
            </tbody>
        </table>
    </div>
<?= $this->endSection(); ?>