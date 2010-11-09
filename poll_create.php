<?php

include_once("util.inc");

$user = requireLogin();

if (!isAdmin($user)) {
  setError("You do not have permission to create a poll!");
} else if (isset($_POST['create'])) {

  $poll = new Poll(null);
  $poll->setText($_POST['name']);
  $poll->setCreator($user->getUsername());
  $poll->setHidden($_POST['hidden']=="on"?1:0);

  $index = 0;
  while ($option = $_POST["$index"]) {
    $poll->setOption($index, $_POST["$index"]);
    $index++;
  }

  $poll->save();

  $message = "Poll created.";
}

$title = "new poll";
$headers = '
<script type="text/javascript" language="JavaScript">

function addRow() {
  lastInput = document.getElementById("last");

  newLabel = document.createElement("label");
  newLabel.innerHTML = "&nbsp;";
  newInput = lastInput.cloneNode();
  newInput.id = "";

  lastInput.parentNode.insertBefore(newInput, lastInput);
  lastInput.parentNode.insertBefore(document.createElement("br"), lastInput);
  lastInput.parentNode.insertBefore(newLabel, lastInput);

  lastInput.value = "";
  lastInput.name = 1 + parseInt(lastInput.name);
  lastInput.focus();
  return;
}

</script>
';
include("top.php");

echo "<h2>$title</h2>";

$e = displayErrors();

if (!$e) {

  if (isset($message))
    echo "<div class='message'>$message</div>";
  else {
?>

<form method="POST" action="poll_create.php">
  <label for="name">question:</label>
  <input type="text" name="name" size="40" value="<?=stripslashes($_POST['name'])?>">
  <br>
  <br>

  <label>choices:</label>
  <input type="text" name="0" size="40" value="<?=$_POST['0']?>">
  <br>

  <label>&nbsp;</label>
  <input type="text" name="1" size="40" value="<?=$_POST['1']?>">
  <br>

  <label>&nbsp;</label>
  <input type="text" name="2" size="40" value="<?=$_POST['2']?>">
  <br>

  <label>&nbsp;</label>
  <input type="text" name="3" size="40" value="<?=$_POST['3']?>">
  <br>

  <label>&nbsp;</label>
  <input type="text" name="4" id="last" size="40" value="<?=$_POST['4']?>">
  <a href="#" onclick="addRow()" style="color: #55F; text-decoration: underline;">add row</a>
  <br>

  <label for='hidden'>hidden:</label>
  <input type='checkbox' name='hidden'>
  <br>

  <label for="create">&nbsp;</label>
  <input type="submit" name="create" value="create poll">
</form>
<? }
}

include("bottom.php");
?>
