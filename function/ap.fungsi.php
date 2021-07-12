<?php
function query($data)
{
	global $koneksi;
	$perintah = $koneksi->query($data);
	if (!$perintah) die("Gagal melakukan query." . $koneksi->error());
	return $perintah;
}

function prepare($data)
{
	global $koneksi;
	$perintah = $koneksi->prepare($data);
	if (!$perintah) die("Gagal melakukan query" . $koneksi->error());
	return $perintah;
}
function FilterInput($data)
{
	$data = htmlspecialchars($data);
	$data = stripslashes($data);
	$data = trim($data);
	return $data;
}
function ValidateEmail($data)
{
	if (!preg_match("/@/", $data)) {
		return true;
	} else {
		return false;
	}
}
function ValidateName($data)
{
	if (!preg_match("/^[a-zA-Z ]*$/", $data)) {
		return true;
	} else {
		return false;
	}
}
function ValidateNumber($data)
{
	if (!preg_match("/^[0-9]*$/", $data)) {
		return true;
	} else {
		return false;
	}
}
function EscapeString($data)
{
	global $koneksi;
	$data = $koneksi->real_escape_string($data);
	return $data;
}
function CekUsername($username)
{
	$sql = "SELECT username FROM ap_user WHERE username=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("s", $param_username);
		$param_username = $username;
		if ($stmt->execute()) {
			$stmt->store_result();
			if ($stmt->num_rows == 1) {
				return true;
			} else {
				return false;
			}
		} else {
			die("Gagal mengeksekusi data");
		}
	}
	$stmt->close();
}
function CekEmail($data)
{
	$sql = "SELECT email FROM ap_user WHERE email=?";
	if ($stmt = prepare($sql)) :
		$stmt->bind_param("s", $param_email);
		$param_email = $data;
		if ($stmt->execute()) :
			$stmt->store_result();
			if ($stmt->num_rows == 1) :
				return true;
			else :
				return false;
			endif;

		endif;
	endif;
	$stmt->close();
}
function InsertRegister($nama_lengkap, $no_hp, $alamat_lengkap, $email, $username, $password)
{
	global $secret_key;
	$sql = "INSERT INTO ap_user (nama_lengkap, no_hp, alamat_lengkap, email, username, password) VALUES (?,?,?,?,?,?
)";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("ssssss", $param_nama_lengkap, $param_no_hp, $param_alamat_lengkap, $param_email,  $param_username, $param_password);
		$param_nama_lengkap = $nama_lengkap;
		$param_no_hp = $no_hp;
		$param_alamat_lengkap = $alamat_lengkap;
		$param_email = $email;
		$param_username = $username;
		$param_password = password_hash($secret_key . $password, PASSWORD_DEFAULT);
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	$stmt->close();
}
function ProdukTampil()
{

	$halaman = 8;
	$page = isset($_GET['halaman']) ? (int)$_GET["halaman"] : 1;
	$mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
	$sql = "SELECT id, nama_produk, deskripsi_produk, jenis_produk, harga_produk, satuan_produk, stok_produk, foto_produk FROM ap_produk LIMIT $mulai, $halaman";
	$perintah = query($sql);
	return $perintah;
}
function KeranjangTampil($data)
{
	$sql = "SELECT * FROM ap_keranjang WHERE id_pembeli='$data' AND status_pembayaran = 'Menunggu Pembayaran'  ";
	$perintah = query($sql);
	return $perintah;
}
function KeranjangRiwayat($data)
{
	$sql = "SELECT * FROM ap_keranjang WHERE id_pembeli='$data' AND status_pembayaran='Lunas' OR status_pembayaran='Belum Diverifikasi' OR status_pembayaran = 'Menunggu Pembayaran' ";
	$perintah = query($sql);
	return $perintah;
}
function KeranjangDetail($var_id)
{
	global $id, $id_pembeli, $nama_pembeli, $alamat_pembeli, $jumlah_beli, $id_produk, $nama_produk, $jenis_produk, $harga_produk,  $satuan_produk, $foto_produk, $status_pengiriman, $status_pembayaran, $tanggal_pembelian, $tanggal;
	$sql = "SELECT id, id_pembeli, nama_pembeli, alamat_pembeli, jumlah_beli, id_produk, nama_produk, jenis_produk, harga_produk, satuan_produk, foto_produk, status_pengiriman, status_pembayaran, tanggal_pembelian, tanggal FROM ap_keranjang WHERE id=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("i", $param_id);
		$param_id = $var_id;
		if ($stmt->execute()) {
			$stmt->store_result();
			$stmt->bind_result($id, $id_pembeli, $nama_pembeli, $alamat_pembeli, $jumlah_beli, $id_produk, $nama_produk, $jenis_produk, $harga_produk,  $satuan_produk, $foto_produk, $status_pengiriman, $status_pembayaran, $tanggal_pembelian, $tanggal);
			$stmt->fetch();
			if ($stmt->num_rows == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
}
function ProfileTampil($data)
{
	$sql = "SELECT id FROM ap_user WHERE username='$data' ";
	$perintah = query($sql);
	return $perintah;
}
function ProfileUpdate($nama_lengkap, $no_hp, $alamat_lengkap, $email, $username, $password, $var_id)
{
	global $secret_key;
	$sql = "UPDATE ap_user SET nama_lengkap=?, no_hp=?, alamat_lengkap=?, email=?, username=?, password=? WHERE id= ?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("ssssssi", $param_nama_lengkap, $param_no_hp, $param_alamat_lengkap, $param_email, $param_username, $param_password, $param_id);

		$param_nama_lengkap = $nama_lengkap;
		$param_no_hp = $no_hp;
		$param_alamat_lengkap = $alamat_lengkap;
		$param_email = $email;
		$param_username = $username;
		$param_password = password_hash($secret_key . $password, PASSWORD_DEFAULT);
		$param_id = $var_id;
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	$stmt->close();
}
function LoadProduk()
{
	/*
	Dok CMS RIMI ROOT93 : Cara Membuat Pagination 
	*/
	$halaman = 4;
	$ProdukTampil = ProdukTampil();
	echo '
		<div class="container" style="margin-bottom:10%">
		<h4 style="margin-bottom:20px;">Produk terbaru</h4>
		<div class="row mb-3">



		';

	if ($ProdukTampil->num_rows > 0) {

		$no = 1;
		while ($row = $ProdukTampil->fetch_array()) {
			if (isset($_SESSION['username'])) {
				$beli = "<a title='Beli' class='btn btn-flat btn-secondarytani btn-sm' href='beli.php?produk=beli&id=" . $row['id'] . "'><i class='fas fa-shopping-cart'></i> Masukkan keranjang</a>";
			}
			echo '
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3" data-aos="fade-up">
          <div class="card h-100">
          <a href="?produk=detail&id=' . $row['id'] . '"><img class="card-img-top" src="../img/produk/' . $row['foto_produk'] . '" alt="' . $row['nama_produk'] . '"></a>
          <div class="card-body">
           <h6 class="card-title">
           <a href="?produk=detail&id=' . $row['id'] . '">' . $row['nama_produk'] . '</a>
           </h6>
           <div class="post-info">
           <span class="produk-info"><i class="fas fa-fw fa-shopping-cart"></i>' . $row['jenis_produk'] . '</span>
           <span class="label-info"><i class="fas fa-fw fa-tags"></i>' . number_format($row['harga_produk']) . '' . $row['satuan_produk'] . '</span>
           </div>
            <p class="card-text">
            ';

			if (!empty($beli)) {
				echo $beli;
			}
			echo '            
            </p>
              
            </div>
          </div>

       </div>';
		}
	} else {

		echo '
		<em>Belum ada produk yang ditambahkan</em>

		';
	}
	echo

	'
	</div>
	</div>
	';


	$total = $ProdukTampil->num_rows;
	$pages = ceil($total / $halaman);
	$i = 1;


	if (!isset($_GET['halaman'])) {
		$_GET['halaman'] = '1';
	}

	if ($i < $_GET['halaman']) {
		echo '
                <ul class="pagination justify-content-center">
               <li class="page-item">
                <a class="page-link" href="javascript:history.back()" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only">Previous</span>
                </a>
              </li>';
	} else {
		echo '
               <ul class="pagination justify-content-center">
                 <li class="page-item">
                  <a class="page-link" style="display:none;" href="?halaman=' . ($i) . '"aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>';
	}
	for ($i = 1; $i <= $pages; $i++) {
		//Bagian number halaman
		echo '
                <li class="page-item">          
                  <a class="page-link" href="?halaman=' . $i . '">' . $i . '</a>
                  </li>';
	}

	if ($_GET['halaman'] == $pages) {
		echo '
                    <li class="page-item">
                      <a class="page-link" style="display:none;" href="?halaman=javascript:history.back()"aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                      </a>
                    </li>
                  </ul>';
	} else {
		echo '
                  <li class="page-item">
                    <a class="page-link" href="?halaman=' . ($_GET['halaman'] + 1) . '"aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>';
	}
}
function LoadProdukDetail($var_id)
{
	global $id, $nama_produk_pemilik, $nama_produk, $deskripsi_produk, $jenis_produk, $harga_produk, $satuan_produk, $stok_produk,  $foto_produk, $tanggal_buat, $tanggal_update;
	$sql = "SELECT id, nama_produk_pemilik, nama_produk, deskripsi_produk, jenis_produk, harga_produk, satuan_produk,  stok_produk, foto_produk, tanggal_buat, tanggal_update FROM ap_produk WHERE id=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("i", $param_id);
		$param_id = $var_id;
		if ($stmt->execute()) {
			$stmt->store_result();
			$stmt->bind_result($id, $nama_produk_pemilik, $nama_produk, $deskripsi_produk, $jenis_produk, $harga_produk, $satuan_produk, $stok_produk,  $foto_produk, $tanggal_buat, $tanggal_update);
			$stmt->fetch();
			if ($stmt->num_rows == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
	$stmt->close();
}
function LoadProdukContent($id, $nama_produk_pemilik, $nama_produk, $deskripsi_produk, $jenis_produk, $harga_produk, $satuan_produk, $stok_produk, $foto_produk, $tanggal_buat, $tanggal_update)
{
	if (isset($_SESSION['username'])) {
		$beli = "<a style='margin:15px 0;' title='Beli' class='btn btn-primarytani' href='beli.php?produk=beli&id=" . $id . "'><i class='fas fa-shopping-cart'></i> Beli</a>";
	} else {
		$beli = "Untuk melakukan pembelian, Anda harus login terlebih dahulu";
	}
	echo '
	
	
	<div id="content-wrapper" style="margin-bottom:15%">
      <div class="container">
      <ol class="breadcrumb" style="margin-top: 35px;">
                <li class="breadcrumb-item">
                  <a href="home">Detail Produk</a>
                </li>
                <li class="breadcrumb-item active">' . $nama_produk . '</li>
              </ol>
			
       <div class="row">      
		<div class="col-md-6 col-sm-6">
		
		 <figure class="figure">
              <img src="../img/produk/' . $foto_produk . '" alt="' . $nama_produk . '" title="' . $nama_produk . '" class="figure-img img-fluid">
              <figcaption class="figure-caption">
              <i class="fas fa-calendar"></i> ' . $tanggal_buat . '

             </figcaption>  

              <hr/>       
        </div>

        <div class="col-md-6 col-sm-6">
        	<h1 style="font-size:24px;">' . $nama_produk . '</h1>
        	   <ul class="nav nav-tabs" role="tablist">
			    <li class="nav-item">
			      <a class="nav-link active" data-toggle="tab" href="#home">Deskripsi Produk</a>
			    </li>		    
			  </ul>
			
			<div class="tab-content">
				<div id="home" class="container tab-pane active"><br>
				<div class="table-responsive">
				<table width="100%"" class="table table-sthiped table-bordered table-hover">
						 <tr>
						  <td>Nama Produk</td>
						    <td>' . $nama_produk . '</td>
						  </tr>
						  <tr>
						    <td>Jenis Produk </td>
						    <td>' . $jenis_produk . '</td>
						  </tr>
						  <tr>
						    <td>Harga</td>
						    <td>IDR. ' . number_format($harga_produk) . '' . $satuan_produk . '</td>
						  </tr>
						  <tr>
						    <td>Stok</td>
						    <td>' . $stok_produk . '' . $satuan_produk . '</td>
						  </tr>';
						  

	echo '

							</table>';
	if (!empty($beli)) {
		echo $beli;
	}
	echo '
					</div>
			    </div>
		    </div>
       </div>
       <!--row -->
       </div>
       <!--Fluid -->

       </div>
       </div>
   
		';
}

function InsertKeranjang($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8, $data10, $data11, $data12)
{
	$sql = "INSERT INTO ap_keranjang (id_pembeli, nama_pembeli, alamat_pembeli, jumlah_beli, id_produk, nama_produk, jenis_produk, harga_produk, satuan_produk, foto_produk, tanggal_pembelian) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param(
			"isssissssss",
			$param_data1,
			$param_data2,
			$param_data3,
			$param_data4,
			$param_data5,
			$param_data6,
			$param_data7,
			$param_data8,
			$param_data10,
			$param_data11,
			$param_data12
		);
		$param_data1 = $data1;
		$param_data2 = $data2;
		$param_data3 = $data3;
		$param_data4 = $data4;
		$param_data5 = $data5;
		$param_data6 = $data6;
		$param_data7 = $data7;
		$param_data8 = $data8;
		$param_data10 = $data10;
		$param_data11 = $data11;
		$param_data12 = $data12;
	}
	if ($stmt->execute()) {
		return true;
	} else {
		return false;
	}
	$stmt->close();
}

function Hari($data)
{

	switch ($data) {

		case 'Monday':
			$data = "Senin";
			return $data;
		case 'Tuesday':
			$data = "Selasa";
			return $data;
		case 'Wednesday':
			$data = "Rabu";
			return $data;
		case 'Thrusday':
			$data = "Kamis";
			return $data;
		case 'Friday':
			$data = "Jumat";
			return $data;
		case 'Saturday':
			$data = "Sabtu";
			return $data;
		case 'Sunday':
			$data = "Minggu";
			return $data;
	}
}
function Bulan($data)
{
	switch ($data) {
		case '1':
			$data = "Januari";
			return $data;
		case '2':
			$data = "Februari";
			return $data;
		case '3':
			$data = "Maret";
			return $data;
		case '4':
			$data = "April";
			return $data;
		case '5':
			$data = "Mei";
			return $data;
		case '6':
			$data = "Juni";
			return $data;
		case '7':
			$data = "Juli";
			return $data;
		case '8':
			$data = "Agustus";
			return $data;
		case '9':
			$data = "September";
			return $data;
		case '10':
			$data = "Oktober";
			return $data;
		case '11':
			$data = "Nopember";
			return $data;
		case '12':
			$data = "Desember";
			return $data;
	}
}
function TampilTanggal()
{
	$tanggal = Hari(date('l')) . ', ';
	$tanggal .= date('d') . ' ';
	$tanggal .= Bulan(date('m')) . ' ';
	$tanggal .= date('Y');
	return $tanggal;
}
function KonfirmasiBayar($data, $id_data)
{
	$sql = "UPDATE ap_keranjang SET status_pembayaran=? WHERE id=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("si", $param_data, $param_id_data);
		$param_data = $data;
		$param_id_data = $id_data;
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	$stmt->close();
}
function DataSitus()
{
	$sql = "SELECT id, nama_situs, alamat_situs, deskripsi_situs, kontak_situs, author_situs, logo_situs FROM ap_situs";
	$perintah = query($sql);
	return $perintah;
}
function DataSitusTampil()
{
	global $ArrayDataSitus;
	$DataSitus = DataSitus();
	while ($Data = $DataSitus->fetch_array()) {
		$nama_situs = $Data['nama_situs'];
		$alamat_situs = $Data['alamat_situs'];
		$deskripsi_situs = $Data['deskripsi_situs'];
		$kontak_situs = $Data['kontak_situs'];
		$author_situs = $Data['author_situs'];
		$logo_situs = $Data['logo_situs'];
	}

	$ArrayDataSitus = array($nama_situs, $alamat_situs, $deskripsi_situs, $kontak_situs, $author_situs, $logo_situs);
}
