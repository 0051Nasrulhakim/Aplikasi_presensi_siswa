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
        <style>
            @media screen and (max-width:680px){
                #contain {
                    margin-top: 20%;
                }
                #bungkus{
                    width: auto;
                }
            }
            @media screen and (min-width:681px){
                #contain {
                    margin-top: 8%;
                    height: 100%;
                    width: 100%;
                }
                #bungkus{
                    height: auto;
                    width: auto;
                    /* border: 1px so; */
                }
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="<?= base_url()?>/guru">SMK NESAWARA</a>

            <div class="selamat_datang d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <a class="navbar-brand ps-3" id="jam" style="color: white;"></a>
            </div>      
        </nav>
        
            <script>
                let nama_hari = Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat' ,'Sabtu')
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
        
                <!-- buat jam -->
                
                