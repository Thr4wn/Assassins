<?php

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

// for safety
unset($assassin_set);
$showform = false;

$game = Game::getGame($_GET['id']);
if (!$game)
  setError("Game not found!");
else if (!$game->isAdmin($user) && !isAdmin($user))
  setError("You are not the admin of that game!");
else if ($game->started())
  setError("This game has already been started!");
else if (!$game->canStart())
  setError("There are not enough players to start a game yet!");
else if ($_POST['num'])
  $game->start($_POST['num']);
else
  $showform = true;

$title = "start game";
include("top.php");

$e = displayErrors();

if (!$e) {
  if ($showform) {
    if (!$game->canStart()) {
      setError("There are not enough players to start this type of game!");
      displayErrors();
      print "<p><a href='game.php?id={$game->getId()}'>Back to game</a>";
    } else {
      switch ($game->getType()) {
        case Game::REGULAR:
          print "<p>There are {$game->numTotal()} players in the game. How many assassins do you want to set?</p>\n";
          print "<form name='start_game?id={$game->getId()}' method='post'>\n";
          print "<select name='num'>\n";
          for ($i = 1; $i < $game->numTotal()-1; $i++)
            print "\t<option value='$i'>$i</option>\n";
          print "</select><br/><input type=submit value='Start Game'/></form>";
          break;

        case Game::ZOMBIES:
          print "<p>There are {$game->numTotal()} players in the game. How many initial zombies do you want to set?</p>\n";
          print "<form name='start_game?id={$game->getId()}' method='post'>\n";
          print "<select name='num'>\n";
          for ($i = 1; $i <= $game->numTotal()/2; $i++)
            print "\t<option value='$i'>$i</option>\n";
          print "</select><br/><input type=submit value='Start Game'/></form>";
          break;

        case Game::CIRCLED:
          print "<p>Are you sure you want to start the game? This action cannot be undone.</p>\n";
          print "<form name='start_game?id={$game->getId()}' method='post'>\n";
          print "<input type=hidden name='num' value=1/>";
          print "<input type=submit value='Start Game'/></form>";
          break;
      }
    }
  } else {
    $num = $game->numAssassins();
    $type = ($game->getType()==Game::ZOMBIES)?"zombie":"assassin";
    if ($num)
      print "<p>$num ".pluralize($type, $num)." successfully set.</p>";

    print "<p><a href='game.php?id={$game->getId()}'>Back to the game</a></p>";
  }
}

include("bottom.php");
?>
