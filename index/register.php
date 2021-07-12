<?php
session_start();
if (isset($_SESSION['username'])) {
	header("location: home");
	exit;
}
?>
<?php
require_once '../config/database.php';
require_once '../function/ap.fungsi.php';
require_once '../function/ap.theme.php';
require_once '../function/ap.identitas.situs.php';
LoadHead($nama_situs, $alamat_situs, $deskripsi_situs, $author_situs, $logo_situs);
LoadCss();
LoadBody($nama_situs, $logo_situs);


$nama_lengkap = $no_hp = $no_hp_err =  $email = $username = $password = $confirm_password = $alamat_lengkap = $simpan = "";
$nama_lengkap_err =  $email_err = $username_err = $password_err = $confirm_password_err = $alamat_lengkap_err = "";

/*Bagian register data ketika semua data telah terisi dan divalidasi */
if (isset($_POST['register'])) {
	if (empty(trim($_POST['nama_lengkap']))) {
		$nama_lengkap_err = "<div class='alert alert-danger'>Nama lengkap tidak boleh kosong</div>";
	} elseif (ValidateName($_POST['nama_lengkap'])) {
		$nama_lengkap_err = "<div class='alert alert-danger'>Nama lengkap harus karakter alphabet</div>";
	} else {
		$nama_lengkap = FilterInput($_POST['nama_lengkap']);
		$nama_lengkap = EscapeString($_POST['nama_lengkap']);
	}
	if (empty(trim($_POST['no_hp']))) {
		$no_hp_err = "<div class='alert alert-danger'>Nama lengkap tidak boleh kosong</div>";
	} elseif (ValidateNumber($_POST['no_hp'])) {
		$no_hp_err = "<div class='alert alert-danger'>Format nomor handphone harus berupa angka</div>";
	} else {
		$no_hp = FilterInput($_POST['no_hp']);
		$no_hp = EscapeString($_POST['no_hp']);
	}
	if (empty(trim($_POST['alamat_lengkap']))) {
		$alamat_lengkap_err = "<div class='alert alert-danger'> Masukan alamat secara lengkap</div>";
	} else {
		$alamat_lengkap = trim($_POST['alamat_lengkap']);
	}
	if (empty(trim($_POST['email']))) {
		$email_err = "<div class='alert alert-danger'>Maaf email tidak boleh kosong</div>";
	} elseif (ValidateEmail($_POST['email'])) {
		$email_err = "<div class='alert alert-danger'>Format penulisan email salah</div>";
	} else {
		if (CekEmail(trim($_POST['email']))) {
			$email_err = "<div class='alert alert-danger'>Email tersebut sudah digunakan, silahkan ganti !</div>";
		} else {
			$email = FilterInput($_POST['email']);
			$email = EscapeString($email);
		}
	}
	if (empty($_POST['username'])) {
		$username_err = "<div class='alert alert-danger'>Harap masukan sebuah username </div>";
	} elseif (strlen($_POST['username']) > 25) {
		$username_err = "<div class='alert alert-danger'>Username tidak boleh lebih dari 25 karakter</div>";
	} elseif (strlen($_POST['username']) < 3) {
		$username_err = "<div class='alert alert-danger'>Username minimal 3 karakter</div>";
	} else {
		if (CekUsername(trim($_POST['username']))) {
			$username_err = "<div class='alert alert-danger'>Username tersebut sudah digunakan !</div>";
		} else {
			$username = FilterInput($_POST['username']);
			$username = EscapeString($username);
		}
	}
	if (empty(trim($_POST['password']))) {
		$password_err = "<div class='alert alert-danger'>Harap masukan sebuah password </div>";
	} elseif (strlen($_POST['password']) < 6) {
		$password_err = "<div class='alert alert-danger'> Password tidak boleh kurang dari 6 karakter</div>";
	} else {
		$password = trim($_POST['password']);
	}
	if (empty($_POST['confirm_password'])) {
		$confirm_password_err = "<div class='alert alert-danger'>Konfirmasi password harus diisi</div>";
	} else {
		$confirm_password = trim($_POST['confirm_password']);
		if (empty($password_err) && ($password != $confirm_password)) {
			$confirm_password_err = "<div class='alert alert-danger'>Konfirmasi password tidak cocok</div>";
		}
	}
	if (empty($nama_lengkap_err) && empty($no_hp_err) && empty($alamat_lengkap_err) && empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

		if (InsertRegister($nama_lengkap, $no_hp, $alamat_lengkap, $email, $username, $password)) {
			$simpan = "<div class='alert alert-success'>Registrasi berhasil. Silahkan login untuk melanjutkan berbelanja</div>";
			echo "<meta http-equiv=\"refresh\"content=\"2;URL=login\"/>";
		} else {
			$simpan = "<div class='alert alert-danger'>Registrasi gagal. Silahkan coba kembali</div>";
		}
	}
}

?>

<div id="content-wrapper">
	<div class="container mt-5 mb-4">
		<!-- Breadcrumbs-->
		<?php echo $simpan; ?>
		<div class="row">
			<div class="col-md-8 col-sm-6">
				<h3>Daftar</h3>
				<hr>
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="register">
					<div class="form-group">
						<label>Masukan Nama:</label>
						<input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" minlength="3" value="<?php echo $nama_lengkap; ?>" placeholder="Masukan nama depan Anda" required="" />
					</div>
					<?php echo $nama_lengkap_err; ?>

					<div class="form-group">
						<label>No.HP / WhatsApp:</label>
						<input type="text" class="form-control" name="no_hp" id="no_hp" value="<?php echo $no_hp; ?>" minlength="11" maxlength="13" placeholder="Masukan No. HP atau WhtasApp Anda" required="" />
					</div>
					<?php echo $no_hp_err; ?>
					<div class="form-group">
						<label>Alamat :</label>
						<textarea class="form-control" name="alamat_lengkap" id="alamat_lengkap" rows="5" placeholder="Masukan alamat lengkap. Contoh : Dusun Babakan RT 01 RW 04 Desa Parigi Kec Parigi Kab. Pangandaran"><?php echo $alamat_lengkap; ?></textarea>

					</div>
					<?php echo $alamat_lengkap_err; ?>
					<div class="form-group">
						<label>Email : </label>
						<input type="text" class="form-control" name="email" id="email" placeholder="Masukan alamat email yang valid yang Anda miliki" value="<?php echo $email; ?>" />
					</div>
					<?php echo $email_err; ?>
					<div class="form-group">
						<label>Username : </label>
						<input type="text" class="form-control" name="username" id="username" placeholder="Masukan username. Contoh Adi223" minlength="5" value="<?php echo $username; ?>" />
					</div>
					<?php echo $username_err; ?>
					<div class="form-group">
						<label>Password :</label>
						<input type="password" class="form-control" name="password" id="password" minlength="6" placeholder="Password minimal 6 karakter" />
					</div>
					<?php echo $password_err; ?>
					<div class="form-group">
						<label>Konfirmasi password:</label>
						<input type="password" class="form-control" name="confirm_password" id="confirm_password" minlength="6" placeholder="Masukan konfirmasi password" />
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-flat btn-primarytani" name="register" id="register" value="Daftar" />
					</div>

				</form>
			</div>
			
		</div>
		<!-- Content Wrapper And Fluid End -->
	</div>
</div>


<?php
LoadFooter($nama_situs);
?>