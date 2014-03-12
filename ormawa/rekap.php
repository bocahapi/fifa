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
    <h3 class="title">Rekap Penggunaan Dana</h3>
    <table class="table table-bordered">
        <tr>
            <th>Nomor</th>
            <th>Tanggal</th>
            <th>Jenis Dana</th>
            <th>Jenis Kegiatan</th>
            <th>Penggunaan Dana</th>
        </tr>
        <tr>
            <td>1</td>
            <td>15/3/13</td>
            <td>Operasional</td>
            <td>Seminar Teknologi</td>
            <td>Rp. 1.000.000</td>
        </tr>
        <tr>
            <td>2</td>
            <td>15/3/13</td>
            <td>Operasional</td>
            <td>Seminar Teknologi</td>
            <td>Rp. 1.000.000</td>
        </tr>

    </table>
</div>