<?php
  require_once '../function/ap.session.php';
  session_start();
  if(SessionAdminCek()){
      header("location:log-in.php");
      }else{

      SessionActiveAdmin();
      $id=$Adminarray[0];
      $nama=$Adminarray[1];
      $email=$Adminarray[2];
      $username=$Adminarray[3];   
      $level=$Adminarray[4];
      /*
      $hari=date('l');	
	  switch($hari){
			case'Monday':$hari="Senin";break;
			case'Tuesday':$hari="Selasa";break;
			case'Wednesday':$hari="Rabu";break;
			case'Thrusday':$hari="Kamis";break;
			case'Friday':$hari="Jumat";break;
			case'Saturday':$hari="Sabtu";break;
			case'Sunday':$hari="Minggu";break;
			
		}
	*/

     
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
        	 
<?php
if(!isset($_GET['produk'])) { $_GET['produk']=''; }

	if($_GET['produk']=='detail'){
		if(!empty(trim($_GET['id'])) || intval($_GET['id'])){
				if(!LoadProdukDetail($_GET['id'])){
					die('Data tidak ditemukan');
				}

		}else{
			echo "<meta http-equiv=\"refresh\"content=\";URL=home\"/>";
		}

				LoadProdukContent($id, $nama_produk_pemilik, $nama_produk, $deskripsi_produk, $jenis_produk, $harga_produk, $satuan_produk, $stok_produk, $foto_produk, $tanggal_buat, $tanggal_update);
		

		}elseif($_GET['produk']=='kategori'){

			LoadJenisProduk();

		}elseif($_GET['produk']=='delete'){

			if(!LoadProdukDetail($_GET['id'])){
					die("Error: Id Produk tidak ditemukan");
			}				

				if(isset($_POST['id']) && !empty($_POST['id'])){
					//panggil fungsi delete
					if(DeleteProduk(trim($_POST['id']))&&unlink("../img/produk/$foto_produk")){
						echo "<div class='alert alert-success'>Produk berhasil dihapus</div>";
	        			echo "<meta http-equiv=\"refresh\"content=\"1;URL=produk.php\"/>";
					}else{
						echo "<div class='alert alert-danger'>Produk gagal dihapus</div>";
	        			echo "<meta http-equiv=\"refresh\"content=\"3;URL=produk.php\"/>";

					}
				}

				
					
			
			echo '
			
				<form action="'.htmlspecialchars($_SERVER['REQUEST_URI']).'" method="post" />
				<div class="form-group">
				<input type="hidden" name="id" value="'.FilterInput($_GET['id']).'" />
				<span>Apaka anda yakin hapus produk ini?</span>
				</div>
				
				<div class="form-group">
				<input type="submit" name="delete" class="btn btn-danger" value="Delete" />
				</div>
				</form>

			';
		}




		else{
			
			 
		
			
 					
		LoadProduk();
	}
?>

			 
</div>
</div>
<?php
LoadFooterPanel();
?>