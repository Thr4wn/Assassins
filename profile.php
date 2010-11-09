<?php
include_once("database.inc");
include_once("util.inc");

$user = requireLogin(true);

unset($message);
$update = false;

if ($user) {
  // to update name
  if (isset($_POST['update']) && $user->getFirst() == 'none') {
    $message = handle_Name(
      $user,
      $_POST['name']);
  }

  // to update the avatar
  else if (isset($_POST['cava'])) {
    $message = handle_Avatar(
      $user,
      $_FILES['avatar']);
  }

  if ($user->getFirst() == 'none')
    setError("You must supply a first name before continuing!");
  if (!$user->getAva())
    setError("You must supply an avatar before continuing!");
} else
  setError("Unable to find you in the database!");

$title = "edit profile";
include("top.php");

$e = displayErrors();

if(isset($message))
  echo "<div class='message'>$message</div>";

?>

<h2><a href="who.php?username=<?=$user->getUsername()?>"><?="{$user->getFullName()}"?></a></h2>

<h3 class='rule'>personal</h3>
<form method="POST" action="profile.php">

  <div>
  <label for="name">first name:</label>
  <input name="name" id="name" type="text" <?
      if ($user->getFirst() != "none")
        echo "value='{$user->getFirst()}' readonly";
      else
        $update = true;
      ?>>
  <br>

  <label for="last">last name:</label>
  <input name="last" id="last" type="text" value="<?=$user->getLast()?>" readonly>
  <br>

  <label for="email">email:</label>
  <input name="email" id="email" type="text" value="<?=$user->getEmail()?>" readonly> <a href="changeemail.php" class="sub">change</a>
  <br>

  <?php
    if ($update) {
  ?>
  <label for="update">&nbsp;</label>
  <input type="submit" name="update" id="update" value="update">
  <?php } ?>
  </div>
</form>

<h3>avatar</h3>
<label for="cur">Current picture:</label><img src='ava.php?username=<?=$user->getUsername()?>' alt='Profile Picture' id='cur'><br>
<form enctype="multipart/form-data" method="POST" action="profile.php">
  <div>
  <input type="hidden" name="MAX_FILE_SIZE" value="2621440">
  <label for="avatar">New avatar:</label>
  <input type="file" name="avatar" id="avatar">
  Please have this be an actual picture of yourself.<br>
  <label>&nbsp;</label>(JPG, PNG, or GIF)<br>
  <br>
  <label for="cava">&nbsp;</label>
  <input type="submit" name="cava" id="cava" value="change avatar">
  </div>
</form>


<?php
include("bottom.php");
?>
