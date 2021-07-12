<?php
require_once '../function/ap.session.php';
session_start();
if (SessionAdminCek()) {
  header("location:log-in.php");
} else {

  SessionActiveAdmin();
  $id = $Adminarray[0];
  $nama = $Adminarray[1];
  $email = $Adminarray[2];
  $username = $Adminarray[3];
  $level = $Adminarray[4];
}

?>
<?php

require_once '../config/database.php';
require_once '../function/ap.admin.php';
require_once '../function/ap.theme.php';
LoadHeadPanel();
LoadCssPanel();
LoadMenuPanel();
?>
<div id="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb" style="margin-top: 15px;">
      <li class="breadcrumb-item active"><i class="fas fa-fw fa-user"></i>Hi, Admin</li>
    </ol>
    <!-- Icon Cards-->
    <div class="row">
      <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fas fa-fw fa-shopping-cart"></i>
            </div>
            <div class="mr-5">Produk</div>
          </div>
          <a class="card-footer text-white clearfix small z-1" href="produk.php">
            <span class="float-left">Lihat Produk</span>
            <span class="float-right">
              <i class="fas fa-angle-right"></i>
            </span>
          </a>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fas fa-fw fa-edit"></i>
            </div>
            <div class="mr-5">Pesanan</div>
          </div>
          <a class="card-footer text-white clearfix small z-1" href="order.php">
            <span class="float-left">Lihat Pesanan</span>
            <span class="float-right">
              <i class="fas fa-angle-right"></i>
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
LoadFooterPanel();
?>