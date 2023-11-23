<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= base_url()?>/assets/css/styles.css" rel="stylesheet" />
    <link href="<?= base_url()?>/assets/css/login.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>
<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
              <h5 class="card-title text-center">Login Page</h5>
              <div class="logo text-center" >
                <img src="<?= base_url()?>/assets/logo.jpg" alt="Logo SMK" style="width: 40%;">
              </div>
              <h3 class="text-center mb-3">SMK Negeri 1 Warungasem</h3>
              <!-- tampilkan pesan error -->
                <?php if(session()->getFlashdata('pesan')):?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('pesan');?>
                    </div>
                <?php endif;?>
            <form action="<?= base_url()?>/login/cek_login" method="post">
              <div class="form-floating mb-3">

                <input type="text" class="form-control" id="floatingInput" name="username" placeholder="masukkan username">
                <label for="floatingInput">Username</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                <label for="floatingPassword">Password</label>
              </div>
              <div class=" mb-5">
                <select name="hak_akses" id="" class="form-select">
                    <option value="">pilih akses</option>
                    <option value="1">Siswa</option>
                    <option value="2">Guru</option>
                    <option value="3">Tu</option>
                </select>
              </div>

              
              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                  in</button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>