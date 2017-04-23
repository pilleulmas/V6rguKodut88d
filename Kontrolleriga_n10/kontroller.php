<?php session_start();?>
<?php require_once('head.html'); ?>
<?php $pildid = array(
    "pildid/nameless1.jpg",
    "pildid/nameless2.jpg",
    "pildid/nameless3.jpg",
    "pildid/nameless4.jpg",
    "pildid/nameless5.jpg",
    "pildid/nameless6.jpg");
if (!empty($_GET["mode"])) {
    $page = $_GET["mode"];
} else {
    $page = "pealeht";
}
switch ($page) {
    case "galerii":
        require('galerii.php');
        break;
    case "vote":
        require('vote.php');
        break;
    case "tulemus":
        require('tulemus.php');
        break;
    default:
        require('pealeht.php');
        break;
}
require_once('foot.html');
?>