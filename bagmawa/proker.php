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
 <!-- Lihat Proker -->
<div class="content">
    <h3 class="title">Lihat Proker</h3>
    <table class="table table-bordered">
        <tr>
            <th>Nomor</th>
            <th>User</th>
            <th>Nama File</th>
            <th class="text-center">Date</th>
            <th class="text-center">Aksi</th>
        </tr>
        <?php
        $no = 1;
        $sql   = "SELECT * FROM user,proker WHERE proker.id_user=user.id_user ";
        $query = $mysqli->query ($sql);
        while ($proker = $query->fetch_assoc()) {
        
        if($proker['status'] != ""){
          
            $status = "<b>{$proker['status']}</b>";
        
        }else{

            $status = "<a href=\"#\" data-act=\"setuju\" data-id=\"{$proker['id_proker']}\"><span class=\"glyphicon glyphicon-ok\"></span></a>"
                     ."<a href=\"#\" data-act=\"tidak\" data-id=\"{$proker['id_proker']}\"><span class=\"glyphicon glyphicon-remove\"></span></a>"; 
        }
        echo "<tr>"
            ."<td>{$no}</td>"
            ."<td>{$proker['nama']}</td>"
            ."<td><a href=\"http://docs.google.com/viewer?url={$proker['url']}\" target=\"_blank\"><span class=\"glyphicon glyphicon-cloud-download\"></span></a>{$proker['nama_file']}</td>"
            ."<td class=\"text-center\">{$proker['tgl_proker']}</td>"
            ."<td class=\"text-center aksi\">"
                .$status
            ."</td>"
            ."</tr>";

            $no++;
        }
        ?>
    </table>
</div>
<script>
    jQuery(function($){
        jQuery('td.aksi a').click(function() {
            var id = $(this).data('id');
            var value = $(this).data('act');

            $.ajax({
                url:'query/query.php',
                type:'post',
                data:{act:'aksi',id:id,val:value},
                success:function(result){
                   if(result=='sukses'){
                    location.reload(true);
                   }
                }
            });
            return false;


        });
    });
</script>