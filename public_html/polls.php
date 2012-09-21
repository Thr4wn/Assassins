<?php

include_once("util.inc");
include_once("poll.inc");

$user = requireLogin();

if (isset($_GET['id']))
  $poll = Poll::getPoll($_GET['id']);


if (isset($poll)) {
  $title = $poll->getText();
  include("top.php");

  echo "<h2>{$title}</h2>\n";

  if (!$poll->hasVoted($user->getUsername()) && $poll->isActive())
    setError("You cannot see results of the current poll until you have voted!");
  else {

    // Display specific poll
    echo "<ol>";
    $options = $poll->getOptions();
    for ($i=0; $i<count($options); $i++) {
      $text = $options[$i];
      $votes = $poll->getVotes($i);

      if ($poll->getNumVotes() > 0)
        $percent = 100*count($votes)/$poll->getNumVotes();
      else
        $percent = 0;

      echo "<li>";
      echo "<div id='progress-bar'>";
      echo "<div id='progress-level' style='width: $percent%'>&nbsp;</div>";
      echo "</div>";

      echo "[".count($votes)."] $text</li>";
    }
    echo "</ol>";

  }
  echo "<a href='polls.php'>back to polls</a>";

} else {
  $title = "polls";
  include("top.php");

  echo "<h2>{$title}</h2>\n";

  // Display all polls
  $polls = Poll::getAllPolls();

  echo "<table style='width:100%; margin: 1em;'>";

  foreach ($polls as $poll) {
    if (!$poll->isHidden()) {
      echo "<tr><td><a href='polls.php?id={$poll->getId()}'>{$poll->getText()}</a></td></tr>\n";
    }
  }

  echo "</table>";
}

$e = displayErrors();

include("bottom.php");
?>
