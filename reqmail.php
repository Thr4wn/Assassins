<?php

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
  mail($_CONFIG['email'],
      "Mass Email Request",
      "User: {$user->getFullName()}\n".
      "Subject: {$_POST['subject']}\n".
      "Message:\n{$_POST['message']}\n\n".
      "http://{$_CONFIG['hostname']}/mail.php?id={$game->getId()}&username={$user->getUsername()}&type=mailall&subject=".urlencode($_POST['subject']),
      $_CONFIG['addheaders']);
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
?>
<p>Using this form, you may send an approval request to the system administrator for an email to be sent to all players in this game on your behalf. If approved, your username will show up in the email.</p>
<form action='reqmail.php?id=<?=$game->getId()?>' method='post'>
  <div>
  <input type=hidden value=1 name='send'>
  <label for='subject'>subject:</label>
  <input type=text name='subject' id='subject' maxlength=50><br>
  <label for='message'>message:</label>
  <textarea name='message' id='message' rows=8 cols=60></textarea><br>
  <label for='submit'>&nbsp;</label>
  <input type='submit' name='submet' id='submit' value='Request Approval'>
  </div>
</form>
<?php
  } else {
    echo "<p><a href='game.php?id={$game->getId()}'>Back to the game</a></p>";
  }
}

include("bottom.php");
?>
