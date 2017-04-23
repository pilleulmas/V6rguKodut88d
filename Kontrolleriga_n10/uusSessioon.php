<?php $_SESSION = array();
if (isset($_SESSION['LAST_ACTIVITY']) && 
	(time()-$_SESSION['LAST_ACTIVITY'] > $expire))
{ session_destroy();}
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-42000, '/');
}
echo "<script>window.location = 'kontroller.php'</script>";
?>
