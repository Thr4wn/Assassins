<?php

include_once("database.inc");
include_once("user.inc");
include_once("game.inc");
include_once("util.inc");

function puts($str="") {
	echo "$str\t";
}

function putline() {
	echo "\n";
}

if ($_GET['type']=="generic") {
	puts("#started");
	$games = Game::getStartedGames();
	foreach ($games as $game) {
		puts($game->getId());
		puts($game->getName());
		puts($game->getTypeName());
		puts($game->getStart());
		puts($game->numDead());
		puts($game->numAlive());
		putline();
	}

	puts("#pending");
	$games = Game::getPendingGames();
	foreach ($games as $game) {
		puts($game->getId());
		puts($game->getName());
		puts($game->getTypeName());
		puts($game->getStart());
		putline();
	}

	puts("#finished");
	$games = Game::getFinishedGames();
	foreach ($games as $game) {
		puts($game->getId());
		puts($game->getName());
		puts($game->getTypeName());
		puts($game->getStart());
		puts($game->ended());
		puts($game->numDead());
		puts($game->numAlive());
		putline();
	}
}

?>
