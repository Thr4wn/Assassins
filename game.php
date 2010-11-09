<?php

include_once("database.inc");
include_once("user.inc");
include_once("util.inc");
include_once("game.inc");

$user = requireLogin();

$id = $_GET['id'];
$game = Game::getGame($id);

if ($game) {

  $title = $game->getName();
  $headers = "<meta http-equiv='refresh' content=300>";
  include("top.php");


  echo "<h2>{$game->getName()}</h2>\n";

  echo "<table style='width:100%;'><tr><td>";

  // administrator functions
  if ($game->isAdmin($user) || isAdmin($user)) {
    echo "&middot; <a href=\"alter.php?id=$id\">alter</a> the game info<br>";

    if (!$game->started())
      echo "&middot; <a href=\"start.php?id=$id\">start</a> the game<br>";
    else if (!$game->ended())
      echo "&middot; <a href=\"end.php?id=$id\">end</a> the game<br>";

    echo "&middot; <a href=\"reqmail.php?id=$id\">request</a> email to all players<br>";

  }

  if (isAdmin($user))
    echo "&middot; <a href=\"mail.php?id=$id&amp;username={$user->getUsername()}\">mail</a> all players<br>";

  if ($game->started() && !$game->ended() && $game->isPlayer($user)) {
    if ($game->getType() == Game::REGULAR)
      echo "&middot; <a href='ami.php?game=$id'>check</a> if you are the assassin<br>";
    else if ($game->getType() == Game::CIRCLED && !$game->isDead($user))
      echo "&middot; <a href='ami.php?game=$id'>check</a> who your target is<br>";
  }

  echo "<br>";

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
      echo "<img src='ava.php?username={$player->getUsername()}' height=48 width=48 alt='Profile Picture'>\n";
    }
    echo "<a href='who.php?username={$player->getUsername()}'>";
    echo "{$player->getFullName()}</a></td>\n";
  }


  // Output the last bit of information about the player
  function output_player_footer($game, $player) {
    if ($game->getType() == Game::ZOMBIES && $game->started()) {
      // 1st column
      echo "<td style=\"width: 0px\">\n";
      echo "killed:&nbsp;{$game->getKillCount($player->getUsername())}<br>\n";
      echo "infested:&nbsp;{$game->getInfestationCount($player->getUsername())}</td>\n";

      if (!$game->ended() && $player->isLoggedIn()) {

        // 3rd column
        if ($game->isDead($player))
          echo "<td><a href='zomkill.php?id={$game->getId()}'>[increment human<br>infestation count]</a></td>\n";
        else
          echo "<td><a href='zomkill.php?id={$game->getId()}'>[increment zombie<br>kill count]</a></td>\n";

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
      echo "<img src='ava.php?username={$player->getUsername()}' height=48 width=48 alt='Profile Picture'>\n";
    echo "<a href='who.php?username={$player->getUsername()}'>{$player->getFullName()}</a>";

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

      echo "killed:&nbsp;{$game->getKillCount($player->getUsername())}<br>\n";
      echo "infested:&nbsp;{$game->getInfestationCount($player->getUsername())}\n";

      echo "</td>";
    }
  }

  // Increment link
  function output_column_5($game,$player) {
    if ($game->getType() == Game::ZOMBIES && $game->started() && !$game->ended() && $player->isLoggedIn()) {
      echo "<td>";

      if ($game->isDead($player))
        echo "<a href='zomkill.php?id={$game->getId()}'>[increment human<br>infestation count]</a>";
      else
        echo "<a href='zomkill.php?id={$game->getId()}'>[increment zombie<br>kill count]</a>";

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

  echo "</td>";



  // Start the right-hand content box
  if ($game->started() && !$game->ended() && $game->isPlayer($user)) {
    echo "<td class='rulesbox'>";
    // Output an info box
    echo "<fieldset>\n";
    echo "<legend>{$game->getTypeName()}</legend>\n";

    // Short Description
    switch ($game->getType()) {
      case Game::REGULAR:
        echo "Secret assassins try to eliminate the rest of the players. Watch your back!";
        break;
      case Game::ZOMBIES:
        echo "Zombies have risen from the grave to haunt the humans until a cure is found!";
        break;
      case Game::CIRCLED:
        echo "Everyone <i>has</i> a target and <i>is</i> a target. Last one standing wins!";
        break;
    }

    // Goal
    echo "<fieldset><legend>Goal</legend>";
    switch ($game->getType()) {
      case Game::REGULAR:
        echo "The assassins win by eliminating all the non-assassin players. The rest of the players win by killing the assassins.";
        break;
      case Game::ZOMBIES:
        if ($game->isAlive($user)) {
          echo "Win by remaining a human until the game ends.";
        } else if ($game->isDead($user)) {
          echo "Win by infecting all the humans before the game ends.";
        }
        break;
      case Game::CIRCLED:
        echo "Win by being the last player standing.";
        break;
    }
    echo "</fieldset>";

    // Weapons
    echo "<fieldset><legend>Allowed Weapons</legend>";
    if ($game->getType() == Game::ZOMBIES && $game->isDead($user))
      echo "You may only use melee weapons or your hands to infect humans.";
    else
      echo "Standard melee and ranged weapons are allowed.";
    echo "</fieldset>";

    // Additional rules
    echo "<fieldset><legend>Special Rules</legend>";
    switch ($game->getType()) {
      case Game::REGULAR:
        if ($game->isAlive($user))
          echo "You may attack any player still in the game, and you may lie about whether or not you are the assassin. You may divulge any information about the game to anyone.";
        else
          echo "In regards to this game, you may <b>only</b> say that you are dead and when you died. No matter what anyone else has told you or what you have witnessed, you may not give out this information to anyone, whether or not they are playing the game. You are dead, after all.";
        break;
      case Game::ZOMBIES:
        if ($game->isAlive($user)) {
          echo "Humans are not allowed to attack one another. If, for some strange reason, you duel another human, no deaths count during this game. If a zombie kills you, you must instantly become a zombie and don a brightly colored piece of cloth on your <b>left</b> arm ASAP to indicate your status.";
        } else if ($game->isDead($user)) {
          echo "You <span style='font-weight:bold;text-decoration:underline;'>MUST</span> wear a brightly colored piece of cloth on your <b>left</b> arm! Without it, you are out of the game. Zombies cannot kill one another. If, for some strange reason, you dual another zombie, no deaths count during this game. If a human kills you, you are dead until the next hour begins, as indicated by Taylor's bell tower. If you are dead and outside when the hour begins, you do not resurrect until you enter and leave a safe zone.";
        }
        break;
      case Game::CIRCLED:
        echo "You must track down and kill your target, as indicated in an email you should have received. If you kill your target, your new target is their target, unless you are the last person remaining. If you die, you must immediately divulge to your killer who your target was. There is no restriction on the spread of information during this game.";
        break;
    }
    echo "</fieldset>";

#Only a few people are secretly, randomly chosen to be "assassins." They are sent an email telling them that they are an assassin. Everyone else tries to guess who the assassins are and kill them, and the assassins try to kill everyone else.
#
#A few people are publicly, randomly declared to be "zombies," while the rest are "humans."
#<ul>
#<li>All zombies <i>must</i> wear a clearly visible bandana (or similar piece of cloth) on their <b>left</b> arm</li>
#<li>All zombies can only use melee weapons (including their hands).</li>
#<li>If a zombie strikes a human <b>anywhere</b>, then the human immediately becomes a zombie (as soon as they can put their bandana on!).</li>
#<li>If a zombie dies, they resurrect at the first sound of the TU bell tower at the top of the hour.</li>
#<li>If a zombie does not have a bandana on as they are leaving a building, they cannot secretly put it on later until they get inside a building again. A zombie cannot kill or be killed without a bandana.</li>
#</ul>
#
#Everyone is secretly emailed a target. If you kill anyone other than your target, you lose and must announce yourself as dead on the website. When you kill your target, they should tell you your new target (which used to be theirs), and when they mark themselves as dead, their new target will be emailed to you.

    echo "</fieldset>\n";
    echo "</td>";
  }

  echo "</tr></table>";

} else {
  $title = "Unknown Game";
  include("top.php");
}

displayErrors();

include("bottom.php");
?>
