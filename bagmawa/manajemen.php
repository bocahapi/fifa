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

    <!-- alert -->
    <div class="alert alert-danger" style="display:none">
      <button type="button" class="close" >&times;</button>
      <strong>Ups!</strong> <span>ada Form yang lupa Anda Isi. Mohon cek kembali.</span>
    </div>
    <!-- alert -->

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
                <form class="col-md-5 s jd">
                    <input type="hidden" name="act" value="jd">
                    <input type="text" name="jenis_dana" class="form-control" placeholder="Nama Jenis Dana"><br>
                    <div class="btn btn-primary btn-sm simpan-jd">Simpan</div>
                </form>
            </div>
        </div>
      </div>
      
      <div class="tab-pane fade" id="sub-dana">
        <div class="row">
           <div class="form-group">
           <br>
                <form class="col-md-5 s sb">
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
                   <input type="text" name="sub_dana" id="" class="form-control" placeholder="Nama Sub Dana">
                   <br>
                   <div class="btn btn-primary btn-sm simpan-sb">Simpan</div>
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

    /*
    jQuery Trigger
    ref : http://stackoverflow.com/questions/6245046/run-jquery-ajax-when-hitting-enter-return
    */

    jQuery('form').bind('submit',function(event) {
      
        $(this).find('div.btn').trigger('click');

        event.preventDefault();
    });


    var hash = jQuery(location).attr('hash');

    if( hash != ''){

      jQuery('.nav-tabs a[href="'+hash+'"]').tab('show');    

    }

    /*
      Ajax untuk menyimpan data
    */
   jQuery('.simpan-jd,.simpan-sb').click(function(event) {
     
     var form = $(this).parents('form');
     var ID   = $(this).parents('.tab-pane').attr('id');
     var URL  = 'query/query.php';
     var DataSend = form.serialize();

     $.ajax({
        url:URL,
        type:'post',
        data:DataSend,
        success:function(result){
          if(result != 'sukses'){

            jQuery('.alert > span').html(result);

            jQuery('.alert').fadeIn(400);

          }else{

            location.reload(true);

          }

        }
     });

     return false;
     event.preventDefault();
   });

   // Close Alert
   jQuery('.close').click(function(event) {
     $(this).parents('.alert').fadeOut(400);
     event.preventDefault();
   });


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
                    
                    // Refresh Halaman
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

      event.preventDefault();
    });
  });
</script>