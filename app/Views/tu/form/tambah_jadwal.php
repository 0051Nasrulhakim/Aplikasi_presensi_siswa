<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Form Tambah Jadwal </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem </li>
        </ol>
        <div class="err" style="width: 60rem; margin-left: 5%; margin-right: 5%; margin-bottom: -3%;">
            <?php
                $guru_selected = '';
                $errors 	= session()->getFlashdata('errors');
                $waktu_limit = session()->getFlashdata('waktu_limit');
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
                $limit_waktu 	= session()->getFlashdata('limit_waktu');
                if(!empty($limit_waktu)){
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><?= $limit_waktu?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
            ?>
        </div>

        <div class="card" style="width: 60rem; margin-left: 5%; margin-right: 5%; margin-top: 5%; margin-bottom: 5%;">
            <div class="card-header">
                Inpu Jadwal Mengajar
            </div>
            <form action="<?= base_url()?>/crud/insert_jadwal" method="post">
                <div class="form" style="padding: 2%;">
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-9">
                            <select name="tahun_akademik" class="form-select" id="">
                                <option value="">Pilih Tahun akademik</option>
                                <?php foreach($tahun_akademik as $tahun):?>
                                <option value="<?= $tahun['id_tahun']?>" 
                                <?php 
                                    if($tahun['id_tahun'] == session()->get('id_akademik')){ echo 'Selected'; }
                                    ?>>Tahun <?= $tahun['tahun']?> - Semester <?= $tahun['semester']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Hari</label>
                        <div class="col-sm-9">
                            <select name="hari" id="" class="form-select">
                                <option value="">Pilih Hari</option>
                                <option value="senin">Senin</option>
                                <option value="selasa">selasa</option>
                                <option value="rabu">rabu</option>
                                <option value="kamis">kamis</option>
                                <option value="jum'at">jum'at</option>
                                <option value="sabtu">sabtu</option>
                                <option value="minggu">minggu</option>
                            </select>
                            <!-- <input type="text" class="form-control" name="hari"> -->
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Kelas</label>
                        <div class="col-sm-9">
                            <select name="kelas" class="form-select" id="">
                                <option value="">Pilih Kelas</option>
                                <?php foreach($kelas as $nama_kelas):?>
                                <option value="<?= $nama_kelas['id_kelas']?>"><?= kelas($nama_kelas['kelas']).' '.$nama_kelas['jurusan'].' '.$nama_kelas['kelompok']?></option>
                                <?php endforeach;?>
                            </select>
                            <!-- <input type="text" class="form-control" name="kelas"> -->
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Nama Mapel</label>
                        <div class="col-sm-9">
                            <select name="nama_mapel" id="mapel" class="form-select">
                                <option value="">Pilih Mapel</option>
                                <?php foreach($mapel as $nama_mapel):?>
                                <option value="<?= $nama_mapel['id_mapel']?>"><?= $nama_mapel['nama_mapel']?></option>
                                <?php endforeach?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Nama Guru</label>
                        <div class="col-sm-9">
                            <select name="nama_guru" id="guru" class="form-select">
                                <option value="">Pilih Guru</option>
                                <?php foreach($guru as $value):?>
                                <option value="<?=$value['nip']?>"><?= $value['nama_guru']?></option>
                                <?php endforeach?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Jam Masuk</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" name="jam_masuk">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Jam Selesai</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" name="jam_selesai">
                        </div>
                    </div>
                    <div class="mb-5 row">
                        <div class="col" style=" margin-left: 80%;">
                            <button class="btn btn-sm btn-danger"><i class="fa-solid fa-floppy-disk"></i> Hapus</button>
                            <button class="btn btn-sm btn-success"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- <script>

        $(document).ready(function(){
            $('#mapel').change(function(){
                var mapel = $(this).val();
                // console.log(mapel);
                $.ajax({
                    url: "<?= base_url()?>/crud/get_guru",
                    type: "post",
                    data: {mapel: mapel},
                    dataType: "json",
                    success: function(response){
                        console.log(response);
                        var len = response.length;
                        $('#guru').empty();
                        for(var i = 0; i < len; i++){
                            var id = response[i]['nip'];
                            var nama_guru = response[i]['nama_guru'];
                            
                            $('#guru').append("<option value='"+id+"'>"+nama_guru+"</option>");
                        }
                    }
                });
            });
        });
    </script> -->

<?= $this->endSection()?>