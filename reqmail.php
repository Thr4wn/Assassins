<?php
session_start();

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

unset($message);

$showform = false;

$game = Game::getGame($_GET['id']);
if (!$game)
	setError("Game not found!");
else if (!$game->isAdmin($user))
  setError("You are not the admin of that game!");
else if ($_POST['send']) {
  // logic here
  mail(User::getUser($_CONFIG['admin_id'])->getEmail(),
      "Mass Email Request",
      "User: {$user->getUsername()}\n".
      "Subject: {$_POST['subject']}\n".
      "Message:\n{$_POST['message']}\n\n".
      "http://assassins.homelinux.org/assassins/mail.php?id={$game->getId()}&userid={$user->getId()}&subject=".urlencode($_POST['subject']),
      "From: taylor.assassins@gmail.com");
  $message = "Request for email sent.";
} else
  $showform = true;

$title = "request email to all players";
include("top.php");

$e = displayErrors();

if (isset($message))
  echo "<div class='message'>$message</div>";

if (!$e) {
  if ($showform) {
    echo "<br/><br/>Using this form, you may send an approval request to the system administrator for an email to be sent to all players in this game on your behalf. If approved, your username will show up in the email.<br/><br/>\n";
    echo "<form name='req_mail?id={$game->getId()}' method='post'>\n";
    echo "<input type=hidden value=1 name='send'/>\n";
    echo "<label for='subject'>subject:</label>\n";
    echo "<input type=text name='subject' maxlength=50/><br/>\n";
    echo "<label for='message'>message:</label>\n";
    echo "<textarea name='message' rows=8 cols=60></textarea><br/>\n";
    echo "<label for='submit'>&nbsp;</label>\n";
    echo "<input type=submit value='Request Approval'/></form>\n";
  } else {
    echo "<p><a href='game.php?id={$game->getId()}'>Back to the game</a></p>";
  }
}

include("bottom.php");
?>
