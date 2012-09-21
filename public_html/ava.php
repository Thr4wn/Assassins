<?php
include_once("database.inc");
include_once("util.inc");

requireLogin(true);

$ouser = User::getUser($_GET['username']);
if (!$ouser) exit;

$mime = $ouser->getMime();
$data = $ouser->getAva();

header("Content-Type: $mime");
print $data;
?>
