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
	die();
}else{
	$parameter = $_POST['act'];
}

/**
* 
*/
switch($parameter){

	# Halaman Manajemen Jenis dana (bag. Jenis Dana)
	case 'jd':
		$jenis = $_POST['jenis_dana'];

		if($jenis == '' || empty($jenis) ){
			echo "ada Form yang lupa Anda Isi. Mohon cek kembali.";
			exit;
		}

		$sql   = "INSERT INTO `jenis_dana` (nama_jenis) values ('$jenis')";
		$res   = $mysqli->query($sql);
		if($res){
			//header('location:./../dashboard.php?page=manajemen#jenis-dana');
			echo "sukses";
		}else{
			//header('location:./../dashboard.php?page=manajemen#ERROR');
			echo "Gagal Input, ulangi beberapa saat lagi";
		}
	break;

	# Halaman Manajemen Jenis dana (bag. Sub Dana)
	case 'sd':
		$jenis = $_POST['jenis_dana'];
		$sub   = $_POST['sub_dana'];

		if( $jenis == "" || empty($jenis) || $sub == "" || empty($sub) ){
			echo "ada Form yang lupa Anda Isi. Mohon cek kembali.";
			exit;
		}

		$sql   = "INSERT INTO `sub_dana` (nama_sub,id_jenis) VALUES ('$sub','$jenis') ";
		$res   = $mysqli->query($sql);

		if($res){
			//header('location:./../dashboard.php?page=manajemen#sub-dana');
			echo "sukses";
		}else{
			//header('location:./../dashboard.php?page=manajemen#ERROR');
			echo "Gagal Input, ulangi beberapa saat lagi";
		}
	break;

	# Delete Management Jenis Data
	case 'men-delete':
		$id  = $_POST['id'];
		$_ex = explode('-', $id);

		$id_sub   = $_ex[0];
		$id_jenis = $_ex[1];

		$sql 	= "SELECT * FROM `sub_dana` WHERE id_jenis='$id_jenis'";
		$query  = $mysqli->query($sql);
		$num 	= $query->num_rows;

			$del_sub_dana = $mysqli->query("DELETE FROM `sub_dana` WHERE id_sub = '$id_sub' ");

			if($del_sub_dana){

				if($num == 1){
				
					$del = $mysqli->query("DELETE FROM `jenis_dana` WHERE id_jenis='$id_jenis' ");
					
					if($del){
						echo "sukses";
					}else{
						echo "error";
					}
				}

			}else{
				echo "error";
			}
		break;

	#Edit Manajemen Jenis Dana
	case 'men-edit':
		$id  = $_POST['id'];
		$_ex = explode('-', $id);

		$id_sub   = $_ex[0];
		$id_jenis = $_ex[1];

		$jenis_dana = $mysqli->query("SELECT nama_jenis FROM `jenis_dana` WHERE id_jenis = '$id_jenis' ");
		$nama_jenis = $jenis_dana->fetch_assoc();
		$nama 		= $nama_jenis['nama_jenis'];

		# Mengambil Nama Sub dana
		$sub_dana = $mysqli->query("SELECT nama_sub FROM `sub_dana` WHERE id_sub = '$id_sub' LIMIT 1");
		$index 	  = $sub_dana->fetch_assoc();

		?>
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#nama_jenis" data-toggle="tab">Jenis Dana</a></li>
		  <li><a href="#nama_sub" data-toggle="tab">Sub Dana</a></li>
		</ul>

		
		<div class="tab-content">
		  <!-- Tab Jenis Dana -->
		  <div class="tab-pane active" id="nama_jenis">
		  	<div class="row">
		  		<div class="form-group">
	                <form action="query/query.php" method="post" class="col-md-8 s">
	                    <input type="hidden" name="act" value="jd-update">
	                    <input type="hidden" name="id" value="<?php echo $id_jenis;?>">
	                    <input type="hidden" name="last" value="<?php echo $nama;?>">
	                    <br>
	                    <input type="text" name="jenis_dana" class="form-control" placeholder="Nama Jenis Dana" value="<?php echo $nama;?>"><br>
	                    <div class="btn btn-primary btn-sm save">Simpan</div>
	                </form>
	            </div>
		  	</div>
		  </div>

		  <!-- Tab Sub Dana  -->
		  <div class="tab-pane" id="nama_sub">
		  	<div class="row">
			  	<div class="form-group">
			  	<br>
	                <form action="query/query.php" method="post" class="col-md-8 s">
	                  <input type="hidden" name="act" value="sd-update">
	                  <input type="hidden" name="id" value="<?php echo $id_sub ;?>">
	                   <select name="jenis_dana" id="" class="form-control">
	                       <option value="">Pilih Jenis Dana</option>
	                       <?php
	                       $stmt = $mysqli->query("SELECT * FROM jenis_dana");
	                       while($jenis_dana = $stmt->fetch_assoc()){

	                       	$selected = ($jenis_dana['id_jenis'] == $id_jenis ) ? 'selected' : '';
	                        
	                        echo "<option value=\"{$jenis_dana['id_jenis']}\" {$selected}>{$jenis_dana['nama_jenis']}</option>"; 
	                       
	                       }
	                       $stmt->free();
	                       ?>
	                   </select> <br>
	                   <select name="sub_dana" id="" class="form-control">
	                       <option value="Nalar" <?php if($index['nama_sub'] == 'Nalar') {echo 'selected' ;}?>>Nalar</option>
	                       <option value="Non Nalar" <?php if($index['nama_sub'] == 'Non Nalar') {echo 'selected' ;}?>>Non Nalar</option>
	                       <option value="Reor" <?php if($index['nama_sub'] == 'Reor') {echo 'selected' ;}?>>Reor</option>
	                   </select> <br>
	                   <div class="btn btn-primary btn-sm save">Simpan</div>
	               </form>
	        	</div>
			  </div>
			</div>
		</div>

		<?php
		break;

	# Update Nama Jenis Dana
	case 'jd-update':
		$id_jenis   = $_POST['id'];
		$last_nama  = $_POST['last'];
		$nama_jenis = $_POST['jenis_dana'];

		// mengecek Nama terakhir yang di input kedalam database, jika sama / kosong , maka tidak akan dirubah.
		if( $nama_jenis == $last_nama || $nama_jenis == '' )
		{

			echo "sukses";

		}
		// jika Nama Jenis berbeda, maka akan di update.
		else if( $nama_jenis != $last_nama )
		{

			$Update = $mysqli->query("UPDATE `jenis_dana` SET nama_jenis= '$nama_jenis' WHERE id_jenis = '$id_jenis'");

			if ($Update) {
				echo "sukses";
			} else {
				echo "error";
			}
			

		}
		break;

	#update Sub Dana
	case 'sd-update':
		$id_sub = $_POST['id'];
		$id_jenis = $_POST['jenis_dana'];
		$nama_sub = $_POST['sub_dana'];

		#check data masih sama ataukah tidak
		$check  = $mysqli->query("SELECT * FROM `sub_dana` WHERE id_sub='$id_sub' AND id_jenis='$id_jenis' AND nama_sub='$nama_sub' ");
		$num  	= $check->num_rows;

		if($num == 1){
			echo "sukses";
		}else{

			$update = $mysqli->query("UPDATE `sub_dana` SET id_jenis='$id_jenis', nama_sub='$nama_sub' WHERE id_sub='$id_sub' ");

			if($update){
				echo "sukses";
			}else{
				echo "error";
			}
			
		}
		break;

	# Halaman Input Total Dana untuk Menampilkan sub dana.
	case 'input-total':

		$id_user  = $_POST['user'];
		$id_jenis = $_POST['dana'];
		?>
		<h4>Input Total Dana</h4>
		<form action="query/query.php" role="form">
	        <table class="table-form">
	            
			<?php
				$sql = $mysqli->query("SELECT * FROM `sub_dana` WHERE id_jenis = '$id_jenis' ");

				echo "<input type=\"hidden\" name=\"act\" value=\"sub_dana\">"
	                 ."<input type=\"hidden\" name=\"id_user\" value=\"{$id_user}\">"
	                 ."<input type=\"hidden\" name=\"id_jenis\" value=\"{$id_jenis}\">";
				
				while ($sub_dana = $sql->fetch_assoc()) {

	            echo "<tr>"
	                ."<th colspan=\"3\">{$sub_dana['nama_sub']}</th>"
	            	."</tr>"
	            	."<tr>"
	                ."<td>Total Dana</td>"
	                ."<td>:</td>"
	                ."<td>"
	                ."<input type=\"hidden\" name=\"id[]\" value=\"{$sub_dana['id_sub']}\">"
	                ."<input type=\"text\" data=\"numb\" class=\"form-control\" name=\"dn_total[]\" placeholder=\"Total Dana\">"
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

	# Halaman Input Total Dana untuk Eksekusi total Dana.
	case 'sub_dana':
		$id 		= $_POST['id_user'];
		$id_sub 	= $_POST['id'];
		$id_jenis 	= $_POST['id_jenis'];
		$nama_dana 	= $_POST['dn_total'];
		$date 		= date('d/m');
		$year 		= date('Y');

		# pengechekan apakah dana dalam tahun yang sama sudah di input / belum
		$check = $mysqli->query("SELECT id_sub FROM total_dana WHERE id_user='$id' AND id_jenis='$id_jenis' AND tahun='$year' ");

		$valid = 1;

		while ($checking = $check->fetch_assoc()) {
		 	if( in_array($checking['id_sub'],$id_sub) ){
		 		$valid = $valid+1;
		 	}
		 }

		 if($valid == count($id_jenis)){ 

			$sql = "INSERT INTO `total_dana` (id_user,id_jenis,id_sub,total_dana,tgl_total_dana,tahun) VALUES ";

			for ($i=0; $i < count($nama_dana) ; $i++) { 

				$sql .="('$id','$id_jenis','$id_sub[$i]','$nama_dana[$i]','$date','$year')";

				if($i != count($nama_dana)-1){
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
					echo "sukses";
					#header('location:./../dashboard.php?page=page=inp-total#');
				}else{
					echo "error";
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

		$sql = "SELECT * FROM user,total_dana,jenis_dana 
						 WHERE total_dana.id_user = user.id_user 
						 AND total_dana.id_jenis=jenis_dana.id_jenis 
						 AND total_dana.id_user='{$exp[0]}' 
						 AND total_dana.id_jenis = '{$exp[1]}' 
						 AND total_dana.tahun = '{$exp[2]}' ";

		$lihat_dana = $mysqli->query($sql);
		
		
		/*
			membuat array() dengan fungsi while
			ref : http://stackoverflow.com/questions/9105419/generate-array-from-php-while-loop
		*/

		$dana = array();
		while ( $lihat = $lihat_dana->fetch_assoc() ) {

			$dana[] = $lihat['total_dana'];

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
                    <p>Nalar : <code class=\"nalar-cur\">Rp. ".number_format($dana[0],0,',','.')."</code></p>
                    <p>Non Nalar : <code class=\"non-nalar-cur\">Rp. ".number_format($dana[1],0,',','.')."</code></p>
                    <p>Reor : <code class=\"reor-cur\">Rp. ".number_format($dana[2],0,',','.')."</code></p>
                </div>
                <hr>";
		
		
		break;

	#hapus data total_dana
	case 'delete':
		$group_id = $_POST['id']; // id_user-id_jenis-tahun
		
		$exp = explode('-', $group_id);

		$sql = "DELETE  FROM total_dana 
						WHERE id_user='{$exp[0]}' 
						AND id_jenis = '{$exp[1]}' 
						AND tahun = '{$exp[2]}' ";

		$delete = $mysqli->query($sql);
		break;

	# Edit Form Input Total dana
	case 'edit':
		$group_id = $_POST['id']; // id_user-id_jenis-tahun
		
		$exp = explode('-', $group_id);

		$sql = "SELECT * FROM total_dana,sub_dana 
						 WHERE total_dana.id_sub=sub_dana.id_sub
						 AND total_dana.id_user='{$exp[0]}' 
						 AND total_dana.id_jenis = '{$exp[1]}' 
						 AND total_dana.tahun = '{$exp[2]}' ";
		?>
		<h4>Edit Total Dana</h4>
		<form action="query/query.php" role="form">
	        <table class="table-form">
	            
			<?php
				$edit = $mysqli->query($sql);

				echo "<input type=\"hidden\" name=\"act\" value=\"update_sub_dana\">"
	                 ."<input type=\"hidden\" name=\"tahun\" value=\"{$exp[2]}\">"
	                 ."<input type=\"hidden\" name=\"id_user\" value=\"{$exp[0]}\">"
	                 ."<input type=\"hidden\" name=\"id_jenis\" value=\"{$exp[1]}\">";
				
				while ($sub_dana = $edit->fetch_assoc()) {

	            echo "<tr>"
	                ."<th colspan=\"3\">{$sub_dana['nama_sub']}</th>"
	            	."</tr>"
	            	."<tr>"
	                ."<td>Total Dana</td>"
	                ."<td>:</td>"
	                ."<td>"
	                ."<input type=\"hidden\" name=\"id[]\" value=\"{$sub_dana['id_sub']}\">"
	                ."<input type=\"text\" data=\"numb\" class=\"form-control\" name=\"dn_total[]\" placeholder=\"placeholder\" value=\"{$sub_dana['total_dana']}\">"
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
	case 'update_sub_dana':
		$id 		= $_POST['id_user'];
		$id_sub 	= $_POST['id'];
		$id_jenis 	= $_POST['id_jenis'];
		$nama_dana 	= $_POST['dn_total'];
		$tahun 		= $_POST['tahun'];


		for ($i=0; $i < count($nama_dana) ; $i++) { 
		
			$sql = "UPDATE total_dana SET total_dana='".$nama_dana[$i]."' WHERE tahun='$tahun' AND id_jenis='$id_jenis' AND id_user='$id' AND id_sub='".$id_sub[$i]."' ";

			$res = $mysqli->query($sql);

			if($res){
				$res = "sukses";
			}else{
				$res = "error";
			}
		}
		print_r($res);
		break;
	
	case 'aksi':
		$id  = $_POST['id'];
		$val = $_POST['val'];

		$sql = "UPDATE proker SET status ='$val' WHERE id_proker='$id' ";

		$query = $mysqli->query($sql);

		if($query){

			echo "sukses";
		}
		
		break;
	# jika @$parameter tidak ditemukan, maka blank
	default:

	die();
	
}