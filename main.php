<?php
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
<!--<p>
Update: I am currently working on two new game types: Last Man Standing (basically a free-for-all) and Teams. Last Man Standing (which hilariously shares an acronym with <a href="http://en.wikipedia.org/wiki/Least_mean_squares_filter">Least Mean Squares</a>...) is the easiest, so I'm working on that first.
</p>-->

<?php
echo "<table><tr><td>";
echo "<table id='maintab' border=0>\n";

// started games
$games = Game::getStartedGames(canSeeHiddenGames($user));
$num = count($games);
if ($num > 0) {
  echo "\n\n<tr><td colspan=5><h2>$num ".pluralize("game",$num)." in progress</h2></td></tr>\n";
  foreach ($games as $game) {
    if ($game->isHidden())
      echo "<tr class='hidden'>";
    else
      echo "<tr>";

?>
<td style="width: 15em;"><a href="game.php?id=<?=$game->getId()?>"><?=$game->getName()?></a></td>
<td><b><?=$game->getTypeName()?></b><?=$game->isHidden()?" (hidden)":""?></td>
<td>started: <?=$game->getStart()?></td>
<td><?=$game->numTotal()?> <?=pluralize("player",$game->numTotal())?> in game</td>
<td><span class="dead"><?=$game->numDead()?> dead</span>
<br><span class="alive"><?=$game->numAlive()?> alive</span></td>
</tr>
<?php

  }
}

// unstarted games
$games = Game::getPendingGames(canSeeHiddenGames($user));
$num = count($games);
if ($num > 0) {
  echo "\n\n<tr><td colspan=5><h2>$num unstarted ".pluralize("game",$num)."</h2></td></tr>";
  foreach ($games as $game) {
    if ($game->isHidden())
      echo "<tr class='hidden'>";
    else
      echo "<tr>";
?>
<td style="width: 15em;"><a href="game.php?id=<?=$game->getId()?>"><?=$game->getName()?></a></td>
<td><b><?=$game->getTypeName()?></b><?=$game->isHidden()?" (hidden)":""?></td>
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
$games = Game::getFinishedGames(canSeeHiddenGames($user));
$num = count($games);
if ($num > 0) {
  echo "\n\n<tr><td colspan=5><h2>$num ".pluralize("game",$num)." completed</h2></td></tr>\n";
  foreach ($games as $game) {
    if ($game->isHidden())
      echo "<tr class='hidden'>";
    else
      echo "<tr>";

?>
<td style="width: 15em;"><a href="game.php?id=<?=$game->getId()?>"><?=$game->getName()?></a></td>
<td><b><?=$game->getTypeName()?></b><?=$game->isHidden()?" (hidden)":""?></td>
<td>started: <?=$game->getStart()?></td>
<td>ended: <?=$game->ended()?></td>
<td><?=$game->numTotal()?> <?=pluralize("player",$game->numTotal())?></td>
</tr>
<?php
  }
}

echo "</table>\n";

# Display the currently active poll
if ($poll = Poll::getActivePoll()) {
echo "</td><td id='poll-box'>";

  echo "<b>{$poll->getText()}</b><br>";
  $options = $poll->getOptions();

  if (!$poll->hasVoted($user->getUsername())) {
    echo "<form action='poll_vote.php?id={$poll->getId()}' method='POST'>";
    for ($i=0; $i<count($options); $i++) {
      echo "<input type='radio' name='pollchoice' value='$i'>{$options[$i]}<br>\n";
    }
    echo "<input type='submit' style='padding:1px' value='Vote'>";
    echo "</form>";
  } else {
    for ($i=0; $i<count($options); $i++) {
      $text = $options[$i];
      $votes = $poll->getVotes($i);

      if ($poll->getNumVotes() > 0)
        $percent = 100*count($votes)/$poll->getNumVotes();
      else
        $percent = 0;

      echo "&nbsp;&nbsp;$text<br>";
      echo "<div id='progress-bar'>";
      echo "<div id='progress-level' style='width: $percent%'>&nbsp;</div>";
      echo "</div>";
    }

    echo "<a href='polls.php' class='sub'>all polls</a>";
  }
echo "</td></tr></table>";
}

echo "<br><br>";


#if (isAdmin($user)) {
  echo "<div class='create'>";
  echo "<a href='create.php'>Create</a> a new game.";
  echo "</div>";
#}


include("bottom.php");
?>
