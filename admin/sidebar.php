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

<div class="col-md-2 col-sm-3 sidebar">
    <h1 class="title-site">Admin</h1>

   		<?php fa_nav($_SESSION['level']);?>
   		
   	<div class="credit">
   		<p> <?php footer();?> </p>
   	</div>
</div>