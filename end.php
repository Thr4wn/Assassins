<?php
session_start();

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

$showform = false;

$game = Game::getGame($_GET['id']);
if (!$game)
	setError("Could not find game {$_GET['id']}!");
else if (!$game->isAdmin($user))
  setError("You are not the admin of that game!");
else if (!$game->started())
  setError("That game has not been started yet!");
else if ($game->ended())
  setError("That game has already been ended!");
else if ($_POST['end'])
  $game->endGame();
else
  $showform = true;

$title = "end game";
include("top.php");

$e = displayErrors();

if (!$e) {
  if ($showform) {
    print "<br/><br/>Are you sure you want to end the game?<br/><br/>\n";
    print "<form name='end_game?id={$game->getId()}' method='post'>\n";
    print "<input type=hidden value=1 name='end'/>\n";
    print "<input type=submit value='End Game'/></form>\n";
  } else {
    if ($game->ended())
      print "<p>Game successfully ended.</p>";

    print "<p><a href='game.php?id={$game->getId()}'>Back to the game</a></p>";
  }
}

include("bottom.php");
?>
