<?php
/*
* jika UMS tidak definiskan terlebih dahulu maka proses akan dihentikan.
*/
if(!defined('UMS')){
	header('location:404.html');
}

/*
*
* Funsgi navigasi dengan array
* 
* contoh menggunakan fa_nav('admin');
*/

function fa_nav($parameter){
	
	$arr = array(
		'admin'   => array(
						 array(
						 'name'=> 'Tambah User',
						 'url' => '?#'
						 ),
						 array(
						 'name'=> 'Kelola User',
						 'url' => '?page=kel-user#'
						 ),
						 array(
						 'name'=> 'Manajemen Informasi',
						 'url' => '?page=mnj-info#'
						 ),
						  array(
						 'name'=> 'Logout',
						 'url' => home_url().'/logout.php'
						 ),
					),
		'bagmawa' => array(
						array(
						 'name'=> 'Lihat Proker',
						 'url' => '?#'
						 ),
						 array(
						 'name'=> 'Manajemen Jenis Dana',
						 'url' => '?page=manajemen#'
						 ),
						 array(
						 'name'=> 'Input Total Dana',
						 'url' => '?page=inp-total#'
						 ),
						  array(
						 'name'=> 'Pengelolaan Dana',
						 'url' => '?page=pengelola#'
						 ),
						   array(
						 'name'=> 'Logout',
						 'url' => home_url().'/logout.php'
						 ),
			  		),
		'ormawa'  => array(
						array(
						 'name'=> 'Upload Program Kerja',
						 'url' => '?#'
						 ),
						 array(
						 'name'=> 'Informasi Dana',
						 'url' => '?page=info#'
						 ),
						 array(
						 'name'=> 'Rekap Penggunaan Dana',
						 'url' => '?page=rekap#'
						 ),
						 array(
						 'name'=> 'Logout',
						 'url' => home_url().'/logout.php'
						 ),
					)
		);

		echo "<nav class=\"nav\"><ul class=\"main\">";
		foreach ($arr[$parameter] as $key => $value) {
			if($value['name'] != 'Logout'){
				$url = home_url().'/'.$parameter.'/dashboard.php';
			}else{
				$url='';
			}
			echo "<li><a href=\"{$url}{$value['url']}\" >{$value['name']}</a></li>";
		}
		echo "</ul></nav>";

}


