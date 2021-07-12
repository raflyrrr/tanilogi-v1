<?php

function SessionUserCek(){
	if(!isset($_SESSION['username'])){

		return true;
	}else{
		return false;
	}
}

function SessionActive(){
	global $array;
	$array=array(
		$_SESSION['id'],
		$_SESSION['username'],
		$_SESSION['nama_lengkap'], 
		$_SESSION['no_hp'],
		$_SESSION['alamat_lengkap'],
		$_SESSION['email']
	);

}

function DeleteSession($array){
	unset($array);
	session_destroy();
	header("location:login");

}
function SessionAdminCek(){
	if(!isset($_SESSION['admin'])){

		return true;
	}else{
		return false;
	}
}
function SessionActiveAdmin(){
	global $Adminarray;
	$Adminarray=array(
		$_SESSION['id'],
		$_SESSION['nama'],
		$_SESSION['email'], 
		$_SESSION['admin'],
		$_SESSION['level']
		
	);

}
function DeleteSessionAdmin($Adminarray){
	unset($Adminarray);
	session_destroy();
	header("location:log-in.php");
}
?>