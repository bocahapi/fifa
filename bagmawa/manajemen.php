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
      <li class="active"><a href="#jenis-dana" data-toggle="tab">Nama Jenis Dana</a></li>
      <li><a href="#sub-dana" data-toggle="tab">Sub Jenis Dana</a></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane fade in active" id="jenis-dana">
        <div class="row">
            <div class="form-group">
            <br>
                <form action="query/query.php" method="post" class="col-md-5 s">
                    <input type="hidden" name="act" value="jd">
                    <input type="text" name="jenis_dana" class="form-control" placeholder="Nama Jenis Dana"><br>
                    <button class="btn btn-primary btn-sm">Simpan</button>
                </form>
            </div>
        </div>
      </div>
      
      <div class="tab-pane fade" id="sub-dana">
        <div class="row">
           <div class="form-group">
           <br>
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
            <td class=\"text-center aksi\">
                <a href=\"#\" data-id=\"{$list['id_sub']}-{$list['id_jenis']}\" data-act=\"men-edit\"><span class=\"glyphicon glyphicon-pencil\"></span></a>
                <a href=\"#\" data-id=\"{$list['id_sub']}-{$list['id_jenis']}\" data-act=\"men-delete\"><span class=\"glyphicon glyphicon-trash\"></span></a>
            </td>
        </tr>
        ";
        }
        $listing->free();
        ?>                        
    </table>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit Manajemen Dana</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>

<script>
  jQuery(function($){

    // perintah untuk kolom aksi
    jQuery('.aksi a').click(function(event) {
        /*
            mengambil value dari attribut data-*
        */
        var act = $(this).data('act'); // ambil value dari "data-act"
        var id  = $(this).data('id'); // ambil value dari "data-id"

        /*
            jQuery Ajax 

            ref : http://hayageek.com/jquery-ajax-form-submit/
        */
        $.ajax({
            url:'query/query.php',
            type:'post',
            data:{act:act,id:id},
            success:function(result){


                if (act == 'men-delete') {
                
                    location.reload(true);
                }else if( act == "men-edit"){
                
                $('#edit').find('.modal-body').html(result);

                $('#edit').modal();

                    jQuery('.save').click(function() {
                      var modal = $(this).parents('#edit');
                      var parn  = $(this).parents('form');
                      var name  = parn.serialize();
                      var _url  = parn.attr('action');

                      $.ajax ({
                        url:_url,
                        type:'POST',
                        data:name,
                        success:function(result){
                          if(result == 'sukses'){
  
                            modal.find('.modal-body').html(result);
  
                            setTimeout(function(){
  
                              modal.find('button.close').trigger('click');
  
                            },1000);
  
                          }else{

                            modal.find('.modal-body').html(result);
                            
                          }
                        }

                      }); 
                      return false;
                    
                    });

                }
 
              }

            });
            return false;
    });
  });
</script>