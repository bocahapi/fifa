<?php
if(!isset($_POST['user'])){
	header('location:404.html');
}

session_start();
require_once('fa-config.php');

/*
* Check Login
*/
$user = $_POST['user'];
$pass = $_POST['pass'];

	$user = htmlspecialchars($user);
	$pass = htmlspecialchars($pass);


	/* Membuat password Enkripsi */
	$password = CryptPass($pass);

	/*
	* Untuk Mendeskripsi
	* gunakan Descryption($pass), $pass diambil dari database
	*/
	$sql   = "SELECT * FROM user WHERE username = '$user' AND password = '$password' "; 
	$check = $mysqli->query($sql);

	if($check->num_rows == 1){

		$get_lvl = $check->fetch_assoc();
		$lvl_id = $get_lvl['id_jabatan'];

		# Check Level User
		$stmt = $mysqli->prepare("SELECT jabatan FROM jabatan WHERE id_jabatan = ?");
		$stmt->bind_param('i',$lvl_id);
		$stmt->execute();
		$stmt->bind_result($lvl);
		$stmt->fetch();
		$stmt->close();

		$level = strtolower($lvl);

		# Membuat Session
		$_SESSION['login'] = true;

		$_SESSION['level'] = $level;

		#menuju halaman Panel
		print($level.'/dashboard.php?#');

	}else{

		print('error');

	}

