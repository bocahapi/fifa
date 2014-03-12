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
<h3 class="title">Lihat Proker</h3>
<table class="table table-bordered">
    <tr>
        <th>Nomor</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th class="text-center">Date</th>
        <th class="text-center">Aksi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>BEM FKI</td>
        <td>BEM</td>
        <td class="text-center">25/2/13</td>
        <td class="text-center">
            <span class="glyphicon glyphicon-pencil"></span>|
            <span class="glyphicon glyphicon-trash"></span>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>BEM FKI</td>
        <td>BEM</td>
        <td class="text-center">25/2/13</td>
        <td class="text-center">
            <span class="glyphicon glyphicon-pencil"></span>|
            <span class="glyphicon glyphicon-trash"></span>
        </td>
    </tr>
</table>
</div>