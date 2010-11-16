<?php
  include_once("database.inc");

  class User {
    private $username;
    private $first;
    private $last;
    private $ban;
    private $email;
    private $ava;
    private $mime;
    private $mlist_enrolled;
    private $verify;
    private $changeemail;

    public function User($username) {
      $this->populate($username);
    }

    private function Populate($username) {
      if ($username == null) return;

      $this->username = $username;

      $result = sql(
        "SELECT * ".
        "FROM a_tusers ".
        "WHERE username = '$username' "
        );
      if (!bad($result)) {
        $row = mysql_fetch_array($result);

        $this->first = $row['first'];
        $this->last = $row['last'];
        $this->ban = $row['banned'];
        $this->email = $row['email'];
        $this->ava = $row['ava'];
        $this->mime = $row['mime'];
        $this->mlist_enrolled = $row['maillist_enroll'];
        $this->verify = $row['verify'];
        $this->changeemail = $row['changeemail'];
      }

      $save = false;
      if (!$this->email) {
        $this->email = "{$this->username}@taylor.edu";
        $save = true;
      }

      if (!$this->first || !$this->last) {
        $matches = array();
        if (preg_match("/^(\w+)_([a-zA-Z]+)\d*$/", $this->username, $matches)) {
          $this->first = ucwords($matches[1]);
          $this->last = ucwords($matches[2]);
        } else if (preg_match("/^..([a-zA-Z]+)\d*$/", $this->username, $matches)) {
          $this->first = 'none';
          $this->last = ucwords($matches[1]);
        }
        $save = true;
      }

      if ($save)
        $this->save();

    }

    /*******************************************************
    ***  ACCESSOR METHODS
    *******************************************************/
    public function getUsername() { return $this->username; }
    public function getFullName() { return "{$this->first} {$this->last}"; }
    public function getFirst() { return stripslashes($this->first); }
    public function getLast() { return $this->last; }
    public function getEmail() { return $this->email; }
    public function getAva() { return $this->ava; }
    public function getMime() { return $this->mime; }
    public function isEnrolledInMailingList() { return $this->mlist_enrolled; }
    public function isBanned() { return $this->ban; }
    public function getVerify() { return $this->verify; }
    public function getChangeEmail() { return $this->changeemail; }

    public function setFirst($v) { $this->first = $v; }
    public function setLast($v) { $this->last = $v; }
    public function setEmail($v) { $this->email = $v; }
    public function setAva($v) { $this->ava = $v; }
    public function setMime($v) { $this->mime = $v; }
    public function setMailingListEnrollment($v) { $this->mlist_enrolled = $v; }
    public function setBan($v) { $this->ban = $v; }
    public function setVerify($v) { $this->verify = $v; }
    public function setChangeEmail($v) { $this->changeemail = $v; }

    public function save() {
      $result = sql(
        "UPDATE a_tusers ".
        "SET banned = {$this->ban}, ".
        "    email = '{$this->email}', ".
        "    first = '".addslashes($this->first)."', ".
        "    last = '{$this->last}', ".
        "    maillist_enroll = '{$this->mlist_enrolled}', ".
        "    verify = '{$this->verify}', ".
        "    changeemail = '{$this->changeemail}' ".
        "WHERE username = '{$this->username}' "
        );

      if (!$result) {
        $result = sql(
          "INSERT INTO a_tusers ".
          "    (username, email, first, last) ".
          "VALUES (".
            "'{$this->username}', ".
            "'{$this->email}', ".
            "'".addslashes($this->first)."', ".
            "'{$this->last}' ".
            ") "
          );
      }

      return $result;
    }

    public function saveAvatar() {
      $result = mysql_query(
        "UPDATE a_tusers ".
        "SET ava = \"".addslashes($this->ava)."\", ".
        "    mime = \"{$this->mime}\" ".
        "WHERE username = '{$this->username}' "
        );
      return $result;
    }

    public function isLoggedIn() {
      return $this->username == requireLogin(true, true)->getUsername();
    }

    public static function getUser($username) {
      $user = new User($username);
      return $user;
    }
  }
?>
