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
$OrderTampil = OrderTampil();
$OrderSelesai = OrderSelesai();
?>
<div id="content-wrapper">
  <div class="container-fluid">
    <?php
    if (!isset($_GET['order'])) {
      $_GET['order'] = '';
    }

    if ($_GET['order'] == 'selesai') {
      echo '
    <div>
    <h4>Pesanan Selesai</h4>
    </div>
    <br/>
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="0">
    <thead>
    <tr>
    <th>No</th>
    <th>Nama Pembeli</th>
    <th>Nama Barang</th>
    <th>Jumlah Pembelian</th>
    <th>Aksi</th>   
    </tr>
    </thead>
    <tbody>
    ';

      if ($OrderSelesai->num_rows > 0) {

        $no = 1;
        while ($row = $OrderSelesai->fetch_array()) {
          echo '
      <tr>
      <td>' . $no . '</td>
      <td>' . $row['nama_pembeli'] . '</td>
       <td>' . substr($row['nama_produk'], 0, 10) . '</td>
      <td>' . $row['jumlah_beli'] . '' . $row['satuan_produk'] . '</td>
      <td>
      <a href="#" name="update" id="' . $row['id'] . '" class="update_data"><i class="fas fa-edit fa-fw small" alt="Edit" title="Edit"></i></a>
      <a href="#" data-target="#confirm-detail" id="' . $row['id'] . '" class="lihat_data"><i class="fa fa-eye fa-fw small" alt="Detail" title="Detail order"></i></a>
      </td>
  
      
      
      ';
          $no++;
        }
      } else {

        echo '
    <tr>
    <td colspan="7" align="center">
    Belum ada pesanan yang diselesaikan</td>
    </tr>

    ';
      }
      echo '

    </tbody>
    </table>
    </div>
    ';
      $OrderSelesai->free_result();
    } else {



      echo '
    <div>
      <h4>Semua pesanan</h4>
    </div>
    <br/>
    <div id="tbl_order">
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="0">
    <thead>
    <tr>
    <th>No</th>
    <th>Nama Pembeli</th>
    <th>Nama Barang</th>
    <th>Status Pembayaran</th>
    <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    ';

      if ($OrderTampil->num_rows > 0) {

        $no = 1;
        while ($row = $OrderTampil->fetch_array()) {
          echo '
      <tr>
      <td>' . $no . '</td>
      <td>' . $row['nama_pembeli'] . '</td>
      <td>' . $row['nama_produk'] . '</td>   
      <td>' . $row['status_pembayaran'] . '</td>
      <td>
       <a href="#" name="update" id="' . $row['id'] . '" class="update_data"><i class="fas fa-edit fa-fw small" alt="Edit" title="Edit"></i></a>
       <a href="#" data-target="#confirm-detail" id="' . $row['id'] . '" class="lihat_data"><i class="fa fa-eye fa-fw small" alt="Detail" title="Detail order"></i></a>
       <a href="deletePesanan.php?id='.$row['id'].'" onClick=\'alert("Pesanan berhasil dihapus");\' title="Delete Pesanan Produk"><i class="fas fa-fw fa-trash"></i></a>
       </td>
     
      
      ';
          $no++;
        }
      } else {

        echo '
    <tr>
    <td colspan="7" align="center">
    Belum ada pesanan yang masuk</td>
    </tr>

    ';
      }
      echo '

    </tbody>
    </table>
    </div>
    </div>
    ';

      $OrderTampil->free_result();
    }

    ?>


  </div>
</div>
<?php
LoadFooterPanel();
?>