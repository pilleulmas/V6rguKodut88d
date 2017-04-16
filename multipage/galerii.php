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
    <h3>Fotod</h3>
    <div id="gallery">
        <?php foreach ($pildid as $nr => $pilt): ?>
            <img src="pildid/nameless<?php echo $nr + 1; ?>.jpg" alt="nimetu <?php echo $nr + 1; ?>"/>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once("foot.html"); ?>