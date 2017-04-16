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
	<?php if (isset($_POST["pilt"])): ?>
		<h2>Aitäh! Valisid järgeva pildi:</h2>
		<img src="pildid/nameless<?php echo $_POST["pilt"] ?>.jpg"
				alt="nimetu <?php echo $_POST["pilt"] + 1; ?>">
	<?php else: ?>
		<h2>Pilt on veel valimata!</h2>
	<?php endif; ?>
</div>
<?php
require_once("foot.html");
?>