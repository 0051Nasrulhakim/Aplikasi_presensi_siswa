<style>
   /* buat tabel menjadi border*/
    .table{
        border-collapse: collapse;
    }
    .table, th, td{
        border: 1px solid black;
    }
    .table th{
        text-align: center;
    }
    .table td{
        padding: 0.2cm;
    }
    .table tr:nth-child(even){
        background-color: #f2f2f2;
    }
    .table tr:hover{
        background-color: #ddd;
    }
    .table th{
        background-color: #4CAF50;
        color: white;
    }
    .table td{
        text-align: center;
    }
    .table td:nth-child(1){
        text-align: center;
    }
    /* buat lebar tabel 100% */
    .table{
        width: 100%;
    }
    /* buat font dalam tabel 12 pt */
    .table{
        font-size: 10pt;
    }
    /* buat kolom nama rata kiri */
    .table td:nth-child(1){
        width: 10px;
    }
    .table td:nth-child(2){
        width: 30px;
    }
    .table td:nth-child(3){
        text-align: left;
    }
    .table td:nth-child(4){
        width: 25px;
    }
    .table td:nth-child(5){
        width: 25px;
    }
    .table td:nth-child(6){
        width: 25px;
    }
    .table td:nth-child(7){
        width: 30px;
    }
    .table td:nth-child(8){
        width: 47px;
    }
    
    .header{
        display: flex !important;
        flex-wrap: nowrap;
        flex-direction: column;
    }
    .logo{
        width: 20%;
    }
    .text{
        width: 80%;
    }

    /* sejajarkan logo dengan text */

    /* letakkan nomor halaman di bawah tengah */
    .footer{
        position: fixed;
        bottom: 0;
        width: 100%;
        text-align: center;
    }
</style>
<div class="wrapper" style="margin-top: 0.6cm;">
    <div class="header">
        <div class="logo" style="margin-left: 2.7%; float: left;">
            <img src="<?=$gambar?>" style="width: 2cm; height: 2cm; ">
        </div> 
        <div class="text" style="margin-left: 2%;">
            <div class="line-1" style="font-size: 18pt; text-align: center;">
                Hasil Rekap Presensi Siswa
            </div>
            
            <div class="line3" style="font-size: 12pt; text-align: center">
                Kelas : <?= $kelas?>
            </div>
            <div class="line-4" style="font-size: 12pt; text-align: center">
                Tahun Pelajaran <?= $tahun?>/<?= $tahun+1?> Semester : <?= $semester?> (<?= $satuan?>)
            </div>
        </div>
    </div>
    <!-- buat garis -->
    <div class="garis" style="border: 3px solid; margin-top: 0.3cm;"></div>
    <div class="garis" style="border: 1px solid; margin-top: 0.1cm; margin-bottom: 0.5cm;"></div>

    <div class="presensi">
        <?php $jumlah_halaman = 0; foreach($daftar_mapel as $daftar):?>
            <h3>Mapel : <?= $daftar['nama_mapel']?></h3>
            <div class="table">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 4%;">No</th>
                            <th style="width: 13%;">Nis</th>
                            <th style="width: 18%;">Nama</th>
                            <th style="width: 8%;">Hadir</th>
                            <th style="width: 8%;">Izin</th>
                            <th style="width: 8%;">Alpha</th>
                            <th style="width: 8%;">Total</th>
                            <th style="width: 8%;">Presentase</th>
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
            <?php $jumlah_halaman++;?>
            <?php
                if($jumlah_halaman == $total_mapel){
            ?>
            <div class="form-ttd" style="width: 30%; margin-left: auto; text-align: center; margin-top: 4%;">
                <div class="kepala_sekolah">
                    <div class="line-1">
                        Kepala Sekolah, 
                    </div>
                    <div class="line-2" style="height: 17%;">

                    </div>
                    <div class="line-3" style="text-align: center;">
                        <div class="garis" style="border: 1px solid; margin-top: 0.1cm; margin-bottom: 0.1cm; width: 80%; margin-left: auto; margin-right: auto;"></div>
                    </div>
                    <div class="line-4" style="text-align: left; margin-left: 3%;">
                        NIP : 
                    </div>
                </div>
            </div>
            <?php }else{?>
                <div style="page-break-after: always;"></div>
            <?php }?>
        <?php endforeach;?>
    </div>
    
    <!-- buat nomor halaman -->
    
</div>
<div class="footer">
    <div class="line-1">
        <!-- Halaman <?= $jumlah_halaman?> dari <?= $total_mapel?> -->
        <?php
            if(isset($pdf)){
                $x = 72;
                $y = 18;
                $text = "{PAGE_NUM} of {PAGE_COUNT}";
                $font = $fontMetrics->get_font("helvetica", "bold");
                $size = 6;
                $color = array(255, 0 ,0);
                $word_space = 0.0;
                $char_space = 0.0;
                $angle = 0.0;
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space,$char_space, $angle);
            }
        ?>
    </div>
</div>