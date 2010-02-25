<?php
session_start();

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");

requireNoLogin();

$showform = true;

if (isset($_POST['submit'])) {
	$user = User::getUserByEmail($_POST['email']);

	if (!$user)
		setError("Unable to find an account registered with that email.");

	else {
		$newpass = "";
		for ($i = 0; $i < 8; $i++) {
			if (!rand(0, 4))
				$newpass .= rand(0, 9);
			else if (!rand(0, 1))
				$newpass .= chr(rand(ord('A'), ord('Z')));
			else
				$newpass .= chr(rand(ord('a'), ord('z')));
		}

		$user->setmd5Password(md5($newpass));
		$user-save();

		mail($_POST['email'],
			"New assassins password",
			"Your new assassins password is: $newpass\n\nYou can login to the assassins site here: http://assassins.homelinux.org/assassins/login.php",
			"From: taylor.assassins@gmail.com");
		$showform = false;
		$message = "<p>Your new password has been e-mailed to you</p>";
	}
}

$title = "forgotten passwords";
include("top.php");

displayErrors();

echo "<h2>$title</h2>";

if ($showform)
{
?>

<form method="POST" action="forgot.php">
	<label for="email">email:</label>
	<input type="name" name="email" value="<?=$_POST['email']?>">
	<br/>
	<label for="submit">&nbsp;</label>
	<input type="submit" name="submit" value="send new password">
</form>

<?
} else echo "<div class='message'>$message</div>\n";

echo "<br/><a href='login.php'>back to home page</a>\n";

include("bottom.php");
?>
