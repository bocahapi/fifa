<?php
/*
* jika UMS tidak definiskan terlebih dahulu maka proses akan dihentikan.
*/
if(!defined('UMS')){

	die();
}
# Koneksi ke database
$mysqli = mysqli_connect(HOST_NAME,DB_USER,DB_PASS,DB_NAME);

# pengecekkan koneksi
if(mysqli_connect_errno($mysqli)){

	# jika Koneksi gagal
	echo "Maaf tidak bisa tersambung dengan Database".mysqli_connect_error();

}else{

	# jika koneksi berhasil
	//echo "anda tersambung";
}

# Set Variabel Direktori 
require_once('dir.php');
