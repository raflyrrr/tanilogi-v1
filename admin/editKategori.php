<?php
require_once '../function/ap.session.php';
require_once '../config/database.php';
require_once '../function/ap.admin.php';
require_once '../function/ap.theme.php';
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

if (isset($_POST['submit'])) {
    $jenis_produk = $_POST['jenis_produk'];
    $fotokategori_produk = $_FILES['fotokategori_produk']['name'];
    $idkategori = $_GET['id'];
    $dir = "../img/kategoriproduk/";
    if (!is_dir($dir)) {
        mkdir("../img/kategoriproduk/");
    }

    move_uploaded_file($_FILES["fotokategori_produk"]["tmp_name"], "../img/kategoriproduk/" . $_FILES["fotokategori_produk"]["name"]);
    $sql = mysqli_query($koneksi, "update ap_produk_jenis set jenis_produk='$jenis_produk',fotokategori_produk = '$fotokategori_produk' where id='$idkategori'");
    $_SESSION['msg'] = "menambah kategori produk";
}

?>
<?php
LoadHeadPanel();
LoadCssPanel();
LoadMenuPanel();
?>

<?php
$idkategori = $_GET['id'];
$query = "select * from ap_produk_jenis where id = '$idkategori' ;";
$query_run = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($query_run);
?>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb" style="margin-top: 15px;">
            <li class="breadcrumb-item">
                <a href="index.php">Admin Panel</a>
            </li>
            <li class="breadcrumb-item active">Edit Kategori</li>
        </ol>
        <?php if (isset($_POST['submit'])) {
            header("refresh:1; url=produk.php?produk=kategori");
        ?>
            <div class="alert alert-success mt-4">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Berhasil</strong> <?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?>
            </div>
        <?php } ?>
        <form method="post" enctype="multipart/form-data" />
        <div class="form-group">
            <label>Kategori Produk</label>
            <input class="form-control" type="text" name="jenis_produk" value=<?php echo $row['jenis_produk'] ?> />
        </div>
        <div class="form-group">
            <label>Foto </label>
            <input class="form-control" type="file" name="fotokategori_produk" />
        </div>
        <div class="form-group">
            <input class="btn btn-default" type="submit" name="submit" value="Simpan" />
        </div>
        </form>
    </div>
</div>
<?php
LoadFooterPanel();
?>