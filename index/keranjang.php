<?php
require_once '../function/ap.session.php';
session_start();
if (SessionUserCek()) {
	header("location:login");
} else {

	SessionActive();
	$id_pel = $array[0];
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
$KeranjangTampil = KeranjangTampil($id_pel);
$KeranjangRiwayat = KeranjangRiwayat($id_pel);
?>
<div id="content-wrapper" style="margin-bottom:28%;">
	<div class="container">
		<!-- Breadcrumbs-->
		
		<?php

		if (!isset($_GET['keranjang'])) {
			$_GET['keranjang'] = '';
		}

		if ($_GET['keranjang'] == 'riwayat') {
			echo '
		<h4 style="margin-top: 30px; margin-bottom:15px;">Riwayat Belanja</h4>
		<div class="row">
		<div class="table-responsive">
		<table width="100%"" class="table table-sthiped table-bordered table-hover">
		
		<tr>
		<th>No</th>
		<th>Nama Produk</th>
		<th>Jumlah Pembelian</th>
		<th>Status Pengiriman</th>
		<th>Status</th>
		</tr>
		
		';

			if ($KeranjangRiwayat->num_rows > 0) {

				$no = 1;
				while ($row = $KeranjangRiwayat->fetch_array()) {
					echo '
			<tr>
			<td>' . $no . '</td>
			<td>' . $row['nama_produk'] . '</td>
			<td>' . $row['jumlah_beli'] . '' . $row['satuan_produk'] . '</td>
			<td>' . $row['status_pengiriman'] . '</td>
			<td>					
			';
					if ($row['status_pembayaran'] == 'Menunggu Pembayaran') {
						echo '
			<a class="btn btn-primary btn-info btn-sm" href="?keranjang=bayar&id=' . $row['id'] . '">Lanjutkan Pembayaran</a>
			';
					} elseif ($row['status_pembayaran'] == 'Lunas') {
						echo '
			<a class="btn btn-primary btn-success btn-sm" href="#"=' . $row['id'] . '">Lunas</a>
			';
					} elseif ($row['status_pembayaran'] == 'Belum Diverifikasi') {
						echo '
			<a class="btn btn-primary btn-sm" href="#"=' . $row['id'] . '">Belum Diperiksa</a>
			';
					}
					echo '
					<a title="Lihat" href="?keranjang=detail&id=' . $row['id'] . '" class="btn btn-sm btn-primarytani"><i class="fas fa-eye"></i> Detail</a>
			</td>
			';
					$no++;
				}
			} else {

				echo '
		<tr>
		<td colspan="5" align="center">
		Tidak ada riwayat pesanan.</td>
		</tr>

		';
			}
			echo '

		</tbody>
		</table>
		</div>

		<!-Row-->		
		</div>
		';
			$KeranjangRiwayat->free_result();
		} elseif ($_GET['keranjang'] == 'bayar') {
			/*Menampilkan data pemesanan pada kernajang */
			if (!KeranjangDetail(trim($_GET['id']))) {
				die("Error: id produk not found");
			} else {
				if ($status_pembayaran != 'Menunggu Pembayaran') {
					echo "<meta http-equiv=\"refresh\"content=\";URL=keranjang.php\"/>";
				}
			}
			/*POST DATA KONFIRMASI PEMBAYARAN */
			$simpan = "";
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if (empty(trim($_POST['konfirmasi']))) {
					$konfirmasi_err = "Konfirmasi harus dicentang";
				}
				if (empty(trim($_POST['status_pembayaran']))) {
					die("Error: Percobaan manipulasi data terdeteksi");
				} elseif ($_POST['status_pembayaran'] != 'Belum Diverifikasi') {
					die("Error: Percobaan manipulasi data terdeteksi");
				} else {
					$status_pembayaran = FilterInput($_POST['status_pembayaran']);
					$status_pembayaran = EscapeString($status_pembayaran);
				}
				if (empty($konfirmasi_err)) {
					if (KonfirmasiBayar($status_pembayaran, $id)) {
						$simpan = "<div class='alert alert-success'>Terima kasih sudah melakukan pembayaran. Kami akan segera proses, untuk mempercepat proses konfirmasi bisa Hubungi kontak yang tersedia</div>";
						echo "<meta http-equiv=\"refresh\"content=\"3;URL=keranjang.php\"/>";
					} else {
						$simpan = "<div class='alert alert-danger'>Terjadi kesalahan silahkan coba kembali</div>";
					}
				}
			}
			echo $simpan;
			echo '
<div class="row mt-5">      
	<div class="col-md-6 col-sm-6">
			<div class="table-responsive">
				<table width="100%"" class="table table-sthiped">
				
					<tr>
					<td colspan=2><h4>Informasi Pembayaran</h4></td>
					</tr>
					<tr>
						<td>Nama produk</td>
						<td>' . $nama_produk . '</td>
					</tr>
					<tr>
						<td>Jumlah Beli</td>
						<td>' . $jumlah_beli . '' . $satuan_produk . '</td>
						</tr>
					<tr>
						<td>Harga</td>
						<td>' . number_format($harga_produk) . '' . $satuan_produk . '</td>
					</tr>
					<tr>
						<td><b>Total</b></td>
						<td><b>Rp. ' . number_format($jumlah_beli * $harga_produk) . '</b></td>
					</tr>


				</table>
			</div><br/><br/>
	</div>
	<div class="col-md-6 col-sm-6">
			<h4>Intruksi Pembayaran</h4>
			<p>Silahkan melakukan pembayaran ke rekening berikut: </p>
			<ol>
			<li>Bank BCA : 123123 atas nama <b>Tanilogi</b></li>
			<li>Bank Mandiri : 123123 atas nama <b>Tanilogi</b></li>
			</ol>
			<p>Jika sudah melakukan pembayaran. Klik konfirmasi pembayaran</p>
	<form action=' . htmlspecialchars(basename($_SERVER['REQUEST_URI'])) . ' method="post">
	
		<div class="form-check">
		<input type="checkbox" class="check-input" name="konfirmasi" required="">
		<label class="form-check-label" style="font-size:12px;">Dengan ini saya mengkonfirmasi bahwa saya sudah melakukan pembayaran</label>
		</div>

		<div class="form-group">
		<input type="hidden" name="status_pembayaran" id="status_pembayaran" value="Belum Diverifikasi">

		<input type="submit" class="btn btn-primarytani btn-sm mt-3 ml-3" name="konfirmasi_bayar" id="konfirmasi_bayar" value="Konfirmasi">
		</div>

	</form>		
	</div>

	<!--Row-->
</div>
';
		} elseif ($_GET['keranjang'] == 'detail') {
			if (!KeranjangDetail(trim($_GET['id']))) {
				die("Error: id produk not found");
			}
			echo '
	<div class="table-responsive mt-5">
		<table width="100%"" class="table table-sthiped">
		
			<tr>
			<td colspan="2"><b>Informasi pengiriman</b></td>
			</tr>
			
			<tr>
				<td>Nama pembeli</td>
				<td>' . $nama_lengkap . '</td>
			</tr>
			<tr>
				<td>Alamat pengiriman</td>
				<td>' . $alamat_pembeli . '</td>
			</tr>
			<tr>
			<td colspan="2"><b>Informasi produk</b></td>
			</tr>
			<tr>
				<td>Nama produk</td>
				<td>' . $nama_produk . '</td>
			</tr>
			
			<tr>
				<td>Jenis produk</td>
				<td>' . $jenis_produk . '</td>
				</tr>
			<tr>
				<td>Harga</td>
				<td>' . number_format($harga_produk) . '' . $satuan_produk . '</td>
			</tr>
			<tr>
				<td>Jumlah Pembelian</td>
				<td>' . $jumlah_beli . '' . $satuan_produk . '</td>
			</tr>
			<tr>
				<td><b>Total bayar</b></td>
				<td><b>Rp. ' . number_format($jumlah_beli * $harga_produk) . '</b></td>
			</tr>
			<tr>
			<td colspan="2"><b>Status</b></td>
			</tr>
			<tr>
				<td>Status Pembayaran</td>
				<td>' . $status_pembayaran . '</td>
			</tr>
			<tr>
				<td>Status Pengiriman</td>
				<td>' . $status_pengiriman . '</td>
			</tr>
			
		</table>
		</div>

	';
		} else {



			echo '
		<h4 style="margin-top: 30px; margin-bottom:15px;">Keranjang</h4>
		<div class="row">
		<div class="table-responsive">
		<table width="100%"" class="table table-sthiped table-bordered table-hover">
		
		<tr>
		<th>No</th>
		<th>Nama Produk</th>
		<th>Jumlah Pembelian</th>
		<th>Status Pengiriman</th>
	
		<th>Status</th>
		</tr>
		
		';

			if ($KeranjangTampil->num_rows > 0) {

				$no = 1;
				while ($row = $KeranjangTampil->fetch_array()) {
					echo '
			<tr>
			<td>' . $no . '</td>
			<td>' . $row['nama_produk'] . '</td>
			<td>' . $row['jumlah_beli'] . '' . $row['satuan_produk'] . '</td>
			<td>' . $row['status_pengiriman'] . '</td>
		
			<td>

			';

					if ($row['status_pembayaran'] == 'Menunggu Pembayaran') {
						echo '
			<a class="btn btn-primary btn-info btn-sm" href="?keranjang=bayar&id=' . $row['id'] . '">Lanjutkan Pembayaran</a>
			';
					} elseif ($row['status_pembayaran'] == 'Lunas') {
						echo '
			<a class="btn btn-primary btn-success btn-sm" href="#"=' . $row['id'] . '">Lunas</a>
			';
					} elseif ($row['status_pembayaran'] == 'Belum Diverifikasi') {
						echo '
			<a class="btn btn-primary btn-sm" href="#"=' . $row['id'] . '">Belum Diperiksa</a>
			';
					}

					echo '
			<a title="Lihat" href="?keranjang=detail&id=' . $row['id'] . '" class="btn btn-sm btn-primarytani"><i class="fas fa-eye"></i> Detail</a>
			</td>
			';
					$no++;
				}
			} else {

				echo '
		<tr>
		<td colspan="5" align="center">
		Tidak ada produk didalam keranjang.</td>
		</tr>

		';
			}
			echo '

		</tbody>
		</table>
		</div>
		</div>
		';
			$KeranjangTampil->free_result();
		}

		?>


	</div>
</div>
<?php
LoadFooter($nama_situs);
?>