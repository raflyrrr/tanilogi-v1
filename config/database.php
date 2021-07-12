<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS','');
define('DB_NAME','tanilogi');
$koneksi= new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if($koneksi==false){
	die("Gagal melakukan koneksi ke database :".$koneksi->connect_error());
}
$secret_key='X09AzX39Rt0oId0c';
$secret_panel='c0dIo0tR93XzA90X';
?>