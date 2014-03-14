<?php
session_start();
/*
* Check sudah login atau belum
*/
if(!isset($_SESSION['login'])){
	header('location:./../');
}
if($_SESSION['level'] != 'ormawa'){
	header('location:./../404.html');
}
$usr_id = $_SESSION['id'];
require_once('../fa-config.php');
$usr = $mysqli->query("SELECT nama FROM user WHERE id_user = '$usr_id'");
$the_name = $usr->fetch_assoc();
$get_name = $the_name['nama'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Page{ <?php echo $_SESSION['level'];?> }</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="<?php stylesheet('web-style.css'); ?>">
    <script src="<?php get_js('jquery');?>"></script>
</head>

<body>
    <div class="col-md-12 header">
    </div>

    <div class="col-md-12">
        <div class="row">