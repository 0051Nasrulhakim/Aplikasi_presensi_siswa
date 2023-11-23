<?= $this->extend('guru/index') ?>
<?= $this->section('content') ?>
    
    <div class="container">
        <div class="container-fluid px-4">
            <h1 class="mt-4">Detail Kehadiran </h1>
            <?php $total=0; foreach($nama_kelas as $NK):?>
            <h5 class="mb-4"><?= $NK['nama_siswa']?> - <?= $NK['kelas']?></h5>
            <?php endforeach?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nis</td>
                        <td>Nama</td>
                        <td>Matapelajaran</td>
                        <td>Presensi</td>
                        <td>Waktu presensi</td>
                        <td>Guru</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if($data != null){?>
                    <?php  $i=1; foreach($data as $d):?>
                    <tr>
                        <td><?= $i?></td>
                        <td><?= $d['nis_siswa']?></td>
                        <td><?= $d['nama_siswa']?></td>
                        <td><?= $d['nama_mapel']?></td>
                        <td><?= $d['status']?></td>
                        <td><?= $d['waktu_presensi']?></td>
                        <td><?= $d['guru']?></td>
                    </tr>
                    <?php $total++;$i++; endforeach;?>
                    <?php }else{
                        echo "<tr><td colspan='7' class='text-center'>Data tidak ditemukan. Belum ada absen masuk</td></tr>";
                    }?>
                    <tr>
                        <td colspan="3">Jumlah Presensi : <?= $total?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
<?= $this->endSection() ?>