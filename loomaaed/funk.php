<?php


function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function logi(){
	global $connection;
	if (!empty($_SESSION["user"])) {
        header("Location: ?page=loomad");
	} else {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		  	$errors = array();
		  	if (empty($_POST['user']) || empty($_POST['pass'])) {
		  		if(empty($_POST['user'])) {
			    	$errors[] = "kasutajanimi on puudu";
				}
				if(empty($_POST['pass'])) {
					$errors[] = "parool on puudu";
				} 
		  	} else {
		  		$username = mysqli_real_escape_string($connection, $_POST["user"]);
		  		$passw = mysqli_real_escape_string($connection, $_POST["pass"]);
		  		
				$query = "SELECT id FROM pulmas_kylastajad WHERE username='$username' && passw=SHA1('$passw')";
				$result = mysqli_query($connection, $query) or die("midagi läks valesti");
			
				$queryresult = mysqli_fetch_assoc($result);
				$role = $queryresult['roll'];
			
				$ridu = mysqli_num_rows($result);
					if ( $ridu > 0) {
						$_SESSION['user'] = $username;
						$_SESSION['roll'] = $role;
						if ($_SESSION['roll'] == 'admin') {
							header("Location: ?page=lisa");	
						} else {
							header("Location: ?page=loomad");	
						}
					}
		  	}
		} else {
			 include_once 'views/login.html';
		}
	}

	include_once('views/login.html');
}

function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}

function kuva_puurid(){
	if (!empty($_SESSION['user'])) {
		global $connection;
		$p= mysqli_query($connection, "select distinct(puur) as puur from pulmas_loomaaed order by puur asc");
		$puurid=array();
		while ($r=mysqli_fetch_assoc($p)){
			$l=mysqli_query($connection, "SELECT * FROM pulmas_loomaaed WHERE  puur=".mysqli_real_escape_string($connection, $r['puur']));
			while ($row=mysqli_fetch_assoc($l)) {
				$puurid[$r['puur']][]=$row;
			}
		}
		include_once('views/puurid.html');
	} else {
		include_once 'views/login.html';
	}
}

function lisa(){
	if (empty($_SESSION['user'])) {
		include_once 'views/login.html';
	}else {
        if ($_SESSION["role"] == 'admin'){ 
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$errors = array();
				if(empty($_POST['nimi'])) {
					$errors[] = "nimi on puudu";
				}
				if(empty($_POST['puur'])) {
					$errors[] = "puur on puudu";
				}
				$pilt = upload("liik");
				if ($pilt == "") {
					$errors[] = "pilt on puudu";
				}
				if (empty($errors)) {
					global $connection;
					$loomanimi = mysqli_real_escape_string($connection, $_POST["nimi"]);
					$puurinr = mysqli_real_escape_string($connection, $_POST["puur"]);
					$query = "INSERT INTO pulmas_loomaaed (nimi, liik, puur) VALUES ('$loomanimi', '$pilt', '$puurinr')";
					$result = mysqli_query($connection, $query) or die("midagi läks valesti");;
				
					if (mysqli_insert_id($connection) > 0) {
						header("Location: ?page=loomad");
					} else {
						header("Location: ?page=loomavorm");
					}
				} 
			}
		} else {
            header("Location: ?page=loomad");
        }
	}
	include_once('views/loomavorm.html');
}

function muuda(){
	global $connection;
	if (empty($_SESSION['user'])) {
		header("Location: ?page=login");
	}
	if ($_SESSION['role'] == 'user') {
		header("Location: ?page=loomad");
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && $_GET['id'] != "") {
		$id = $_GET['id'];
		$animal = hangi_loom(mysqli_real_escape_string($connection, $id)); 
	} else {
		header("Location: ?page=loomad");
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['muuda'])) {
	$errors = array();
	if (empty($_POST['nimi'])) {
		$errors[] = "nimi puudub";
	}
	if (empty($_POST['puur'])) {
		$errors[] = "puur puudub";
	}
	
	if (empty($errors)) {
		$id = $_POST['muuda'];
		$loom = hangi_loom(mysqli_real_escape_string($connection, $id));
		
		$loom['nimi'] = mysqli_real_escape_string($connection, $_POST["nimi"]);
		$loom['puur'] = mysqli_real_escape_string($connection, $_POST["puur"]);
		$liik = upload("liik");
			if ($liik != "") {
				$loom['liik'] = $liik;
			}
		}
		$query = "UPDATE pulmas_loomaaed SET nimi='".$loom['nimi']."', liik='".$loom['liik']."', puur=".$loom['puur']."  WHERE id=".$id; 
		$result = mysqli_query($connection, $query) or die("ei muutnud midagi");
		header("location: ?page=loomad");
	}
	include_once('views/editvorm.html');
}

function hangi_loom($id) {
	global $connection;
	$query = "SELECT * FROM pulmas_loomaaed WHERE id=".$id;
	$result = mysqli_query($connection, $query) or die("midagi läks valesti");
 	if ($animaldata = mysqli_fetch_assoc($result)) {
		return $animaldata;
	}
	else {
		header("Location: ?page=loomad");
	}
}

function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$extension = end(explode(".", $_FILES[$name]["name"]));

	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
    // fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
      // vigu ei ole
			if (file_exists("pildid/" . $_FILES[$name]["name"])) {
        // fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pildid/" .$_FILES[$name]["name"];
			} else {
        // kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
				return "pildid/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

?>