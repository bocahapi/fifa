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
        <?php
        $no =1;
        $sql = "SELECT * FROM kelola_dana,jenis_dana WHERE kelola_dana.id_jenis = jenis_dana.id_jenis AND kelola_dana.id_user='$usr_id' ORDER BY tgl_kelola_dana DESC";
        $query = $mysqli->query($sql);
        while ($rekap = $query->fetch_assoc()) {
            echo "<tr>"
                 ."<td>{$no}</td>"
                 ."<td>{$rekap['tgl_kelola_dana']}/{$rekap['tahun']}</td>"
                 ."<td>{$rekap['nama_jenis']}</td>"
                 ."<td>{$rekap['jenis_kegiatan']}</td>"
                 ."<td class=\"text-right\">Rp. ".number_format($rekap['input_dana'],0,',','.')."</td>"
                 ."</tr>";
            $no++;
        }
        
        ?>
    </table>
</div>