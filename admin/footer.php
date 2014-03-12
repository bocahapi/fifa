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
        </div>
    </div>
    </div>
    <script src="<?php get_js('bootstrap');?>"></script>
    <script src="<?php get_js('custom');?>"></script>
	<script src="<?php echo the_core().'/tinymce/tinymce.min.js';?>"></script>
    <script>
    	  tinymce.init({
    	  	selector:'textarea',
    	  	menubar:false
    	  });
    </script>
</body>

</html>