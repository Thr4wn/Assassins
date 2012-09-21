<?php

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

$showform = false;

if (isset($_GET['stop'])) {
  stopImpersonating();
  header('Location: main.php');
} else if (!isAdmin($user)) {
  setError("You do not have privileges to perform this action!");
} else if (isset($_POST['who'])) {
  startImpersonating($_POST['who']);
  header('Location: profile.php');
} else
  $showform = true;

$title = "impersonate a user";
include("top.php");

$e = displayErrors();

if (!$e) {
  if ($showform) {
    echo "<p>Who do you wish to impersonate?</p>\n";
    echo "<form method=POST action='impersonate.php'>\n";
    echo "<div>\n";
    echo "<select name='who'>\n";

    $result = sql(
      "SELECT username, first, last ".
      "FROM a_tusers ".
      "ORDER BY last,first ASC "
      );

    while ($row = mysql_fetch_array($result)) {
      echo "<option value='{$row['username']}'>{$row['first']} {$row['last']}</option>\n";
    }
    echo "</select><br><br>\n";
    echo "<input type='submit' value='Submit'>";
    echo "</div>\n";
    echo "</form>\n";
  }
}

include("bottom.php");
?>
