<?php
session_start();

include_once("database.inc");
include_once("util.inc");

requireLogin();

$ouser = User::getUser($_GET['id']);
if ($ouser)
	$title = $ouser->getUsername();
else
	setError("Unable to find player.");

include("top.php");

$e = displayErrors();

if (!$e) {
	echo "<h2>{$ouser->getUsername()}</h2>\n<br>\n".
		"<img src='ava.php?id={$ouser->getId()}'>\n\n";
}

include("bottom.php");
?>
