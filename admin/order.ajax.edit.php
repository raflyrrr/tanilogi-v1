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

	if(!OrderDetail(trim($_POST['update_id']))){		
		die ("Data tidak ditemukan");
	}
}


$arrayD=array(
	0=>"$id",'id'=>"$id",
	1=>"$status_pengiriman",'status_pengiriman'=>"$status_pengiriman",
	2=>"$status_pembayaran",'status_pembayaran'=>"$status_pembayaran"
);
echo json_encode($arrayD);
?> 
   
