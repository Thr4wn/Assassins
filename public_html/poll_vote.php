<?php

include_once("util.inc");
include_once("poll.inc");

$user = requireLogin();

$poll = Poll::getPoll($_GET['id']);
if (!$poll)
  setError("Poll {$_GET['id']} does not exist.");

else if (!$poll->isActive())
  setError("This poll is not currently active!");

else if (isset($_POST['pollchoice'])) {
  $choice = $_POST['pollchoice'];

  if (!is_numeric($choice) || $choice < 0 || $choice > count($poll->getOptions()))
    setError("Invalid option.");

  else
    $poll->vote($user->getUsername(), $choice);

} else
  setError("You must select an option!");

$title = "vote";
include("top.php");

$e = displayErrors();

if (!$e) {
  echo "<div class='message'>Your vote has been recorded.</div>";
}

include("bottom.php");
?>
