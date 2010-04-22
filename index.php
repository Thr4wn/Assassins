<?php
session_start();

include_once("database.inc");
include_once("user.inc");
include_once("game.inc");
include_once("util.inc");

$user = requireLogin();

include("top.php");
?>

<h2>Notice from the site admin</h2>
<p>
Welcome to the new Assassins server! Please <a href="send.php">let me know</a> if you encounter any bugs, error messages, unexpected behavior, or other site-related problems.
</p>
<p>
Update: I am currently working on two new game types: Last Man Standing (basically a free-for-all) and Teams. Last Man Standing (which hilariously shares an acronym with <a href="http://en.wikipedia.org/wiki/Least_mean_squares_filter">Least Mean Squares</a>...) is the easiest, so I'm working on that first.
</p>

<?php
echo "<table id='maintab' border=0>\n";

// started games
$games = Game::getStartedGames();
$num = count($games);
if ($num > 0) {
	echo "\n\n<tr><td colspan=5><h2>$num ".pluralize("game",$num)." in progress</h2></td></tr>\n";
	foreach ($games as $game) {

?>
<tr>
<td style="width: 15em;"><a href="game.php?id=<?=$game->getId()?>"><?=$game->getName()?></a></td>
<td><b><?=$game->getTypeName()?></b></td>
<td>started: <?=$game->getStart()?></td>
<td><?=$game->numTotal()?> <?=pluralize("player",$game->numTotal())?> in game</td>
<td><span class="dead"><?=$game->numDead()?> <?=pluralize("player",$game->numDead())?> dead</span>
<br><span class="alive"><?=$game->numAlive()?> <?=pluralize("player",$game->numAlive())?> alive</span></td>
</tr>
<?php

	}
}

// unstarted games
$games = Game::getPendingGames();
$num = count($games);
if ($num > 0) {
	echo "\n\n<tr><td colspan=5><h2>$num unstarted ".pluralize("game",$num)."</h2></td></tr>";
	foreach ($games as $game) {

?>
<tr>
<td style="width: 15em;"><a href="game.php?id=<?=$game->getId()?>"><?=$game->getName()?></a></td>
<td><b><?=$game->getTypeName()?></b></td>
<td>starts: <?=$game->getStart()?></td>
<td><?=$game->numTotal()?> <?=pluralize("player",$game->numTotal())?> signed up</td>
<?php
	if (!$game->isPlayer($user))
		print "<td><a href='join.php?id={$game->getId()}'>join</a> this game.</td>\n";
	else
		print "<td><i>Already joined!</i></td>\n";
	print "</tr>\n";

	}
}

// ended games
$games = Game::getFinishedGames();
$num = count($games);
if ($num > 0) {
	echo "\n\n<tr><td colspan=5><h2>$num ".pluralize("game",$num)." completed</h2></td></tr>\n";
	foreach ($games as $game) {

?>
<tr>
<td style="width: 15em;"><a href="game.php?id=<?=$game->getId()?>"><?=$game->getName()?></a></td>
<td><b><?=$game->getTypeName()?></b></td>
<td>started: <?=$game->getStart()?></td>
<td>ended: <?=$game->ended()?></td>
<td><?=$game->numTotal()?> <?=pluralize("player",$game->numTotal())?></td>
</tr>
<?php
	}
	echo "</table>\n";
}
?>

<br><br>

<!--
<div class="create">
	<a href="create.php">Create</a> a new game.
</div>
-->

<? include("bottom.php"); ?>
