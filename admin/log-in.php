<?php
session_start();
if (isset($_SESSION['admin'])) {
  header("location:index.php");
}

?>
<?php
require_once '../config/database.php';
require_once '../function/ap.fungsi.php';
require_once '../function/ap.login.php';
require_once '../function/ap.theme.php';
require_once '../function/ap.identitas.situs.php';
LoadHead($nama_situs, $alamat_situs, $deskripsi_situs, $author_situs, $logo_situs);
LoadCss();
?>
<?php
$username_err = $password_err = $login = "";
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
    $password = ($secret_panel . $password);
  }
  if (empty($username_err) && empty($password_err)) {
    if (LoginAdmin($username, $password)) {

      $_SESSION['id'] = $id;
      $_SESSION['nama'] = $nama;
      $_SESSION['email'] = $email;
      $_SESSION['admin'] = $username;
      $_SESSION['level'] = $level;

      $login = "<div class='alert alert-success'>Login berhasil, mengarahkan...</div>";
      echo "<meta http-equiv=\"refresh\"content=\"2;URL=index.php\"/>";
    } else {
      $login = "<div class='alert alert-danger'>Username atau password salah</div>";
    }
  }

  $koneksi->close();
}

?>

<link href="../theme/css/sb-admin.css" rel="stylesheet">

<body>
  <div class="container">
    <h4 style="text-align: center;">Tanilogi</h4>
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login Admin</div>
      <div class="logo-login">
      </div>
      <div class="card-body">
        <?php echo $login; ?>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

          <div class="form-group">
            <div class="form-label-group">
              <input id="username" name="username" class="form-control" placeholder="Masukan Username" required="required" autofocus="autofocus">
              <label for="username">Username</label>
            </div>

          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="required">
              <label for="password">Password</label>
            </div>
          </div>


          <input type="submit" class="btn btn-primary btn-block" name="login" value="Login" />
        </form>

      </div>
    </div>
  </div>
  <script src="../theme/vendor/jquery/jquery.min.js"></script>
  <script src="../theme/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../theme/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>