<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Assassins<? if(isset($title)) echo ": ".$title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css" type="text/css">
<?php if (isset($headers)) echo $headers;?>
<?php if (isset($recaptchaopts)) echo $recaptchaopts;?>
</head>
<body>

<h1><a href="./">Assassins</a></h1>
<div class="content">
<?php
if (isset($user))
{
  echo "<div class='right'>\n";
  echo "{$user->getFullName()} | ";

  if ($isimpersonating)
    echo "<a href='impersonate.php?stop'>stop impersonating</a> &middot; ";
  else if (isAdmin($user))
    echo "<a href='impersonate.php'>impersonate user</a> &middot; ";

  if (isAdmin($user))
    echo "<a href='poll_manage.php'>polls</a> &middot; ";
  ?>

  <a href='profile.php'>edit profile</a>
  &middot; <a href='logout.php'>logout</a>
</div>

<?php
}
if(!isset($noshow))
{
	echo "<a href='main.php'>home</a> &middot <a href='rules.php'>rules</a>\n";
}
?>
