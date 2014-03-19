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
    <h3 class="title">Upload Program Kerja</h3>
     <?php
    if(isset($_GET['upload'])){
        
        $errno = $_GET['upload'];

        if($errno == 'error'){
        
            echo  "<div class=\"action\">"
                 ."<h4 class=\"text-center\">Ukuran Max adalah 2 MB dan bertipe .doc atau .docx <span class=\"glyphicon glyphicon-remove\"></span></h4>"
                 ."</div>";
        
        }elseif($errno == 'error-connection'){
            echo "<div class=\"action\">"
                 ."<h4 class=\"text-center\">Error Koneksi <span class=\"glyphicon glyphicon-remove\"></span></h4>"
                 ."</div>";
        }elseif ($errno == 'sukses') {
            echo "<div class=\"action\">"
                 ."<h5 class=\"text-center\">Upload Sukses <span class=\"glyphicon glyphicon-remove\"></span></h5>"
                 ."</div>";
        }
    }
    ?>
    <div class="notice">
        Silahkan unggah program kerja seama satu periode yang telah direncanakan. file berupa <code>.doc</code> dengan maksimal <code>2 Mb</code>
    </div>

    <form action="query/query.php" method="post" role="form" enctype="multipart/form-data">
        <input type="hidden" name="act" value="upload">
        <input type="hidden" name="id" value="<?php echo $usr_id; ?>">
        <input type="hidden" name="path" value="<?php echo $get_name; ?>">
        <input type="file" name="proker">
        <div class="s">
            <button class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-cloud-upload"></span> Upload</button>
        </div>
    </form>
</div>

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
        $sql   = "SELECT * FROM user,proker WHERE proker.id_user=user.id_user AND proker.id_user = '$usr_id' ";
        $query = $mysqli->query ($sql);
        while ($proker = $query->fetch_assoc()) {
        
        if($proker['status'] != ""){
          
            $status = "<b>{$proker['status']}</b>";
        
        }else{

            $status = "<i><b>Sedang diproses</b></i>";
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
    jQuery('.action span').click(function(e) {

        $(this).parents('.action').fadeTo(400, 0.5, function() {
            $(this).remove();
            var URL  = $(location).attr('href');
            var Load =  URL.split('?');

            window.location = Load[0]+"?#";
        });
        
        e.preventDefault();
    });
</script>