<?php

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

unset($message);

$showform = false;

$game = Game::getGame($_GET['id']);
$sending_user = User::getUser($_GET['username']);

if (!$game)
  setError("Game not found!");
else if (!isAdmin($user))
  setError("You are not the administrator! Shame on you for trying to hack the system!");
else if (!$sending_user)
  setError("No sending user specified!");
else if ($_POST['send']) {
  $subject = "Assassins: ".$_POST['subject'];
  $emessage = $_POST['message']."\n\n- {$sending_user->getFullName()}";
  mailPlayers($game->getPlayers(), $subject, $emessage, true);
  $message = "Message sent";
} else
  $showform = true;

$title = "Mail Players";
include("top.php");

$e = displayErrors();

if (isset($message))
  echo "<div class='message'>$message</div>";

if (!$e) {
  if ($showform) {
?>
<h2>Mail Players</h2>

<table style='width: 100%'>
<tr><td style='vertical-align: top'>
<form name='mail?id=<?=$game->getId()?>' method='post'>
<input type=hidden value=1 name='send'/>
<label for='name'>name:&nbsp;</label>
<input type=text name='dname' id='dname' maxlength=30 value='<?=$sending_user->getFullName()?>' readonly><br>
<input type=hidden name='name' value='<?=$sending_user->getUsername()?>'>
<label for='subject'>subject:&nbsp;</label>
<input type=text name='subject' maxlength=50 value='<?=$_GET['subject']?>'><br>
<label for='message'>message:&nbsp;</label>
<textarea name='message' rows=8 cols=60></textarea><br>
<label for='submit'>&nbsp;</label>
<input type=submit value='Send Email'></form>
</td><td style='vertical-align: top; width: auto;'>
<p>Will be sending email to:</p>
<ul>
<?php
  foreach ($game->getPlayers() as $player) {
    echo "<li>{$player->getEmail()} ({$player->getUsername()})</li>\n";
  }
?>
</ul>
</td></tr>
</table>
<?php
  }
  echo "<p><a href='game.php?id={$game->getId()}'>Back to the game</a></p>";
}

include("bottom.php");
?>
