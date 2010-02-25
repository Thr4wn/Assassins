<?php
session_start();

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

$showform = false;

if ($user->getId() != $_CONFIG['admin_id'])
  setError("You do not have privileges to perform this action!");
else if ($_POST['who']) {
  $_SESSION['userid'] = $_POST['who'];
} else
  $showform = true;

$title = "impersonate a user";
include("top.php");

$e = displayErrors();

if (!$e) {
  if ($showform) {
    echo "<p>Who do you wish to impersonate?</p>\n";
    echo "<form method=POST action='impersonate.php'>\n";
    echo "<select name='who'>\n";

    $result = sql(
      "SELECT id, name ".
      "FROM a_users ".
      "ORDER BY id DESC "
      );

    while ($row = mysql_fetch_array($result)) {
      echo "<option value='{$row['id']}'>[{$row['id']}] {$row['name']}</a>\n";
    }
    echo "</select><br/><br/>\n";
    echo "<input type='submit' value='Submit'/>";
    echo "</form>\n";
  } else {
    $myself = requireLogin();
    echo "<p class='message'>You have successfully impersonated {$myself->getUsername()} with id of {$myself->getId()}</p>\n";
    echo "<p><a href='profile.php'>Go to profile</a></p>\n";
    echo "<p><a href='index.php'>Go to main page</a></p>\n";
  }
}

include("bottom.php");
?>
