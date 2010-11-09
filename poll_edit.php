<?php
include_once("util.inc");
include_once("poll.inc");

$user = requireLogin();
$poll = Poll::getPoll($_GET['id']);

if (!isAdmin($user))
  setError("You do not have privileges to perform this action!");

else if (!$poll)
  setError("Poll not found");

else if ($poll->getNumVotes() > 0)
  setError("You cannot edit a poll that already has votes!");

else if (isset($_POST['edit'])) {

  $poll->setText($_POST['name']);
  $poll->clearOptions();

  $index = 0;
  while ($_POST["$index"]) {
    $poll->setOption($index, $_POST["$index"]);
    $index++;
  }

  $poll->save();

  $message = "Poll saved.";
}

$title = "edit poll";
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

$e = displayErrors();

if (!$e) {

  if (isset($message))
    echo "<div class='message'>$message</div>";

  $poll = Poll::getPoll($_GET['id']);

  if (isset($_GET['setactive'])) {
    $poll->setActive($_GET['setactive']);
    $poll->save();
    echo "<meta http-equiv='refresh' content='0;poll_manage.php'>";
  } else if (isset($_GET['hide'])) {
    $poll->setHidden($_GET['hide']);
    $poll->save();
    echo "<meta http-equiv='refresh' content='0;poll_manage.php'>";
  } else {
    // Display edit info
    echo "<h2>$title</h2>";
?>
<p>Remember: If you have an option that is empty, then no options after that one will be saved!</p>
<form method="POST" action="poll_edit.php?id=<?=$poll->getId()?>">
  <label for="name">question:</label>
  <input type="text" name="name" size='40' value="<?=$poll->getText()?>">
  <br>
  <br>

<?php
      $options = $poll->getOptions();
      $cnt = count($options);
      for ($i=0; $i<$cnt; $i++) {
        if ($i == 0)
          echo "<label>options:</label>\n";
        else
          echo "<label>&nbsp;</label>\n";

        echo "<input type='text' name='$i'".($i==$cnt-1?" id='last'":"")." size='40' value=\"{$options[$i]}\">\n";

        if ($i == $cnt-1)
          echo "<a href='#' onclick='addRow()' style='color: #55F; text-decoration: underline;'>add row</a>\n";

        echo "<br>\n";
      }
?>

  <label for="edit">&nbsp;</label>
  <input type="submit" name="edit" value="edit poll">
</form>

<p><a href="poll_manage.php">back to polls</a></p>
<?php
  }
}
include("bottom.php");
?>
