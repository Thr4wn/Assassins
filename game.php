<?php
session_start();

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

$id = $_GET['id'];
$game = Game::getGame($id);

if ($game) {

  $title = $game->getName();
  include("top.php");

  echo "<meta http-equiv='refresh' content=300/>\n";

  echo "<h2>{$game->getName()}</h2>\n";

  // administrator functions
  if ($game->isAdmin($user) || $user->getId() == $_CONFIG['admin_id']) {
    echo "&middot; <a href=\"alter.php?id=$id\">alter</a> the game info<br/>";

    if (!$game->started())
      echo "&middot; <a href=\"start.php?id=$id\">start</a> the game<br/>";
    else if (!$game->ended())
      echo "&middot; <a href=\"end.php?id=$id\">end</a> the game<br/>";

    echo "&middot; <a href=\"reqmail.php?id=$id\">request</a> email to all players<br/>";

  }

  if ($user->getId() == $_CONFIG['admin_id'])
    echo "&middot; <a href=\"mail.php?id=$id&userid={$user->getId()}\">mail</a> all players<br/>";

  if ($game->started() && !$game->ended() && $game->isPlayer($user)) {
    if ($game->getType() == Game::REGULAR)
      echo "&middot; <a href='ami.php?game=$id'>check</a> if you are the assassin<br/>";
    else if ($game->getType() == Game::CIRCLED)
      echo "&middot; <a href='ami.php?game=$id'>check</a> who your target is<br/>";
  }

  echo "<br/>";

  // start and end dates
  echo "\n\tstart".($game->started()?"ed":"s").": {$game->getStart()}";
  if ($game->ended())
    echo "\n\t<br>ended: {$game->ended()}";

  echo "\n<p>\n\t".str_replace("\n", "\n</p><p>\n\t", $game->getDescr())."\n</p>";
  echo "\n\n<h2>players</h2>\n";

  if ($game->numTotal() == 0)
    echo "<p>Huh, There appear to be no players yet. You can sign up <a href='join.php?id=$id'>here</a>.</p>";



  // Output the avatar and username
  function output_player_header($player) {
    echo "<tr><td>";
    if ($player->getAva()) {
      echo "<img src='ava.php?id={$player->getId()}' height=48 width=48 />\n";
    }
    echo "<a href='who.php?id={$player->getId()}'>";
    echo $player->getUsername()."</a></td>\n";
  }


  // Output the last bit of information about the player
  function output_player_footer($game, $player) {
    if ($game->getType() == Game::ZOMBIES && $game->started()) {
      // 1st column
      echo "<td style=\"width: 0px\">\n";
      echo "killed:&nbsp;{$game->getKillCount($player->getId())}<br/>\n";
      echo "infested:&nbsp;{$game->getInfestationCount($player->getId())}</td>\n";

      if (!$game->ended() && $player->isLoggedIn()) {

        // 3rd column
        if ($game->isDead($player))
          echo "<td><a href='zomkill.php?id={$game->getId()}'>[increment human<br/>infestation count]</a></td>\n";
        else
          echo "<td><a href='zomkill.php?id={$game->getId()}'>[increment zombie<br/>kill count]</a></td>\n";

      }
    }

    if ($player->isLoggedIn() && $game->started() && !$game->ended() && $game->isAlive($player))
      echo "<td><a href='mark.php?id={$game->getId()}'>[mark as dead]</a></td>\n";
    echo "</tr>\n";
  }


  // Output all the alive players in the game
  function output_alive_players($game) {
    foreach ($game->getAlivePlayers() as $player) {
      output_player_header($player); // 1st column

      echo "<td><span class='alive'>still alive</span></td>"; // 2nd column

      if ($game->getType()==Game::REGULAR && $game->isAssassin($player) && $game->ended())
        echo "<td><span class='assassin'>was an assassin!</span></td>"; // 3rd column
      else
        echo "<td></td>"; // 3rd column

      output_player_footer($game, $player);
    }
  }


  // Output all the dead players in the game
  function output_dead_players($game) {
    foreach ($game->getDeadPlayers() as $player) {
      output_player_header($player); // 1st column

      echo "<td><span class='dead'>died: ".date("Y-m-d H:i", strtotime($game->deathTime($player)))."</span></td>"; // 2nd column

      if ($game->getType() == Game::REGULAR && $game->isAssassin($player)) {
        echo "\t<td><span class='assassin'>was an assassin!</span></td>"; // 3rd column

      } else if ($game->getType() == Game::ZOMBIES) {
        echo "\t<td style=\"width: 0px\">";
        if ($game->isAssassin($player))
          echo "<span class='assassin'>(initial zombie)</span>";
        echo "</td>";   // 3rd column
      }

      output_player_footer($game, $player);
    }
  }


  //
  // New code for the outputting of players on the game page
  //

  // Avatar and Username
  function output_column_1($game,$player) {
    echo "<td>";

    if ($player->getAva())
      echo "<img src='ava.php?id={$player->getId()}' height=48 width=48 />\n";
    echo "<a href='who.php?id={$player->getId()}'>{$player->getUsername()}</a>";

    echo "</td>\n";
  }

  // Still alive or death time
  function output_column_2($game,$player) {
    echo "<td>";

    if ($game->isAlive($player))
      echo "<span class='alive'>still alive</span>";
    else if ($game->isDead($player))
      echo "<span class='dead'>died: ".date("Y-m-d H:i", strtotime($game->deathTime($player)))."</span>";

    echo "</td>\n";
  }

  // Was an assassin or initial zombie
  function output_column_3($game,$player) {
    echo "<td style='width: 0px'>";

    if ($game->getType() == Game::REGULAR && $game->isAssassin($player) && ($game->ended() || $game->isDead($player)))
      echo "<span class='assassin'>was an assassin!</span>";
    else if ($game->getType() == Game::ZOMBIES && $game->isAssassin($player))
      echo "<span class='assassin'>(initial zombie)</span>";

    echo "</td>\n";
  }

  // Killed/Infested count
  function output_column_4($game,$player) {
    if ($game->getType() == Game::ZOMBIES && $game->started()) {
      echo "<td style=\"width: 0px\">\n";

      echo "killed:&nbsp;{$game->getKillCount($player->getId())}<br/>\n";
      echo "infested:&nbsp;{$game->getInfestationCount($player->getId())}</td>\n";

      echo "</td>";
    }
  }

  // Increment link
  function output_column_5($game,$player) {
    if ($game->getType() == Game::ZOMBIES && $game->started() && !$game->ended() && $player->isLoggedIn()) {
      echo "<td>";

      if ($game->isDead($player))
        echo "<a href='zomkill.php?id={$game->getId()}'>[increment human<br/>infestation count]</a>";
      else
        echo "<a href='zomkill.php?id={$game->getId()}'>[increment zombie<br/>kill count]</a>";

      echo "</td>\n";
    }
  }

  // Mark as dead link
  function output_column_6($game,$player) {
    if ($player->isLoggedIn() && $game->started() && !$game->ended() && $game->isAlive($player))
      echo "<td><a href='mark.php?id={$game->getId()}'>[mark as dead]</a></td>\n";
  }


  function output_players($game,$players) {
    foreach ($players as $player) {
      echo "<tr>";
      output_column_1($game,$player);
      output_column_2($game,$player);

      if ($game->started()) {
        output_column_3($game,$player);
        output_column_4($game,$player);
        output_column_5($game,$player);
        output_column_6($game,$player);
      }

      echo "</tr>";
    }
  }



  echo "<table cellspacing=5>\n";
  #output_alive_players($game);
  #output_dead_players($game);
  output_players($game, $game->getAlivePlayers());
  output_players($game, $game->getDeadPlayers());
  echo "</table>";


  // Output message if it hasn't started and you haven't joined yet
  if (!$game->started() && !$game->isPlayer($user))
    echo "<br><br><p><a href='join.php?id=$id'>Join</a> this game.</p>\n";

} else {
  $title = "Unknown Game";
  include("top.php");
}

displayErrors();

include("bottom.php");
?>
