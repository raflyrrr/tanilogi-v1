<?php
require_once '../function/ap.session.php';
session_start();
if (SessionUserCek()) {
	header("location:login");
} else {

	SessionActive();
	$id_pembeli = $array[0];
	$username = $array[1];
	$nama_lengkap = $array[2];
	$no_hp = $array[3];
	$alamat_lengkap = $array[4];
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
$tanggal_pembelian = TampilTanggal();
$tanggal_pembelian = EscapeString($tanggal_pembelian);

?>
<?php
if (!LoadProdukDetail(trim($_GET['id']))) {
	die("Error: Produk id not found");
} else {
	$jumlah_beli_err = $alamat_lengkap_err = $simpan = "";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (empty(trim($_POST['jumlah_beli']))) {
			$jumlah_beli_err = "Jumlah pembelian tidak boleh kosong";
		} elseif (ValidateNumber($_POST['jumlah_beli'])) {
			$jumlah_beli_err = "Masukan jumlah pembelian dengan benar";
		} elseif ($_POST['jumlah_beli'] > $stok_produk) {
			$jumlah_beli_err = "Maaf jumlah pembelian Anda melebihi stok";
		} else {
			$jumlah_beli = FilterInput($_POST['jumlah_beli']);
			$jumlah_beli = EscapeString($jumlah_beli);
		}
		if (empty(trim($_POST['alamat_pembeli']))) {
			$alamat_pembeli_err = "Alamat pengiriman pembeli tidak boleh kosong";
		} else {
			$alamat_pembeli = FilterInput($_POST['alamat_pembeli']);
			$alamat_pembeli = EscapeString($alamat_pembeli);
		}
		if (empty($jumlah_beli_err) && empty($alamat_pembeli_err)) {
			//Insert Ke kEranjang
			if (InsertKeranjang($id_pembeli, $nama_lengkap, $alamat_pembeli, $jumlah_beli, $id, $nama_produk, $jenis_produk, $harga_produk, $satuan_produk, $foto_produk, $tanggal_pembelian)) {
				$simpan = "<div class='alert alert-success'>Produk telah di tambahkan ke keranjang. Silahkan lakukan pembayaran</div>";
				echo "<meta http-equiv=\"refresh\"content=\"2;URL=keranjang.php\"/>";
			} else {
				$simpan = "<div class='alert alert-danger'>Terjadi kesalahan silahkan coba kembali</div>";
			}
		}
	}
}

?>

<div id="content-wrapper" style="margin-bottom: 175px;">
	<div class="container">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb" style="margin-top: 35px;">
			<li class="breadcrumb-item">
				<a href="#"><i class="fas fa-shopping-cart"></i></a>
			</li>
			<li class="breadcrumb-item active">Detail Pembelian</li>
		</ol>
		<?php echo $simpan; ?>
		<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

			<div class="table-responsive">
				<table width="100%"" class=" table table-sthiped">

					<tr>
						<td>Nama produk</td>
						<td><?php echo $nama_produk; ?></td>
					</tr>
					<tr>
						<td>Jenis produk</td>
						<td><?php echo $jenis_produk; ?></td>
					</tr>
					<tr>
						<td>Harga</td>
						<td><?php echo number_format($harga_produk) . $satuan_produk; ?></td>
					</tr>
					<tr>
						<td>Jumlah Pembelian</td>
						<td>
							<div class="form-group">
								<label>Jumlah beli :</label>
								<input class="form-control" type="text" name="jumlah_beli" placeholder="Misal : 1 atau 2" required="" />
								<span style="color:red;"><?php echo $jumlah_beli_err; ?></span>
							</div>
						</td>
					</tr>
					<tr>
						<td>Nama pembeli</td>
						<td><?php echo $nama_lengkap; ?></td>
					</tr>
					<tr>
						<td>Alamat pengiriman</td>
						<td>
							<div class="form-group">
								<em style="font-size:12px; color: red; ">Anda dapat mengubah alamat pengiriman barang</em>
								<textarea class="form-control" name="alamat_pembeli" rows="5"><?php echo $alamat_lengkap; ?>
						
					</textarea>
								<span style="color:red;"><?php echo $alamat_lengkap_err; ?></span>
							</div>
						</td>
					</tr>

				</table>
			</div>
			<div class="form-group">
				<input class="btn btn-flat btn-primarytani btn-sm" type="submit" name="simpan" id="simpan" value="Simpan & Lanjutkan ke Pembayaran" />
			</div>
		</form>
	</div>
</div>

<?php
LoadFooter($nama_situs);
?>