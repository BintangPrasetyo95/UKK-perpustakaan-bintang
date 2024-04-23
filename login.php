<?php
require_once("./functions.php");

if (!empty($_SESSION['perpus_bintang'])) {
  header('location:index.php');
}

if (ifset('login')) {
  $nama = finn('nama');
  $pw = finn('password');

  $cek_user = Qselect("user", "WHERE (username='$nama' OR email='$nama') AND disable='0' ");

  if (rows($cek_user) != 1) {
    $validasi = false;
  } elseif (valid($nama) || valid($pw)) {
    $validasi = false;
  } else {
    $user = fetch($cek_user);
    $password = password_verify($pw, $user["password"]);

    if ($password !== false) {
      $_SESSION['perpus_bintang'] = $user;
      $_SESSION['login'] = true;
      header('location:index.php');
    } else {
      $validasi = false;
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
  <title>UKK Perpus Bintang</title>
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
          <div class="col-lg-8">
            <div class="card-group d-block d-md-flex row">
              <div class="card col-md-7 p-4 mb-0">
                <div class="card-body">
                  <?php
                  if (isset($validasi) && $validasi == false) {
                  ?>
                    <div class="row">
                      <div class="alert alert-danger">
                        Login gagal, coba lagi!
                      </div>
                    </div>
                  <?php
                  }
                  ?>
                  <h1>Login</h1>
                  <p class="text-body-secondary">Masuk menggunakan akun anda</p>
                  <div class="input-group mb-3"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                      </svg></span>
                    <input class="form-control" name="nama" type="text" placeholder="Username / Email">
                  </div>
                  <div class="input-group mb-4"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                      </svg></span>
                    <input class="form-control" name="password" type="password" placeholder="Password">
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <button class="btn btn-primary px-4" name="login" type="submit">Login</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card col-md-5 text-white bg-primary py-5">
                <div class="card-body text-center">
                  <div>
                    <h2>Register</h2>
                    <p>Tidak mempunyai akun? Tekan register untuk membuat akun.</p>
                    <a class="btn btn-lg btn-outline-light mt-3" href="./register.php">Registrasi Sekarang!</a>
                  </div>
                </div>
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
  <?php
  if (isset($_SESSION['register']) && $_SESSION['register'] == true) {
    swalert("Registrasi berhasil!, Silahkan login.");
    $_SESSION['register'] = false;
  }
  ?>

</body>

</html>