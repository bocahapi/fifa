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

switch($parameter){

	case 'edit-user':
		$id = $_POST['id'];
		$query = $mysqli->prepare("SELECT id_user,nama,id_jabatan FROM user WHERE id_user= ? ");
		$query->bind_param('i',$id);
		$query->execute();
		$query->bind_result($id_user,$nama,$id_jabatan);
		$query->fetch();
		$query->close();

		?>
		<form role="form" method="post" action="query/query.php">
        <table class="table-form">
            <tr>
                <td>
                    <label for="">Nama</label>
                </td>
                <td>:</td>
                <td>
                    <input type="hidden" name="act" value="update-user">
                    <input type="hidden" name="id" value="<?php echo $id_user ;?>">
                    <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php echo $nama; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Jabatan</label>
                </td>
                <td>:</td>
                <td>
                    <select id="" name="jabatan" class="form-control">
                    <option value="">Pilih Jabatan</option>
                    <?php
                        $sql = "SELECT * FROM jabatan";
                        $jabatan = $mysqli->query($sql);
                        while ( $content = $jabatan->fetch_assoc() ) {
                        	$selected = ($content['id_jabatan'] == $id_jabatan) ? " selected" : "" ;
                            echo "<option value=\"{$content['id_jabatan']}\" {$selected}>{$content['jabatan']}</option>";
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Username</label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Password</label>
                </td>
                <td>:</td>
                <td>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </td>
            </tr>
        </table>
		<?php
		break;

	case 'add-user':
		$nama     = $_POST['nama'];
		$jabatan  = $_POST['jabatan'];
		$username = $_POST['username'];
		$pass 	  = htmlentities($_POST['password']);

		
		# Enkripsi Password;
		$password = CryptPass($pas);
		$insert = $mysqli->query("INSERT INTO `user` (username,password,nama,id_jabatan) VALUES ('$username','$password','$nama','$jabatan') ");
		
		if($insert){
			
			header('location:./../dashboard.php?#sukses');
		
		}else{

			header('location:./../dashboard.php?#error');
		}
	break;

	case 'posting':
		$title   = $_POST['title'];
		$posting = $_POST['informasi']; 
		$insert = $mysqli->query("INSERT INTO `informasi` (judul,isi) VALUES ('$title','$posting') ");
		
		if($insert){
			
			header('location:./../dashboard.php?page=mnj-info#sukses');
		
		}else{

			header('location:./../dashboard.php?page=mnj-info#error');
		}

	break;

	case 'update-user':

		$id = $_POST['id'];
		$nama = $_POST['nama'];
		$jabatan  = $_POST['jabatan'];
		$username = $_POST['username'];
		$pass = $_POST['password'];

		# Check Username dan password,
		$query = $mysqli->prepare("SELECT username, password FROM user WHERE id_user= ? ");
		$query->bind_param('i',$id);
		$query->execute();
		$query->bind_result($username_old,$password_old);
		$query->fetch();
		$query->close();

		if($username == ''){
			$username = $username_old;
		}
		if($pass == ''){
			$password = $password_old;
		}else{
			$pass = htmlentities($pass);
			$password = CryptPass($pass);
		}

		$update = $mysqli->query("UPDATE `user` SET username='$username',password='$password',nama='$nama',id_jabatan='$jabatan' WHERE id_user='$id' ");

		if($update){
			
			print('sukses');
		
		}else{

			print('gagal');
		}
		break;

		case 'delete-user':
			$id = $_POST['id'];
			$delete = $mysqli->query("DELETE FROM `user` WHERE id_user='$id' ");
			if($delete){
				print('sukses');
			}else{
				print('gagal');
			}
			break;
	
	# jika @$parameter tidak ditemukan, maka blank
	default:

	die();
}