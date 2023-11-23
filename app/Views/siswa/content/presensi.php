<?= $this->extend('siswa/index') ?>
<?= $this->section('content') ?>
  <?php $total=0?>
    <div class="bungkus" id="bungkus">
        <div class="container-fluid px-4" style="margin-top: 6%;">
            <h1 style="margin-top:4%; margin-bottom: 2%;">Detail Kehadiran </h1>
            <h5 class=""><?= $nama_siswa?> - <?= $nama_kelas?></h5>
            <p class="mb-4">Tahun <?= session()->get('tahun_akademik')?> - Semester <?= session()->get('semester')?></p>
            <?php
                if($jumlah_alpha >= 4){
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Perhatian!</strong> Anda sudah mengalami 5 kali ALPHA tanpa keterangan. Silahkan hubungi wali kelas untuk keterangan lebih lanjut.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
            <div class="table-responsive">
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
                            <td><?= $d['nama_guru']?></td>
                        </tr>
                        <?php $total++;$i++; endforeach;?>
                        <?php }else{
                            echo "<tr><td colspan='7' class='text-center'>Data tidak ditemukan. Belum ada absen masuk</td></tr>";
                        }?>
                        <tr>
                            <td colspan="3">Jumlah Presensi : <?= $total?></td>
                        </tr>
                        <tr>
                            <td colspan="3">Jumlah Hadir : <?= $jumlah_hadir?> </td>
                        </tr>
                        <tr>
                            <td colspan="3">Jumlah izin : <?= $jumlah_izin?></td>
                        </tr>
                        <tr>
                            <td colspan="3">Jumlah izin : <?= $jumlah_alpha?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="logout text-center mt-5" style="margin-bottom: 13%;">
            <h4>Kembali Halaman Home <a href="<?= base_url()?>/siswa"><button class="btn btn-sm btn-warning">Back</button></a></h4>
        </div>
    </div>
<?= $this->endSection()?>