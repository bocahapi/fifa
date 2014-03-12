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
<h3 class="title">Infomasi Dana</h3>
<div class="clearfix">
   <div class="row">
        <form action="" role="form" class="col-md-4">
                  
                       <select name="" id="" class="form-control input-sm">
                           <option value="#">Operasional BEM</option>
                           <option value="#">Penelitian dan Pengapdian Masyarakat</option>
                       </select>
       
           <div class="s text-right">
               <button class="btn btn-primary">Lihat</button>
           </div>
       </form>
   </div>
</div>

<hr>
    <table class="table-form">
        <tr>
            <th colspan="3">Nalar</th>
        </tr>
        <tr>
            <td>Jumlah Total Dana</td>
            <td>:</td>
            <td>
                <input type="text" class="form-control" placeholder="placeholder">
            </td>
        </tr>
        <tr>
            <td>Dana Pakai</th>
            <td>:</td>
            <td>
                <input type="text" class="form-control" placeholder="placeholder">
            </td>
        </tr>
        <tr>
            <td>Sisa Dana</th>
            <td>:</td>
            <td>
                <input type="text" class="form-control" placeholder="placeholder">
            </td>
        </tr>

        <tr>
            <th colspan="3">Non Nalar</th>
        </tr>
        <tr>
            <td>Jumlah Total Dana</td>
            <td>:</td>
            <td>
                <input type="text" class="form-control" placeholder="placeholder">
            </td>
        </tr>
        <tr>
            <td>Dana Pakai</th>
            <td>:</td>
            <td>
                <input type="text" class="form-control" placeholder="placeholder">
            </td>
        </tr>
        <tr>
            <td>Sisa Dana</th>
            <td>:</td>
            <td>
                <input type="text" class="form-control" placeholder="placeholder">
            </td>
        </tr>

        <tr>
            <th colspan="3">Reor</th>
        </tr>
        <tr>
            <td>Jumlah Total Dana</td>
            <td>:</td>
            <td>
                <input type="text" class="form-control" placeholder="placeholder">
            </td>
        </tr>
        <tr>
            <td>Dana Pakai</th>
            <td>:</td>
            <td>
                <input type="text" class="form-control" placeholder="placeholder">
            </td>
        </tr>
        <tr>
            <td>Sisa Dana</th>
            <td>:</td>
            <td>
                <input type="text" class="form-control" placeholder="placeholder">
            </td>
        </tr>
    
    </table>

<hr>
<table class="table table-bordered">
    <tr>
        <th>Nomor</th>
        <th class="text-center">Tanggal</th>
        <th>User</th>
        <th>Jenis Dana</th>
        <th class="text-center">Aksi</th>
    </tr>
    <tr>
        <td>1</td>
        <td class="text-center">25/2/13</td>
        <td>BEM FKI</td>
        <td>Operasional</td>
        <td class="text-center">
            <a href="#"><span class="glyphicon glyphicon-eye-open"></span></a>
            <a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
            <a href="#"><span class="glyphicon glyphicon-trash"></span></a>
        </td>
    </tr>
</table>
</div>