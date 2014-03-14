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
        <form action="query/query.php" method="post" class="col-md-6 s">
                  <input type="hidden" name="act" value="info-dana">
                  <input type="hidden" name="usr" value="<?php echo $usr_id;?>">
                   <select name="jenis_dana" id="" class="form-control">
                       <option value="">Pilih Jenis Dana</option>
                       <?php
                       $stmt = $mysqli->query("SELECT * FROM jenis_dana");
                       while($jenis_dana = $stmt->fetch_assoc()){
                        echo "<option value=\"{$jenis_dana['id_jenis']}\">{$jenis_dana['nama_jenis']}</option>"; 
                       }
                       $stmt->free();
                       ?>
                   </select>
       
           <div class="s text-right">
               <div class="btn btn-primary btn-sm lihat">Lihat</div>
           </div>
       </form>
   </div>
</div>
<hr>
<!-- view Dana -->
<div class="data-view"></div>
<!-- view Dana -->

</div>

<script>
    jQuery('.lihat').click(function(event) {
        var parn = $(this).parents('form');
        var Url  = parn.attr('action');

        var DataSend = parn.serialize();

        $.ajax({
            url:Url,
            type:'post',
            data:DataSend,
            success:function(result){
                jQuery('.data-view').html(result);
            }
        });
        return false;
    });
</script>