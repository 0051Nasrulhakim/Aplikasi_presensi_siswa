<?= $this->extend('tu/index') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <?php foreach($daftar_mapel as $daftar):?>
        
        <h5>Mapel : <?= $daftar['nama_mapel']?></h5>
        <div class="table">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th style="width: 4%;">no</th>
                        <th style="width: 13%;">Nis</th>
                        <th style="width: 18%;">Nama</th>
                        <th style="width: 8%;">hadir</th>
                        <th style="width: 8%;">izin</th>
                        <th style="width: 8%;">Alpha</th>
                        <th style="width: 8%;">Total</th>
                        <th style="width: 8%;">Presente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($daftar_siswa as $siswa):?>
                        <tr>
                            <td><?= $i++?></td>
                            <td><?= $siswa['nis_siswa']?></td>
                            <td><?= $siswa['nama_siswa']?></td>
                            <td>
                                <?php 
                                    $hadir = 0;
                                    foreach($data as $d){
                                        if($d['id_mapel'] == $daftar['id_mapel'] && $d['nis_siswa'] == $siswa['nis_siswa'] && $d['status'] == 'hadir'){
                                            $hadir++;
                                        }
                                    }
                                    echo $hadir;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $izin = 0;
                                    foreach($data as $d){
                                        if($d['id_mapel'] == $daftar['id_mapel'] && $d['nis_siswa'] == $siswa['nis_siswa'] && $d['status'] == 'izin'){
                                            $izin++;
                                        }
                                    }
                                    echo $izin;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $alpha = 0;
                                    foreach($data as $d){
                                        if($d['id_mapel'] == $daftar['id_mapel'] && $d['nis_siswa'] == $siswa['nis_siswa'] && $d['status'] == 'alpha'){
                                            $alpha++;
                                        }
                                    }
                                    echo $alpha;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $total = 0;
                                    foreach($data as $d){
                                        if($d['id_mapel'] == $daftar['id_mapel'] && $d['nis_siswa'] == $siswa['nis_siswa']){
                                            $total++;
                                        }
                                    }
                                    echo $total;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $presente = 0;
                                    foreach($data as $d){
                                        if($d['id_mapel'] == $daftar['id_mapel'] && $d['nis_siswa'] == $siswa['nis_siswa'] && $d['status'] == 'hadir'){
                                            $presente++;
                                        }
                                    }
                                    if($total == 0){
                                        echo 0;
                                    }else{
                                        echo $presente/$total*100 . '%';
                                    } 
                                ?>

                        </tr>
                    <?php endforeach?>
                </tbody>
                
            </table>
        </div>
        
    <?php endforeach;?>
</div>
<?= $this->endSection()?>