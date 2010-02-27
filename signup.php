<?php
session_start();

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");

requireNoLogin();

$what = 1;
if (isset($_POST['signup'])) {
	if (strtolower($_POST['check']) != strtolower($_SESSION['key']))
		setError("The security key did not match.");
	else {
		$pass = "";
		for ($i = 0; $i < 8; $i++) {
			if (rand(0, 4) == 0)
				$pass .= "".rand(0, 9);
			else if (rand(0, 1) == 0)
				$pass .= chr(rand(ord('A'), ord('Z')));
			else
				$pass .= chr(rand(ord('a'), ord('z')));
		}

		$user = new User(null);
		$user->setEmail($_POST['email']);
		$user->setmd5Password(md5($pass));
		$res = $user->save();

		phplog("New user setup! email={$_POST['email']} unlock={$pass}");

		if ($res) {
			send_setup_email($_POST['email'],$pass);
			$what = 2;
		}
	}
}

// to unlock the game
else if ($_GET['unlock']) {
	$what = 3;
	$user = User::getUserByPassword($_GET['unlock']);

	if (!$user) {
		setError("Sorry, there was an error processing your request! Please make sure you followed the correct link that was sent in the email.");
		phplog("Error! unlock={$_GET['unlock']}");

	}

	else if (isset($_POST['complete'])) {
		$ret = handle_Avatar(
			$user,
			$_FILES['avatar']);


		if ($ret != NULL) {

			$ret2 = handle_NameAndEmail(
				$user,
				$_POST['name'],
				$user->getEmail());


			if ($ret2 != NULL) {

				handle_Password(
					$user,
					$_GET['unlock'],
					$_POST['new1'],
					$_POST['new2']);
			}
		}

		// activate account
		if (numErrors() == 0) {
			$user->confirmAccount();
			$user->save();

			$what = 4;
		}
	}
}

$title = "registration";
include("top.php");

$e = displayErrors();
?>

<h2>signup</h2>

<?
if($what == 1) { ?>

<form method="POST" action="signup.php">
	<label for="email">email:</label>
	<input type="text" name="email" value="<?=$_POST['email']?>" />
	please do not have this be a school address as there has been trouble.
	<br/>
	<br/>
	Please prove you are human by entering in the security code.
	<br/>
	<img src="image.php">
	<br/>
	<br/>
	<label for="check">code:</label>
	<input type="text" name="check">
	<br/>
	<label for="signup">&nbsp;</label>
	<input type="submit" name="signup" value="sign me up!">
</form>
<? } else if ($what == 2) { ?>

<p>Thank you. You should recieve an e-mail with your password shortly.</p>

<? } else if ($what == 3 || ($what == 4 && $e)) {

	echo "<br>Please finish setting up your account here:<br><br>";
?>

<form enctype="multipart/form-data" method="POST" action="signup.php?unlock=<?=$_GET['unlock']?>">
	<label for="name">full name:</label>
	<input type="text" name="name">
	<br/>
	<label for="new1">new password:</label>
	<input type="password" name="new1">
	<br/>
	<label for="new2">password again:</label>
	<input type="password" name="new2">
	<br/>
	<input type="hidden" name="MAX_FILE_SIZE" value="2621440">
	<label for="avatar">avatar (JPG):</label>
	<input type="file" name="avatar">
	Please have this be an actual picture of yourself.
	<br/>
	<label for="complete">&nbsp;</label>
	<input type="submit" name="complete" value="let me play!">
</form>
<? } elseif($what == 4) { ?>

<p>Thank you. You should now be able to <a href="login.php">sign in</a>.</p>
<? }

include("bottom.php");
?>
