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

<!-- Tambah User -->
<div class="content">
    <h3 class="title">Tambah User</h3>
    <form role="form" method="post" action="query/query.php">
        <table class="table-form">
            <tr>
                <td>
                    <label for="">Nama</label>
                </td>
                <td>:</td>
                <td>
                    <input type="hidden" name="act" value="add-user">
                    <input type="text" name="nama" class="form-control" placeholder="Nama">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Jabatan</label>
                </td>
                <td>:</td>
                <td>
                    <select id="" name="jabatan" class="form-control">
                    <option value="">Pilih Jabatan</option>
                    <?php
                        $sql = "SELECT * FROM jabatan";
                        $jabatan = $mysqli->query($sql);
                        while ( $content = $jabatan->fetch_assoc() ) {
                            echo "<option value=\"{$content['id_jabatan']}\">{$content['jabatan']}</option>";
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Username</label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Password</label>
                </td>
                <td>:</td>
                <td>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </td>
            </tr>
        </table>
        <div class="text-right">
            <div class="btn btn-primary">Simpan</div>
        </div>
    </form>
</div>

<script>
    $(function(){
        
         $('div.btn').click(function(){
            var name = $('[name|="nama"]');
            var jabatan = $('select');
            var username = $('[name|="username"]');
            var password = $('[name|="password"]');

            if(name.val() =='' || name.val().length < 3){
                alert('kurang dari 3');
                //stop();
            }else if(jabatan.val() == ''){
                alert('belum dipilih');
                //stop();
            }else if(username.val() == '' || username.val().length < 3){
                alert('username kosong / kurang dari 3');
                //stop();
            }else if(password.val() == '' || password.val().length < 3){
                alert('password salah');
            }else{
                $(this).parents('form').trigger('submit');
            }
         });
    });
</script>