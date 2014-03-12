<?php
session_start();
/*
* membuat definisi login
* ref : http://pqcms.blogspot.com/2008/10/melindung-akses-secara-langsung-pada.html
*/
define('Login',true);

# check user sudah login atau belum
if(!isset($_SESSION['login'])){
	
	# jika Belum login, maka form login
	require_once('fa-login.php');

}else{

	# jika sudah login, maka masuk halaman panel
	header('location:'.$_SESSION['level'].'/dashboard.php');
}

