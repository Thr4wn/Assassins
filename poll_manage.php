<?php

include_once("util.inc");

$user = requireLogin();

$showform = false;

if (!isAdmin($user)) {
  setError("You do not have privileges to perform this action!");
}

$title = "manage polls";
include("top.php");

$e = displayErrors();

if (!$e) {
  ini_set('display_errors', true);

  echo "<h2>manage polls</h2>\n";

  echo "&middot; <a href='poll_create.php'>Create New Poll</a><br>";

  $polls = Poll::getAllPolls();

  if (count($polls) > 0) {
    echo "<table style='margin: 1.5em'>";

    foreach ($polls as $poll) {

      $style = "style='";
      if ($poll->isHidden())
        $style .= "font-style: italic;";

      if ($poll->isActive())
        $style .= "font-weight: bold;";
      $style .= "'";

      echo "<tr $style><td>";

      if ($poll->isActive())
        echo "* ";

      echo "{$poll->getText()}</td>\n";
      echo "<td rowspan='2' style='vertical-align: top'>";
      echo "<p><a href='poll_edit.php?id={$poll->getId()}'>edit poll</a></p>\n";

      if (!$poll->isActive())
        echo "<p><a href='poll_edit.php?id={$poll->getId()}&setactive=1'>set as active poll</a></p>\n";
      else
        echo "<p><a href='poll_edit.php?id={$poll->getId()}&setactive=0'>set poll as inactive</a></p>\n";

      if ($poll->isHidden())
        echo "<p><a href='poll_edit.php?id={$poll->getId()}&hide=0'>make public</a></p>\n";
      else
        echo "<p><a href='poll_edit.php?id={$poll->getId()}&hide=1'>make hidden</a></p>\n";

      echo "</td></tr><tr $style><td><ol style='margin-left: 2em'>";
      $options = $poll->getOptions();
      for ($i=0; $i<count($options); $i++) {
        $text = $options[$i];
        $votes = $poll->getVotes($i);

        if ($poll->getNumVotes() > 0)
          $percent = 100*count($votes)/$poll->getNumVotes();
        else
          $percent = 0;

        echo "<li>";
        echo "<div id='progress-bar' title='".implode("\n",$votes)."'>";
        echo "<div id='progress-level' style='width: $percent%'>&nbsp;</div>";
        echo "</div>";

        echo "[".count($votes)."] $text</li>";
      }
      echo "</ol></td>";
      echo "</tr>";
    }

    echo "</table>";

  }
}

include("bottom.php");
?>
