<?php

include_once("database.inc");
include_once("util.inc");

requireLogin();

$ouser = User::getUser($_GET['username']);
if ($ouser)
	$title = $ouser->getUsername();
else
	setError("Unable to find player.");

include("top.php");

$e = displayErrors();

if (!$e) {
	echo "<h2>{$ouser->getFullName()}</h2>\n<br>\n".
		"<img src='ava.php?username={$ouser->getUsername()}'>\n\n";
}

include("bottom.php");
?>
