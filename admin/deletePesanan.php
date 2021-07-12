<?php
	include '../config/database.php';
    $id = $_GET['id'];
    $delete="DELETE FROM ap_keranjang where id=$id";
    mysqli_query($koneksi,$delete);
    header("location:order.php");
?>