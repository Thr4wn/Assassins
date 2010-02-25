<?php
session_start();
include_once("database.inc");
include_once("util.inc");

$user = requireLogin();

unset($message);

if ($user) {
	// to update name and email
	if (isset($_POST['update'])) {
		$message = handle_NameAndEmail(
			$user,
			$_POST['name'],
			$_POST['email']);
	}

	// to update the avatar
	else if (isset($_POST['cava'])) {
		$message = handle_Avatar(
			$user,
			$_FILES['avatar']);
	}

	// to update password
	else if (isset($_POST['pass'])) {
		$message = handle_Password(
			$user,
			$_POST['old'],
			$_POST['new1'],
			$_POST['new2']);
	}
} else
	setError("Unable to find you in the database!");

$title = "edit profile";
include("top.php");

$e = displayErrors();

if(isset($message))
	echo "<div class='message'>$message</div>";

?>

<h2><a href="who.php?id=<?=$user->getId()?>"><?=$user->getUsername();?></a></h2>

<h3 class='rule'>personal</h3>
<form method="POST" action="profile.php">
	<label for="name">name:</label>
	<input name="name" type="text" value="<?
			if (isset($_POST['name']) && !$e)
				echo $_POST['name'];
			else
				echo $user->getUsername();
			?>">
	<br>
	<label for="email">email:</label>
	<input name="email" type="text" value="<?
			if (isset($_POST['email']) && !$e)
				echo $_POST['email'];
			else
				echo $user->getEmail();
			?>">
	<br>
	<label for="update">&nbsp;</label>
	<input type="submit" name="update" value="update">
</form>

<h3>avatar</h3>
<label for="cur">Current picture:</label><img src='ava.php?id=<?=$user->getId()?>'/><br/>
<form enctype="multipart/form-data" method="POST" action="profile.php">
	<input type="hidden" name="MAX_FILE_SIZE" value="2621440">
	<label for="avatar">New avatar:</label>
	<input type="file" name="avatar">
	Please have this be an actual picture of yourself.<br/>
	<label for="aoeu">&nbsp;</label>(JPG, PNG, or GIF)<br/>
	<br>
	<label for="cava">&nbsp;</label>
	<input type="submit" name="cava" value="change avatar">
</form>

<h3>password</h3>
<form method="POST" action="profile.php">
	<label for="old">password:</label>
	<input type="password" name="old">
	<br>
	<label for="new1">new password:</label>
	<input type="password" name="new1">
	<br>
	<label for="new2">again:</label>
	<input type="password" name="new2">
	<br>
	<label for="pass">&nbsp;</label>
	<input type="submit" name="pass" value="change password">
</form>

<?php
include("bottom.php");
?>
