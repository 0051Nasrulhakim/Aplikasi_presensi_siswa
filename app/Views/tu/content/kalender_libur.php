<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
        });
        // calendar.addEvent({ title: 'new event', start: '2023-03-05' });
        // ambil event dari database
        <?php foreach($kalender as $k):?>  
            calendar.addEvent({ 
                title: '<?= $k['nama_kegiatan']?>', 
                start: '<?= $k['tanggal_mulai']?>', 
                end: '<?= $k['tanggal_selesai']?>',
            });
        <?php endforeach;?>
        calendar.setOption('locale', 'id');
        calendar.render();
        });

    </script>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Halaman Kalender Liburan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">SMK Negeri 1 Warungasem </li>
        </ol>

        <div class="tombol mb-3">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Buat Hari Libur</button>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-7">
                    <div id='calendar'></div>
                </div>
                <div class="col-5">
                    <div class="list" style="border: 1px solid; border-radius: 7px; height: 100%;">
                        <div class="table-responsive">
                            <div class="judul text-center mb-3 mt-3">
                                <h5>Daftar Hari Libur tahun akademik <?= session()->get('tahun_akademik')?></h5>
                            </div>
                            <div class="tanggal">
                                <?php $i=1; foreach($kalender as $k):?>
                                    <div class="kegiatan mt-2" style="display: flex; flex-direction: row;">
                                        <div class="nomor" style="margin-right: 2%; margin-left: 2%;">
                                            <?= $i++ . '.'?>
                                        </div>
                                        <div class="keterangan">
                                            <?= $k['nama_kegiatan']?> 
                                            <!-- format tanggal indonesia -->
                                            <?php
                                                $tanggal_mulai = date_create($k['tanggal_mulai']);
                                                $tanggal_selesai = date_create($k['tanggal_selesai']);

                                            ?>
                                            (
                                                <?= date_format($tanggal_mulai, 'd M Y') ?> - 
                                                <?= date_format($tanggal_selesai, 'd M Y')?>
                                            )
                                            <!-- hapus -->
                                            <a href="<?= base_url()?>/Crud/delete_kalender/<?= $k['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</a>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- modal  -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Input Jadwal Kegiatan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url()?>/Crud/insert_kalender" method="post">
                        <div class="modal-body">
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Nama Kegiatan</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="nama_kegiatan">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Tahun Akademik</label>
                                <div class="col-sm-6">
                                    <select name="tahun_akademik" class="form-select form-select-sm" id="">
                                        <?php foreach($tahun_akademik as $ta): ?>
                                            <option value="<?= $ta['id_tahun']?>" <?php if($ta['id_tahun']==session()->get('id_akademik')){echo 'Selected';}?>><?= $ta['tahun']?> - semester <?= $ta['semester']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Aktifitas Sekolah</label>
                                <div class="col-sm-6">
                                    <select name="keterangan" id="" class="form-select form-select-sm">
                                        <option value="Libur">Libur</option>
                                        <option value="Berangkat">Berangkat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Tanggal Mulai</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" name="tanggal_mulai">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Tanggal Selesai</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" name="tanggal_selesai">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end modal -->
    </div>  
    
<?= $this->endSection() ?>