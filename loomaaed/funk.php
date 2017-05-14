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
	if (isset($_POST['user'])) {
		include_once('views/puurid.html');
	}
	if (isset($_SERVER['REQUEST_METHOD'])) {
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
		  		global $connection;
		  		$username = mysqli_real_escape_string($connection, $_POST["user"]);
		  		$passw = mysqli_real_escape_string($connection, $_POST["pass"]);
		  		
				$query = "SELECT id FROM pulmas_kylastajad WHERE username='$username' && passw=SHA1('$passw')";
				$result = mysqli_query($connection, $query) or die("midagi läks valesti");
			
				$ridu = mysqli_num_rows($result);
					if ( $ridu > 0) {
						$_SESSION['user'] = $username;
						header("Location: ?page=loomad");
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
		$query = "SELECT DISTINCT(puur) FROM `pulmas_loomaaed`";
		$result = mysqli_query($GLOBALS["connection"], $query) or die("$query - " . mysqli_error($GLOBALS["connection"]));
		$result = mysqli_fetch_all($result);
		foreach ($result as $array) {
			foreach ($array as $innerArray) {
				$puurid[$innerArray] = array();
				$forEachResult = mysqli_query($GLOBALS["connection"], "SELECT `nimi`, `liik` FROM `pulmas_loomaaed` WHERE puur=" . (string)$innerArray)
				or die("$query - " . mysqli_error($GLOBALS["connection"]));
				$forEachResult = mysqli_fetch_all($forEachResult);
				foreach ($forEachResult as $loomaNimiArrayna) {
					foreach ($loomaNimiArrayna as $loomaNimi) {
						array_push($puurid[$innerArray], $loomaNimi);
					}
				}
			}
		}
		$_SESSION["puurid"] = $puurid;
		include_once('views/puurid.html');
	} else {
		include_once 'views/login.html';
	}
}

function lisa(){
	if (empty($_SESSION['user'])) {
		include_once 'views/login.html';
	}
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
			}
	  	} 
	}
	include_once('views/loomavorm.html');
	
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