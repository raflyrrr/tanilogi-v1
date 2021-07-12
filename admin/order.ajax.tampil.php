<?php
  require_once '../function/ap.session.php';
  session_start();
  if(SessionAdminCek()){
      header("location:log-in.php");
      }else{
      SessionActiveAdmin();
    
  }
  
?>
<?php
    require_once '../config/database.php';
    require_once '../function/ap.admin.php';        
?>
<?php
if(isset($_POST["detail_order"])){
		 if(!OrderDetail(trim($_POST["detail_order"]))){
		    die("error");
		 }

 }
 echo "<div class='table-responsive'>";  
      echo "<table width='100%' class='table table-bordered'>";  
           
                echo "<tr>";  
                echo "<td>Order ID</td>";  
                echo  "<td>".$id."</td>";  
                echo "</tr>";  
                echo "<tr>";  
                echo "<td>Nama Pembeli</td>";  
                echo  "<td>".$nama_pembeli."</td>";  
                echo "</tr>";  
                echo "<tr>";  
                echo "<td>Alamat</td>";  
                echo  "<td>".$alamat_pembeli."</td>";  
                echo "</tr>";
                echo "<tr>";  
                echo "<td>Jumlah Pembelian</td>";  
                echo  "<td><b>".$jumlah_beli."</b></td>";  
                echo "</tr>";
                echo "<tr>";  
                echo "<td>Nama Produk</td>";  
                echo  "<td>".$nama_produk."</td>";  
                echo "</tr>";
                echo "<tr>";  
                echo "<td>Jenis Produk</td>";  
                echo  "<td>".$jenis_produk."</td>";  
                echo "</tr>";
                echo "<tr>";  
                echo "<td>Harga Produk</td>";  
                echo  "<td>".$harga_produk."".$satuan_produk."</td>";  
                echo "</tr>";
                echo "<tr>";  
                echo "<td>Status Pengiriman</td>";  
                echo  "<td>".$status_pengiriman."</td>";  
                echo "</tr>";
                echo "<tr>";  
                echo "<td>Status Pembayaran</td>";  
                echo  "<td>".$status_pembayaran."</td>";  
                echo "</tr>";
                 $exTgl=explode("-", $tanggal); 
                echo "<tr>";  
                echo "<td>Tanggal Beli</td>";  
                echo  "<td>".$tanggal_pembelian."/".$exTgl[2]."</td>";  
                echo "</tr>";                    
                echo "<tr>";  
                echo "<td>Total Bayar</td>";  
                echo  "<td><b>".number_format($harga_produk * $jumlah_beli)."<b></td>";  
                echo "</tr>";
                
                
       
      echo "</table>";
      echo "</div>";  
     
 ?>