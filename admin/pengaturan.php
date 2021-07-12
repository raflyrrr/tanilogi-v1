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
$RowData = InfSitus();
while ($Data = $RowData->fetch_array()) {
	$id = $Data['id'];
	$nama_situs = $Data['nama_situs'];
	$alamat_situs = $Data['alamat_situs'];
	$deskripsi_situs = $Data['deskripsi_situs'];
	$kontak_situs = $Data['kontak_situs'];
	$author_situs = $Data['author_situs'];
	$logo_situs = $Data['logo_situs'];
}
?>
<?php

$simpan = $nama_situs_err = $alamat_situs_err = $deskripsi_situs_err = $kontak_situs_err = $author_situs_err = $logo_err = "";
if (isset($_POST['save_situs'])) {
	if (empty(trim($_POST['nama_situs']))) {
		$nama_situs_err = "Maaf nama situs tidak boleh kosong";
	} else {
		$nama_situs = FilterInput($_POST['nama_situs']);
		$nama_situs = EscapeString($nama_situs);
	}
	if (empty(trim($_POST['alamat_situs']))) {
		$alamat_situs_err = "Maaf alamat url situs tidak boleh kosong";
	} elseif (ValidateUrl($_POST['alamat_situs'])) {
		$alamat_situs_err = "Format penulisan alamat situs salah";
	} else {
		$alamat_situs = FilterInput($_POST['alamat_situs']);
		$alamat_situs = EscapeString($alamat_situs);
	}
	if (empty(trim($_POST['deskripsi_situs']))) {
		$deskripsi_situs_err = "Deskripsi situs tidak boleh kosong";
	} else {
		$deskripsi_situs = FilterInput($_POST['deskripsi_situs']);
		$deskripsi_situs = EscapeString($deskripsi_situs);
	}
	if (empty(trim($_POST['kontak_situs']))) {
		$kontak_situs_err = "Kontak situs tidak boleh kosong";
	} elseif (ValidateNumber($_POST['kontak_situs'])) {
		$kontak_situs_err = "Isian kontak situs salah !";
	} else {
		$kontak_situs = FilterInput($_POST['kontak_situs']);
		$kontak_situs = EscapeString($kontak_situs);
	}
	if (empty(trim($_POST['author_situs']))) {
		$author_situs_err = "Author situs tidak boleh kosong";
	} else {
		$author_situs = FilterInput($_POST['author_situs']);
		$author_situs = EscapeString($author_situs);
	}
	if (empty($_FILES["logo_situs"]["tmp_name"])) {
		$FileItem = $logo_situs;
	} else {
		$FileName = $_FILES['logo_situs']['name'];
		$FileDir = $_FILES['logo_situs']['tmp_name'];
		$FileSize = $_FILES['logo_situs']['size'];
		$FileDestination = '../theme/content/';
		$FileExtension = strtolower(pathinfo($FileName, PATHINFO_EXTENSION));
		$FileValid = array('jpeg', 'jpg', 'png');
		$FileItem = "logo_web" . "." . $FileExtension;

		if (in_array($FileExtension, $FileValid)) {
			if ($FileSize > 100000) {
				$logo_situs_err = "logo tidak boleh lebih dari 100Kb";
			} else {
				$logo_situs = $FileDir;
			}
		} else {
			$logo_situs_err = "Ektensi foto produk tidak sesuai, pilih file format jpeg, jpg atau png";
		}
	}
	if (empty($nama_situs_err) && empty($alamat_situs_err) && empty($deskripsi_situs_err) && empty($kontak_situs_err) && empty($author_situs_err) && empty($logo_situs_err)) {

		if (UpdateInfSitus($nama_situs, $alamat_situs, $deskripsi_situs, $kontak_situs, $author_situs, $logo_situs, $id)) :
			$simpan = "<div class='alert alert-success'>Data situs berhasil diperbaharui</div>";
			echo "<meta http-equiv=\"refresh\"content=\"2;URL=pengaturan.php\"/>";
		else :
			$simpan = "<div class='alert alert-danger'>Data situs gagal diperbaharui</div>";

		endif;
	}
	//end save_situs
}
?>
<?php
$nama_sosmed_err = $url_id_err = "";
if (isset($_POST['save_sosmed'])) {
	if (empty(trim($_POST['nama_sosmed']))) {
		$nama_sosmed_err = "Nama jenis sosial media tidak boleh kosong";
	} else {
		$nama_sosmed = FilterInput($_POST['nama_sosmed']);
		$nama_sosmed = EscapeString($nama_sosmed);
	}
	if (empty(trim($_POST['url_id']))) {
		$url_id_err = "Alamat url id sosial media tidak boleh kosong";
	} elseif (ValidateUrl($_POST['url_id'])) {
		$url_id_err = "Maaf format penulisan url salah !";
	} else {
		$url_id = FilterInput($_POST['url_id']);
		$url_id = EscapeString($url_id);
	}
	if (empty($nama_sosmed_err) && empty($url_id_err)) {
		if (InsertSosmed($nama_sosmed, $url_id)) {
			$simpan = "<div class='alert alert-success'>Data sosial media berhasil diperbaharui</div>";
			echo "<meta http-equiv=\"refresh\"content=\"2;URL=" . $_SERVER['REQUEST_URI'] . "\"/>";
		} else {
			$simpan = "<div class='alert alert-danger'>Data sosial media gagal disimpan</div>";
			echo "<meta http-equiv=\"refresh\"content=\"2;URL=" . $_SERVER['REQUEST_URI'] . "\"/>";
		}
	}
}
?>
<div id="content-wrapper">
	<div class="container-fluid">

		<?php
		if (!isset($_GET['pengaturan'])) {
			$_GET['pengaturan'] = '';
		}

		echo '


	<ol class="breadcrumb" style="margin-top: 15px;">
                <li class="breadcrumb-item">
                  <a href="index.php">Admin Panel</a>
                </li>
                <li class="breadcrumb-item active">Pengaturan Situs</li>
              </ol>
       ' . $simpan . '
		<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post" enctype="multipart/form-data" />
			<div class="form-group">
			<label>Nama situs : </label>
				<input class="form-control" name="nama_situs" value="' . $nama_situs . '">
				<span style="color:red;">' . $nama_situs_err . '</span>
			</div>
			<div class="form-group">
			<label>Alamat url : </label>
				<input class="form-control" name="alamat_situs" value="' . $alamat_situs . '">
				<span style="color:red;">' . $alamat_situs_err . '</span>
			</div>
			<div class="form-group">
			<label>Deskripsi : </label>
				<textarea class="form-control" rows="5" name="deskripsi_situs">' . $deskripsi_situs . '</textarea>
				<span style="color:red;">' . $deskripsi_situs_err . '</span>
			</div>
			<div class="form-group">
			<label>Kontak : </label>
				<input class="form-control" name="kontak_situs" value="' . $kontak_situs . '">
				<span style="color:red;">' . $kontak_situs_err . '</span>
			</div>
			<div class="form-group">
			<label>Author : </label>
				<input class="form-control" name="author_situs" value="' . $author_situs . '">
				<span style="color:red;">' . $author_situs_err . '</span>
			</div>
			<div class="form-group">
			<label>Logo :</label><br>
			<em>Disarankan ukuran kecil 50x50 format png</em>			
				<input type="file" class="form-control-file" name="logo_situs">
			</div>
			<div class="form-group">
			<input class="btn btn-primary btn-md" type="submit" name="save_situs" value="Simpan">
			</div>

		</form>


	';
		

		?>



	</div>
</div>

<?php
LoadFooterPanel();
?>