<html>
<head>
<title>Assassins<? if(isset($title)) echo ": ".$title; ?></title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

<h1><a href="./">Assassins</a></h1>
<div class="content">
<?php
if(isset($_SESSION['userid']))
{
	echo "<div class='right'>\n";
  if (isset($_SESSION['userid']) && $_SESSION['userid'] == $_CONFIG['admin_id']) {
    echo "<a href='impersonate.php'>impersonate user</a> &middot; ";
  }
  echo "<a href='profile.php'>edit profile</a> &middot; ";
  echo "<a href='login.php?logout=1'>logout</a></div>\n";
}
if(!isset($noshow))
{
	echo "<a href='./'>home</a> &middot <a href='learn.php'>rules</a>\n";
}
?>
