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

if(isset($_POST["update_id"])){
    if(empty(trim($_POST['update_id']))){
        die("Error: Nilai id data error");
    }else{
        $update_id=FilterInput($_POST['update_id']);
        $update_id=EscapeString($update_id);
    }
    if(empty(trim($_POST['status_pengiriman']))){
        die("Error: Status pengiriman tidak dapat ditemukan");
    }else{
        $status_pengiriman=FilterInput($_POST['status_pengiriman']);
        $status_pengiriman=EscapeString($status_pengiriman);
    }
    if(empty(trim($_POST['status_pembayaran']))){
        die("Error: Status pembayaran error");
    }else{
        $status_pembayaran=FilterInput($_POST['status_pembayaran']);
        $status_pembayaran=EscapeString($status_pembayaran);
    }
    if(OrderUpdate($status_pengiriman, $status_pembayaran, $update_id)){
      $OrderTampil=OrderTampil();
      if($OrderTampil->num_rows>0){
                echo '

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

                $no=1;
                while($row=$OrderTampil->fetch_array()){
                        echo'
                        <tr>
                        <td>'.$no.'</td>
                        <td>'.$row['nama_pembeli'].'</td>
                        <td>'.$row['nama_produk'].'</td>   
                        <td>'.$row['status_pembayaran'].'</td>
                        <td>
                         <a href="#" name="update" id="'.$row['id'].'" class="update_data"><i class="fas fa-edit fa-fw small" alt="Edit" title="Edit"></i></a>
                         <a href="#" data-target="#confirm-detail" id="' . $row['id'] . '" class="lihat_data"><i class="fa fa-eye fa-fw small" alt="Detail" title="Detail order"></i></a>
                         </td>                 
                        ';
                        $no++;
                }
                echo '
                        </tbody>
                        </table>
                        </div>
                ';
            }    
                


  }else{
    die("error");
  }
    
 }
   


    