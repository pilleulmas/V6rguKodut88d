<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Suur täht</title>
    <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
    <style>
   
#wrap {
    width: 800px;
    margin: auto;
}
    </style>
</head>
<body>
<div id="wrap">
    <h1>Tagurpidi tekst</h1>
<?php
$text="See tekst on see, mille soovin esitada peegelpildis. See tähendab, et panen viimase tähe esimeseks ja niimoodi järgemööda, kuni jõuan esimese täheni, mis saab viimaseks.";
echo $text."<br><br>";
$txet ="";

for ($i = strlen($text)-1; $i>=0; $i--){
	$txet= $txet."$text[$i]";
}
echo $txet."<br><br>";

$proov = strrev($text);
echo $proov."<br><br>";

?>
</div>
</body>
</html>