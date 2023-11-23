<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Tahun Akademik</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem</li>
        </ol>
        
        <div class="alert alert-primary" role="alert">
            Data yang terdapat logo X berati kelas tidak ada dan data tersebut tidak akan tersimpan
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Nis</td>
                        <td>Nama Siswa</td>
                        <td>Kelas</td>
                        <td>Tanggal Lahir</td>
                        <td>Tahun Masuk </td>
                        <td>Jenis kelamin</td>
                        <td>Status</td>
                        <td>pesan</td>
                    </tr>
                </thead>
                <!-- key value -->
                <?php foreach($data as $key => $value):?>
                <tr>
                    <td><?= $value['nis_siswa']?></td>
                    <td><?= $value['nama_siswa']?></td>
                    <td><?= $value['kelas']?></td>
                    <td><?= $value['tanggal_lahir']?></td>
                    <td class="text-center"><?= $value['tahun_masuk']?></td>
                    <td class="text-center"><?= $value['jenis_kelamin']?></td>
                    <td><?= $value['status']?></td>
                    <!-- jika informasi kosong tampilkan ceklis -->
                    <td class="text-center">
                        <?php if($value['informasi'] != null){?>
                            <!-- ketika hover muncul pesan -->
                            <span class="badge" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $value['informasi']?>"><i class="fa-solid fa-x" style="color: red;"></i></span>
                            
                            
                        <?php }else{?>
                            <i class="fa-solid fa-check" style="color: green;"></i>
                        <?php }?>
                    </td>
                </tr>

                <?php endforeach;?>
                <!-- kirim data yang ada di dalam tabel -->
                <!--  -->
                
            </table>
            <button class="btn btn-primary" onclick="save()">Simpan</button>
            <!-- tampilkan $data kedalam konsole log -->
            <script>
                var data = <?= json_encode($data)?>
                // onclick
                function save(){
                    $.ajax({
                        url: '<?= base_url()?>/export/save',
                        type: 'post',
                        data: {data: data},
                        success: function(res){
                            // jika status respon 200
                            console.log(res)
                            if(res.status == 200){
                                // swal
                                Swal.fire({
                                    icon: 'success',
                                    title: res.pesan,
                                    text: res.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                // redirect
                                window.location.href = '<?= base_url()?>/tu/daftar_siswa'
                            }
                        }
                    });

                }
                
            </script>

      
        </div>
    </div>
<?= $this->endSection() ?>