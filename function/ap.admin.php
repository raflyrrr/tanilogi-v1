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
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
// function ValidateEmail($data){
// 	if(!ereg("^.+@.+\\..+$",$data)){
// 		return true;
// 	}else{
// 		return false;
// 	}
// }
function ValidateUrl($data)
{
	if (!preg_match("#^http://[_a-z0-9-]+\\.[_a-z0-9-]+#i", $data)) {
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
	$sql = "SELECT username FROM ap_admin WHERE username=?";
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
function InsertProduk($nama, $nama_produk, $deskripsi_produk, $jenis_produk, $harga_produk, $satuan_produk, $stok_produk, $foto_produk, $tanggal_buat)
{
	global $FileItem, $FileDestination;
	$sql = "INSERT INTO ap_produk (nama_produk_pemilik, nama_produk, deskripsi_produk, jenis_produk, harga_produk, satuan_produk, stok_produk, foto_produk, tanggal_buat) VALUES(?,?,?,?,?,?,?,?,?)";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param(
			"sssssssss",
			$param_nama_produk_pemilik,
			$param_nama_produk,
			$param_deskripsi_produk,
			$param_jenis_produk,
			$param_harga_produk,
			$param_satuan_produk,
			$param_stok_produk,
			$param_foto_produk,
			$param_tanggal_buat
		);
		$param_nama_produk_pemilik = $nama;
		$param_nama_produk = $nama_produk;
		$param_deskripsi_produk = $deskripsi_produk;
		$param_jenis_produk = $jenis_produk;
		$param_harga_produk = $harga_produk;
		$param_satuan_produk = $satuan_produk;
		$param_stok_produk = $stok_produk;
		$param_foto_produk = $FileItem;
		$param_tanggal_buat = $tanggal_buat;
		if ($stmt->execute() && (move_uploaded_file($foto_produk, $FileDestination . $FileItem))) {
			return true;
		} else {
			return false;
		}
	}
	$stmt->close();
}
function ProdukTampil()
{
	$sql = "SELECT id, nama_produk_pemilik, nama_produk, deskripsi_produk, jenis_produk, harga_produk, satuan_produk, stok_produk, foto_produk, tanggal_buat, tanggal_update FROM ap_produk";
	$perintah = query($sql);
	return $perintah;
}
function OrderTampil()
{
	$sql = "SELECT * FROM ap_keranjang ORDER by id desc";
	$perintah = query($sql);
	return $perintah;
}
function OrderSelesai()
{
	$sql = "SELECT * FROM ap_keranjang WHERE status_pengiriman='Selesai'";
	$perintah = query($sql);
	return $perintah;
}
function OrderLunas()
{
	$sql = "SELECT * FROM ap_keranjang WHERE status_pembayaran='Lunas'";
	$perintah = query($sql);
	return $perintah;
}
function OrderUpdate($status_pengiriman, $status_pembayaran, $update_id)
{
	$sql = "UPDATE ap_keranjang SET status_pengiriman=?, status_pembayaran=? WHERE id=?";
	if ($stmt = prepare($sql)) :
		$stmt->bind_param(
			"ssi",
			$param_status_pengiriman,
			$param_status_pembayaran,
			$param_id
		);
		$param_status_pengiriman = $status_pengiriman;
		$param_status_pembayaran = $status_pembayaran;
		$param_id = $update_id;

		if ($stmt->execute()) :
			return true;
		else :
			return false;
		endif;

	endif;

	$stmt->close();
}
function OrderDetail($var_id)
{
	global $id, $id_pembeli, $nama_pembeli, $alamat_pembeli, $jumlah_beli, $id_produk, $nama_produk, $jenis_produk, $harga_produk, $satuan_produk, $foto_produk, $status_pengiriman, $status_pembayaran, $tanggal_pembelian, $tanggal;
	$sql = "SELECT id, id_pembeli, nama_pembeli, alamat_pembeli, jumlah_beli, id_produk, nama_produk, jenis_produk, harga_produk, satuan_produk, foto_produk, status_pengiriman, status_pembayaran, tanggal_pembelian, tanggal FROM ap_keranjang WHERE id=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("i", $param_id);
		$param_id = $var_id;
		if ($stmt->execute()) {
			$stmt->store_result();
			$stmt->bind_result($id, $id_pembeli, $nama_pembeli, $alamat_pembeli, $jumlah_beli, $id_produk, $nama_produk, $jenis_produk, $harga_produk, $satuan_produk, $foto_produk, $status_pengiriman, $status_pembayaran, $tanggal_pembelian, $tanggal);
			$stmt->fetch();
			if ($stmt->num_rows == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
}
function LoadProduk()
{

	echo '
	
              <h4>Semua Produk</h4>
			  <br/>

	<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="0">
    <thead>
    <tr>
    <th>No</th>
    <th>Nama Produk</th>
    <th>Stok Produk</th>
    <th>Harga</th>
    <th>Tindakan</th>
   
    </tr>
    </thead>
    <tbody>
    ';
	$ProdukTampil = ProdukTampil();
	if ($ProdukTampil->num_rows > 0) {
		$no = 1;
		while ($row = $ProdukTampil->fetch_array()) {
			echo '
      <tr>
      <td>' . $no . '</td>
      <td>' . $row['nama_produk'] . '</td>
      <td>' . $row['stok_produk'] . '' . $row['satuan_produk'] . '</td>
      <td>IDR ' . number_format($row['harga_produk']) . '</td>
      <td>
      <a title="Lihat Detail" href="?produk=detail&&id=' . $row['id'] . '"><i class="fas fa-fw fa-eye"></i></a>
      <a title="Edit" href="produk.edit.php?id=' . $row['id'] . '"><i class="fas fa-fw fa-edit"></i></a>
      <a title="Delete Produk" href="?produk=delete&&id=' . $row['id'] . '"><i class="fas fa-fw fa-trash"></i></a>



      </td>
     
      
      ';
			$no++;
		}
	} else {

		echo '
    <tr>
    <td colspan="7" align="center">
    Belum ada produk yang ditambahkan</td>
    </tr>

    ';
	}
	echo '

    </tbody>
    </table>
    </div>
    <br/><br/>
    ';
	$ProdukTampil->free_result();
}
function LoadProdukDetail($var_id)
{
	global $id, $nama_produk_pemilik, $nama_produk, $deskripsi_produk, $jenis_produk, $harga_produk, $satuan_produk, $stok_produk,  $foto_produk, $tanggal_buat, $tanggal_update;
	$sql = "SELECT id, nama_produk_pemilik, nama_produk, deskripsi_produk, jenis_produk, harga_produk, satuan_produk, stok_produk, foto_produk, tanggal_buat, tanggal_update FROM ap_produk WHERE id=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("i", $param_id);
		$param_id = $var_id;
		if ($stmt->execute()) {
			$stmt->store_result();
			$stmt->bind_result($id, $nama_produk_pemilik, $nama_produk, $deskripsi_produk, $jenis_produk, $harga_produk, $satuan_produk, $stok_produk, $foto_produk, $tanggal_buat, $tanggal_update);
			$stmt->fetch();
			if ($stmt->num_rows == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
}
function LoadProdukContent($id, $nama_produk_pemilik, $nama_produk, $deskripsi_produk, $jenis_produk, $harga_produk, $satuan_produk, $stok_produk, $foto_produk, $tanggal_buat, $tanggal_update)
{
	echo '
	<div class="row">
	<div id="content-wrapper">
      <div class="container-fluid">
		<div class="col-md-12">
		 <figure class="figure">
              <img src="../img/produk/' . $foto_produk . '" alt="' . $nama_produk . '" title="' . $nama_produk . '" class="figure-img img-fluid" width="500px">
           <figcaption class="figure-caption">

             </figcaption>           
        </figure>
        <h3>' . $nama_produk . '</h3>
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
				<td>Kategori Produk </td>
				<td>' . $jenis_produk . '</td>
			  </tr>
			  <tr>
				<td>Harga</td>
				<td>IDR. ' . number_format($harga_produk) . '' . $satuan_produk . '</td>
			  </tr>
			  <tr>
				<td>Stok</td>
				<td>' . $stok_produk . '' . $satuan_produk . '</td>
			  </tr>
			</table>
			</div>
		</div>
		<div id="menu1" class="container tab-pane fade"><br>
		
	</div>
        </div>
        	   



       </div>
       </div>
        </div>
		';
}
function UpdateProduk($nama, $nama_produk, $deskripsi_produk, $jenis_produk, $harga_produk, $satuan_produk, $stok_produk, $foto_produk, $id)
{
	global $FileItem, $FileDestination;
	$sql = "UPDATE ap_produk SET nama_produk_pemilik = ?, nama_produk=?, deskripsi_produk=?, jenis_produk=?, harga_produk=?, satuan_produk=?, stok_produk=?, foto_produk=? WHERE id=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param(
			"ssssssssi",
			$param_nama_produk_pemilik,
			$param_nama_produk,
			$param_deskripsi_produk,
			$param_jenis_produk,
			$param_harga_produk,
			$param_satuan_produk,
			$param_stok_produk,
			$param_foto_produk,
			$param_id
		);
		$param_nama_produk_pemilik = $nama;
		$param_nama_produk = $nama_produk;
		$param_deskripsi_produk = $deskripsi_produk;
		$param_jenis_produk = $jenis_produk;
		$param_harga_produk = $harga_produk;
		$param_satuan_produk = $satuan_produk;
		$param_stok_produk = $stok_produk;
		$param_foto_produk = $FileItem;
		$param_id = $id;
		/*Mengecek kondisi apakah foto kosong atau tidak
		jika kosong simpan foto sebelumnya, jika tidak upload foto baru
		*/
		if (empty($_FILES["foto_produk"]["tmp_name"])) {
			if ($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		} else {
			if ($stmt->execute() && (move_uploaded_file($foto_produk, $FileDestination . $FileItem))) {
				return true;
			} else {
				return false;
			}
		}
	}
	$stmt->close();
}
function DeleteProduk($data)
{
	$sql = "DELETE FROM ap_produk WHERE id=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("i", $param_id);
		$param_id = $data;
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	$stmt->close();
}
function TambahJenisProduk($jenis_produk, $foto_produk)
{
	$sql = "INSERT INTO ap_produk_jenis (jenis_produk, foto_produk) VALUES(?,?)";
	global $FileItem, $FileDestination;
	if ($stmt = prepare($sql)) {
		$stmt->bind_param(
			"ss",
			$param_jenis_produk,
			$param_foto_produk
		);
		$param_jenis_produk = $jenis_produk;
		$param_foto_produk = $foto_produk;
		if ($stmt->execute() && (move_uploaded_file($foto_produk, $FileDestination . $FileItem))) {
			return true;
		} else {
			return false;
		}
	}
	$stmt->close();
}
function TampilJenisProduk()
{
	$sql = "SELECT id, jenis_produk FROM ap_produk_jenis";
	$perintah = query($sql);
	return $perintah;
}

function LoadJenisProduk()
{
	echo '
	<h4>Kategori Produk</h4>
	<br/>
	<a title="Tambah Jenis Produk" href="produk.jenis.php" class="btn btn-sm btn-primary"><i class="fas fa-shopping-cart"></i> Tambah Kategori</a>
	<br/>
	<br/>
	<div class="table-responsive">
    <table width="100%"" class="table table-sthiped table-bordered table-hover">
    
    <tr>
    <th>No</th>
    <th>Kategori Produk</th>   
    <th>Aksi</th>
    </tr>
    
    ';
	$TampilJenisProduk = TampilJenisProduk();
	if ($TampilJenisProduk->num_rows > 0) {
		$no = 1;
		while ($row = $TampilJenisProduk->fetch_array()) {
			echo '
      <tr>
      <td>' . $no . '</td>
      <td>' . $row['jenis_produk'] . '</td>      
      <td>      
      <a title="Delete Kategori Produk" href="editKategori.php?id=' . $row['id'] . '"><i class="fas fa-fw fa-edit"></i></a>
      <a title="Delete Kategori Produk" href="deleteKategori.php?id=' . $row['id'] . '" onClick=\'alert("Kategori berhasil dihapus");\' ><i class="fas fa-fw fa-trash"></i></a>



      </td>
     
      
      ';
			$no++;
		}
	} else {

		echo '
    <tr>
    <td colspan="7" align="center">
    Belum ada kategori produk yang ditambahkan</td>
    </tr>

    ';
	}
	echo '

    </tbody>
    </table>
    </div>
    <br/><br/>
    ';
	$TampilJenisProduk->free_result();
}
function CekJenisProduk($data)
{
	$sql = "SELECT jenis_produk FROM ap_produk_jenis WHERE jenis_produk = ?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("s", $param_jenis_produk);
		$param_jenis_produk = $data;
		if ($stmt->execute()) {
			$stmt->store_result();
			if ($stmt->num_rows == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
	$stmt->close();
}
function TampilPelanggan()
{
	$sql = "SELECT id, nama_lengkap, no_hp, alamat_lengkap, email, username FROM ap_user";
	$perintah = query($sql);
	return $perintah;
}
function LoadPelanggan()
{
	echo '
	<ol class="breadcrumb" style="margin-top: 15px;">
                <li class="breadcrumb-item">
                  <a href="index.php">Admin Panel</a>
                </li>
                <li class="breadcrumb-item active"> Data Pelanggan </li>
              </ol>
              
	<div class="table-responsive">
    <table width="100%"" class="table table-sthiped table-bordered table-hover">
    
    <tr>
    <th>No</th>
    <th>Nama Pelanggan</th>   
    <th>No.HP</th>
    <th>Username</th>
    <th>Tindakan</th>
    </tr>
    
    ';
	$TampilPelanggan = TampilPelanggan();
	if ($TampilPelanggan->num_rows > 0) {
		$no = 1;
		while ($row = $TampilPelanggan->fetch_array()) {
			echo '
      <tr>
      <td>' . $no . '</td>
      <td>' . $row['nama_lengkap'] . '</td> 
      <td>' . $row['no_hp'] . '</td> 
      <td>' . $row['username'] . '</td>        
      <td>
      <a title="Detail Pelanggan" href="?pelanggan=detail&&id=' . $row['id'] . '"><i class="fas fa-fw fa-eye"></i></a>      
     




      </td>
     
      
      ';
			$no++;
		}
	} else {

		echo '
    <tr>
    <td colspan="7" align="center"><i style="font-size:100px" class="fas fa-users"></i><br>
    Belum ada pelanggan</td>
    </tr>

    ';
	}
	echo '

    </tbody>
    </table>
    </div>
   
    ';
	$TampilPelanggan->free_result();
}
function LoadPelangganDetail($var_id)
{
	global $id, $nama_lengkap, $no_hp, $alamat_lengkap, $email_pelanggan, $username;

	$sql = "SELECT id, nama_lengkap, no_hp, alamat_lengkap, email, username FROM ap_user WHERE id=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("i", $param_id);
		$param_id = $var_id;
		if ($stmt->execute()) {
			$stmt->store_result();
			$stmt->bind_result($id, $nama_lengkap, $no_hp, $alamat_lengkap, $email_pelanggan, $username);
			$stmt->fetch();
			if ($stmt->num_rows == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
}
function LoadPelangganContent($id, $nama_lengkap, $no_hp, $alamat_lengkap, $email_pelanggan, $username)
{
	echo '
	<ol class="breadcrumb" style="margin-top: 15px;">
                <li class="breadcrumb-item">
                  <a href="index.php">Admin Panel</a>
                </li>
                <li class="breadcrumb-item active"> Data Pelanggan </li>
              </ol>
              
	<div class="table-responsive">
    <table width="100%"" class="table table-sthiped table-bordered table-hover">
    
    <tr>
    <td>ID. Pel</td>
    <td>' . $id . '</td>
    </tr>
    <tr>
    <td>Nama Pelangan</td>
    <td>' . $nama_lengkap . '</td>
    </tr>
    <tr>
    <td>No.HP</td>
    <td>' . $no_hp . '</td>
    </tr>
    <tr>
    <td>Alamat Lengkap</td>
    <td>' . $alamat_lengkap . '</td>
    </tr>
    <tr>
    <td>Email</td>
    <td>' . $email_pelanggan . '</td>
    </tr>
    <tr>
    <td>Username</td>
    <td>' . $username . '</td>
    </tr>
    </table>
    </div>

    ';
}
function AddAdmin($nama, $email, $username, $password, $level, $secret_panel)
{
	$sql = "INSERT INTO ap_admin (nama, email, username, password, level) VALUES (?,?,?,?,?)";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param(
			"sssss",
			$param_nama,
			$param_email,
			$param_username,
			$param_password,
			$param_level
		);
		$param_nama = $nama;
		$param_email = $email;
		$param_username = $username;
		$param_password = password_hash($secret_panel . $password, PASSWORD_DEFAULT);
		$param_level = $level;
	}
	if ($stmt->execute()) {
		return true;
	} else {
		return false;
	}
	$stmt->close();
}
function CekAdmin($data)
{
	$sql = "SELECT username FROM ap_admin WHERE username = ?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("i", $param_username);
		$param_username = $data;
		if ($stmt->execute()) {
			$stmt->store_result();
			if ($stmt->num_rows == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
	$stmt->close();
}
function UpdateAdmin($nama, $email, $username, $password, $level, $id, $secret_panel)
{
	$sql = "UPDATE ap_admin SET nama=?, email=?, username=?, password=?, level=? WHERE id=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param(
			"sssssi",

			$param_nama,
			$param_email,
			$param_username,
			$param_password,
			$param_level,
			$param_id

		);
		$param_nama = $nama;
		$param_email = $email;
		$param_username = $username;
		$param_password = password_hash($secret_panel . $password, PASSWORD_DEFAULT);
		$param_level = $level;
		$param_id = $id;
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
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
	$tanggal = Hari(date('l')) . ', '; //hari
	$tanggal .= date('d') . ' '; //tanggal
	$tanggal .= Bulan(date('m')) . ' '; //bulan
	$tanggal .= date('Y'); //tahun
	/*Digabung Hari, Tanggal bulan tahun */
	return $tanggal;
}

function LoadModal()
{
	echo '
	 <!-- Modal Edit Update -->
    <div class="modal fade" id="update_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
           
          <div class="modal-body">
           <form method="post" id="update_form" />
            <div class="form-group">
            <label>Status Pengiriman :</label>
            <select class="form-control" id="status_pengiriman_m" name="status_pengiriman">
              <option value="Belum Diproses">Belum Diproses</option>
              <option value="Sedang Diproses">Sedang Diproses</option>
              <option value="Sudah Dikirim">Sudah Dikirim</option>
              <option value="Selesai">Selesai</option>
            </select>
            </div>
            <div class="form-group">
            <label>Status Pembayaran :</label>
            <select class="form-control" id="status_pembayaran_m" name="status_pembayaran">
             
              <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
              <option value="Belum Diverifikasi">Belum Diverifikasi</option>
              <option value="Lunas">Lunas</option>              
            </select>
            </div>
            <input type="hidden" name="update_id" id="update_id_m" />  
            <input type="submit" name="update" id="Update" value="Update" class="btn btn-success" /> 
            </form>                   
          </div>        
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>          
          </div>   
        </div>
      </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Logout ?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Klik "Logout" jika anda ingin mengakhiri sesi ini.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="log-out.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
     <!-- Modal detail -->
    <div class="modal fade" id="confirm-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Order</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="detail_order">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                    
          </div>      
        </div>
      </div>
    </div>
	';
}


function InfSitus()
{
	$sql = "SELECT id, nama_situs, alamat_situs, deskripsi_situs, kontak_situs, author_situs, logo_situs FROM ap_situs";
	$perintah = query($sql);
	return $perintah;
}
function UpdateInfSitus($nama_situs, $alamat_situs, $deskripsi_situs, $kontak_situs, $author_situs, $logo_situs, $id)
{
	global $FileItem, $FileDestination;
	$sql = "UPDATE ap_situs SET nama_situs=?, alamat_situs=?, deskripsi_situs=?,  kontak_situs=?, author_situs=?, logo_situs=? WHERE id=?";

	if ($stmt = prepare($sql)) :
		$stmt->bind_param(
			"ssssssi",

			$param_nama_situs,
			$param_alamat_situs,
			$param_deksripsi_situs,
			$param_kontak_situs,
			$param_author_situs,
			$param_logo_situs,
			$param_id

		);
		$param_nama_situs = $nama_situs;
		$param_alamat_situs = $alamat_situs;
		$param_deksripsi_situs = $deskripsi_situs;
		$param_kontak_situs = $kontak_situs;
		$param_author_situs = $author_situs;
		$param_logo_situs = $FileItem;
		$param_id = $id;
		if (empty($_FILES['logo_situs']['tmp_name'])) :

			if ($stmt->execute()) :
				return true;
			else :
				return false;
			endif;
		else :
			if ($stmt->execute() && (move_uploaded_file($logo_situs, $FileDestination . $FileItem))) :
				return true;
			else :
				return false;
			endif;
		endif;

	endif;
	$stmt->close();
}
function InsertSosmed($nama_sosmed, $url_id)
{
	$sql = "INSERT INTO ap_sosmed (nama_sosmed, url) VALUES (?,?)";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("ss", $param_nama_sosmed, $param_url_id);
		$param_nama_sosmed = $nama_sosmed;
		$param_url_id = $url_id;

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	$stmt->close();
}
function DeleteSosmed($data)
{
	$sql = "DELETE FROM ap_sosmed WHERE id=?";
	if ($stmt = prepare($sql)) {
		$stmt->bind_param("i", $param_id);
		$param_id = $data;
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
}
function TampilSosmed()
{
	$sql = "SELECT id, nama_sosmed, url FROM ap_sosmed";
	$perintah = query($sql);
	return $perintah;
}
