<?php
	include_once("database.inc");

	class User {
		private $id;
		private $username;
		private $md5password;
		private $ban;
		private $email;
		private $joined;
		private $limbo;
		private $ava;
		private $mime;

		public function User($user_id) {
			$this->populate($user_id);
		}

		private function Populate($user_id) {
			if ($user_id == null) return;

			$result = sql(
				"SELECT * ".
				"FROM a_users ".
				"WHERE id = $user_id "
				);
			if (bad($result))
				return;

			$row = mysql_fetch_array($result);

			$this->id = $row['id'];
			$this->username = $row['name'];
			$this->md5password = $row['password'];
			$this->ban = $row['ban'];
			$this->email = $row['email'];
			$this->joined = $row['joined'];
			$this->limbo = $row['limbo'];
			$this->ava = $row['ava'];
			$this->mime = $row['mime'];
		}

		/*******************************************************
		***  ACCESSOR METHODS
		*******************************************************/
		public function getId() { return $this->id; }
		public function getUsername() { return stripslashes($this->username); }
		public function getPassword() { return $this->md5password; }
		public function getEmail() { return stripslashes($this->email); }
		public function getJoined() { return $this->joined; }
		public function getLimbo() { return $this->limbo; }
		public function getAva() { return $this->ava; }
		public function getMime() { return $this->mime; }
		public function isBanned() { return $this->ban; }

		public function setUsername($v) { $this->username = $v; }
		public function setmd5Password($v) { $this->md5password = $v; }
		public function setBan($v) { $this->ban = $v; }
		public function setEmail($v) { $this->email = $v; }
		public function setJoined($v) { $this->joined = $v; }
		public function setLimbo($v) { $this->limbo = $v; }
		public function setAva($v) { $this->ava = $v; }
		public function setMime($v) { $this->mime = $v; }

		public function save() {
			if ($this->id) {
				$result = sql(
					"UPDATE a_users ".
					"SET name = '".addslashes($this->username)."', ".
					"    password = '{$this->md5password}', ".
					"    ban = {$this->ban}, ".
					"    email = '".addslashes(strtolower($this->email))."', ".
					"    joined = '{$this->joined}', ".
					"    limbo = {$this->limbo} ".
					"WHERE id = {$this->id} "
					);

				return $result;
			} else {
				if (!vemail($this->email)) {
					setError("Invalid email address!");
					return null;
				}

				$user = User::getUserByEmail($this->email);
				if ($user) {
					setError("Duplicate email!");
					return null;
				}

				$result = sql(
					"INSERT INTO a_users ".
					"    (name, password, email, joined) ".
					"VALUES (".
						"'".addslashes($this->username)."',".
						"'{$this->md5password}',".
						"'".addslashes($this->email)."',".
						"'{$this->joined}'".
						") "
					);

				return $result;
			}
		}

		public function saveAvatar() {
			$result = mysql_query(
				"UPDATE a_users ".
				"SET ava = \"".addslashes($this->ava)."\", ".
				"    mime = \"{$this->mime}\" ".
				"WHERE id = {$this->id} "
				);
			return $result;
		}

		public function confirmAccount() {
			$this->setLimbo(0);
			return $result;
		}

		public function isLoggedIn() {
			return $this->id == $_SESSION['userid'];
		}

		public static function getUser($user_id) {
			$user = new User($user_id);
			if ($user->getId() == null) return null;
			return $user;
		}

		public static function getUserByName($name) {
			$name = addslashes($name);
			$result = sql(
				"SELECT id ".
				"FROM a_users ".
				"WHERE username = '$name' "
				);

			if (bad($result))
				return null;

			$row = mysql_fetch_array($result);
			return User::getUser($row['id']);
		}

		public static function getUserByEmail($email) {
			$email = addslashes(strtolower($email));
			$result = sql(
				"SELECT id ".
				"FROM a_users ".
				"WHERE email = '$email' "
				);

			if (bad($result))
				return null;

			$row = mysql_fetch_array($result);
			return User::getUser($row['id']);
		}

		public static function getUserByPassword($pass) {
			$pass = md5($pass);
			$result = sql(
				"SELECT id ".
				"FROM a_users ".
				"WHERE password = '$pass' "
				);

			if (bad($result))
				return null;

			$row = mysql_fetch_array($result);
			return User::getUser($row['id']);
		}
	}
?>
