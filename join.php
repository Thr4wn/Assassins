<?php
session_start();

include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

$game = Game::getGame($_GET['id']);
if ($game) {
	$game->addPlayer($user);
	$joined = true;
} else
	setError("Game {$_GET['id']} not found!");

$title = "join game";
include("top.php");

$e = displayErrors();

if (!$e) {
	echo "<p>You joined the game \"{$game->getName()}\" successfully.</p>\n";
}
echo "<p><a href='game.php?id={$game->getId()}'>Back to the game</a></p>\n";

include("bottom.php");
?>
