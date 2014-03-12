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
}?>
<div class="content">
    <h3 class="title">Upload Program Kerja</h3>
    <div class="notice">
        Silahkan unggah program kerja seama satu periode yang telah direncanakan. file berupa <code>.doc</code> dengan maksimal <code>2 Mb</code>
    </div>
    <form action="" role="form" enctype="multipart/form-data">
        <input type="file" name="">
        <div class="s">
            <button class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-cloud-upload"></span> Upload</button>
        </div>
    </form>
</div>