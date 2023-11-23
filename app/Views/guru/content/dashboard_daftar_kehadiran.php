<?= $this->extend('guru/index'); ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Kehadiran </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 01 Warungasem</li>
        </ol>
        <div class="container">
            <div class="row">
                <?php foreach($data_kelas as $kelas): ?>
                    <div class="card text-white bg-primary mb-3 me-3" style="max-width: 15rem;">
                        <div class="card-header " style="margin-left: -5%;"><?= $kelas['nama_kelas']?></div>
                        <div class="card-body">
                            <?php $i=0;
                                foreach($jumlah_siswa as $jumlah){
                                    if($kelas['nama_kelas'] == $jumlah['kelas']){
                                        $i++;
                                    }
                                }
                            ?>
                            <h5 class="card-title text-center">Jumlah Murid</h5>
                            <h4 class="card-title text-center"> <?= $i?></h4>
                            <p class="card-text text-center">
                                <a href="<?= base_url()?>/home/laporan_presensi/<?=$kelas['nama_kelas']?>"><button type="button" class="btn btn-warning">Lihat Presensi</button></a>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?= $this->endSection();?>