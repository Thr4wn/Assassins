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
$sending_user = User::getUser($_GET['userid']);

if (!$game)
  setError("Game not found!");
else if ($user->getId() != $_CONFIG['admin_id'])
  setError("You are not the administrator! Shame on you for trying to hack the system!");
else if (!$sending_user)
  setError("No sending user specified!");
else if ($_POST['send']) {
  $subject = $_POST['subject'];
  $emessage = $_POST['message']."\n\n- {$sending_user->getUsername()}";
	mailPlayers($game->getPlayers(), $subject, $emessage);
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
    echo "<h2>Mail Players</h2>";

    echo "<form name='mail?id={$game->getId()}' method='post'>\n";
    echo "<input type=hidden value=1 name='send'/>\n";
    echo "<label for='name'>name:</label>\n";
    echo "<input type=text name='name' maxlength=30 value='{$sending_user->getUsername()}' /><br/>\n";
    echo "<label for='subject'>subject:</label>\n";
    echo "<input type=text name='subject' maxlength=50 value='{$_GET['subject']}' /><br/>\n";
    echo "<label for='message'>message:</label>\n";
    echo "<textarea name='message' rows=8 cols=60></textarea><br/>\n";
    echo "<label for='submit'>&nbsp;</label>\n";
    echo "<input type=submit value='Send Email'/></form>\n";
  } else {
    echo "<p><a href='game.php?id={$game->getId()}'>Back to the game</a></p>";
  }
}

include("bottom.php");
?>
