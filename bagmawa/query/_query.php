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

	case '_kelola':
		
		$id_jenis = $_POST['id_jenis'];

		echo "<td>Ambil Dana</td>"
             ."<td>:</td>"
             ."<td>"
             ."<select name=\"sub_dana\" id=\"\" class=\"form-control input-sm\">"
			 ."<option value=\"\">Pilih Sub Dana</option>";
                           
           $stmt = $mysqli->query("SELECT * FROM sub_dana WHERE id_jenis = '$id_jenis' ");
            while($sub_dana = $stmt->fetch_assoc()){
                echo "<option value=\"{$sub_dana['id_sub']}\">{$sub_dana['nama_sub']}</option>"; 
            }
      	   $stmt->free();

        echo "</select>"
              ."</td>";
		break;

	# form kelola dana
	case 'pengelola':
		$id_user  = $_POST['user'];
		$id_jenis = $_POST['dana'];
		$id_sub	  = $_POST['sub_dana'];

		?>
		<h4>Kelola Dana</h4>
		<form action="query/_query.php" role="form">
	        <table class="table-form">
	            
			<?php
				$sql = $mysqli->query("SELECT * FROM `sub_dana` WHERE id_jenis = '$id_jenis' AND id_sub = '$id_sub' ");

				echo "<input type=\"hidden\" name=\"act\" value=\"_dana\">"
	                 ."<input type=\"hidden\" name=\"id_user\" value=\"{$id_user}\">"
	                 ."<input type=\"hidden\" name=\"id_jenis\" value=\"{$id_jenis}\">";
				
				while ($sub_dana = $sql->fetch_assoc()) {
				echo "<tr>"
		             ."<th colspan=\"3\">{$sub_dana['nama_sub']}</th>"
		             ."</tr>"
		             ."<tr>"
		             ."<input type=\"hidden\" name=\"id\" value=\"{$sub_dana['id_sub']}\">"
		             ."<td>Jenis Kegiatan</td>"
		             ."<td>:</td>"
		             ."<td>"
					 ."<input type=\"text\" class=\"form-control\" name=\"kegiatan\" placeholder=\"Jenis Kegiatan\">"
		             ."</td>"
		             ."</tr>"
		             ."<tr>"
		             ."<td>Input Dana</th>"
		             ."<td>:</td>"
		             ."<td>"
		             ."<input type=\"text\" data=\"numb\" class=\"form-control\" name=\"dn\" placeholder=\"Input Dana\">"
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
		$id_sub   = $_POST['id']; 
		$kegiatan = $_POST['kegiatan'];
		$dana     = $_POST['dn']; 
		$date     = date('d/m');
		$year     = date('Y');

		# id_total dana
		$sql = "SELECT id_total_dana,total_dana FROM total_dana 
												WHERE id_user = '$id_user' 
									 			AND id_jenis = '$id_jenis' 
									 			AND id_sub = '$id_sub' 
									 			ORDER BY tahun DESC limit 1";
        $result = $mysqli->query($sql);

        $total_dana = $result->fetch_assoc();

        $id_total_dana = $total_dana['id_total_dana'];
        $total_dana_   = $total_dana['total_dana'];

		# insert dan id_kelola_dana
        $sql_insert = "INSERT INTO kelola_dana  (id_user,id_jenis,id_sub,jenis_kegiatan,input_dana,tgl_kelola_dana,tahun)
        								  VALUES ('$id_user','$id_jenis','$id_sub','$kegiatan','$dana','$date','$year') ";

        $insert = $mysqli->query($sql_insert);

        if(!$insert){
        	echo "gagal";
        }

        /*
		mendapatkan id setelah insert data baru
		ref: http://id1.php.net/mysqli_insert_id
        */
        $id_kelola_dana = $mysqli->insert_id;


        # check sisa dana
        $sql_check = "SELECT sisa_dana FROM informasi_dana 
        										WHERE id_user = '$id_user' 
									 			AND id_jenis = '$id_jenis' 
									 			AND id_sub = '$id_sub' 
									 			AND id_total_dana = '$id_total_dana' 
									 			AND id_kelola_dana = '$id_kelola_dana' 
									 			ORDER BY id_informasi_dana DESC limit 1";
		$check = $mysqli->query($sql_check);
		if($check->num_rows >= 1){
			$sisa_dana_fetch = $check->fetch_assoc();

			$sisa_dana =  $sisa_dana_fetch['sisa_dana'];
			# mengurangi dana
    	    $dana_total_n = $sisa_dana - $dana;
			
		}else{
			# mengurangi dana
        	$dana_total_n = $total_dana_ - $dana;
    	}

        if ( $dana_total_n < 0 ){
        	
        	echo " Dana Habis ";

        }else{
 	
 	       $insert_info = "INSERT INTO informasi_dana (id_user,id_jenis,id_sub,id_total_dana,id_kelola_dana,sisa_dana) 
        				VALUES ('$id_user','$id_jenis','$id_sub','$id_total_dana','$id_kelola_dana','$dana_total_n') ";
    	   
    	   $insert_dana = $mysqli->query($insert_info);
    	   if($insert_dana){

    	   	  echo "sukses";

    	   }else{
    	   	  
    	   	  echo "gagal".$mysqli->error;

    	   }
        }

		break;
	
	# fungsi (Tombol) melihat total dana
	case 'lihat':

		$group_id = $_POST['id']; // id_user-id_jenis-tahun
		
		$sql = "SELECT * FROM user,kelola_dana,jenis_dana,sub_dana 
						 WHERE kelola_dana.id_user = user.id_user 
						 AND kelola_dana.id_jenis = jenis_dana.id_jenis 
						 AND kelola_dana.id_sub = sub_dana.id_sub
						 AND kelola_dana.id_kelola_dana = '$group_id' ";

		$lihat_dana = $mysqli->query($sql);
		
		/*
			membuat array() dengan fungsi while
			ref : http://stackoverflow.com/questions/9105419/generate-array-from-php-while-loop
		*/
		

		$lihat = $lihat_dana->fetch_assoc();

		$title 	  = $lihat['nama_sub'];
		$user  	  = $lihat['nama'];
		$jenis    = $lihat['nama_jenis'];
		$dana 	  = $lihat['input_dana'];
		$kegiatan = $lihat['jenis_kegiatan'];


		$lihat_dana->close();


		/*
		* number_format(number,decimals,decimalpoint,separator);
		* ngubah angka menjadi format uang 
		* Ref : http://www.w3schools.com/php/func_string_number_format.asp
		*/
		echo "<div class=\"notice center\">
                    <p><b>{$user}</b></p>
                    <p>{$jenis}</p>
                    <p>{$title} : <code>Rp. ".number_format($dana,0,',','.')."</code> untuk <b>{$kegiatan}</b></p>
                </div>
                <hr>";
		
		
		break;

	#hapus data kelola_dana
	case 'delete':
		$group_id = $_POST['id']; // id_user-id_jenis-tahun

		$sql = "DELETE  FROM kelola_dana 
						WHERE id_kelola_dana = '$group_id' ";

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
						 AND kelola_dana.tgl_kelola_dana = '{$exp[2]}' 
						 AND kelola_dana.tahun = '{$exp[3]}' 
						 AND kelola_dana.id_kelola_dana = '{$exp[4]}'";
		?>
		<h4>Edit Dana Kegiatan</h4>
		<form action="query/_query.php" role="form">
	        <table class="table-form">
	            
			<?php
				$edit = $mysqli->query($sql);

				echo "<input type=\"hidden\" name=\"act\" value=\"update_kelola_dana\">"
	                 ."<input type=\"hidden\" name=\"tahun\" value=\"{$exp[3]}\">"
	                 ."<input type=\"hidden\" name=\"id_kelola\" value=\"{$exp[4]}\">"
	                 ."<input type=\"hidden\" name=\"id_user\" value=\"{$exp[0]}\">"
	                 ."<input type=\"hidden\" name=\"id_jenis\" value=\"{$exp[1]}\">";
				
				while ($sub_dana = $edit->fetch_assoc()) {
				$id_sub = $sub_dana['id_sub'];
				$id_total_sql = " SELECT id_total_dana FROM total_dana WHERE id_jenis = '{$exp[1]}' AND id_sub='$id_sub' AND id_user  ='{$exp[0]}' AND tahun = '{$exp[3]}'  LIMIT 1 "; 
				
				$get_id_total = $mysqli->query($id_total_sql);
				
				$id_total_dana = $get_id_total->fetch_assoc();

	            echo "<tr>"
		             ."<th colspan=\"3\">{$sub_dana['nama_sub']}</th>"
		             ."</tr>"
		             ."<tr>"
		             ."<input type=\"hidden\" name=\"id_total\" value=\"{$id_total_dana['id_total_dana']}\">"
		             ."<input type=\"hidden\" name=\"id\" value=\"{$sub_dana['id_sub']}\">"
		             ."<td>Jenis Kegiatan</td>"
		             ."<td>:</td>"
		             ."<td>"
					 ."<input type=\"text\" class=\"form-control\" name=\"kegiatan\" placeholder=\"Jenis Kegiatan\" value=\"{$sub_dana['jenis_kegiatan']}\">"
		             ."</td>"
		             ."</tr>"
		             ."<tr>"
		             ."<td>Input Dana</th>"
		             ."<td>:</td>"
		             ."<td>"
		             ."<input type=\"text\" data=\"numb\" class=\"form-control\" name=\"dn\" placeholder=\"Input Dana\" value=\"{$sub_dana['input_dana']}\">"
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
		$id 			= $_POST['id_user'];
		$id_kelola  	= $_POST['id_kelola'];
		$id_sub 		= $_POST['id'];
		$id_total_dana  = $_POST['id_total'];
		$id_jenis 		= $_POST['id_jenis'];
		$kegiatan 		= $_POST['kegiatan'];
		$nama_dana 		= $_POST['dn'];
		$date 			= date('d/m');
		$tahun 			= $_POST['tahun'];

				# ambil data sebelum diupdate
				$sql_kel = "SELECT input_dana FROM kelola_dana WHERE id_kelola_dana = '$id_kelola' LIMIT 1";
				$query_kel = $mysqli->query($sql_kel);
				$query_kel = $query_kel->fetch_assoc();

				$dana_kel  = $query_kel['input_dana']; // dana terakhir dipakai


				# id_total dana
				$sql = "SELECT total_dana FROM total_dana 
														WHERE id_total_dana = '$id_total_dana' 
											 			ORDER BY tahun DESC limit 1";
				$result = $mysqli->query($sql);

				$total_dana = $result->fetch_assoc();

				$total_dana_   = $total_dana['total_dana'];// total dana



				# check sisa dana
		        $sql_check = "SELECT sisa_dana,id_informasi_dana FROM informasi_dana 
        										WHERE id_user = '$id' 
									 			AND id_jenis = '$id_jenis' 
									 			AND id_sub = '$id_sub' 
									 			AND id_total_dana = '$id_total_dana' 
									 			AND id_kelola_dana = '$id_kelola' 
									 			ORDER BY id_informasi_dana DESC limit 1";

				$check = $mysqli->query($sql_check);

				$sisa_dana_fetch = $check->fetch_assoc();

				$sisa_dana =  $sisa_dana_fetch['sisa_dana'];

				$id_informasi_dana = $sisa_dana_fetch['id_informasi_dana']; // id tabel informasi dana

				# dana sebelum dikurangi
				$last_dana = $sisa_dana + $dana_kel;// membalikan nilai dana sebelum di kurangi 
				
				# mengurangi dana
	    	    $dana_total_n = $last_dana - $nama_dana;					


		        if ( $dana_total_n < 0 ){
		        	
		        	echo " Dana Habis ";

		        }else{
		 			
		 			# update sisa dana ditabel informasi_dana
		 	       $update = "UPDATE informasi_dana SET sisa_dana = '$dana_total_n' WHERE id_informasi_dana = '$id_informasi_dana' ";

		    	   $update_dana = $mysqli->query($update);

		    	   # check Query
		    	   if($update_dana){

		    	   	  # update input dana di tabel kelola dana
		    	   	  $update = "UPDATE kelola_dana SET input_dana = '$nama_dana' WHERE id_kelola_dana = '$id_kelola' ";

		    	   	  $update_dana = $mysqli->query($update);

		    	   	  # check Query
		    	   	  if($update_dana){
		    	   	  	echo "sukses";
		    	   	  }else{
		    	   	  	echo "error";
		    	   	  }

		    	   }else{
		    	   	  
		    	   	  echo "gagal".$mysqli->error;

		    	   }
		        }

		break;

	# jika @$parameter tidak ditemukan, maka blank
	default:

	die();
}