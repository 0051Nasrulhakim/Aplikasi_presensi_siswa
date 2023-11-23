<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistem Presensi Siswa SMK N 01 Warungasem</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="<?= base_url()?>/assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- data tabel -->
        <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        
        <!-- sweeet alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
        
        
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">SMK NESWARA</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <div class="selamat_datang d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <a class="navbar-brand ps-3" id="jam" style="color: white;"></a>
            </div> 
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <!-- <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li> -->
                        <li><a class="dropdown-item" href="<?= base_url()?>/login/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link <?= $retVal = ($parameter == 'Dashboard') ? 'active' : '' ;?>" href="<?= base_url()?>/tu">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link <?= $retVal = ($parameter == 'Tahun Ajaran') ? 'active' : '' ;?>" href="<?= base_url()?>/tu/tahun_akademik">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                                Daftar Tahun Ajaran
                            </a>
                            <a class="nav-link <?= $retVal = ($parameter == 'Kalender Libur') ? 'active' : '' ;?>" href="<?= base_url()?>/tu/kalender_libur">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar"></i></div>
                                Kalender Libur
                            </a>
                            <a class="nav-link <?= $retVal = ($parameter == 'Daftar Mapel') ? 'active' : '' ;?>" href="<?= base_url()?>/tu/daftar_mapel">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                                Daftar Mapel
                            </a>
                            <a class="nav-link <?= $retVal = ($parameter == 'Daftar Kelas') ? 'active' : '' ;?>" href="<?= base_url()?>/tu/daftar_kelas">
                                <div class="sb-nav-link-icon"><i class="fa-sharp fa-solid fa-school"></i></div>
                                Daftar Kelas
                            </a>
                            <!-- <div class="sb-sidenav-menu-heading">Murid</div> -->
                            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Siswa
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="<?php if($parameter == 'Daftar Siswa' || $parameter ==  'Presensi'){echo '';}else{ echo 'collapse';}?>" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= $retVal = ($parameter == 'Daftar Siswa') ? 'active' : '' ;?>" href="<?= base_url()?>/tu/daftar_siswa"><i class="fa-solid fa-graduation-cap"></i> &nbsp; Daftar Siswa</a>
                                    <a class="nav-link <?= $retVal = ($parameter == 'Presensi') ? 'active' : '' ;?>" href="<?= base_url()?>/tu/presensi"><i class="fa-sharp fa-solid fa-school-circle-check"></i> &nbsp; Presensi</a>
                                </nav>
                            </div>
                            <a class="nav-link <?php if($parameter == 'Daftar Guru' || $parameter ==  'Jadwal Mengajar'){echo '';}else{ echo 'collapse';}?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                                Guru
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="<?php if($parameter == 'Daftar Guru' || $parameter ==  'Jadwal Mengajar'){echo '';}else{ echo 'collapse';}?>" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link <?= $retVal = ($parameter == 'Daftar Guru') ? 'active' : '' ;?>" href="<?= base_url()?>/tu/daftar_guru">
                                        <i class="fa-solid fa-users"></i> &nbsp; Daftar Guru
                                    </a>
                                    <a class="nav-link <?= $retVal = ($parameter == 'Jadwal Mengajar') ? 'active' : '' ;?>" href="<?= base_url()?>/tu/jadwal_mengajar" >
                                        <i class="fa-solid fa-calendar-days"></i>&nbsp; Jadwal Mengajar
                                    </a>
                                </nav>
                            </div>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Loggin Sebagai : </div>
                        <h5><?= session()->get('nama_tu')?></h5>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <script>
                let nama_hari = Array('Minggu','Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat' ,'Sabtu')
                let nama_bulan = Array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')
                    function jam(){

                        var waktu = new Date();
                        var tanggal = waktu.getDate();
                        var get_hari = waktu.getDay();
                        var bulan = waktu.getMonth();
                        // alert(bulan);
                        var b = nama_bulan[bulan];
                        var tahun = waktu.getFullYear();
                        // alert(tahun);
                        var hari = nama_hari[get_hari];
                        // alert(d);
                        var jam = waktu.getHours();
                        var menit = waktu.getMinutes();
                        var detik = waktu.getSeconds();
                        if (jam < 10) {
                            jam = "0" + jam;
                        }
                        if (menit < 10) {
                            menit = "0" + menit;
                        }
                        if (detik < 10) {
                            detik = "0" + detik;
                        }
                        var jam_div = document.getElementById('jam');
                        jam_div.innerHTML = hari + ', ' + tanggal + ' ' + b +' ' + tahun + ' - ' + jam + ":" + menit + ":" + detik + ' WIB';
                    }
                    setInterval(jam, 1000);
             </script>
                