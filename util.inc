<?php
  $_SESSION['err'] = array();

  include_once("poll.inc");
  include_once("user.inc");
  include_once("config.php");
  include_once("CAS-1.2.1RC1/CAS.php");

  function pluralize($word,$count) {
    return ($count==1)?$word:$word."s";
  }

  function requireLogin($nocheck=false, $noreauthenticate=false) {
    global $_CONFIG, $isimpersonating, $phpCAS;

    initializeCAS();

# To avoid an endless loop with Taylor's USIDESC cookie being set while asking the user for reauthentication, here we call clearcookies.jsp to clear Taylor's cookies if the user tries to log in with our form. (After clearing the cookies, we send them to main.php, which will log them into CAS by redirecting them to myTAYLOR.) Surprisingly, this does not reset the CAS session, so SSO still works if they reach the login page while still logged in. Still, this workaround only works if they visit login.php. If they get caught elsewhere on the site (as in, their session timed out and they got redirected to the myTAYLOR login page, clearcookies.jsp will never be called, so they will still be stuck in a loop until they visit this page. This might be solved by checking if the user is authenticated before forcing authentication, and redirecting them to login.php if they are not authenticated.)

# UPDATE: A redirect parameter was added to clearcookies.jsp, so one can clear the user's session cookies and then redirect back to assassins.
# So the string of requests goes: [somewhere_assassins] -> Is Not Authenticated -> 'cas' Not Present -> clearcookies.jsp -> [somewhere_assassins] -> Is Not Authenticated -> my.taylor.edu -> [somewhere_assassins]
# This would probably work better if we changed the CAS client to redirect first to clearcookies and then use that to redirect to the login page. However, this would involve messing with the way CAS calls the server, so it's probably not the best idea.

    if (!$noreauthenticate && !phpCAS::isAuthenticated()) {

      // We don't force CAS authentication unless we see the cas parameter. This is because we need to clear the user's Portal session cookies first.
      if (!$_GET['cas']) {
        $page = "http://".$_CONFIG['hostname'].$_SERVER['REQUEST_URI'];
        $page .= (strpos($page, '?')!==false?'&':'?').'cas=1';
        $page = urlencode($page);

        header("Location: http://my.taylor.edu/content/jsp/clearcookies.jsp?redirect=$page");

#        $domain = $_CONFIG['hostname'];
#        header("p3p", "CP=\"IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT\"");
#        echo <<<EOS
#<html>
#<head>
#<script type="text/javascript" language="JavaScript">
# function openWindow() {
#     var height = 1;
#     var width = 1;
#     var left = (screen.width/2)-(width/2);
#     var top = (screen.height/2)-(height/2);
#     mywindow = window.open("https://my.taylor.edu/content/jsp/clearcookies.jsp", "login","location=1,status=1,scrollbars=1#,top=" + top + ",left=" + left + ",width=" + width + ",height=" + height);
#
#     if(mywindow != null) {
#       mywindow.close();
#       window.location = '$page';
#     }
# }
#</script>
#</head>
#<body onLoad="openWindow()">
#<p>You are being redirected to myTAYLOR to login to the Assassins website.</p>
#<p>If you are not automatically redirected, please allow popups for this site and <a href="#" onclick="openWindow(); return# false;">click here</a>.</p>
#</body>
#</html>
#EOS;
        exit;
      } else {

        // force CAS authentication
        phpCAS::forceAuthentication();
      }
    }

    $username = phpCAS::getUser();
    $user = User::getUser($username);

    $isimpersonating = false;
    if (isAdmin($user) && isset($_COOKIE['impersonate'])) {
      $user = User::getUser($_COOKIE['impersonate']);
      $isimpersonating = true;
    }

    // Check that the user has a first name that is not 'none'
    if (!$nocheck && ($user->getFirst() == 'none' || !$user->getAva())) {
      header('Location: profile.php');
    }

    return $user;
  }

  function initializeCAS() {
    global $_CONFIG, $phpCAS;

    if (!$phpCAS) {
      // initialize phpCAS
      phpCAS::client(CAS_VERSION_2_0, $_CONFIG['cas_server'], $_CONFIG['cas_port'], $_CONFIG['cas_dir']);

      // no SSL validation for the CAS server
      phpCAS::setNoCasServerValidation();
    }

    $phpCAS = true;
  }

  function getCASLogoutURLWithService($service) {
    return phpCAS::getServerLogoutURL()."?service=".URLEncode($service);
  }


  function doLogout() {
    global $_CONFIG;

    stopImpersonating();


    // initialize phpCAS (and the current session)
    phpCAS::client(CAS_VERSION_2_0, $_CONFIG['cas_server'], $_CONFIG['cas_port'], $_CONFIG['cas_dir']);

    // Trying to log out via the CAS server proved futile. This is because the cookie 'usidesc' wasn't being unset.
    // (Before the Portal upgrade, it was being unset from the login page. But this is no longer the case.)
    // So, there are two things that need to be destroyed. First, our local session must be obliterated.
    // Second, the usidesc cookie must also be nuked. This can be achieved by calling the Portal logout page.

    // UPDATE: Instead of calling the Portal logout page, we now call clearcookies.jsp and redirect back here.
    session_destroy();

    header('Location: http://my.taylor.edu/content/jsp/clearcookies.jsp?redirect='.urlencode("http://".$_CONFIG['hostname']));

    exit;
    #header('Location: http://my.taylor.edu/up/Logout?uP_tparam=frm&frm=');

    // no SSL validation for the CAS server
    //phpCAS::setNoCasServerValidation();

    //phpCAS::logoutWithRedirectService("http://assassins.homelinux.org");
  }

  function startImpersonating($username) {
    setcookie('impersonate', $username, 0);
  }

  function stopImpersonating() {
    setcookie('impersonate', 'none', time() - 60*60*24*265);
  }

  function isAdmin($user) {
    global $_CONFIG;

    return in_array($user->getUsername(), $_CONFIG['admin_usernames']);
  }

  function canSeeHiddenGames($user) {
    global $_CONFIG;

    return isAdmin($user) || $user->getUsername() == "test_student";
  }

  function setError($err) {
    $_SESSION['err'][] = $err;
    return 0;
  }

  function numErrors() {
    return count($_SESSION['err']);
  }

  function displayErrors() {
    if (!isset($_SESSION['err']))
      return 0;

    echo "<div class='error'>ERROR: ";
    echo implode("\n<br><br>ERROR: ",$_SESSION['err']);
    echo "</div>";
    unset($_SESSION['err']);

    return 1;
  }

  function vname($name) {
    return strlen($name) > 1 && strlen($name) < 20;
  }

  function vemail($email) {
    return preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9.\+=_-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $email);
  }

  function vdate($date) {
    return preg_match("/^20\d\d\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/", $date);
  }

  function handle_Name($user,$name) {
    $name = trim(strip_tags($name));

    if (!vname($name))
      setError("Your name must be between 2 and 20 characters");
    else {
      $user->setFirst($name);
      $user->save();
      return "Name updated.";
    }

    return null;
  }

  function handle_Email($user) {
    $user->setEmail($user->getChangeEmail());
    $user->setChangeEmail("");
    $user->setVerify("");
    $user->save();
  }

  function handle_Avatar($user,$file) {
    $ori_file = $file['name'];
    $tmp_file = $file['tmp_name'];

    if (!$file['tmp_name'])
      setError("You did not upload a picture, or it was too large!");
    else if ($file['error'] != 0)
      switch ($file['error']) {
        case 1:
        case 2:
          setError("The file is bigger than the maximum allowed of 2MB.");
          break;
        case 3:
          setError("There was an error during transmission. Please try uploading again.");
          break;
        case 4:
          setError("You did not select a picture to upload!");
          break;
      }

    else if (!preg_match("/(\.jpe?g$)|(\.png$)|(\.gif$)/i", $ori_file))
      setError("The file \"$ori_file\" is not a JPG, PNG, or GIF image.");
    else {
      // Reformat image to correct size
      $newsize = 200;
      $maxsize = 300;

      list($width, $height) = getimagesize($tmp_file);
      $imageratio = $width / $height;
      if ($imageratio > 1) {
        $newwidth = $newsize;
        $newheight = min($maxsize, $newsize / $imageratio);
      } else {
        $newwidth = min($maxsize, $newsize * $imageratio);
        $newheight = $newsize;
      }
      $newimage = ImageCreateTrueColor($newwidth, $newheight);

      // get the image from the file
      if (preg_match("/\.jpe?g$/i",$ori_file))
        $source = imagecreatefromjpeg($tmp_file);
      else if (preg_match("/\.png$/i",$ori_file))
        $source = imagecreatefrompng($tmp_file);
      else if (preg_match("/\.gif$/i",$ori_file))
        $source = imagecreatefromgif($tmp_file);

      imagecopyresized($newimage, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

      // Save the image in the database
      if (imagejpeg($newimage, $tmp_file, 100)) {
        $fh = fopen($tmp_file,"rb");
        $bytes = fread($fh,filesize($tmp_file));
        fclose($fh);
        $user->setAva($bytes);
        $user->setMime(stripslashes($_FILES['avatar']['type']));

        if (!$user->saveAvatar())
          setError("Error uploading avatar to database!");
        else
          return "Avatar updated.";
      } else
        setError("Unable to update avatar.");
    }

    return null;
  }


  function phplog($message) {
    // open file
    $fd = fopen("../logs/php.log", "a");

    // append date/time to message
    $str = "[" . date("Y/m/d h:i:s", mktime()) . "] $message";

    // write string
    fwrite($fd, $str . "\n");

    // close file
    fclose($fd);
  }

  function mailPlayers($players, $subject, $message, $printEmail=false) {
    global $_CONFIG;

    if (!is_array($players)) {
      $players = Array($players);
    }

    foreach ($players as $player) {
      $success = mail($player->getEmail(), $subject, $message, $_CONFIG['addheaders']);
      $successMessage = "mail ".($success?"successfully":"<b>unsuccessfully</b>")." sent to {$player->getUsername()}<br>";

      phplog($successMessage);

      if ($printEmail)
        print $successMessage;
    }
  }

?>
