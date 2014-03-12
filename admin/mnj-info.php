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

<!-- Manajemen Informasi -->

<div class="content">
    <h3 class="title">Manajemen Informasi</h3>
    <form role="form" method="post" action="query/query.php">
    	<div class="s">
    		<div class="row">
    			<div class="col-md-8">
                    <input type="hidden" class="form-control" name="act" value="posting">
    				<input type="text" class="form-control" name="title" placeholder="Judul Informasi">
    			</div>
    			<div class="col-md-4 text-right">
    				<button class="btn btn-primary">Simpan</button>	
    			</div>
    		</div>
    	</div>
        <textarea name="informasi" class="informasi" id="informasi" cols="30" rows="10"></textarea>
        	
    </form>
</div>