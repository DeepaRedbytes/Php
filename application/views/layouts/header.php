<?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$dashboard = '';
$user = '';
$service = '';
$adrequest = '';
$user = '';
$about = '';
$category = '';
$event = '';
if (strpos($url,'dashboard') !== false) {
    $dashboard = 'activeclass';
} else if (strpos($url,'user') !== false) {
    $user = 'activeclass';
} else if (strpos($url,'about') !== false) {
    $about = 'activeclass';
} else if (strpos($url,'service') !== false) {
    $service = 'activeclass';
} else if (strpos($url,'category') !== false) {
    $category = 'activeclass';
} else if (strpos($url,'advertisement') !== false) {
    $adrequest = 'activeclass';
} else if (strpos($url,'event') !== false) {
    $event = 'activeclass';
}?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Community Services | Dashboard</title>

  <!-- Bootstrap core CSS-->
  <link href="<?= base_url();?>theme/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="<?= base_url();?>theme/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">

  <!-- Page level plugin CSS-->
  <link href="<?= base_url();?>theme/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url();?>theme/css/style.css" rel="stylesheet">
  <link href="<?= base_url();?>theme/vendor/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">

  <link href="https://foliotek.github.io/Croppie/croppie.css" rel="stylesheet">


    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css"> -->
    <link rel="stylesheet" href="https://www.samclarke.com/assets/migrating-to-hugo/monokai.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.min.css">


</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top no-padding">


    <a class="navbar-brand mr-1" href="<?= base_url();?>index.php/dashboard"><img class=" logo text-center" src="<?= base_url();?>theme/img/logo.png" />Community
      Services</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <img class=" mennu text-center" src="<?= base_url();?>theme/img/menu.png" />
    </button>

    <!-- Navbar Search -->
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </div>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">

      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw circle-css"></i><i class="fas fa-sort-down align-drop"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Activity Log</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <span class="logout">Logout</span><span><img class=" log-image text-center" src="<?= base_url();?>theme/img/logout.png" /></a></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>




  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link main-link <?=$dashboard;?>" href="<?= base_url();?>index.php/dashboard">
          <i class="fas fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link main-link <?=$user;?>" href="<?= base_url();?>index.php/user">
          <i class="fas fa-users"></i>
          <span>User List</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link main-link <?=$service;?>" href="<?= base_url();?>index.php/service">
          <i class="fas fa-cogs"></i>
          <span>Service List</span>
        </a>
      </li>

      <li class="nav-item active">
        <a class="nav-link main-link <?=$event;?>" href="<?= base_url();?>index.php/event">
          <i class="fas fa-calendar-alt"></i>
          <span>Event List</span>
        </a>
      </li>

      
       <li class="nav-item active">
          <a class="nav-link main-link <?=$adrequest;?>" href="<?= base_url();?>index.php/advertisement">
            <i class="fas fa-file-signature"></i>
            <span>Advertisement List</span>
          </a>
      </li> 

      <li class="nav-item active">
        <a class="nav-link main-link <?=$category;?>" href="<?= base_url();?>index.php/category">
          <i class="fas fa-list-alt"></i>
          <span>Categorie List</span>
        </a>
      </li>  
      <li class="nav-item active">
          <a class="nav-link main-link">
              <i class="fas fa-file-contract"></i>
              <span>Legal</span>
          </a>
          <ul class="submenu navbar-nav">
              <li class="nav-item active" style="display: none;"><a class="nav-link main-link" href="<?= base_url();?>index.php/about_us">About Us</a></li>
              <li class="nav-item active" style="display: none;"><a class="nav-link main-link" href="<?= base_url();?>index.php/terms_condition">Terms and condition</a></li>
              <li class="nav-item active"><a class="nav-link main-link" href="<?= base_url();?>index.php/faq">Faq's</a></li>
              <li class="nav-item active"><a class="nav-link main-link" href="<?= base_url();?>index.php/resource">Resources</a></li>
          </ul>
      </li>
</ul>