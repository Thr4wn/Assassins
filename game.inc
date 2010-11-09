<?php
include_once("database.inc");
include_once("user.inc");

class Game {
  private $id;
  private $descr;
  private $start;
  private $admin;
  private $name;
  private $gametype;
  private $started;
  private $ended;
  private $hidden;
  private $num_tot;
  private $num_dead;
  private $num_alive;
  private $alive_players;
  private $dead_players;
  private $assassins;

  const REGULAR = 0;
  const ZOMBIES = 1;
  const CIRCLED = 2;

  public function Game($game_id) {
    $this->populate($game_id);
  }

  private function populate($game_id) {
    if ($game_id == null) return;

    $result = sql(
        "SELECT * ".
#				"  COUNT(a_ingame.game) AS total, ".
#				"  COUNT(a_ingame.died) AS died ".
        "FROM a_games ".
#				"  INNER JOIN a_ingame ON (a_ingame.game = a_games.id) ".
        "WHERE a_games.id = $game_id "
        );
    if (bad($result))
      return;

    $row = mysql_fetch_array($result);

    $this->id = $row['id'];
    $this->descr = $row['descr'];
    $this->start = $row['starts'];
    $this->admin = $row['admin'];
    $this->name = $row['name'];
    $this->gametype = $row['type'];
    $this->started = $row['started'];
    $this->ended = $row['ended'];
    $this->hidden = $row['hidden'];

    $this->dead_players = array();
    $this->alive_players = array();
    $this->cod_players = array();
    $this->assassins = array();
    $this->kill_count = array();
    $this->infestation_count = array();
    $result = sql(
        "SELECT username,died,assassin,kills,infestations ".
        "FROM a_ingame ".
        "WHERE game=$game_id ".
        "ORDER BY died DESC, username ASC "
        );
    while ($row = mysql_fetch_array($result)) {
      $player_username = $row['username'];

      if ($row['died'])
        $this->addDeadPlayer($player_username,$row['died']);
      else
        $this->addAlivePlayer($player_username);

      if ($row['assassin'])
        $this->assassins[] = $player_username;

      $this->kill_count[$player_username] = $row['kills'];
      $this->infestation_count[$player_username] = $row['infestations'];
    }


    // Circle of Death games
    if ($this->gametype == Game::CIRCLED) {
      $result = sql(
          "SELECT player, initial_target, current_target ".
          "FROM a_cod ".
          "WHERE game = $game_id "
          );
      while ($row = mysql_fetch_array($result)) {
        $this->cod_players[$row['player']] = $row['current_target'];
      }
    }
  }

  /*******************************************************
   ***  ACCESSOR METHODS
   *******************************************************/
  public function getId() { return $this->id; }
  public function getDescr() { return stripslashes($this->descr); }
  public function getStart() { return $this->start; }
  public function getAdmin() { return $this->admin; }
  public function getName() { return stripslashes($this->name); }
  public function getType() { return $this->gametype; }
  public function started() { return $this->started; }
  public function ended() { return $this->ended; }
  public function isHidden() { return $this->hidden; }
  public function numTotal() { return $this->numDead()+$this->numAlive(); }
  public function numDead() { return count($this->dead_players); }
  public function numAlive() { return count($this->alive_players); }

  public function setDesc($v) { $this->descr = $v; }
  public function setStart($v) { $this->start = $v; }
  public function setAdmin($v) { $this->admin = $v; }
  public function setName($v) { $this->name = $v; }
  public function setType($v) { $this->gametype = $v; }
  public function setStarted($v) { $this->started = $v; }
  public function setHidden($v) { $this->hidden = $v; }

  public function getKillCount($player_username) { return $this->kill_count[$player_username]; }
  public function getInfestationCount($player_username) { return $this->infestation_count[$player_username]; }

  public function incKillCount($player_username) {
    $this->kill_count[$player_username]++;
    $result = sql(
        "UPDATE a_ingame ".
        "SET kills = {$this->kill_count[$player_username]} ".
        "WHERE username = '$player_username' ".
        "AND game = {$this->id} "
        );
  }

  public function incInfestationCount($player_username) {
    $this->infestation_count[$player_username]++;
    $result = sql(
        "UPDATE a_ingame ".
        "SET infestations = {$this->infestation_count[$player_username]} ".
        "WHERE username = '$player_username' ".
        "AND game = {$this->id} "
        );
  }

  public function getTypeName() {
    switch ($this->gametype) {
      case Game::REGULAR:
        return "Classic";
      case Game::ZOMBIES:
        return "Zombies";
      case Game::CIRCLED:
        return "Circle of Death";
    }
  }

  public function endGame() {
    $this->ended = date("Y-m-d");
    $this->save();
  }

  public function save() {
    if ($this->id) {
      $result = sql(
          "UPDATE a_games ".
          "SET descr = '".addslashes($this->descr)."', ".
          "    starts = '{$this->start}', ".
          "    admin = '{$this->admin}', ".
          "    name = '".addslashes($this->name)."', ".
          "    type = '{$this->gametype}', ".
          "    hidden = {$this->hidden}, ".
          "    started = {$this->started}, ".
          "    ended = ".($this->ended?"'{$this->ended}'":"NULL")." ".
          "WHERE id = {$this->id} "
          );
    } else {
      $result = sql(
          "INSERT INTO a_games ".
          "(name, type, starts, descr, admin, hidden) ".
          "VALUES ( ".
          "'".addslashes($this->name)."', ".
          $this->gametype.", ".
          "'{$this->start}', ".
          "'".addslashes($this->descr)."', ".
          "'{$this->admin}', ".
          "{$this->hidden})"
          );

      $this->id = mysql_insert_id();
    }

    if ($this->gametype == Game::CIRCLED && $this->started) {
      foreach ($this->cod_players as $key => $val) {
        $result2 = sql(
            "UPDATE a_cod ".
            "SET current_target = '$val' ".
            "WHERE game = {$this->id} ".
            "  AND player = '$key' "
            );
      }
    }

    if (!$result)
      setError("Game save failed!");
  }

  public function getPlayers() {
    $result = sql(
        "SELECT username ".
        "FROM a_ingame ".
        "WHERE game=".$this->id
        );

    $players = array();
    while ($row = mysql_fetch_array($result)) {
      $players[] = User::getUser($row['username']);
    }
    return $players;
  }

  public function getDeadPlayers() {
    $arr = array();
    foreach ($this->dead_players as $key => $val) {
      $arr[] = User::getUser($key);
    }
    return $arr;
  }

  public function getAlivePlayers() {
    $arr = array();
    foreach ($this->alive_players as $key => $val) {
      $arr[] = User::getUser($key);
    }
    return $arr;
  }

  public function getCodPlayers() {
    $arr = array();
    foreach ($this->cod_players as $key => $val) {
      $arr[User::getUser($key)] = User::getUser($val);
    }
    return $arr;
  }

  public function getAssassinPlayers() {
    $result = sql(
        "SELECT username ".
        "FROM a_ingame ".
        "WHERE game={$this->id} ".
        "  AND assassin=1 "
        );

    $players = array();
    while ($row = mysql_fetch_array($result)) {
      $players[] = User::getUser($row['username']);
    }
    return $players;
  }

  public function getNonAssassinPlayers() {
    $result = sql(
        "SELECT username ".
        "FROM a_ingame ".
        "WHERE game={$this->id} ".
        "  AND assassin=0 "
        );

    $players = array();
    while ($row = mysql_fetch_array($result)) {
      $players[] = User::getUser($row['username']);
    }
    return $players;
  }

  public function isDead($user)     { return isset($this->dead_players[$user->getUsername()]); }
  public function deathTime($user)  { return $this->dead_players[$user->getUsername()]; }
  public function isAlive($user)    { return isset($this->alive_players[$user->getUsername()]); }
  public function isPlayer($user)   { return $this->isAlive($user) || $this->isDead($user); }
  public function isAssassin($user) { return in_array($user->getUsername(),$this->assassins); }
  public function numAssassins()    { return count($this->assassins); }
  public function isAdmin($user) { return $this->admin == $user->getUsername(); }

  public function addPlayer($user) {
    if ($this->ended())
      return setError("This game has already ended!");
    else if ($this->isPlayer($user))
      return setError("You are already playing this game!");
    else {
      sql(
          "INSERT INTO a_ingame ".
          "(username, game) ".
          "VALUES ('{$user->getUsername()}', {$this->getId()}) "
         );
      $this->alive_players[$user->getUsername()] = 1;
    }
  }

  private function addDeadPlayer($username,$when) { $this->dead_players[$username] = $when; }
  private function addAlivePlayer($username)      { $this->alive_players[$username] = 1; }

  public function setAssassin($user) {
    sql(
        "UPDATE a_ingame ".
        "SET assassin=TRUE ".
        "WHERE game={$this->getId()} ".
        "  AND username='{$user->getUsername()}' "
       );
    $this->assassins[] = $user->getUsername();
  }

  public function canStart() {
    switch ($this->gametype) {
      case Game::REGULAR:
        return count($this->alive_players) > 2;
      case Game::ZOMBIES:
      case Game::CIRCLED:
        return count($this->alive_players) > 1;
    }
  }

  # TODO XXX
  static function getCodStartEmailText($target) {
    return "A game of Circle of Death has started! Every person has the name of only one other target. It is your goal to track down and kill your target while avoiding your persuer. Your target's name is:\n\n{$target->getFullName()}\n\nYou may find their profile picture here: http://assassins.homelinux.org/assassins/who.php?username={$target->getUsername()}\n\nIt is recommended that you print out this email and keep it on you at all times as proof of who your target is. Then, should you die, you can give it to your killer so that they may continue hunting others. PLEASE mark yourself as dead on the website AS SOON AS POSSIBLE after you die!\n\nBe safe, watch your back, and trust no one!";
  }

  public function start($num_assassins) {
    switch ($this->gametype) {
      case Game::REGULAR:
      case Game::ZOMBIES:
        $players = $this->getPlayers();

        if ($num_assassins > count($players)) {
          setError("Cannot set that many assassins!");
          return;
        }

        for ($i = 0; $i < $num_assassins; $i++) {
          do {
            $assassin = rand(0, count($players)-1);
          } while($this->isAssassin($players[$assassin]));

          $this->setAssassin($players[$assassin]);
          if ($this->gametype == Game::ZOMBIES)
            $this->setDead($players[$assassin], date('Y-m-d'));
        }

        // Email players
        $message = "The assassins game \"$this->name\" has started.\n\n";
        if ($this->gametype == Game::REGULAR) {
          $subject = "An assassins game you joined has started!";
          $message_assassin = $message.
            "You have been chosen as one of the ".
            "{$this->numAssassins()} assassins! ".
            "Kill as many people as you can!";
          $message_nonassassin = $message.
            "You are NOT one of the ".
            "{$this->numAssassins()} assassins.";

        } else {
          $subject = "An assassins game of zombies you joined has started!";
          $message_assassin = $message.
            "You have been chosen as one of the ".
            "{$this->numAssassins()} initial zombies! ".
            "Infect as many people as you can!\n\n".
            "Please indicate your zombie status by wearing ".
            "a brightly-colored bandana on your arm.";
          $message_nonassassin = $message.
            "You are NOT one of the ".
            "{$this->numAssassins()} initial zombies. Beware of them!";
        }

        mailPlayers($this->getAssassinPlayers(),
            $subject,
            $message_assassin,
            true);

        mailPlayers($this->getNonAssassinPlayers(),
            $subject,
            $message_nonassassin,
            true);
        break;

      case Game::CIRCLED:
        $players = $this->getPlayers();
        $current_player = $players[0];

        while (count($players) > 1) {
          // Generate the current player's target
          $rand = rand(1,count($players)-1);

          // Set the current player's target
          sql(
              "INSERT INTO a_cod ".
              "  (game, player, initial_target, current_target) ".
              "VALUES ( ".
              $this->getId().", ".
              "'{$current_player->getUsername()}', ".
              "'{$players[$rand]->getUsername()}', ".
              "'{$players[$rand]->getUsername()}'".
              ")"
             );

          // Mail the current player about their target
          mailPlayers(
            array($current_player),
            "Assassins: Circle of Death game has started!",
            $this->getCodStartEmailText($players[$rand]),
            true
            );

          // Advance the current player
          $current_player = $players[$rand];

          // Remove the old current player from the list
          $players[$rand] = $players[count($players)-1];
          unset($players[count($players)-1]);
        }

        // Set the current player's target
        sql(
            "INSERT INTO a_cod ".
            "  (game, player, initial_target, current_target) ".
            "VALUES ( ".
            $this->getId().", ".
            "'{$current_player->getUsername()}', ".
            "'{$players[0]->getUsername()}', ".
            "'{$players[0]->getUsername()}'".
            ")"
           );

        // Mail the last player
        mailPlayers(
          array($current_player),
          "Assassins: Circle of Death game has started!",
          $this->getCodStartEmailText($players[0]),
          true
          );
        break;
    }

    $this->started = 1;
    $this->save();
  }


  public function setDead($user,$time) {
    sql(
        "UPDATE a_ingame ".
        "SET died='$time' ".
        "WHERE username='{$user->getUsername()}' ".
        "  AND game=".$this->getId()
       );
    $this->dead_players[$user->getUsername()] = $time;
    unset($this->alive_players[$user->getUsername()]);


    $this->evaluateGameState();

    // Handle Circle of Death games
    if ($this->gametype == Game::CIRCLED && !$this->ended) {
      $username = $user->getUsername();

      // Get our current target and set it to nothing
      $target = $this->cod_players[$username];
      $this->cod_players[$username] = -1;

      // Find out who has us and update their target to ours
      foreach ($this->cod_players as $key => $val) {
        if ($val == $username) {
          // $val/$username is us (the newly dead)
          // $key is the person who has us
          // $target is our old target

          $this->cod_players[$key] = $target;

          $killer = User::getUser($key);
          $me = User::getUser($username)->getFullName();
          $them = User::getUser($target)->getFullname();

          mailPlayers(array($killer),
              "Your assassins target has died!",
              "Your previous assassins target, $me, has been neutralized! Your new target is:\n\n$them\n\nYou may find their profile picture here: http://assassins.homelinux.org/assassins/who.php?username=$target"
              );
          break;
        }
      }

      $this->save();
    }
  }

  private function evaluateGameState() {
    switch ($this->gametype) {
      case Game::REGULAR:
        $num_reg = 0;
        $num_ass = 0;

        foreach ($this->alive_players as $k => $v) {
          if (in_array($k,$this->assassins))
            $num_ass++;
          else
            $num_reg++;
        }

        if ($num_ass == 0 || $num_reg == 0) {
          $this->endGame();
        }
        break;

      case Game::ZOMBIES:
        if (count($this->alive_players) == 0) {
          $this->endGame();
        }
        break;

      case Game::CIRCLED:
        if (count($this->alive_players) == 1) {
          $this->endGame();
        }
        break;
    }
  }

  public static function getStartedGames($showhidden = false) {
    $result = sql(
        "SELECT id ".
        "FROM a_games ".
        "WHERE started = 1 ".
        "  AND ended IS NULL ".
        ($showhidden?"":" AND hidden = 0 ").
        "ORDER BY starts DESC "
        );

    $games = array();
    while ($row = mysql_fetch_array($result)) {
      $games[] = Game::getGame($row['id']);
    }
    return $games;
  }

  public static function getPendingGames($showhidden = false) {
    $result = sql(
        "SELECT id ".
        "FROM a_games ".
        "WHERE started = 0 ".
        "  AND ended IS NULL ".
        ($showhidden?"":" AND hidden = 0 ").
        "ORDER BY starts DESC "
        );

    $games = array();
    while ($row = mysql_fetch_array($result)) {
      $games[] = Game::getGame($row['id']);
    }
    return $games;
  }

  public static function getFinishedGames($showhidden = false) {
    $result = sql(
        "SELECT id ".
        "FROM a_games ".
        "WHERE started = 1 ".
        "  AND ended IS NOT NULL ".
        ($showhidden?"":" AND hidden = 0 ").
        "ORDER BY starts DESC "
        );

    $games = array();
    while ($row = mysql_fetch_array($result)) {
      $games[] = Game::getGame($row['id']);
    }
    return $games;
  }

  public static function getGame($game_id) {
    $game = new Game($game_id);
    if ($game->getId() == null)
      return null;
    return $game;
  }
}
?>
