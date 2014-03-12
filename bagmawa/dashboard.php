<?php
require_once('header.php');
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

require_once('sidebar.php');
?>

            <div class="col-md-10 col-sm-9 contain col-md-offset-2 col-sm-offset-3">
                
            <?php require_once('bagmawa-nav.php');?>
            </div>
 <?php
 require_once('footer.php');?>