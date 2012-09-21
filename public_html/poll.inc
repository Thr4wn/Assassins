<?php
  include_once("database.inc");

  class Poll {
    private $id;
    private $creator;
    private $text;
    private $createtime;
    private $hidden;
    private $active;
    private $options;
    private $votes;
    private $numvotes;

    public function Poll($id) {
      $this->populate($id);
    }

    private function Populate($id) {
      if ($id == null) return;

      $result = sql(
        "SELECT * ".
        "FROM a_polls ".
        "WHERE id = $id "
        );

      if (bad($result))
        return;
      else {

        $row = mysql_fetch_array($result);

        # Get basic info
        $this->id = $row['id'];
        $this->creator = $row['creator'];
        $this->text = $row['text'];
        $this->createtime = $row['createtime'];
        $this->hidden = $row['hidden'];
        $this->active = $row['active'];
        $this->options = array();
        $this->votes = array();

        # Get total number of votes
        $result = sql(
          "SELECT count(*) as cnt ".
          "FROM a_pollchoices ".
          "WHERE poll_id = {$this->id} "
        );
        $row = mysql_fetch_array($result);
        $this->numvotes = $row['cnt'];

        # Get individual options
        $result = sql(
          "SELECT * ".
          "FROM a_polloptions ".
          "WHERE poll_id = {$this->id} ".
          "ORDER BY number "
        );

        while ($row = mysql_fetch_array($result)) {

          $this->setOption($row['number'], $row['text']);
          $this->votes[$row['number']] = array();

          # Get individual votes
          $result2 = sql(
            "SELECT username ".
            "FROM a_pollchoices ".
            "WHERE poll_id = {$this->id} ".
            "  AND choice = {$row['number']} "
          );

          while ($row2 = mysql_fetch_array($result2)) {
            $this->addVote($row['number'], $row2['username']);
          }
        }
      }
    }

    /*******************************************************
    ***  ACCESSOR METHODS
    *******************************************************/
    public function getId() { return $this->id; }
    public function getCreator() { return $this->creator; }
    public function getText() { return stripslashes($this->text); }
    public function getCreateTime() { return $this->createtime; }
    public function getOptions() { return $this->options; }
    public function getVotes($num) { return $this->votes[$num]; }
    public function isHidden() { return $this->hidden; }
    public function isActive() { return $this->active; }
    public function getNumVotes() { return $this->numvotes; }

    public function setCreator($v) { $this->creator = $v; }
    public function setText($v) { $this->text = $v; }
    public function setOption($num, $text) { $this->options[$num] = str_replace('"', '', $text); }
    public function clearOptions() { $this->options = array(); }
    private function addVote($num, $user) { $this->votes[$num][] = $user; }
    public function setHidden($v) { $this->hidden = $v; }
    public function setActive($v) { $this->active = $v; }

    public function save() {
      if ($this->id) {

        if ($this->active) {
          sql(
            "UPDATE a_polls ".
            "SET active = 0 "
          );
        }

        $result = sql(
          "UPDATE a_polls ".
          "SET creator = '{$this->creator}', ".
          "    text = '".addslashes($this->text)."', ".
          "    hidden = {$this->hidden}, ".
          "    active = {$this->active} ".
          "WHERE id = {$this->id} "
          );

        sql(
          "DELETE FROM a_polloptions ".
          "WHERE poll_id = {$this->id} "
        );
        foreach ($this->options as $num => $text) {
          sql(
            "INSERT INTO a_polloptions ".
            "    (poll_id, text, number) ".
            "VALUES (".
              "{$this->id}, ".
              "'".addslashes($text)."', ".
              "{$num} ".
            ") "
          );
        }
      } else {
        $result = sql(
          "INSERT INTO a_polls ".
          "    (creator, text, hidden) ".
          "VALUES (".
            "'{$this->creator}', ".
            "'".addslashes($this->text)."', ".
            "{$this->hidden} ".
            ") "
          );

        $this->id = mysql_insert_id();

        foreach ($this->options as $num => $text) {
          $result = sql(
            "INSERT INTO a_polloptions ".
            "    (poll_id, text, number) ".
            "VALUES (".
              "{$this->id}, ".
              "'".addslashes($text)."', ".
              "{$num} ".
            ") "
          );
        }
      }

      if (!$result)
        setError("Poll save failed!");

      return $result;
    }

    public function hasVoted($username) {
      foreach ($this->votes as $votearr) {
        if (in_array($username, $votearr))
          return true;
      }
      return false;
    }

    public function vote($username, $choice) {
      if (!$this->hasVoted($username)) {
        $result = sql(
          "INSERT INTO a_pollchoices(username, poll_id, choice) ".
          "VALUES ('$username', {$this->id}, $choice) "
        );

        $this->addVote($choice, $username);
      } else {
        setError("You have already voted in this poll!");
      }
    }

    public static function getActivePoll() {
      $result = sql(
        "SELECT id ".
        "FROM a_polls ".
        "WHERE active = 1 ".
        "  AND hidden = 0 "
      );

      if (!bad($result)) {
        $row = mysql_fetch_array($result);
        return Poll::getPoll($row['id']);
      } else
        return null;
    }

    public static function getAllPolls() {
      $result = sql(
        "SELECT id ".
        "FROM a_polls ".
        "ORDER BY createtime DESC"
      );

      $polls = array();

      while ($row = mysql_fetch_array($result)) {
        $polls[] = Poll::getPoll($row['id']);
      }

      return $polls;
    }

    public static function getPoll($id) {
      $poll = new Poll($id);
      if (!$poll->getId())
        return null;
      return $poll;
    }
  }
?>
