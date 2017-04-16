<?php require_once("head.html");
$pildid = array(
    "pildid/nameless1.jpg",
    "pildid/nameless2.jpg",
    "pildid/nameless3.jpg",
    "pildid/nameless4.jpg",
    "pildid/nameless5.jpg",
    "pildid/nameless6.jpg");
?>
<div id="wrap">
	<h3>Vali oma lemmik :)</h3>
	<form action="tulemus.php" method="GET">
		<?php foreach ($pildid as $nr => $pilt): ?>
			<p>
				<label for="p<?php echo $nr + 1; ?>">
					<img src="pildid/nameless<?php echo $nr + 1; ?>.jpg" alt="nimetu <?php echo $nr + 1; ?>" height="100"/>
				</label>
				<input type="radio" value="<?php echo $nr + 1; ?>" id="p<?php echo $nr + 1;?>" name="pilt"/>
			</p>
		<?php endforeach; ?>
		<br/>
		<input type="submit" value="Valin!"/>
	</form>
</div>
<?php require_once("foot.html"); ?>