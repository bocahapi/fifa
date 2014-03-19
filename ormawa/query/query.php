<?php
session_start();
/*
* Pengechekan Definisi UMS
*/
if(!isset($_SESSION['login'])){
    header('location:./../../404.html');
}
# include connect database
include_once('./../../fa-config.php');

/**
* 
*/

if(!isset($_POST['act'])){
	header('location:./../dashboard.php?upload=error-connection');
}else{
	$parameter = $_POST['act'];
}

/**
* 
*/
switch ($parameter) {
	
	# Upload Dokumen
	case 'upload':
		$id_user    = $_POST['id'];
		$tgl_proker = date('d/m/Y'); 
		/*
		* fungsi Upload File
		* ref : http://www.w3schools.com/php/php_file_upload.asp
		*/
		$data      = $_FILES['proker'];

		$max_size  = 200000; // 2MB
		$title     = $data['name'];
		$get	   = explode('.', $title);
		$extention = end($get);

		# Direktori Upload
		$path_name     = Upload().'/'.strtolower($_POST['path']).'/';
		$path_year	   = $path_name.date('Y').'/';
		$path_month    = $path_year.date('m').'/';
		$path_day	   = $path_month.date('d').'/';

		#if($data['error'])

		#file yang diijinkan 
		$allow_file    = array('doc','docx');

		if( $data['size'] < $max_size && in_array($extention, $allow_file) ){

			#mengecek dan membuat direktori jika belum ada
			if(!is_dir($path_name)){

				mkdir($path_name,0777, true);
				
			}
			if(!is_dir($path_year)){
			
				mkdir($path_year,0777, true);
			
			}
			if(!is_dir($path_month)){
				
				mkdir($path_month,0777, true);

			}
			if (!is_dir($path_day)) {
				
				mkdir($path_day,0777, true);
				
			}else{}

			$path = $path_name.date('Y/m/d').'/';
			
		 	$upload = move_uploaded_file($data['tmp_name'], $path.$title);
		 	
		 	if($upload){

		 		$url 	= home_url().'/upload/'.strtolower($_POST['path']).date('/Y/m/d').'/'.$title;
		 		$sql 	= "INSERT INTO proker (id_user,nama_file,tgl_proker,url) VALUES 
		 									 ('$id_user','$title','$tgl_proker','$url') ";
		 		$insert = $mysqli->query($sql);

		 		if($insert){
		 			header('location:./../dashboard.php?upload=sukses');
		 		}else{
		 			unlink($path.$title);
		 			
		 			header('location:./../dashboard.php?upload=error-connection');
		 		
		 		}

		 	}else{
		 		
		 		header('location:./../dashboard.php?upload=error-connection');
		 	}

		}else{

			header('location:./../dashboard.php?upload=error');

		}

		break;
	
	# Informasi Dana
	case 'info-dana':
		$id_user = $_POST['usr'];
		$id_jenis= $_POST['jenis_dana'];
		$tahun   = date('Y');

		# membuat nama dan id subdana menjadi Array;
		$query_sub   = $mysqli->query("SELECT * FROM `sub_dana` WHERE id_jenis = '$id_jenis' ");		
		
		$_sub_dana = array();
		while ($sub_dana = $query_sub->fetch_assoc()) {
			$_sub_dana['id_sub'][] = $sub_dana['id_sub'];
			$_sub_dana['nama_sub'][] = $sub_dana['nama_sub'];
		}

		# menentukan Total Dana dan id 
		$ttdana = $mysqli->query("SELECT * FROM `total_dana` 
													    WHERE id_user = '$id_user'
													    AND id_jenis = '$id_jenis'
													    AND tahun = '$tahun' 
														");
		$check = $ttdana->num_rows;
		if($check < 1){
			echo "<h4 class=\"text-center\">Belum ada Dana Yang bisa ditampilkan</h4> <hr/>";
			exit;
		}
		$total_dana = array();

		while ($dana = $ttdana->fetch_assoc()) {
			$total_dana['id_total_dana'][] = $dana['id_total_dana'];
			$total_dana['total_dana'][]    = $dana['total_dana'];
		}

		#menentukan dana terpakai
		$dn_pk   = array();
		for ($i=0; $i < count($_sub_dana['id_sub']); $i++) { 
			$dn_query = "SELECT id_kelola_dana FROM `kelola_dana` 
															   WHERE id_user = '$id_user' 
															   AND id_sub = '".$_sub_dana['id_sub'][$i]."' 
															   AND id_jenis = '$id_jenis' 
															   AND tahun = '$tahun' 
															   ORDER BY id_kelola_dana DESC LIMIT 1
															   ";
			$dana_pk    = $mysqli->query($dn_query);
			$dana_pakai	= $dana_pk->fetch_assoc();
 

			$dn_query_c = "SELECT SUM(input_dana) AS dana_pakai FROM `kelola_dana` 
															   WHERE id_user = '$id_user' 
															   AND id_sub = '".$_sub_dana['id_sub'][$i]."' 
															   AND id_jenis = '$id_jenis' 
															   AND tahun = '$tahun' 
															   ORDER BY id_kelola_dana DESC LIMIT 1
															   ";
			$dana_pk_c    = $mysqli->query($dn_query_c);
			$dana_pakai_c	= $dana_pk_c->fetch_assoc();

			$dn_pk['id_kelola_dana'][] = $dana_pakai['id_kelola_dana'];
			$dn_pk['dana_pakai'][] 	 = $dana_pakai_c['dana_pakai'];
		}

		
		# menentukan sisa dana
		$sisa = array();
		for ($i=0; $i < count($dn_pk['id_kelola_dana']); $i++) { 
			$sisa_sql = "SELECT sisa_dana FROM `informasi_dana` 
										  WHERE id_user = '$id_user'
										  AND id_sub = '".$_sub_dana['id_sub'][$i]."'
										  AND id_jenis = '$id_jenis'
										  AND id_total_dana = '".$total_dana['id_total_dana'][$i]."'
										  AND id_kelola_dana = '".$dn_pk['id_kelola_dana'][$i]."'
										  ";

			$sisa_query = $mysqli->query($sisa_sql);
			$sisa_fetch = $sisa_query->fetch_assoc();

			$sisa[] = $sisa_fetch['sisa_dana'];

			//echo $sisa_sql.'<br />';
			
		}

		/*
		#Sub dana
		-----------------------------
		$_sub_dana['id_sub'],
		 $_sub_dana['nama_sub'] 
		
		# Total Dana
		-----------------------------
		$total_dana['id_total_dana'], 
		$total_dana['total_dana'] 

		# Dana Terpakai
		-----------------------------
		$dn_pk['dana_pakai'], 
		$dn_pk['id_kelola_dana']
		
		# Sisa Dana
		-----------------------------
		$sisa array tunggal

		*/

		for ($i=0; $i < count($_sub_dana['id_sub']) ; $i++) { 
		$sisa_dana = ($sisa[$i] == '') ? $total_dana['total_dana'][$i] : $sisa[$i];
		?>
		<table class="table-form">
	        <tr>
	            <th colspan="3"><?php echo $_sub_dana['nama_sub'][$i];?></th>
	        </tr>
	        <tr>
	            <td>Jumlah Total Dana</td>
	            <td>:</td>
	            <td>
	                Rp. <?php echo number_format($total_dana['total_dana'][$i],0,',','.') ;?>
	            </td>
	        </tr>
	        <tr>
	            <td>Dana Pakai</th>
	            <td>:</td>
	            <td>
	               Rp. <?php echo number_format($dn_pk['dana_pakai'][$i],0,',','.');?>
	            </td>
	        </tr>
	        <tr>
	            <td>Sisa Dana</th>
	            <td>:</td>
	            <td>
	                Rp. <?php echo number_format($sisa_dana,0,',','.') ;?>
	            </td>
	        </tr>
	    </table>
		<hr>

		<?php
		 }			

		break;
	default:
		header('location:./../../404.html');
		break;
}