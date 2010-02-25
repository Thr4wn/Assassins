<?
session_start();

include_once("database.inc");
include_once("util.inc");
include_once("user.inc");
include_once("game.inc");

$user = requireLogin();

unset($complete);
unset($showform);

$game = Game::getGame($_GET['id']);
if (!$game)
	setError("Game {$_GET['id']} does not exist.");

else if (!$game->started())
	setError("This game has not even been started yet!");

else if ($game->ended())
	setError("This game has already ended. You cannot mark yourself as dead.");

else if (!$game->isAlive($user)) // NOT equivalent to isDead()!!
	setError("You do not appear to be playing in that game, or you are already dead.");

else if (isset($_POST['when'])) {
	$arr = split(" ",$_POST['when']);
	if (!vdate($arr[0]) || !preg_match("/^([01]?[0-9]|2[0-3])\:[0-5][0-9]$/",$arr[1])) {
		setError("Invalid time stamp. ".$arr[0]."::".$arr[1]);
		$showform = true;
	} else {
		$game->setDead($user,$_POST['when']);
		$complete = true;
	}
} else
	$showform = true;

$title = "mark as dead";
include("top.php");

$e = displayErrors();

if (!$e && isset($complete)) {
	if ($game->ended())
		echo "<p class='message'>The game is over!</p>";
	echo "<p>You have been marked as dead at: {$_POST['when']}</p>";
}

if(isset($showform))
{ ?>

<form action="mark.php?id=<?=$game->getId()?>" method="POST">
	time died (yyyy-mm-dd hh:mm): <input type="text" value="<?
			if(isset($_POST['when']))
				echo $_POST['when'];
			else
				echo date("Y-m-d H:i", time());
		?>" name="when" maxlength=16>
	<p>
		Please note that this the hours are in military time (00-23).
		Try to guess minutes to the closest 5 minutes.
	</p>
	<label for="die">&nbsp;</label>
	<input type="submit" name="die" value="mark me as dead">
</form>
<?
}
echo "<br/><p><a href='game.php?id={$game->getId()}'>back</a> to the game</p>\n";

include("bottom.php");
?>
