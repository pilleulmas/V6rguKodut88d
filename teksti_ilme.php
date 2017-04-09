<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Teksti muutmine</title>
<style>
	body { }
	div {
		background:#EBDEF0;
		padding: 25px;
	}
	#output {
		
	}
	#input {
		border-color: #F5CBA7;
		border-width: 5px;
		border-style: double;
		border-radius: 25px;
	}
</style>
</head>
<body>
<?php $text="Siia sisesta soovitud tekst.";
if (isset($_POST['message']) && $_POST['message']!="") {
    $text=htmlspecialchars($_POST['message']);
}
$bg_col="#21618C";
if (isset($_POST['bg_color']) && $_POST['bg_color']!="") {
    $bg_col=htmlspecialchars($_POST['bg_color']);
}
$text_col="#FCF3CF";
if (isset($_POST['text_color']) && $_POST['text_color']!="") {
    $text_col=htmlspecialchars($_POST['text_color']);
}
$font="Times New Roman";
if (isset($_POST['font_fam']) && $_POST['font_fam']!="") {
    $font=htmlspecialchars($_POST['font_fam']);
}
$f_size="15";
if (isset($_POST['font_size']) && $_POST['font_size']!="") {
    $f_size=htmlspecialchars($_POST['font_size']);
}
$bd_col="#F39C12";
if (isset($_POST['border_col']) && $_POST['border_col']!="") {
    $bd_col=htmlspecialchars($_POST['border_col']);
}
$bd_width="5";
if (isset($_POST['border_width']) && $_POST['border_width']!="") {
    $bd_width=htmlspecialchars($_POST['border_width']);
}
$bd_style="solid";
if (isset($_POST['border_style']) && $_POST['border_style']!="") {
    $bd_style=htmlspecialchars($_POST['border_style']);
}
$bd_rad="25";
if (isset($_POST['border_rad']) && $_POST['border_rad']!="") {
    $bd_rad=htmlspecialchars($_POST['border_rad']);
}
?>
<div>
	<div id=output style="
	background: <?php echo $bg_col; ?>;
	color: <?php echo $text_col; ?>;
	font-family: <?php echo $font; ?>;
	font-size: <?php echo $f_size; ?>px;
	border-color: <?php echo $bd_col; ?>;
	border-width: <?php echo $bd_width; ?>px;
	border-style: <?php echo $bd_style; ?>;
	border-radius: <?php echo $bd_rad; ?>px;
	">
		<?php echo $text; ?>
	</div>
	<div id=input>
	<hr>
		<form  action="teksti_ilme.php" method="post">
			<textarea name="message" rows="5" cols="20" placeholder="Siia sisesta soovitud tekst."><?php if (isset($text)) echo $text;?></textarea><br>
			<input type="color" name="bg_color" value="<?php if (isset($bg_col)) echo $bg_col;?>"> Tausta värvus <br>
			<input type="color" name="text_color" value="<?php if (isset($text_col)) echo $text_col;?>"> Teksti värvus <br>
			<select name="font_fam">
				<option value="Times New Roman" <?php if (isset($font)&&$font=="Times New Roman") echo "selected";?>>Times New Roman</option>
				<option value="Verdana" <?php if (isset($font)&&$font=="Verdana") echo "selected";?>>Verdana</option>
				<option value="Comic Sans MS" <?php if (isset($font)&&$font=="Comic Sans MS") echo "selected";?>>Comic Sans MS</option>
				<option value="Georgia" <?php if (isset($font)&&$font=="Georgia") echo "selected";?>>Georgia</option>
			</select> <br>		
			<input type="number" name="font_size" value="<?php if (isset($f_size)) echo $f_size;?>" min="10" max="50"> Teksti suurus (10-50px) <br>
			<hr>
			<input type="color" name="border_col" value="<?php if (isset($bd_col)) echo $bd_col;?>"> Piirjoone värvus <br>
			<input type="number" name="border_width" value="<?php if (isset($bd_width)) echo $bd_width;?>" min="1" max="20"> Piirjoone paksus (1-20px) <br>
			<select name="border_style">
				<option value="solid" <?php if (isset($bd_style)&&$bd_style=="solid") echo "selected";?>>solid</option>
				<option value="double" <?php if (isset($bd_style)&&$bd_style=="double") echo "selected";?>>double</option>
				<option value="dotted" <?php if (isset($bd_style)&&$bd_style=="dotted") echo "selected";?>>dotted</option>
				<option value="groove" <?php if (isset($bd_style)&&$bd_style=="groove") echo "selected";?>>groove</option>
				<option value="ridge" <?php if (isset($bd_style)&&$bd_style=="ridge") echo "selected";?>>ridge</option>
			</select> <br>
			<input type="number" name="border_rad" value="<?php if (isset($bd_rad)) echo $bd_rad;?>" min="0" max="100"> Piirjoone raadius (0-100px) <br>
			<hr>		
			<input type="submit" value="esita">
		</form>
	</div>
</div>
<p>
	<a href="http://validator.w3.org/check?uri=referer">
		<img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
	</a>
</p>
</body>
</html>