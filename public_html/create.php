<?php

include_once("database.inc");
include_once("game.inc");
include_once("util.inc");

$user = requireLogin();

// unset an important variable to prevent errors
unset($complete);

if (isset($_POST['create'])) {
  $result = sql(
    "SELECT id ".
    "FROM a_games ".
    "WHERE name=\"".addslashes($_POST['name'])."\""
    );

  if ($row = mysql_fetch_array($result))
    setError("A game with that name already exists, sorry. Please choose a new name.");
  else if (!preg_match("/^20\d\d\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/", $_POST['starts']))
    setError("Invalid starting date.");
  else if ($_POST['type'] == "cod")
    setError("Sorry, that game type is not implemented yet!");
  else {
    $game = new Game(null);
    $game->setType($_POST['type']);
    $game->setName($_POST['name']);
    $game->setStart($_POST['starts']);
    $game->setDesc($_POST['about']);
    $game->setAdmin($user->getUsername());

    if (isAdmin($user))
      $game->setHidden($_POST['hidden']=="on"?1:0);
    else
      $game->setHidden(0);

    $result = $game->save();

    $complete = true;
  }
}

$title = "new game";
include("top.php");

echo "<h2>$title</h2>";

$e = displayErrors();

if (!$e && $complete) {
  echo "<p>The game has been added to the database, thanks!</p>\n";
  echo "<a href='main.php'>go back</a>\n";
} else {
?>

<form method="POST" action="create.php">
  <label for="type">game type:</label>
  <select name="type">
  <option<?=$_POST['type']=='0'?" selected":""?> value="0">Regular</option>
  <option<?=$_POST['type']=='1'?" selected":""?> value="1">Zombies</option>
  <option<?=$_POST['type']=='2'?" selected":""?> value="2">Circle of Death</option>
  </select>
  <br>
  <label for="name">game name:</label>
  <input type="text" name="name" value="<?=stripslashes($_POST['name'])?>">
  <br>
  <label for="starts">start time (yyyy-mm-dd):</label>
  <input type="text" name="starts" value="<?=$_POST['starts']?>">
  <br><br>
  <label for="about">description:</label>
  <textarea name="about" rows="5" cols="60"><?=$_POST['about']?></textarea>
  <br>
<?php
  if (isAdmin($user)) {
    echo "<label for='hidden'>hidden:</label>\n";
    echo "<input type='checkbox' name='hidden' id='hidden'>\n";
    echo "<br>\n";
  }
?>
  <label for="create">&nbsp;</label>
  <input type="submit" name="create" value="create a game!">
  <a href="index.php">never mind</a>
</form>
<? }

include("bottom.php");
?>
