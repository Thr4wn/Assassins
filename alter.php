<?php
session_start();

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

$game = Game::getGame($_GET['id']);

if ($game) {
	if ($game->isAdmin($user) || $user->getId() == $_CONFIG['admin_id']) {
		if (isset($_POST['alter'])) {
			if (!vdate($_POST['starts']))
				setError("Invalid starting date.");
			else if ($_POST['name'] == "")
				setError("Invalid game name!");
			else {
				$game->setName($_POST['name']);
				$game->setStart($_POST['starts']);
				$game->setDesc($_POST['about']);

				$result = $game->save();

				#if (!$result)
				#	setError("Unable to modify game! Perhaps a game with the same name already exists.");
			}
		}
	} else
		setError("You do not have permission to modify that game!");
}

$title = "alter game parameters";
include("top.php");

$e = displayErrors();

if (!$e) {
  if($_POST['alter']) {
    echo "<h2>{$_POST['name']}</h2>".
      "<p>The game information has been modified. ".
      "<a href='game.php?id={$game->getId()}'>Back</a> to the game.</p>";
  } else { ?>

<h2><?=$game->getName()?></h2>
<form method="POST" action="alter.php?id=<?=$game->getId()?>">
	<label for="name">game name:</label>
	<input type="text" name="name" value="<?=$_POST['name']?$_POST['name']:$game->getName()?>">
	<br>
	<label for="starts">start time (yyyy-mm-dd):</label>
	<input type="text" name="starts" value="<?=$_POST['starts']?$_POST['starts']:$game->getStart()?>">
	<br><br>
	<label for="about">description:</label>
	<textarea name="about" rows="5" cols="60"><?=$_POST['about']?$_POST['about']:$game->getDescr()?></textarea>
	<br>
	<label for="alter">&nbsp;</label>
	<input type="submit" name="alter" value="alter info">
	<a href="game.php?id=<?=$game->getId()?>">never mind</a>
</form>

<? }
}
include("bottom.php");
?>
