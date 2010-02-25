<?php
	$_SESSION['err'] = array();

	include_once("user.inc");
  include_once("config.inc");

	function pluralize($word,$count) {
		return ($count==1)?$word:$word."s";
	}

	function requireLogin() {
		if (!isset($_SESSION['userid'])) {
			header("Location: login.php");
		} else {
			return User::getUser($_SESSION['userid']);
		}
	}

	function requireNoLogin() {
		if (isset($_SESSION['userid']))
			header("Location: ./");
	}

	function setError($err) {
		$_SESSION['err'][] = $err;
		return 0;
	}

	function numErrors() {
		return count($_SESSION['err']);
	}

	function displayErrors() {
		if (!$_SESSION['err'])
			return 0;

		echo "<div class='error'>ERROR: ";
		echo implode("\n<br><br>ERROR: ",$_SESSION['err']);
		echo "</div>";
		unset($_SESSION['err']);

		return 1;
	}

	function vname($name) {
		return strlen($name) > 1;
	}

	function vemail($email) {
		return preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9.\+=_-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $email);
	}

	function vdate($date) {
		return preg_match("/^20\d\d\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/", $date);
	}

	function handle_NameAndEmail($user,$name,$email) {
		$name = trim(strip_tags($name));

		if (!vname($name))
			setError("Your name is too short");
		else if (!vemail($email))
			setError("Invalid e-mail address.");
		else {
			$user->setUsername($name);
			$user->setEmail($email);
			$user->save();
			return "Profile updated.";
		}

		return null;
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

		else if (!preg_match("/(\.jpg$)|(\.png$)|(\.gif$)/i", $ori_file))
			$error = "The file \"$ori_file\" is not a JPG, PNG, or GIF image.";
		else {
			// Reformat image to correct size
			$newsize = 240;
			list($width, $height) = getimagesize($tmp_file);
			$imageratio = $width / $height;
			if ($imageratio > 1) {
				$newwidth = $newsize;
				$newheight = $newsize / $imageratio;
			} else {
				$newwidth = $newsize * $imageratio;
				$newheight = $newsize;
			}
			$newimage = ImageCreateTrueColor($newwidth, $newheight);

			// get the image from the file
			if (preg_match("/\.jpg$/i",$ori_file))
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
				$user->setMime($_FILES['avatar']['type']);

				if (!$user->saveAvatar())
					setError("Error uploading avatar to database!");
				else
					return "Avatar updated.";
			} else
				setError("Unable to update avatar.");
		}

		return null;
	}

	function handle_Password($user,$old,$new1,$new2) {
		if (md5($old) != $user->getPassword())
			setError("Old password does not match.");
		else if (strlen($new1) < 8)
			setError("Your new password must be at least 8 characters long.");
		else if ($new1 != $new2)
			setError("The new passwords did not match.");
		else {
			$user->setmd5Password(md5($new1));
			$user->save();
			if (isset($_COOKIE['asn_pas'])) {
				setcookie("asn_pas", md5($new1), time() + 60*60*24*30, "/");
			}
			return "Password updated.";
		}

		return null;
	}

  function mailPlayers($players, $subject, $message, $printEmail=false) {
    foreach ($players as $player) {
      $success = mail($player->getEmail(), $subject, $message, "From: taylor.assassins@gmail.com");

      if ($printEmail)
        print "mail ".($success?"successfully":"<b>unsuccessfully</b>")." sent to {$player->getUsername()}<br>";
    }
  }

	function send_setup_email($email,$pass) {

		mail($_POST['email'],
			"Assassins Signup",
			"An assassins account has been created with this email address.\n".
				"To unlock your account, please go to:\n".
				"http://assassins.homelinux.org/assassins/signup.php?unlock=$pass",
			"From: taylor.assassins@gmail.com");
	}
?>
