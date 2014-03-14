<?php
/*
* jika UMS tidak definiskan terlebih dahulu maka proses akan dihentikan.
*/
if(!defined('UMS')){
	die();
}

/*
* deklarasi direktori kedalam variable / fungsi define,
*/
$site = home_url();

/* main direktori */
function home_url(){

	$main = $_SERVER['SERVER_NAME'];// Folder Main

	$get_main  = explode('/', $_SERVER['REQUEST_URI']);

	$main_site = $get_main[1];// Get Array Terakhir

	# mengechek main site yang dituju file/folder
	$check = strpos($main_site, '.');

	if($check){
	
		$main_site ='';
	}

	$protocol  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://' ;
	
	$site_main = $protocol.$main.'/'.$main_site;
	return $site_main;
}


# auto Update Name Site
$stmt = $mysqli->prepare("UPDATE link SET url = ? WHERE name= 'site' ");
$stmt->bind_param('s',$site);
$stmt->execute();
$stmt->close();


$Query = $mysqli->query("SELECT url FROM link WHERE name= 'site' ");

$sites = $Query->fetch_assoc();
$url   = $sites['url'];

$main_root = dirname(dirname(__FILE__));

/* Direktori */
function the_core(){
	global $url;
	return $url.'/core';
}

function Upload(){
	global $main_root;
	return $main_root.'/upload';
}


/* Jquery File Script */
function get_js($param = 'jquery'){
$js = array(
	'jquery'   =>'jquery.min.js',
	'custom' =>'custom.js',
	'bootstrap'=>'bootstrap.min.js'
	);
	
	$javascript = the_core().'/js/'.$js[$param];
	print $javascript;
}

# CSS Script direktori
function stylesheet($parameter = 'master.css'){
	$stylesheet = the_core().'/css/'.$parameter;

	print $stylesheet;
}

/*
* Enkripsi
*/

function CryptPass($pass){

	/* Membuat password Enkripsi */
	$key  = md5($pass);
	$pass = '/'.$pass;
	$encrypt = base64_encode($key.$pass);

	return $encrypt;
}
/*
* Deskripsi password
* @param $passHash diambil dari database
*/
function Descryption($passHash){
	$passDesc = base64_decode($passHash);
	$pass = explode('/', $passDesc);
	print $pass[1];
}

function footer(){
	global $credit;
	echo $credit;
}

