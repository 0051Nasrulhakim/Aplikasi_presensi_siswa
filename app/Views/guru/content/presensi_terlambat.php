<?= $this->extend('guru/index'); ?>
<?= $this->section('content'); date_default_timezone_set('Asia/Jakarta');
?>
    <div class="container-fluid px-4"id="contain">
        <div class="isi" style="margin-bottom: 3%;">
            <div class="judul" style="margin-bottom: 3%;">
                <h1 class="mt-4 text-center">Lembar Presensi terlambat</h1>
                <h5 class="text-center">Tanggal Terlambat : <?= $waktu?></h5>
                <h5 class="text-center">Nama Mapel : <?= $nama_mapel?></h5>
                <h5 class="text-center">Kelas : <?= $kelas?></h5>
                <h5 class="text-center">Tahun Akademik : <?= session()->get('tahun_akademik');?> Semester <?= session()->get('semester')?></h5>
            </div>
            <!-- <ol class="breadcrumb mb-4 text-center">
                <li class="breadcrumb-item active ">Kelas = <?= $kelas?></li>
            </ol> -->
            <div class="container" style="border: 1px solid; border-radius: 9px; height: auto; margin-bottom: 10%;">
                <div class="table-responsive mb-5">
                    <form action="<?= base_url()?>/crud/insert_presensi_terlambat" clas="was-validated" method="post">
                        <input type="text" name="mapel" value="<?= $id_mapel?>" hidden>
                        <input type="text" name="tanggal_presensi" value="<?= $waktu?>" hidden>
                        <table class="table table-striped">
                            <thead>
                                <td>NO</td>
                                <td>NIS</td>
                                <td>Nama</td>
                                <td>Hadir</td>
                                <td>Izin</td>
                                <td>Alpha</td>
                                <td style="width: 18%;" class="text-center">Action</td>
                                <input type="text" name="kelas" value="<?= $id_kelas?>" hidden>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($siswa as $data_siswa) :
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
                                <input type="text" name="nama[<?= $data_siswa['nis_siswa']?>]" value="<?= $data_siswa['nama_siswa']?>" hidden>
                                <tr>
                                    <td><?= $i?></td>
                                    <td>
                                        <?= $data_siswa['nis_siswa']?>
                                    </td>
                                    <td>
                                        <?= $data_siswa['nama_siswa']?>
                                    </td>
                                    <td class="text-center" style="background-color: #68B984; width: 6%;">
                                        <?= $hadir?>
                                    </td>
                                    <td class="text-center" style="background-color: #F8F988; width: 6%;">
                                        <?= $izin?>
                                    </td>
                                    <td class="text-center" <?php if($alpha >=4){echo 'style="color: red; background-color: #E8C4C4; width: 6%;"';}else{ echo 'style="background-color: #E8C4C4; width: 6%;"';}?>>
                                        <?= $alpha?>
                                    </td>
                                    
                                    <td>
                                        <div class="form" style="margin-left: 6%;">
                                            <!-- <input class="form-check-input" type="radio" name="presensi[<?= $data_siswa['nis_siswa']?>]" value="" checked hidden> -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="validationFormCheck1" name="presensi[<?= $data_siswa['nis_siswa']?>]" value="hadir" required>
                                                <label class="form-check-label" for="validationFormCheck1">
                                                    Hadir
                                                </label>
                                                <div class="invalid-feedback">More example invalid feedback text</div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="validationFormCheck2" name="presensi[<?= $data_siswa['nis_siswa']?>]" value="izin" required>
                                                <label class="form-check-label" for="validationFormCheck2">
                                                    Izin
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="validationFormCheck3" name="presensi[<?= $data_siswa['nis_siswa']?>]" value="alpha" required>
                                                <label class="form-check-label" for="validationFormCheck3">
                                                    Alpha
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;endforeach;?>
                        </table>
                        <div class="button">
                            <button type="submit" style="margin-left: 85%;" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
        $(document).ready(function(){
            // ketika radio di click otomatis ter check semua
            $('input[type="radio"]').click(function(){
                if($(this).attr("value") == "hadir"){
                    $(".form-check-input[value='hadir']").prop('checked', true);
                }
            });
        });
    </script>
<?= $this->endSection(); ?>
