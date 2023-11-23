<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Daftar Jadwal </h1>
    <h4> kelas : <?= kelas($kelas['kelas']). ' ' . $kelas['jurusan'] . ' ' . $kelas['kelompok']?></h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">SMK Negeri 1 Warungasem </li>
    </ol>
    
    <div class="container">
        <div class="row" style="margin-top: 4%;">
            <div class="col-md-6 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Senin</li>
                    <?php $i=0;foreach($data as $row):?>
                        <?php if($row['hari'] == 'senin'){ 
                            $i=1; $hari_senin = 'Senin'?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span style="margin-right: 7%; width: 36%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
                                <span style="width: 10%;">
                                    <a href="<?= base_url()?>/crud/hapus_jadwal/<?= $row['id_jadwal'].'/'.$row['id_kelas']?>" onclick="return confirm('Yakin Hapus?')"><button class="btn btn-sm btn-danger mb-2">Hapus</button></a>
                                </span>
                                <span>
                                    <button class="btn btn-sm btn-success" style="margin-left: 3%;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $row['id_jadwal']?>">detail</button>
                                </span>
                            </li>
                            <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-6 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Selasa</li>
                    <?php $i=0; foreach($data as $row):?>
                        <?php if($row['hari'] == 'selasa'){ $i=1; $hari_selasa = 'Selasa'?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span style="margin-right: 7%; width: 36%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
                                <span style="width: 10%;">
                                    <a href="<?= base_url()?>/crud/hapus_jadwal/<?= $row['id_jadwal'].'/'.$row['id_kelas']?>" onclick="return confirm('Yakin Hapus?')"><button class="btn btn-sm btn-danger mb-2">Hapus</button></a>
                                </span>
                                <span>
                                    <button class="btn btn-sm btn-success" style="margin-left: 3%;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $row['id_jadwal']?>">detail</button>
                                </span>
                            </li>
                        <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>

            <div class="col-md-6 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center" aria-current="true" >Rabu</li>
                    <?php $i=0; foreach($data as $row):?>
                        <?php if($row['hari'] == 'rabu'){ $i=1; $hari_rabu = 'rabu' ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span style="margin-right: 7%; width: 36%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
                                <span style="width: 10%;">
                                    <a href="<?= base_url()?>/crud/hapus_jadwal/<?= $row['id_jadwal'].'/'.$row['id_kelas']?>" onclick="return confirm('Yakin Hapus?')"><button class="btn btn-sm btn-danger mb-2">Hapus</button></a>
                                </span>
                                <span>
                                    <button class="btn btn-sm btn-success" style="margin-left: 3%;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $row['id_jadwal']?>">detail</button>
                                </span>
                            </li>
                        <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-6 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Kamis</li>
                    <?php $i=0; foreach($data as $row):?>
                        <?php if($row['hari']== 'kamis'){ $i=1; $hari_kamis = 'Kamis'?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span style="margin-right: 7%; width: 36%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
                                <span style="width: 10%;">
                                    <a href="<?= base_url()?>/crud/hapus_jadwal/<?= $row['id_jadwal'].'/'.$row['id_kelas']?>" onclick="return confirm('Yakin Hapus?')"><button class="btn btn-sm btn-danger mb-2">Hapus</button></a>
                                </span>
                                <span>
                                    <button class="btn btn-sm btn-success" style="margin-left: 3%;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $row['id_jadwal']?>">detail</button>
                                </span>
                            </li>
                        <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-6 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center"  aria-current="true" >Jum'at</li>
                    <?php $i=0; foreach($data as $row):?>
                        <?php if($row['hari']== "jum'at"){ $i=1; $hari_jumat = 'Jumat'?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span style="margin-right: 7%; width: 36%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
                                <span style="width: 10%;">
                                    <a href="<?= base_url()?>/crud/hapus_jadwal/<?= $row['id_jadwal'].'/'.$row['id_kelas']?>" onclick="return confirm('Yakin Hapus?')"><button class="btn btn-sm btn-danger mb-2">Hapus</button></a>
                                </span>
                                <span>
                                    <button class="btn btn-sm btn-success" style="margin-left: 3%;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $row['id_jadwal']?>">detail</button>
                                </span>
                            </li>
                        <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-6 mb-4">
                <ul class="list-group">
                    <li class="list-group-item active text-center " aria-current="true" >Sabtu</li>
                    <?php $i=0; foreach($data as $row):?>
                        <?php  if($row['hari']== 'sabtu'){ 
                            $i=1; $hari_sabtu = 'Sabtu'?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span style="margin-right: 7%; width: 36%;"><?= $row['nama_mapel']?></span>
                                <span style="width: 29%;">Mulai : <?= $row['jam_masuk'] . ' - ' . 'Selesai ' . $row['jam_selesai']; ?></span>
                                <span style="width: 10%;">
                                    <a href="<?= base_url()?>/crud/hapus_jadwal/<?= $row['id_jadwal'].'/'.$row['id_kelas']?>" onclick="return confirm('Yakin Hapus?')"><button class="btn btn-sm btn-danger mb-2">Hapus</button></a>
                                </span>
                                <span>
                                    <button class="btn btn-sm btn-success" style="margin-left: 3%;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $row['id_jadwal']?>">detail</button>
                                </span>
                            </li>
                        <?php }?>
                    <?php endforeach?>
                    <?php if($i == 0 ){?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Belum ada jadwal</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
            
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes
            var modal = $(this)
            // alert(id)
            modal.find('.modal-title').text('Detail Mapel ' + id)
            modal.find('.modal-body').load('<?= base_url()?>/crud/detail_mapel/'+id)
        })
    });
  </script>
<?= $this->endSection() ?>