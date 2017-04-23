<?php
require_once("head.html");
$pildid = array(
    "pildid/nameless1.jpg",
    "pildid/nameless2.jpg",
    "pildid/nameless3.jpg",
    "pildid/nameless4.jpg",
    "pildid/nameless5.jpg",
    "pildid/nameless6.jpg");
?>
<div id="wrap">
	<?php if (isset($_POST["pilt"]) OR isset($_SESSION['voted'])): ?>
		<?php if(!isset($_SESSION['voted'])):?>
			<?php $_SESSION["voted"]=$_POST["pilt"];?>
				<h2>Aitäh! Valisid järgeva pildi:</h2>
				<img src="pildid/nameless<?php echo $_POST["pilt"] ?>.jpg"
						alt="nimetu <?php echo $_POST["pilt"] + 1; ?>">
		<?php else: ?>
				<h2>Sa oled juba oma valiku teinud:</h2>
				<img src="pildid/nameless<?php echo $_SESSION["voted"] ?>.jpg"
						alt="nimetu <?php echo $_SESSION["voted"] + 1; ?>">
		<?php endif;?>
	<?php else: ?>
		<h2>Pilt on veel valimata!</h2>
	<?php endif; ?>

	</br>

	<a href="uusSessioon.php">Alusta uut sessiooni!</a>
    
</div>

<?php
require_once("foot.html");
?>