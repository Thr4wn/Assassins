<?php

include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

$title = "assassin check";
include("top.php");

$game = Game::getGame($_GET['game']);

if (!displayErrors()) {

	$num = $game->numAssassins();

	if (!$game->started())
		setError("This game has not been started! Check back once the game has been started by the admin.");
	else if (!$game->isPlayer($user))
		setError("You are not even playing this game!");
	else if ($game->getType() == Game::REGULAR) {
    if ($game->isAssassin($user))
      echo "<p><b>Yes!</b> You are one of <b>$num</b> ".pluralize("assassin",$num).".</p>";
    else
      echo "<p><b>No!</b> You are <b>not</b> one of the assassins.</p>";

  } else if ($game->getType() == Game::CIRCLED) {
    $target_id = $game->cod_players[$user->getUsername()];
    $target = User::getUser($target_id);
    echo "<p>Your target is <b><a href='who.php?username={$target->getUsername()}'>{$target->getFullName()}</a></b></p>\n";
  }

	displayErrors();

	echo "<p>Go back to <a href='game.php?id={$game->getId()}'>the game</a>.</p>";
}
?>

<? include("bottom.php"); ?>
