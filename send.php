<?php

require_once("recaptchalib.php");
include_once("database.inc");
include_once("user.inc");
include_once("util.inc");

$recaptchaerror = "";

$user = requireLogin();

unset($message);

// a function to strip a string of stuff
function fixStr($string) {
  return strip_tags(trim($string));
}

$title = "questions & comments";
include("top.php");

// see if anything has been posted
if (isset($_POST['submit'])) {
  $subject = fixStr($_POST['subject']);
  $from = fixStr($_POST['from']);
  $emailMessage = fixStr($_POST['message']);

  $resp = recaptcha_check_answer($_CONFIG['privatekey'],
    $_SERVER["REMOTE_ADDR"],
    $_POST["recaptcha_challenge_field"],
    $_POST["recaptcha_response_field"]);
  $error = $resp->error;

  // check post for errors

  // incomplete fields
  if(strlen($subject) == 0 || strlen($emailMessage) == 0)
    setError("One or more fields were left blank.");

  // invalid captcha
  else if (!$resp->is_valid)
    setError("The reCAPTCHA challenge you provided is incorrect.");

  // sending error
  else if(!mail($_CONFIG['email'],
      "Assassins question...",
      "Subject: $subject\nFrom: {$user->getUsername()} ({$user->getEmail()})\n\n$emailMessage",
      "From: ".$user->getEmail(),
      $_CONFIG['addheaders']))
    setError("Message failed to send. This is not good! Please try again or contact the webmaster in person.");

  else {
    $message = "Message sent. Go <a href='index.php'>back</a>";
    unset($_POST);
  }

}

$e = displayErrors();

if (isset($message))
  echo "<div class='message'>$message</div>";
else {

  // normal layout for the page
?>
<h2>questions and comments</h2>

<form action='send.php' method='POST'>
  <div>
  <label for="subject">subject:</label>
  <input type='text' name='subject' id='subject' size=36 maxlength=36
    value='<?
      if (isset($_POST['subject']))
        echo $_POST['subject'];
      else
        echo "Question about assassins";
    ?>'>
  <br>
  <label for="message">message:</label>
  <textarea name='message' id='message' rows=8 cols=60><?php
      if (isset($_POST['message']))
        echo $_POST['message'];
    ?></textarea>
  <br><br>
  <div class="recaptcha">
  <table>
  <tr><td>
    <?= recaptcha_get_html($_CONFIG['publickey'], $recaptchaerror); ?>
  </td><td style="vertical-align: bottom;">
    <input style="padding: 0.3em; font-size: 1.2em;" type='submit' name='submit' value='Send Email >'>
  </td></tr></table>
  </div>
  </div>
</form>
<?php
}

include("bottom.php");
?>
