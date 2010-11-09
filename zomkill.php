<?php

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

$id = $_GET['id'];
$game = Game::getGame($id);

if ($game->isAlive($user))
  $game->incKillCount($user->getUsername());
else if ($game->isDead($user))
  $game->incInfestationCount($user->getUsername());
else
  setError("You are not in that game!");

$title = "kill count";
$headers = "<meta http-equiv='refresh' content='5;url=game.php?id=$id'>\n";
include("top.php");

$e = displayErrors();

if (!$e) {
  echo "<h2>kill count</h2>";
  echo "Congratulations on your ".($game->isAlive($user)?"kill":"infestation")."!<br><br>\n";
  echo "You will be redirected <a href='game.php?id=$id'>back to the game</a> in 5 seconds.\n";
}

  include("bottom.php");

?>
