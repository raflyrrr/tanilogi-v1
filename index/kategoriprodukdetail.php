<?php
session_start();
?>
<?php
$kategori = ($_GET['kategori']);
require_once '../config/database.php';
require_once '../function/ap.fungsi.php';
require_once '../function/ap.theme.php';
require_once '../function/ap.identitas.situs.php';
LoadHead($nama_situs, $alamat_situs, $deskripsi_situs, $author_situs, $logo_situs);
LoadCss();
if (isset($_SESSION['username'])) {
    LoadMenu($nama_situs, $logo_situs);
} else {
    LoadBody($nama_situs, $logo_situs);
}
?>

<div class="container mt-4" style="margin-bottom:25%">
    <?php $query = "select jenis_produk from ap_produk where jenis_produk = '$kategori' ;";
    $query_run = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($query_run);
    ?>
    <h3 style="margin-bottom:25px"><?php echo $row['jenis_produk'] ?></h3>
    <div class="row">
        <?php $query = "select * from ap_produk where jenis_produk = '$kategori' ;";
        $query_run = mysqli_query($koneksi, $query);
        while ($row = mysqli_fetch_assoc($query_run)) {
        ?>
            <div class="col-lg-3 col-md-5 col-sm-7 mb-4" data-aos="fade-up">
                <div class="card" style="width: 16rem;">
                    <img src="../img/produk/<?php echo $row['foto_produk'] ?> " class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="home?produk=detail&id=<?php echo $row['id'] ?>" class="stretched-link" style="text-decoration: none;"><?php echo $row['jenis_produk'] ?></a>
                    </div>
                </div>
            </div><?php } ?>
    </div>
</div>
<?php
LoadFooter($nama_situs);
?>