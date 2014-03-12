<?php
session_start();
/*
* Check sudah login atau belum
*/
if(!isset($_SESSION['login'])){
	header('location:./../');
}
if($_SESSION['level'] != 'bagmawa'){
	header('location:./../404.html');
}
require_once('../fa-config.php');

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