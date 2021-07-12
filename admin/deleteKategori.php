<?php
	include '../config/database.php';
    $id = $_GET['id'];
    $delete="DELETE FROM ap_produk_jenis where id=$id";
    mysqli_query($koneksi,$delete);
    header("location:produk.php?produk=kategori");
?>