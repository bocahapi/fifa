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

<div class="content edit-form">
    <h3 class="title">Edit User</h3>
    <div class="form"></div>
</div>

<!-- Kelola User -->
<div class="content">
<h3 class="title">Kelola User</h3>
<div class="s col-md-4">
    <div class="row">
        <form action="" method="get" class="form-inline" role="form">
            <div class="s">
                <input type="hidden" class="form-control" name="page" value="kel-user">
            	<input type="text" class="form-control" name="cari" placeholder="Cari...">
            	<button type="submit" class="btn btn-primary btn-sm"> <span class="glyphicon glyphicon-search"></span>Cari</button>
            </div>
        </form>
    </div>
</div>

<table class="table table-bordered">
    <tr>
        <th>Nomor</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th class="text-center">Aksi</th>
    </tr>
    <?php
    /*
    * Query multitable antara table user dan jabatan
    */
    $sql = "SELECT * FROM user,jabatan WHERE user.id_jabatan=jabatan.id_jabatan";
    
    // untuk Pencarian
    if(isset($_GET['cari'])){

        $cari = $_GET['cari'];
        
        $sql .= " AND user.nama LIKE '%$cari%'";
    
    }else{

        $sql = $sql;
    }

    $query = $mysqli->query($sql);

    $No = 1; // Nomer urut

    /* 
    * List User dalam table
    */
    while ($users = $query->fetch_assoc()){
    echo "<tr>
            <td>{$No}</td>
            <td>{$users['nama']}</td>
            <td>{$users['jabatan']}</td>
            <td class=\"text-center\">
                <a href=\"#\" data-id=\"{$users['id_user']}\" class=\"edit\"><span  class=\"glyphicon glyphicon-pencil\"></span></a> 
                <a href=\"#\" data-id=\"{$users['id_user']}\" class=\"trash\"><span  class=\"glyphicon glyphicon-trash\"></span></a>
            </td>
        </tr>";
     $No++;   
     } ?>
</table>
</div>

<script>
$(function(){
    $('.edit').on('click',function() {

        

        var id = $(this).data('id');

        $.ajax({
            url: 'query/query.php',
            type: 'POST',
            data: {act: 'edit-user',id:id},
            beforeSend : function () {
                $('.edit-form').fadeIn('fast');
                
                $('.edit-form > .form').html('<div class="loading"></div>');
                
            },
            success:function(result){
                $('.edit-form > .form').html(result);
                $('.edit-form form').append('<div class="text-right"><div class="btn btn-primary btn-sm update">Update</div>  <div class="btn btn-sm btn-danger cancel">Batal</div></div>');

                // Cancel
                $('.cancel').on('click',function() {
                        $(this).parents('.edit-form').fadeOut('slow');
                });

                // Update
                $('.update').on('click',function() {


                    var data = $(this).parents('form').serialize();
                    
                    $.ajax({
                        url: 'query/query.php',
                        type: 'POST',
                        data: data,
                        beforeSend : function () {
                            $('.edit-form').fadeIn('fast');
                            
                            $('.edit-form > .form').html('<div class="loading"></div>');
                            
                        },
                        success:function(result) {
                            if(result == 'sukses'){
                              $('.edit-form > .form').html(result);
                              $('.edit-form').fadeOut();
                            }else{
                              $('.edit-form > .form').html(result);
                            }
                        }
                    });
                    return false;
                });

            }
        });
        return false;
    });
    
    // Delete User 
    $('.trash').on('click',function() {


        var data = $(this).data('id');

        $.ajax({
            url: 'query/query.php',
            type: 'POST',
            data: {act: 'delete-user',id:data},
            success:function(result) {
                if(result == 'sukses'){
                    location.reload(true);
                }else{
                    alert('gagal');
                }
            }
        });
        return false;
    });
});
</script>