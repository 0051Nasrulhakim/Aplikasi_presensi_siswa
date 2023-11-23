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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->
<body>
  <div class="container">
  <form action="<?= base_url()?>/login/cek_login">
  <input type="number" class="form-control" name="hak_akses" value="3">
    <div class="modal" tabindex="-1" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tahun Akademik Aktif tidak ditemukan</h5>
            </div>
            <div class="modal-body">
                

                    <div class="row">
                        <div class="col-5">
                            Anda Login Sebagai
                        </div>
                        <div class="col">
                            TU
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-5">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="floatingInput" name="username" value="<?= $username?>" readonly>
                            
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-5">
                            <label for="floatingInput">Password</label>
                        </div>
                        <div class="col">
                            <input type="password" class="form-control" id="floatingInput" name="password" value="<?= $password?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-5">
                            <label for="floatingInput">Pilih Tahun</label>
                        </div>
                        <div class="col">
                            <select name="params" id="" class="form-select">
                                <?php foreach($daftar_tahun as $value):?>
                                    <option value="<?= $value['id_tahun']?>"><?= $value['tahun'] . ' - Semester ' . $value['semester']?></option>
                                <?php endforeach?>
                            </select>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            </div>
        </div>
    </div>
    </form>
    
  </div>
</body>
<!-- show modal-->
<script>
    $(document).ready(function(){
    // Show the Modal on load
    $("#myModal").modal("show");
        
    // Hide the Modal
    $("#myBtn").click(function(){
        $("#myModal").modal("hide");
    });
    });
</script>

</html>