<?= $this->extend('tu/index') ?>
<?= $this->section('content');
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Halaman Presensi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem </li>
        </ol>
        <?php
            $pesan 	= session()->getFlashdata('pesan');
            if(!empty($pesan)){
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $pesan?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
        ?>
        <?php
            $errors 	= session()->getFlashdata('errors');
            if(!empty($errors)){
            ?>
                <div class="alert alert-danger" role="alert">
                    <ul>    
                        <?php foreach($errors as $e):?>
                            <li><?= $e?></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            <?php
            }
        ?>
        <div class="container">
            <div class="row">
                <?php foreach($data as $value):?>
                    <div class="card text-white mb-3 me-3" style="max-width: 15rem;">
                        <div class="card-header bg-primary text-center" style="height: 90px;"><?=kelas($value['kelas']). ' '. $value['jurusan']. ' ' . $value['kelompok']?></div>
                        <div class="card-body">

                            <?php $i=0;
                                
                                foreach($jumlah_siswa as $jumlah){
                                    if($value['id_kelas'] == $jumlah['id_kelas']){
                                        $i++;
                                    }
                                }
                            ?>
                            <!-- <h5 class="card-title text-center" style="color: black;"></h5> -->
                            <h5 class="card-title text-center" style="color: black;">Jumlah Murid</h5>
                            <h4 class="card-title text-center" style="color: black;"> <?= $i?></h4>
                            <p class="card-text text-center">
                                <button type="button" class="btn btn-sm btn-info" value="<?= $value['id_kelas']?>">Rekap</button>
                                <!-- <a href="<?= base_url()?>/tu/laporan_presensi_kelas/<?=$value['id_kelas']?>"><button type="button" class="btn btn-warning">Lihat Presensi</button></a> -->
                                <button type="button" class="btn btn-sm btn-primary btn_kelola" value="<?= $value['id_kelas']?>">Kelola</button>
                                <button type="button" class="btn btn-warning mt-2" value="<?= $value['id_kelas']?>">Lihat Presensi</button>
                            </p>
                        </div>
                    </div>

                <?php endforeach;?>
            </div>
        </div>
    </div>
    
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Lihat Presensi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url()?>/tu/laporan_presensi_kelas" method="post">
                <div class="modal-body">
                    <input type="text" name="id_kelas" id="id_kelas" hidden>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Pilih Tahun Akademik</label>
                        <div class="col-sm-7">
                            <select name="tahun_akademik" id="" class="form-select">
                                <option value="">Pilih Tahun Akademik</option>
                                <?php foreach($tahun_akademik as $value):?>
                                    <option value="<?= $value['id_tahun']?>"
                                    <?php
                                        if($value['id_tahun'] == session()->get('id_akademik')){
                                            echo 'Selected';
                                        }
                                    ?>
                                    ><?= $value['tahun']?> Semester <?= $value['semester']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Lihat</button>
                </div>
            </form>
        </div>
    </div>
</div>
    
<div class="modal fade" id="modal_rekap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Rekap Presensi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url()?>/export/test_export" method="post">
                <div class="modal-body">
                    <input type="text" name="id_kelas_rekap" id="id_kelas_rekap" hidden>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Pilih Tahun Akademik</label>
                        <div class="col-sm-7">
                            <select name="tahun_akademik" id="" class="form-select">
                                <option value="">Pilih Tahun Akademik</option>
                                <?php foreach($tahun_akademik as $value):?>
                                    <option value="<?= $value['id_tahun']?>" <?php
                                        if($value['id_tahun'] == session()->get('id_akademik')){
                                            echo 'Selected';
                                        }
                                        ?>><?= $value['tahun']?> Semester <?= $value['semester']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Export kedalam</label>
                        <div class="col-sm-7">
                            <select name="jenis_file" id="" class="form-select">
                                <option value="">Pilih Jenis FIle</option>
                                <option value="pdf">pdf (.pdf)</option>
                                <option value="pdf">Excell (.xls)</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Lihat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="kelola" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Kelola Presensi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url()?>/tu/kelola_presensi" method="post">
                <div class="modal-body">
                    <input type="text" name="id_kelas" id="id_kelas_kelola" hidden>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Pilih Tahun Akademik</label>
                        <div class="col-sm-7">
                            <select name="tahun_akademik" id="" class="form-select">
                                <option value="">Pilih Tahun Akademik</option>
                                <?php foreach($tahun_akademik as $value):?>
                                    <option value="<?= $value['id_tahun']?>"
                                    <?php 
                                        if($value['id_tahun'] == session()->get('id_akademik')){
                                            echo 'Selected';
                                        }
                                    ?>
                                    ><?= $value['tahun']?> Semester <?= $value['semester']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Pilih Ketegori</label>
                        <div class="col-sm-7">
                            <select name="kategori" id="kategori" class="form-select kategori">
                                <option value="">Pilih Kategori</option>
                                <!-- <option value="libur">Libur</option> -->
                                <option value="keterlambatan_presensi">Keterlambatan Presensi</option>
                            </select>
                        </div>
                    </div>
                    <div class="mapel input_mapel" id="mapel" style="display: none;">
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-5 col-form-label">Pilih Mapel</label>
                            <div class="col-sm-7">
                                <select name="mapel" id="" class="form-select">
                                    <option value="">Pilih Mapel</option>
                                    <?php foreach($mapel as $value):?>
                                        <option value="<?= $value['id_mapel']?>"><?= $value['nama_mapel']?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-5 col-form-label">Masukkan Tanggal</label>
                            <div class="col-sm-7">
                                <input type="date" name="tanggal" id="" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-5 col-form-label">Tampilkan Token Lewat</label>
                            <div class="col-sm-7">
                                <select name="via" id="via">
                                    <option value="web">Website</option>
                                    <option value="wa">Whatsapp</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="wa via_wa" style="display: none;">
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-5 col-form-label">Masukkan Nomor wa</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="nomor" value="+62" id="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Lihat</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.btn-warning').click(function(){
            var id_kelas = $(this).val();
            $('#exampleModal').modal('show');
            $('#id_kelas').val(id_kelas);
        });
    });
    $(document).ready(function(){
        $('.btn-info').click(function(){
            var id_kelas = $(this).val();
            $('#modal_rekap').modal('show');
            $('#id_kelas_rekap').val(id_kelas);
        });
    });
    
    $(document).ready(function(){
        $('.btn_kelola').click(function(){
            var id_kelas = $(this).val();
            // alert(id_kelas);
            $('#kelola').modal('show');
            $('#id_kelas_kelola').val(id_kelas);
        });
    });
    // get kategori
    $(document).ready(function(){
        $('.kategori').change(function(){
            var kategori = $(this).val();
            if(kategori == 'keterlambatan_presensi'){
                $('.input_mapel').show();
            }else{
                $('.input_mapel').hide();   
            }
        });
    });
    // get via
    $(document).ready(function(){
        $('#via').change(function(){
            var via = $(this).val();
            if(via == 'wa'){
                $('.via_wa').show();
            }else{
                $('.via_wa').hide();
            }
        });
    });

</script>
<?= $this->endSection();?>