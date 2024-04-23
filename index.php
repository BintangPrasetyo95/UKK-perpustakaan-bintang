<?php
require_once("./functions.php");

if (empty($_SESSION['perpus_bintang'])) {
  header('location:login.php');
}

$myID = myData('id_user');

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';


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
  <link href="css/bintang.css" rel="stylesheet">
  <!-- We use those styles to style Carbon ads and CoreUI PRO banner, you should remove them in your application.-->
  <link href="css/ads.css" rel="stylesheet">
  <script src="js/config.js"></script>
  <script src="js/color-modes.js"></script>
  <link href="vendors/@coreui/chartjs/css/coreui-chartjs.css" rel="stylesheet">
  <link href="vendors/@coreui/icons/css/free.min.css" rel="stylesheet">
</head>

<body>
  <?php require_once('./_sidebar.php'); ?>
  <div class="wrapper d-flex flex-column min-vh-100">
    <?php require_once('./_topbar.php'); ?>
    <div class="body flex-grow-1">
      <div class="container-lg px-4">

        <?php


        if ((myData('role') == 'petugas' && $page == 'petugas') || (myData("role") == 'peminjam' && ($page == 'kategori' || $page == 'peminjam' || $page == 'petugas'))) {
          include "./500.html";
        } else {
          if (file_exists("./pages/" . $page . ".php")) {
            if ($page != 'dashboard') {
              include('./actions/c-' . $page . '.php');
            }

            if ($page == "profil" || $page == "buku") {
              include("./actions/c-favorit.php");
              include("./actions/c-ulasan.php");
            }

            include "./pages/" . $page . ".php";
          } else {
            include "./404.html";
          }
        }
        ?>

      </div>
    </div>
    <footer class="footer px-4">
      <div><a href="https://coreui.io">CoreUI </a><a href="https://coreui.io/product/free-bootstrap-admin-template/">Bootstrap Admin Template</a> © 2024 creativeLabs.</div>
      <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/docs/">CoreUI UI Components</a></div>
    </footer>
  </div>
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
  <!-- Plugins and scripts required by this view-->
  <script src="vendors/chart.js/js/chart.umd.js"></script>
  <script src="vendors/@coreui/chartjs/js/coreui-chartjs.js"></script>
  <script src="vendors/@coreui/utils/js/index.js"></script>
  <script src="js/main.js"></script>
  <script src="js/bintang.js"></script>

  <?php
  if ($_SESSION['login'] == true) {
    swalert('Selamat datang, ' . myData('nama_lengkap') . '!');
    $_SESSION['login'] = false;
  }
  ?>

</body>

</html>