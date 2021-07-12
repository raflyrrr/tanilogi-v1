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
<?php

if (isset($_POST['submit'])) {
  $jenis_produk = $_POST['jenis_produk'];
  $fotokategori_produk = $_FILES['fotokategori_produk']['name'];
  $dir = "../img/kategoriproduk/";
  if (!is_dir($dir)) {
    mkdir("../img/kategoriproduk/");
  }

  move_uploaded_file($_FILES["fotokategori_produk"]["tmp_name"], "../img/kategoriproduk/" . $_FILES["fotokategori_produk"]["name"]);
  $sql = mysqli_query($koneksi, "insert into ap_produk_jenis(jenis_produk,fotokategori_produk) values('$jenis_produk','$fotokategori_produk')");
  $_SESSION['msg'] = "menambah kategori produk";
}


?>
<div id="content-wrapper">
  <div class="container-fluid">
    <h4>Tambah Kategori Produk</h4>
    <?php if (isset($_POST['submit'])) { 
      header("refresh:1; url=produk.php?produk=kategori");
      ?>
      <div class="alert alert-success mt-4">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Berhasil</strong> <?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?>
      </div>
    <?php } ?>
    <br>
    <form method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label>Nama Kategori Produk</label>
        <input type="text" class="form-control" required="" name="jenis_produk" placeholder="Masukan Nama Kategori Produk" />
      </div>
      <div class="form-group">
        <label>Foto </label>
        <input class="form-control" type="file" name="fotokategori_produk" />
      </div>
      <div class="form-group">
        <a href="produk.php?produk=kategori" class="btn btn-outline-primary mr-2">Kembali</a>
        <input class="btn btn-success" type="submit" name="submit" value="Tambah" />
      </div>
    </form>
  </div>
</div>
<?php
LoadFooterPanel();
?>