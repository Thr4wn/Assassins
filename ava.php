<?php
session_start();

include_once("database.inc");
include_once("util.inc");

requireLogin();

$ouser = User::getUser($_GET['id']);
if (!$ouser) exit;

$mime = $ouser->getMime();
$data = $ouser->getAva();

header("Content-Type: $mime");
print $data;
?>
