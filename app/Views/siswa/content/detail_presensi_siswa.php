<?= $this->extend('siswa/index') ?>
<?= $this->section('content'); $total = 0; ?>
    <div class="container">
        <div class="container-fluid px-4" style="margin-top: 6%;">
            <div class="center text-center mb-4">
                <h1 class="mt-4">Detail Kehadiran Mapel <?= $nama_mapel?></h1>
                <h5>Nama siswa : <?= $nama_siswa?></h5>
                <h5>Tahun <?= $tahun_akademik . '/' . $tahun_akademik+1?> Semester <?= $semester?></h5>
                <hr>
            </div>
            <h5 class="mb-4 breadcrumb-item active"><?= $nama_kelas?></h5>
            <?php if($jumlah_alpha >= 4){ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Perhatian!</strong> Siswa ini sudah mengalami 5 kali ALPHA tanpa keterangan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nis</th>
                            <th>Nama</th>
                            <th>Matapelajaran</th>
                            <th class="text-center">Presensi</th>
                            <th class="text-center">Waktu presensi</th>
                            <th class="text-center">Hari</th>
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
                            <td class="text-center"><?= $d['status']?></td>
                            <td class="text-center"><?= 
                                date_format(date_create($d['waktu_presensi']), 'd-m-Y H:i:s');
                                ?></td>
                            <!-- <td class="text-center"><?= $d['nama_guru']?></td> -->
                            <td class="text-center">
                                <?= hari_ini(date_format(date_create($d['waktu_presensi']), 'D'));?>
                            </td>
                        </tr>
                        <?php $total++;$i++; endforeach;?>
                        
                        <?php }else{
                            echo "<tr><td colspan='7' class='text-center'>Data tidak ditemukan. Belum ada absen masuk</td></tr>";
                        }?>
                    </tbody>
                </table>
                <h4 style="margin-top: 4%;">Daftar Presensi Terlambat</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nis</th>
                            <th>Nama</th>
                            <th>Matapelajaran</th>
                            <th class="text-center">Presensi</th>
                            <th class="text-center">Tanggal Pelajaran</th>
                            <th class="text-center">Waktu presensi</th>
                            <th class="text-center">Hari</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($terlambat != null){?>
                            <?php  $i=1; foreach($terlambat as $row):?>
                            <tr>
                                <td><?= $i?></td>
                                <td><?= $row['nis_siswa']?></td>
                                <td><?= $row['nama_siswa']?></td>
                                <td><?= $row['nama_mapel']?></td>
                                <td class="text-center"><?= $row['status']?></td>
                                <td class="text-center"><?=
                                    date_format(date_create($row['tanggal_presensi']), 'd-m-Y');
                                    // tanggal format indonesia
                                ?></td>
                                <td class="text-center"><?= 
                                    date_format(date_create($row['waktu_presensi']), 'd-m-Y H:i:s');
                                ?></td>
                                <td class="text-center">
                                <?=
                                    hari_ini(date_format(date_create($row['tanggal_presensi']), 'D'));    
                                ?>
                                </td>
                            </tr>
                            <?php $total++;$i++; endforeach;?>
                        <?php }else{?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada daftar presensi Terlambat</td>
                            </tr>
                        <?php }?>
                    <tbody>
                </table>
                <table class="table table-stripped" style="width: 30%;">
                    <tr>
                        <td colspan="3" class="bg-secondary" style="color: white;">Persentase Kehadiran : <?php 
                            // pesentase kehadiran
                            if($jumlah_hadir == 0){
                                $persen = 0;
                            }else{
                                $persen = $jumlah_hadir / $total * 100;
                            }
                            if($persen != 0){
                                // $persen = $jumlah_hadir / $total * 100;
                                echo $persen.'%';
                            }else{
                                echo '-';
                            }
                            
                        ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="bg-info">Jumlah Presensi : <?= $total?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="bg-success">Jumlah Hadir : <?= $jumlah_hadir?> </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="bg-primary">Jumlah Izin : <?= $jumlah_izin?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="bg-warning">Jumlah Alpha : <?= $jumlah_alpha?></td>
                    </tr>
                </table>
            </div>
            <div class="logout text-center mt-5" style="margin-bottom: 13%;">
                <h4>Halaman Home <a href="<?= base_url()?>/siswa"><button class="btn btn-sm btn-danger">Kembali</button></a></h4>
            </div>
        </div>
    </div>
<?= $this->endSection()?>