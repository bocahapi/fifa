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
        
            echo "<h4 class=\"text-center\">Ukuran Max adalah 2 MB dan bertipe .doc atau .docx</h4>";
        
        }elseif($errno == 'error-connection'){
            echo "<h4 class=\"text-center\">Error Koneksi</h4>";
        }elseif ($errno == 'sukses') {
            echo "<h5 class=\"text-center\">Upload Sukses</h5>";
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