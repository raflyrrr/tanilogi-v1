<?php

session_start();
require_once '../function/ap.session.php';
if (SessionUserCek()) {
	header("location:login.php");
} else {
	SessionActive();
	$id = $array[0];
	$username = $array[1];
	$nama_lengkap = $array[2];
	$no_hp = $array[3];
	$alamat_lengkap = $array[4];
	$email = $array[5];
}

?>
<?php
require_once '../config/database.php';
require_once '../function/ap.fungsi.php';
require_once '../function/ap.theme.php';
require_once '../function/ap.identitas.situs.php';
LoadHead($nama_situs, $alamat_situs, $deskripsi_situs, $author_situs, $logo_situs);
LoadCss();
LoadMenu($nama_situs, $logo_situs);
?>
<?php

$nama_lengkap_err = $no_hp_err = $username_err = $email_err = $password_err = $confirm_password_err = $alamat_lengkap_err = $simpan = "";
/*Bagian update data ketika semua data telah terisi dan divalidasi */
if (isset($_POST['update'])) {
	if (empty(trim($_POST['id']))) {
		die('Error: Percobaan manipulasi');
	} else {
		$id = FilterInput($_POST['id']);
		$id = EscapeString($id);
	}
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
		if (trim($_POST['email']) != $email) {
			if (CekEmail($_POST['email'])) {
				$email_err = "<div class='alert alert-danger'>Maaf alamat email tersebut sudah digunakan, silahkan ganti</div>";
			} else {
				$email = FilterInput($_POST['email']);
				$email = EscapeString($email);
			}
		} else {
			$email = FilterInput($_POST['email']);
			$email = EscapeString($email);
		}
	}
	if (empty($_POST['username'])) {
		$username_err = "<div class='alert alert-danger'>Harap masukan sebuah username </div>";
	} elseif (strlen($_POST['username']) > 12) {
		$username_err = "<div class='alert alert-danger'>Username tidak boleh lebih dari 12 karakter</div>";
	} elseif (strlen($_POST['username']) < 5) {
		$username_err = "<div class='alert alert-danger'>Username miusernameal 5 karakter</div>";
	} else {

		if (trim($_POST['username']) != $username) {
			if (CekUsername($_POST['username'])) {
				$username_err = "<div class='alert alert-danger'>Username sudah digunakan ganti dengan yang lain</div>";
			} else {
				$username = $_POST['username'];
				$username = $koneksi->real_escape_string($username);
			}
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

		if (ProfileUpdate($nama_lengkap, $no_hp, $alamat_lengkap, $email, $username, $password, $id)) {
			$simpan = "<div class='alert alert-success'>Perubahan berhasil disimpan</div>";
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $username;
			$_SESSION['nama_lengkap'] = $nama_lengkap;
			$_SESSION['no_hp'] = $no_hp;
			$_SESSION['alamat_lengkap'] = $alamat_lengkap;
			$_SESSION['email_err'] = $email;
			echo "<meta http-equiv=\"refresh\"content=\"2;URL=profile\"/>";
		} else {
			$simpan = "<div class='alert alert-danger'>Terjadi kesalahan. Silahkan refresh halaman dan ulangi kembali</div>";
		}
	}
}

?>
<div id="content-wrapper">
	<div class="container">
		<!-- Breadcrumbs-->
		<h4 style="margin-top: 30px;">Profile</h4>
		<?php echo $simpan; ?>
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="update">
			<div class="form-group">
				<label>Masukan Nama:</label>
				<input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" minlength="3" value="<?php echo $nama_lengkap; ?>" placeholder="Masukan nama depan Anda" required="" />
				<input type="hidden" name="id" value="<?php echo $id; ?>">
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
				<input type="text" class="form-control" name="email" id="email" placeholder="Masukan alamat email yang valid" value="<?php echo $email; ?>" />
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
				<input type="submit" class="btn btn-primarytani btn-md mb-5" name="update" id="update" value="Simpan Perubahan" />
			</div>

		</form>

	</div>
</div>
<?php
LoadFooter($nama_situs);
?>