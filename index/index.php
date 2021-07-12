<?php
session_start();
?>
<?php
	require_once '../config/database.php';
	require_once '../function/ap.fungsi.php';
	require_once '../function/ap.theme.php';
	require_once '../function/ap.identitas.situs.php';
	LoadHead($nama_situs, $alamat_situs, $deskripsi_situs, $author_situs, $logo_situs);
	LoadCss();
	if(isset($_SESSION['username'])){
		LoadMenu($nama_situs, $logo_situs);
	}else{
		LoadBody($nama_situs, $logo_situs);
	}
?>
             
<?php
if (!isset($_GET['produk'])) { $_GET['produk']=''; }

if($_GET['produk']=='detail'){

	if(!empty(trim($_GET['id']))){
		if(!LoadProdukDetail($_GET['id'])){
			die('Data tidak ditemukan');
		}

	}else{
		echo "<meta http-equiv=\"refresh\"content=\";URL=home\"/>";
	}

	LoadProdukContent($id, $nama_produk_pemilik, $nama_produk, $deskripsi_produk, $jenis_produk, $harga_produk, $satuan_produk, $stok_produk, $foto_produk, $tanggal_buat, $tanggal_update);
	
	}else{
		echo '
		<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
			  <div class="carousel-inner">
				<div class="carousel-item active">
				  <img class="d-block w-100" src="../img/petani1.jpg">
				</div>
			  </div>
			</div>
 			<section class="py-5">
			    <div class="container" data-aos="fade-up">
			      <h1>Selamat Datang di '.$nama_situs.'</h1>
			      <p class="lead">'.$deskripsi_situs.'</p><hr>
			    </div>
  			</section>
			  
		';
		LoadProduk();
}

?>



<?php
LoadFooter($nama_situs);
?>