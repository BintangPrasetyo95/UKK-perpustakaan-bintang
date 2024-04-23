<?php
require_once("./functions.php");

if (isset($_SESSION['perpus_bintang']) && myData('role') == 'petugas') {
  header('location:index.php');
}

if (ifset('register')) {
  $nama_lengkap = finn('nama_lengkap');
  $email = finn('email');
  $username = finn('username');
  $alamat = finn('alamat');

  $pw = finn('pw');
  $pw_konf = finn('pw_konf');

  if ($pw != $pw_konf) {
    $validasi = "Password tidak sama!";
  } else {
    $password = password_hash($pw, PASSWORD_DEFAULT);

    $validasi = Qselect("user", "WHERE (nama_lengkap='$nama_lengkap' OR username='$username' OR email='$email') AND disable='0' ");

    if (rows($validasi) > 0) {
      $validasi = "Akun dengan data yang sama sudah ada!";
    } elseif (valid($nama_lengkap) || valid($email) || valid($username) || valid($alamat)) {
      $validasi = "Tolong isi data dengan benar!";
    } else {
      $query = Qinsert("user", "nama_lengkap='$nama_lengkap', username='$username', email='$email', alamat='$alamat', password='$password', role='peminjam' ");

      if ($query !== false) {
        $_SESSION['register'] = true;
        header("location:login.php");
      } else {
        $validasi = "Registrasi gagal, coba lagi!";
      }
    }
  }
}
?>

<!DOCTYPE html><!--
* CoreUI - Free Bootstrap Admin Template
* @version v5.0.0
* @link https://coreui.io/product/free-bootstrap-admin-template/
* Copyright (c) 2024 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
-->
<html lang="en">

<head>
  <base href="./">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
  <meta name="author" content="Łukasz Holeczek">
  <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
  <title>CoreUI Free Bootstrap Admin Template</title>
  <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="assets/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- Vendors styles-->
  <link rel="stylesheet" href="vendors/simplebar/css/simplebar.css">
  <link rel="stylesheet" href="css/vendors/simplebar.css">
  <!-- Main styles for this application-->
  <link href="css/style.css" rel="stylesheet">
  <!-- We use those styles to show code examples, you should remove them in your application.-->
  <link href="css/examples.css" rel="stylesheet">
  <!-- We use those styles to style Carbon ads and CoreUI PRO banner, you should remove them in your application.-->
  <link href="css/ads.css" rel="stylesheet">
  <script src="js/config.js"></script>
  <script src="js/color-modes.js"></script>
</head>

<body>
  <form method="post">
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card mb-4 mx-4">
              <div class="card-body p-4">
                <?php
                if (isset($validasi)) {
                ?>
                  <div class="row">
                    <div class="alert alert-danger">
                      <?= $validasi ?>
                    </div>
                  </div>
                <?php
                }
                ?>
                <h1>Registrasi</h1>
                <p class="text-body-secondary">Buat akun baru</p>
                <div class="input-group mb-3"><span class="input-group-text">
                    <svg class="icon">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>

                    </svg></span>
                  <input class="form-control" type="text" placeholder="Nama Lengkap" name="nama_lengkap">
                </div>
                <div class="input-group mb-3"><span class="input-group-text">
                    <svg class="icon">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                    </svg></span>
                  <input class="form-control" type="text" placeholder="Email" name="email">
                </div>
                <div class="input-group mb-3"><span class="input-group-text">
                    <svg class="icon">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-contact"></use>
                    </svg></span>
                  <input class="form-control" type="text" placeholder="Username" name="username">
                </div>
                <div class="input-group mb-3"><span class="input-group-text">
                    <svg class="icon">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-golf"></use>
                    </svg></span>
                  <textarea name="alamat" class="form-control" placeholder="Alamat" name="alamat"></textarea>
                </div>
                <div class="input-group mb-3"><span class="input-group-text">
                    <svg class="icon">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                    </svg></span>
                  <input class="form-control" type="password" placeholder="Password" name="pw">
                </div>
                <div class="input-group mb-4"><span class="input-group-text">
                    <svg class="icon">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                    </svg></span>
                  <input class="form-control" type="password" placeholder="Konfirmasi password" name="pw_konf">
                </div>
                <button class="btn btn-block btn-primary me-3" type="submit" name="register">Buat Akun</button>
                Memiliki akun? <a class="text-info" href="./login.php">Login</a>.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- CoreUI and necessary plugins-->
  <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
  <script src="vendors/simplebar/js/simplebar.min.js"></script>
  <script>
    const header = document.querySelector('header.header');

    document.addEventListener('scroll', () => {
      if (header) {
        header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
      }
    });
  </script>
  <script>
  </script>

</body>

</html>