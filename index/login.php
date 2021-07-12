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
require_once '../function/ap.login.php';
require_once '../function/ap.identitas.situs.php';
LoadHead($nama_situs, $alamat_situs, $deskripsi_situs, $author_situs, $logo_situs);
LoadCss();
LoadBody($nama_situs, $logo_situs);

?>
<?php

$username_err = $password_err = $login = $logout = "";
if (isset($_GET['page']) == 'logout') {
    $logout = "Anda sudah keluar";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty(trim($_POST['username']))) {
        $username_err = "<div class='alert alert-danger'>Masukan username Anda</div>";
    } else {

        $username = FilterInput($_POST['username']);
        $username = EscapeString($username);
    }
    if (empty(trim($_POST['password']))) {
        $password_err = "<div class='alert alert-danger'>Masukan sebuah password</div>";
    } else {
        $password = trim($_POST['password']);
        $password = ($secret_key . $password);
    }
    if (empty($username_err) && empty($password_err)) {
        if (LoginUser($username, $password)) {

            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['nama_lengkap'] = $nama_lengkap;
            $_SESSION['no_hp'] = $no_hp;
            $_SESSION['alamat_lengkap'] = $alamat_lengkap;
            $_SESSION['email'] = $email;

            $login = "<div class='alert alert-success'>Login berhasil, mengarahkan...</div>";
            echo "<meta http-equiv=\"refresh\"content=\"2;URL=home\"/>";
        } else {
            $login = "<div class='alert alert-danger'>Username atau password salah</div>";
        }
    }

    $koneksi->close();
}

?>

<div id="content-wrapper">
    <div class="container">
        <div class="login-page mt-5">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <h3>Login</h3>
                    <hr>

                    <div class="col-md-8 col-sm-6">

                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="form-group">
                                <label>Username : </label>
                                <input class="form-control" type="text" name="username" id="username" placeholder="Masukan username" />
                            </div>
                            <span><?php echo $username_err; ?></span>
                            <div class="form-group">
                                <label>Password : </label>
                                <input class="form-control" type="password" name="password" id="password" placeholder="Masukan password" />
                            </div>
                            <span><?php echo $password_err; ?></span>
                            <input type="submit" class="btn btn-flat btn-primarytani" name="login" id="login" value="Login" />
                        </form>
                        <br />
                        <span><?php echo $login; ?></span>
                        <span><?php echo $logout; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-bottom:500px">
        </div>

        <!-- Content Wrapper And Fluid End -->
    </div>
</div>


<?php
LoadFooter($nama_situs);
?>