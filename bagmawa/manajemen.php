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

        <!-- Manajemen Jenis Dana -->
                <div class="content">
                    <h3 class="title">Manajemen Jenis Data</h3>
                    <!-- Tab Menu -->
                    <ul class="nav nav-tabs" id="navigations">
                      <li class="active"><a href="#home" data-toggle="tab">Nama Jenis Dana</a></li>
                      <li><a href="#profile" data-toggle="tab">Sub Jenis Dana</a></li>
                    </ul>

                    <div class="tab-content">
                      <div class="tab-pane fade in active" id="home">
                        <div class="row">
                            <div class="form-group">
                                <form action="query/query.php" method="post" class="col-md-5 s">
                                    <input type="hidden" name="act" value="jd">
                                    <input type="text" name="jenis_dana" class="form-control" placeholder="placeholder"><br>
                                    <button class="btn btn-primary btn-sm">Simpan</button>
                                </form>
                            </div>
                        </div>
                      </div>
                      
                      <div class="tab-pane fade" id="profile">
                        <div class="row">
                           <div class="form-group">
                                <form action="query/query.php" method="post" class="col-md-5 s">
                                  <input type="hidden" name="act" value="sd">
                                   <select name="jenis_dana" id="" class="form-control">
                                       <option value="">Pilih Jenis Dana</option>
                                       <?php
                                       $stmt = $mysqli->query("SELECT * FROM jenis_dana");
                                       while($jenis_dana = $stmt->fetch_assoc()){
                                        echo "<option value=\"{$jenis_dana['id_jenis']}\">{$jenis_dana['nama_jenis']}</option>"; 
                                       }
                                       $stmt->free();
                                       ?>
                                   </select> <br>
                                   <select name="sub_dana" id="" class="form-control">
                                       <option value="Nalar">Nalar</option>
                                       <option value="Non Nalar">Non Nalar</option>
                                       <option value="Reor">Reor</option>
                                   </select> <br>
                                   <button class="btn btn-primary btn-sm">Simpan</button>
                               </form>
                           </div>
                        </div>
                      </div>
                    </div>
                    <!-- Tab Menu -->
                    <hr>
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Jenis Dana</th>
                            <th>Sub Jenis Dana</th>
                            <th class="text-center">Aksi</th>
                        </tr>


                        <?php
                        $listing = $mysqli->query("SELECT * FROM jenis_dana,sub_dana WHERE jenis_dana.id_jenis = sub_dana.id_jenis");
                        while ($list = $listing->fetch_assoc()) {
                          echo "<tr>
                            <td>{$list['nama_jenis']}</td>
                            <td>{$list['nama_sub']}</td>
                            <td class=\"text-center\">
                                <a href=\"#\" data-id=\"{$list['id_sub']}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>
                                <a href=\"#\" data-id=\"{$list['id_sub']}\"><span class=\"glyphicon glyphicon-trash\"></span></a>
                            </td>
                        </tr>
                        ";
                        }
                        $listing->free();
                        ?>                        
                    </table>
                </div>