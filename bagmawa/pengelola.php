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
?>

<!-- Pengelolaan Dana -->
                <div class="content">
                    <h3 class="title">Pengelolaan Dana</h3>
                    <form action="" role="form">
                        <table class="table-form">
                            <tr>
                                <td>User</td>
                                <td>:</td>
                                <td>
                                    <select name="" id="" class="form-control input-sm">
                                        <option value="#">BEM</option>
                                        <option value="#">BEM</option>
                                        <option value="#">BEM</option>
                                        <option value="#">BEM</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Dana</td>
                                <td>:</td>
                                <td>
                                    <select name="" id="" class="form-control input-sm">
                                        <option value="#">Operasional BEM</option>
                                        <option value="#">Penelitian dan Pengapdian Masyarakat</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="s text-right">
                            <button class="btn btn-primary btn-sm">Lihat</button>
                        </div>
                    </form>

                    <hr>
                    <form action="" role="form">
                        <table class="table-form">
                            <tr>
                                <th colspan="3">Nalar</th>
                            </tr>
                            <tr>
                                <td>Jenis Kegiatan</td>
                                <td>:</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="placeholder">
                                </td>
                            </tr>
                            <tr>
                                <td>Input Dana</th>
                                <td>:</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="placeholder">
                                </td>
                            </tr>

                            <tr>
                                <th colspan="3">Non Nalar</th>
                            </tr>
                            <tr>
                                <td>Jenis Kegiatan</td>
                                <td>:</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="placeholder">
                                </td>
                            </tr>
                            <tr>
                                <td>Input Dana</td>
                                <td>:</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="placeholder">
                                </td>
                            </tr>

                            <tr>
                                <th colspan="3">Reor</th>
                            </tr>
                            <tr>
                                <td>Jenis Kegiatan</td>
                                <td>:</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="placeholder">
                                </td>
                            </tr>
                            <tr>
                                <td>Input Dana</td>
                                <td>:</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="placeholder">
                                </td>
                            </tr>
                        
                        </table>
                        <div class="s text-right">
                            <button class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>

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