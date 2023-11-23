<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1>Semester : <?= $semester?></h1>
    <h1>Tahun Akademik : <?= $tahun_akademik . ' / ' . $tahun_akademik+1?> </h1>
</div>
<?= $this->endSection() ?>