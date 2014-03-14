<?php
session_start();
/*
* Pengechekan Definisi UMS
*/
if(!isset($_SESSION['login'])){
    header('location:./../../404.html');;
}
# include connect database
include_once('./../../fa-config.php');

/**
* 
*/

if(!isset($_POST['act'])){
	die();
}else{
	$parameter = $_POST['act'];
}

/**
* 
*/
switch ($parameter) {

	# form kelola dana
	case 'pengelola':
		$id_user  = $_POST['user'];
		$id_jenis = $_POST['dana'];
		?>
		<h4>Kelola Dana</h4>
		<form action="query/_query.php" role="form">
	        <table class="table-form">
	            
			<?php
				$sql = $mysqli->query("SELECT * FROM `sub_dana` WHERE id_jenis = '$id_jenis' ");

				echo "<input type=\"hidden\" name=\"act\" value=\"_dana\">"
	                 ."<input type=\"hidden\" name=\"id_user\" value=\"{$id_user}\">"
	                 ."<input type=\"hidden\" name=\"id_jenis\" value=\"{$id_jenis}\">";
				
				while ($sub_dana = $sql->fetch_assoc()) {
				echo "<tr>"
		             ."<th colspan=\"3\">{$sub_dana['nama_sub']}</th>"
		             ."</tr>"
		             ."<tr>"
		             ."<input type=\"hidden\" name=\"id[]\" value=\"{$sub_dana['id_sub']}\">"
		             ."<td>Jenis Kegiatan</td>"
		             ."<td>:</td>"
		             ."<td>"
					 ."<input type=\"text\" class=\"form-control\" name=\"kegiatan[]\" placeholder=\"Jenis Kegiatan\">"
		             ."</td>"
		             ."</tr>"
		             ."<tr>"
		             ."<td>Input Dana</th>"
		             ."<td>:</td>"
		             ."<td>"
		             ."<input type=\"text\" data=\"numb\" class=\"form-control\" name=\"dn[]\" placeholder=\"Input Dana\">"
		             ."</td>"
		             ."</tr>";

				}
	           $sql->free();
			?>
	        
	        </table>
	        <div class="s text-right simpan-btn">

	        </div>
	    </form>
	    <hr>
	    <?php
		break;

	# Input kelola dana
	case '_dana':
		$id_user  = $_POST['id_user'];
		$id_jenis = $_POST['id_jenis'];
		$id_sub   = $_POST['id']; // Berupa Array
		$kegiatan = $_POST['kegiatan']; // Berupa Array
		$dana     = $_POST['dn']; // Berupa Array
		$date     = date('d/m');
		$year     = date('Y');

		# pengechekan apakah dana dalam tahun yang sama sudah di input / belum
		$check = $mysqli->query("SELECT id_sub FROM kelola_dana WHERE id_user='$id_user' AND id_jenis='$id_jenis' AND tgl_kelola_dana='$date' ");
			
			$valid = 1;
			while ($checking = $check->fetch_assoc()) {
			 	if( in_array($checking['id_sub'],$id_sub) ){
			 		$valid = $valid+1;
			 	}
			 }

		 if($valid == count($id_jenis)){ 

			$sql = "INSERT INTO `kelola_dana` (id_user,id_jenis,id_sub,jenis_kegiatan,input_dana,tgl_kelola_dana,tahun) VALUES ";

			for ($i=0; $i < count($dana) ; $i++) { 

				$sql .="('$id_user','$id_jenis','$id_sub[$i]','$kegiatan[$i]','$dana[$i]','$date','$year')";

				if($i != count($dana)-1){
					$sql .=",";
				}

			}

			/*
			 * hasil $sql jika di cetak adalah :
			 $sql = "INSERT INTO `total_dana` (id_user,id_jenis,id_sub,total_dana,tgl_total_dana,tahun) VALUES 
			 		('1','1','1','20000','14/03',2014),
			 		('1','1','2','20000','14/03',2014),
			 		('1','1','3','20000','14/03',2014),
			 		dst ... ";
			 */
				$insert = $mysqli->query($sql);
				if($insert){
					$the_id = $mysqli->insert_id;// id Kelola dana
					
					# mengambil total dana yang telah digunakan dari table "kelola_dana" dan dibuat Array
					$dn_dipakai = array();
					
					for ($i=0; $i <count($id_sub) ; $i++) { 
						$query_kelola = $mysqli->query("SELECT SUM(input_dana) AS ttl_dn FROM `kelola_dana` WHERE id_user='$id_user' AND id_jenis='$id_jenis' AND id_sub ='$id_sub[$i]' AND tahun='$year' ");
						$get_dana	  = $query_kelola->fetch_assoc();
						$dn_dipakai[] = $get_dana['ttl_dn'];
					}

					# Mengambil ID dan Total Dana, kemudian dirubah kedalam bentuk Array
					$sql_tt_d = $mysqli->query("SELECT id_total_dana,total_dana FROM `total_dana` WHERE id_user='$id_user' AND id_jenis='$id_jenis' AND tahun='$year' ");

					$id_total_dana = array();
					$total_dana    = array();

					while ($id_tt_d = $sql_tt_d->fetch_assoc()) {
						$id_total_dana[] = $id_tt_d['id_total_dana'];
						$total_dana[]	 =$id_tt_d['total_dana'];
					}

					/*
						Input dana kedalam table informasi dana
					*/
					$sql_dana = "INSERT INTO `informasi_dana` (id_user,id_jenis,id_sub,id_total_dana,id_kelola_dana,sisa_dana) VALUES ";

					for ($i=0; $i < count($dana); $i++) { 
						
						$id_kelola_dana = $the_id+$i;
						
						$sisa_dana 		= $total_dana[$i]-$dn_dipakai[$i];

						$sql_dana .= "('$id_user','$id_jenis','$id_sub[$i]','$id_total_dana[$i]','$id_kelola_dana','$sisa_dana')";
					
						if($i != count($dana)-1){
						
							$sql_dana .=",";
						}
					}

					# Eksekusi Insert
					$insert_info_dana = $mysqli->query($sql_dana);

					if($insert_info_dana){
						echo "sukses";
					}else{
						echo "error <br />".$sql_dana;
					}

				}else{
					echo "error insert";
					#header('location:./../dashboard.php?page=page=inp-total#ERROR');
				}
			}else{
				echo "data pernah di Input";
			}
			
		break;
	
	# fungsi (Tombol) melihat total dana
	case 'lihat':

		$group_id = $_POST['id']; // id_user-id_jenis-tahun
		
		$exp = explode('-', $group_id);

		$sql = "SELECT * FROM user,kelola_dana,jenis_dana 
						 WHERE kelola_dana.id_user = user.id_user 
						 AND kelola_dana.id_jenis=jenis_dana.id_jenis 
						 AND kelola_dana.id_user='{$exp[0]}' 
						 AND kelola_dana.id_jenis = '{$exp[1]}' 
						 AND kelola_dana.tgl_kelola_dana = '{$exp[2]}' 
						 AND kelola_dana.tahun = '{$exp[3]}' ";

		$lihat_dana = $mysqli->query($sql);
		
		
		/*
			membuat array() dengan fungsi while
			ref : http://stackoverflow.com/questions/9105419/generate-array-from-php-while-loop
		*/

		$dana = array();
		$kegiatan = array();
		while ( $lihat = $lihat_dana->fetch_assoc() ) {

			$dana[] 	= $lihat['input_dana'];
			$kegiatan[] = $lihat['jenis_kegiatan'];

		}
		$lihat_dana->close();

		$head = $mysqli->query($sql);
		$name = $head->fetch_assoc();
		$user = $name['nama'];
		$jenis = $name['nama_jenis'];


		/*
		* number_format(number,decimals,decimalpoint,separator);
		* ngubah angka menjadi format uang 
		* Ref : http://www.w3schools.com/php/func_string_number_format.asp
		*/
		echo "<div class=\"notice center\">
                    <p><b>{$user}</b></p>
                    <p>{$jenis}</p>
                    <p>Nalar : <code class=\"nalar-cur\">Rp. ".number_format($dana[0],0,',','.')."</code> untuk <b>{$kegiatan[0]}</b> </p>
                    <p>Non Nalar : <code class=\"non-nalar-cur\">Rp. ".number_format($dana[1],0,',','.')."</code> untuk <b>{$kegiatan[1]}</b> </p>
                    <p>Reor : <code class=\"reor-cur\">Rp. ".number_format($dana[2],0,',','.')."</code> untuk <b>{$kegiatan[2]}</b> </p>
                </div>
                <hr>";
		
		
		break;

	#hapus data kelola_dana
	case 'delete':
		$group_id = $_POST['id']; // id_user-id_jenis-tahun
		
		$exp = explode('-', $group_id);

		$sql = "DELETE  FROM kelola_dana 
						WHERE id_user='{$exp[0]}' 
						AND id_jenis = '{$exp[1]}' 
						AND tahun = '{$exp[2]}' ";

		$delete = $mysqli->query($sql);
		break;

	# Edit Form Input Total dana
	case 'edit':
		$group_id = $_POST['id']; // id_user-id_jenis-tahun
		
		$exp = explode('-', $group_id);

		$sql = "SELECT * FROM kelola_dana,sub_dana 
						 WHERE kelola_dana.id_sub=sub_dana.id_sub
						 AND kelola_dana.id_user='{$exp[0]}' 
						 AND kelola_dana.id_jenis = '{$exp[1]}' 
						 AND kelola_dana.tahun = '{$exp[2]}' ";
		?>
		<h4>Edit Dana Kegiatan</h4>
		<form action="query/_query.php" role="form">
	        <table class="table-form">
	            
			<?php
				$edit = $mysqli->query($sql);

				echo "<input type=\"hidden\" name=\"act\" value=\"update_kelola_dana\">"
	                 ."<input type=\"hidden\" name=\"tahun\" value=\"{$exp[2]}\">"
	                 ."<input type=\"hidden\" name=\"id_user\" value=\"{$exp[0]}\">"
	                 ."<input type=\"hidden\" name=\"id_jenis\" value=\"{$exp[1]}\">";
				
				while ($sub_dana = $edit->fetch_assoc()) {

	            echo "<tr>"
		             ."<th colspan=\"3\">{$sub_dana['nama_sub']}</th>"
		             ."</tr>"
		             ."<tr>"
		             ."<input type=\"hidden\" name=\"id[]\" value=\"{$sub_dana['id_sub']}\">"
		             ."<td>Jenis Kegiatan</td>"
		             ."<td>:</td>"
		             ."<td>"
					 ."<input type=\"text\" class=\"form-control\" name=\"kegiatan[]\" placeholder=\"Jenis Kegiatan\" value=\"{$sub_dana['jenis_kegiatan']}\">"
		             ."</td>"
		             ."</tr>"
		             ."<tr>"
		             ."<td>Input Dana</th>"
		             ."<td>:</td>"
		             ."<td>"
		             ."<input type=\"text\" data=\"numb\" class=\"form-control\" name=\"dn[]\" placeholder=\"Input Dana\" value=\"{$sub_dana['input_dana']}\">"
		             ."</td>"
		             ."</tr>";
				}
	           $edit->free();
			?>
	        
	        </table>
	        <div class="s text-right simpan-btn">

	        </div>
	    </form>
	    <hr>
	    <?php 
		break;
	
	#Update From total dana
	case 'update_kelola_dana':
		$id 		= $_POST['id_user'];
		$id_sub 	= $_POST['id'];
		$id_jenis 	= $_POST['id_jenis'];
		$kegiatan 	= $_POST['kegiatan'];
		$nama_dana 	= $_POST['dn'];
		$tahun 		= $_POST['tahun'];


		for ($i=0; $i < count($nama_dana) ; $i++) { 
		
			$sql = "UPDATE kelola_dana SET input_dana='".$nama_dana[$i]."', jenis_kegiatan='".$kegiatan[$i]."' WHERE tahun='$tahun' AND id_jenis='$id_jenis' AND id_user='$id' AND id_sub='".$id_sub[$i]."' ";

			$res = $mysqli->query($sql);

			if($res){
				$res = "sukses";
			}else{
				$res = "error";
			}
		}
		print_r($res);
		break;

	# jika @$parameter tidak ditemukan, maka blank
	default:

	die();
}