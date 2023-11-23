<?= $this->extend('siswa/index'); ?>
<?= $this->section('content') ?>
    <div class="page" style="height: 92vh;">

        <div class="container-fluid px-4" style="margin-top: 7%;">
            <h1 class="mt-4 text-center">Informasi Kegiatan </h1>
            <h4 class="text-center" >SMK Negeri 01 Warungasem</h4>
            
        </div>
        <div class="container" style="margin-top: 3%;">
            <div class="table table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kegitan</th>
                            <th>Keterangan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i= 1;
                            if($jadwal != null){
                                foreach($jadwal as $value){
                        ?>
                        <tr>
                            <td><?= $i++?></td>
                            <td><?= $value['nama_kegiatan']?></td>
                            <td><?= $value['keterangan']?></td>
                            <td><?= date_format(date_create($value['tanggal_mulai']), 'd-m-Y')?></td>
                            <td><?= date_format(date_create($value['tanggal_selesai']), 'd-m-Y')?></td>
                        </tr>
                        <?php
                            }
                        }else{
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada Informasi Kegiatan</td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="logout text-center mt-5" style="margin-bottom: 13%;">
                <h4>Halaman Home <a href="<?= base_url()?>/siswa"><button class="btn btn-sm btn-danger">Kembali</button></a></h4>
            </div>
        </div>
    </div>
<?= $this->endSection();?>