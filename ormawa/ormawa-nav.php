<?php
/*
* Pengecekan Definisi UMS
*/
if(!defined('UMS')){
    header('location:./../404.html');
}

# Jika user belum login maka user dialihkan kehalaman login
if( !isset($_SESSION['login'])) {
    header('location:./../');
}

if(!isset($_GET['page'])){

	$page ='';

}else{
	$page = $_GET['page'];

}

if( $page == '' ){
	
	require_once('upload.php');

}else{
	/*
	* Check ada spesial karakter atau tidak, jika ada akan di hapus
	* ref : http://stackoverflow.com/questions/14114411/remove-all-special-characters-from-a-string
	*/
	$page = preg_replace('/[^a-z\-]/','', $page);

	if(file_exists($page.'.php')){
		require_once($page.'.php');
	}else{
		echo "Maaf Dokument yang anda maksud belum dibuat";
	}
}
?>