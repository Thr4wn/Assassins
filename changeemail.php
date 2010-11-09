<?php

require_once("recaptchalib.php");
include_once("database.inc");
include_once("util.inc");

$recaptchaerror = "";

$user = requireLogin(true);

unset($message);

if ($user) {

  if (isset($_GET['verify'])) {

    if ($user->getVerify() != $_GET['verify'])
      setError("Invalid link! Unable to change preferred email address.");

    else {
       handle_Email($user);
       $message = "Your preferred email address has been updated.";
    }


  // to update email
  } else if (isset($_POST['submit'])) {
    $resp = recaptcha_check_answer($_CONFIG['privatekey'],
      $_SERVER["REMOTE_ADDR"],
      $_POST['recaptcha_challenge_field'],
      $_POST['recaptcha_response_field']);
    $error = $resp->error;

    $email = $_POST['email'];

    // incomplete fields
    if (!vemail($email))
      setError("Invalid email format.");

    // invalid captcha
    else if (!$resp->is_valid)
      setError("The reCAPTCHA challenge you provided is incorrect.");

    // send email to address and display verify message
    else {
      $verify = "";
      for ($i=0; $i<20; $i++)
        $verify .= (rand(0,2)?chr(rand(97,122)):chr(rand(48,57)));

      $user->setChangeEmail($email);
      $user->setVerify($verify);
      $user->save();

      if (!mail(
          $email,
          "Taylor Assassins Verification",
          "{$user->getFullName()} has requested that this email address be set as their preferred email for Taylor Assassins.\n\nIf this was you, please click on or copy-and-paste the following link to verify your email address:\nhttp://{$_CONFIG['hostname']}/changeemail.php?verify=$verify\n\nIf this was not you, then you may disregard this email. You may also reply to this email address to report the abuse.\n\n- Taylor Assassins Administrator",
          $_CONFIG['addheaders']
          )) {

        setError("Unable to send verification email!");
        $user->setChangeEmail("");
        $user->setVerify("");
        $user->save();
      }

      else {
        $message = "Verification email sent to $email. Please check your email account and click on the verification link to change your preferred email address.";
      }
    }

  }

} else
  setError("Unable to find you in the database!");

$title = "change preferred email";
include("top.php");

$e = displayErrors();

if (isset($message))
  echo "<div class='message'>$message</div>";
else {

?>

<h2><a href="who.php?username=<?=$user->getUsername()?>"><?="{$user->getFullName()}"?></a></h2>

<h3 class='rule'>email</h3>
<form method="POST" action="changeemail.php">

  <label for="email">email:</label>
  <input name="email" type="text" value="<?=$user->getEmail()?>">
  <br><br>

  <div class="recaptcha">
  <table>
  <tr><td>
    <?= recaptcha_get_html($_CONFIG['publickey'], $recaptchaerror); ?>
  </td><td style="vertical-align: bottom;">
    <input style="padding: 0.3em; font-size: 1.2em;" type="submit" name="submit" value="Change">
  </td></tr></table>
  </div>
</form>

<?php
}

include("bottom.php");
?>
