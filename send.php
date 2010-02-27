<?php
session_start();
include_once("database.inc");
include_once("user.inc");
include_once("util.inc");

$user = requireLogin();

unset($message);

// a function to strip a string of stuff
function fixStr($string) {
	return strip_tags(trim($string));
}

$title = "questions & comments";
include("top.php");

// see if anything has been posted
if(isset($_POST['submit'])) {
	$subject = fixStr($_POST['subject']);
	$from = fixStr($_POST['from']);
	$emailMessage = fixStr($_POST['message']);

	// check post for errors

	// invalid key
	if (strcasecmp($_POST['proof'], $_SESSION['key']) != 0)
		setError("The entered verification key did not match.");

	// incomplete fields
	else if(strlen($subject) == 0 || strlen($emailMessage) == 0)
		setError("One or more fields were left blank.");

	// sending error
	else if(!mail("taylor.assassins@gmail.com",
			"Assassins question...",
			"Subject: $subject\nFrom: {$user->getUsername()} ({$user->getEmail()})\n\n$emailMessage",
			"From: ".$user->getEmail()))
		setError("Message failed to send. This is not good! Please try again or contact the webmaster in person.");

	else
		$message = "Message sent. Go <a href='index.php'>back</a>";

}

$e = displayErrors();

if (isset($message))
	echo "<div class='message'>$message</div>";

	// normal layout for the page
?>
<h2>questions and comments</h2>

<form action='send.php' method='POST'>
	<label for="subject">subject:</label>
	<input type='text' name='subject' size=36 maxlength=36
		value='Question about assassins'>
	<br>
	<label for="message">message:</label>
	<textarea name='message' rows=8 cols=60></textarea>
	<br><br>
	<img src='image.php'>
	If you have trouble reading the code, try refreshing the page.
	<br><br>
	<label for="proof">verification:</label>
	<input type='text' name='proof'>
	<br>
	<label for="submit">&nbsp;</label>
	<input type='submit' name='submit' value='Submit'>
</form>
<?php

include("bottom.php");
?>
