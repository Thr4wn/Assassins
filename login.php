<?php
session_start();

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");

// see if we are logging out or the cookie expired
$logout = $_GET['logout'];
if (isset($logout)) {
	$user = requireLogin();

	if (isset($_COOKIE['asn_who'])) {
		setcookie("asn_who", $_COOKIE['asn_who'], time() - 60*60*24*30, "/");
		unset($_COOKIE['asn_who']);
	}

	if (isset($_COOKIE['asn_pas'])) {
		setcookie("asn_pas", $_COOKIE['asn_pas'], time() - 60*60*24*30, "/");
		unset($_COOKIE['asn_pas']);
	}

	// unset all the session variables/cookie and destroy the session
	unset($_SESSION);
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
		unset($_COOKIE[session_name()]);
	}

	session_destroy();
}

// see if the player wants to be auto-logined
if (isset($_COOKIE['asn_who']) && isset($_COOKIE['asn_pas'])) {
	$result = sql(
		"SELECT * from a_users ".
		"WHERE MD5(email)='{$_COOKIE['asn_who']}' ".
		" AND password='{$_COOKIE['asn_pas']}' "
		);

	if (bad($result))
		setError("Unable to login. Please contact the <a href='mailto:taylor.assassins@gmail.com'>administrator</a>.");

	else if ($row = mysql_fetch_array($result)) {
    $user = User::getUser($row['id']);

    if (!$user->isBanned()) {
      $_SESSION['userid'] = $row['id'];
      setcookie("asn_who", $_COOKIE['asn_who'], time() + 60*60*24*30, "/");
      setcookie("asn_pas", $_COOKIE['asn_pas'], time() + 60*60*24*30, "/");
      header("Location: ./");
    }
	}
}

// see if the player is not logged in
else if (isset($_POST['login'])) {
	$user = User::getUserByEmail($_POST['email']);
	if (!$user)
		setError("That email address is not registered!");

	else if ($user->getLimbo())
		setError("That email address is registered, but you have not activated your account! Please go to the URL that was sent to your email account. If you have not received this email, check your spam folder.");

  else if ($user->isBanned())
    setError("You have been banned! If you believe you have been banned in error, please contact the <a href='mailto:taylor.assassins@gmail.com'>administrator</a>.");

	else if ($user->getPassword() != md5($_POST['password']))
		setError("Password incorrect.");

	else {
		if (isset($_POST['remember'])) {
			setcookie("asn_who", md5($user->getEmail()), time() + 60*60*24*30, "/");
			setcookie("asn_pas", $user->getPassword(), time() + 60*60*24*30, "/");
		}

		$_SESSION['userid'] = $user->getId();
		header("Location: ./index.php");
	}
}

$noshow = true;
$title = "login";
include("top.php");

displayErrors();
?>

<h2>login</h2>

<form method="POST" action="login.php">
	<label for="email">email:</label>
	<input type="text" name="email" value="<?=$_POST['email']?>" />
	<br/>
	<label for="password">password:</label>
	<input type="password" name="password" />
	<br/>
	<label for="remember">&nbsp;</label>
	<input type="checkbox" name="remember" value="remember me" />remember me
	<br/>
	<label for="login">&nbsp;</label>
	<input type="submit" name="login" value="okay" />
	<br/>
	<br/>
	&gt; I <a href="forgot.php">forgot</a> my password
	<br/>
	&gt; I want to <a href="signup.php">signup</a>
</form>

<h2>what is assassins?</h2>
<p>
	While different rounds may have twists and variations,
	the basic game of Assassin is fairly straightforward:
	One player is randomly designated the Assassin,
	and must try to exterminate all other players.
	The other players must discover the identity of the Assassin, and kill him.
	The game is over when either the Assassin is stopped,
	or all other players are dead.
	<a href="learn.php">Learn more &raquo;</a>
</p>

<?php include("bottom.php"); ?>
