-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 06, 2009 at 02:56 PM
-- Server version: 5.0.76
-- PHP Version: 5.2.9-pl2-gentoo

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `assassins`
--

-- --------------------------------------------------------

--
-- Table structure for table `a_games`
--

DROP TABLE IF EXISTS `a_games`;
CREATE TABLE IF NOT EXISTS `a_games` (
  `id` int(6) NOT NULL auto_increment,
  `descr` text NOT NULL,
  `starts` date NOT NULL,
  `admin` int(6) NOT NULL,
  `name` varchar(32) NOT NULL,
  `type` int(11) NOT NULL,
  `started` int(11) NOT NULL default '0',
  `ended` date default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `a_games`
--

INSERT INTO `a_games` (`id`, `descr`, `starts`, `admin`, `name`, `type`, `started`, `ended`) VALUES
(10, 'Circle of Death means that there is a circle and that people in it die.  More specifically, each person has a specific target and is being targeted by someone.\r\n\r\n*If you do not know the identity of any of the people who have signed up under nicknames rather than their real names, please simply e-mail Ariel and she will tell you*\r\n\r\nRules and workings:\r\n\r\n1) You may only kill your target.  If you kill anyone who is not your target, you are immediately disqualified from the game (one exception -- see 3).  The target has a right, after their death, to make sure that you possess the slip of paper indicating that they are your target.\r\n\r\n2) Once you kill your target, you inherit their target, keeping this beautiful formation and expression of geometric perfection that we like to call a circle.\r\n\r\n3) You may kill in self-defense without being disqualified.  Self-defense is allowed if you see someone''s weapon pointed at you, or if they are obviously in the process of raising it to point it at you.  This means use common sense with your weapon -- don''t go around pointing it at people.  If, in self-defense, you kill the person who had you as a target, the person who was after them will now be after you.  If your target dies, go to them and get their target.', '2006-12-04', 13, 'Circle of Death', 2, 1, '2006-12-09'),
(11, 'A good honest to goodness game of assassins. Rachel Hughes will be arbiter.\r\n\r\nThe Object:\r\nOne (or two if numbers warrant) assassin(s) will attempt to kill everyone else in the game by whatever means possible. Lynchings and vigilante justice will probably get out of hand too. Everyone is working together to figure out who the assassin(s) is(are) and kill them, but they may end up killing civilians as well. The assassin(s) will either be decided by a computer program, or a third party person if the program can''t do it. \r\n\r\nWeapons:\r\nNerf guns and lightsabers will be the only legal weapons, along with marshmellow guns or rubber band guns if someone has them. If spoons, chopsticks, stale breadsticks or the like are used, the killer must yell at the top of their lungs something of the order of "THIS IS THE DEADLY BREADSTICK OF FATAL DEATH WITH WHICH I INTEND TO KILL YOU AFTER I FINISH THIS REALLY LONG SPIEL IN ORDER TO MAKE THIS WEAPON IMPRACTICAL FOR ME AND GIVE YOU MORE THAN A REASONABLE CHANCE TO RUN AWAY OR TO KILL ME" or something like that before killing with them.\r\n\r\nCombat:\r\nCombat must take place outdoors. Anytime you are outside of a building or a car and not touching the door of which you have access to either you can be killed. There are no immunities for events or activities, except in extenuating circumstances. Any hit that would hit your person if the nerf gun were a real gun or the lightsaber were a real sword, kills you. For example if your jacket is hanging out and someone slashes it side to side with a lightsaber, this will not kill you. However, if the nerf dart were a bullet and would go through your jacket in a way that would hit you, it kills you. A hit anywhere kills you, even extremities. The only exception is the gauntlet rule, where a hand that is holding a weapon is protected up to an inch above the wrist. Whether the gauntlet was hit is part of the honor system.\r\n\r\nArmor:\r\nArmor will not be allowed during this game.\r\n\r\nDisputes:\r\nDisputes will either be settled by the person running the game, or some arbiter outside of the game if any were willing. If someone is found to be cheating, they will be dropped from the game.\r\n\r\nIf you have any questions about the rules, talk to Stefan. If you have any disagreements, talk to Rachel.', '2007-02-27', 17, 'Assassins simple', 0, 1, '2007-02-27'),
(12, 'Since Swallowites are no good treacherous backstabbers, and since the last game was so short, another assassin game will be starting. Rachel Hughes will be arbiter.\r\n\r\nThe Object:\r\n\r\nOne (or two if numbers warrant) assassin(s) will attempt to kill everyone else in the game by whatever means possible. Lynchings and vigilante justice will probably get out of hand too. Everyone is working together to figure out who the assassin(s) is(are) and kill them, but they may end up killing civilians as well. The assassin(s) will either be decided by a computer program, or a third party person if the program can''t do it.\r\n\r\nWeapons:\r\n\r\nNerf guns and lightsabers will be the only legal weapons, along with marshmellow guns or rubber band guns if someone has them. If spoons, chopsticks, stale breadsticks or the like are used, the killer must yell at the top of their lungs something of the order of "THIS IS THE DEADLY BREADSTICK OF FATAL DEATH WITH WHICH I INTEND TO KILL YOU AFTER I FINISH THIS REALLY LONG SPIEL IN ORDER TO MAKE THIS WEAPON IMPRACTICAL FOR ME AND GIVE YOU MORE THAN A REASONABLE CHANCE TO RUN AWAY OR TO KILL ME" or something like that before killing with them.\r\n\r\nCombat:\r\n\r\nCombat must take place outdoors. Anytime you are outside of a building or a car and not touching the door of which you have access to either you can be killed. There are no immunities for events or activities, except in extenuating circumstances. Any hit that would hit your person if the nerf gun were a real gun or the lightsaber were a real sword, kills you. For example if your jacket is hanging out and someone slashes it side to side with a lightsaber, this will not kill you. However, if the nerf dart were a bullet and would go through your jacket in a way that would hit you, it kills you. A hit anywhere kills you, even extremities. The only exception is the gauntlet rule, where a hand that is holding a weapon is protected up to an inch above the wrist. Whether the gauntlet was hit is part of the honor system.\r\n\r\nArmor:\r\n\r\nArmor will not be allowed during this game.\r\n\r\nDisputes:\r\n\r\nDisputes will either be settled by the person running the game, or some arbiter outside of the game if any were willing. If someone is found to be cheating, they will be dropped from the game.\r\n\r\nFor the rest of the rules read the "rules" tab, to the right of "home." If you have any questions about the rules, talk to Andy or Stefan. If you have any disagreements, talk to Rachel. \r\n\r\n***NOTE*** For those who don''t know, "The Gunslinger" is also known as Ben Mattice, and "No Shoes" is also known as Aaron Bengston.', '2007-03-05', 12, 'Assassins simple... again', 0, 1, '2007-03-06'),
(14, 'A regular game of assassins. This is the first game of the 2007-2008 year. Yay!\r\n\r\nBasic rules are in the link above, I think they cover most everything. Ask if you aren''t sure about something.\r\n\r\nIf we get more than, say, 15 people or so, we will probably want two assassins. Unfortunately this website does not have this capability, so if needed I will make a manual ghetto one and have people email me so I can update it.\r\n\r\n-Tarzan\r\n\r\nUPDATE: I''m not starting this game with just six people, we need more! \r\n\r\nUPDATE: 10 people is good enough I guess, started the game at 2 am Monday.', '2007-10-01', 12, 'Regular Assasins Fall07', 0, 1, '2007-10-01'),
(15, 'Another regular game of assassins - the last one ended too quickly! We will probably have multiple assassins this time, HOWEVER the assassins will not know who their fellow assassins are. This way they can''t go around in a group ganging up on people. An assassin could potentially unwittingly kill a fellow assassin :-P Since this website doesn''t support multiple assassins I will probably need to set up another website once everyone is signed up and have people email me updates.\r\n\r\nSome other explanation/clarification/information:\r\n-To play, you have to sign up, log in, and JOIN the game.\r\n-You will want to get a weapon, if only for self defense! You can get lightsabers (about $6) and nerf guns (about $8) at Walmart.\r\n-Once the game has started you need to check your email to see if you are the assassin or not.\r\n-Do NOT show your email to anyone! The whole point of the game is that you can NEVER be positive who is a regular player and who is an assassin. If you use your email to prove you are not the assassin, that ruins the game.\r\n\r\n-Tarzan\r\n\r\n', '2007-10-08', 12, 'Regular Assassins Round 2: F2007', 0, 1, '2007-10-09'),
(18, 'Zombies - Edition One\r\n\r\nThe game starts out with one zombie, marked as dead and known to everyone, and everyone else is a human. The running time of the game is from Monday, October 15 - Monday, October 22. The goal is to be the last remaining human standing, with the most Zombie kills.\r\n\r\nZombies: The Zombies are marked as dead on the site and wear bandanas (or otherwise brightly colored cloths around their right arms). Zombies can only use melee weapons as weapons in the game. A zombie can only be killed by a shot to the body or the head. Anything disputed (ex. on the shoulder, whether its on the arm or the body) counts as a kill. Their legs and arms are immune, UNLESS they use an arm to block their body or head from being shot. Any interference of a bullet or sword that likely would have otherwise killed the zombie by a head or body shot makes the zombie die. A Zombie when killed only stays incapacitated for 2 hours, then he reincarnates. When a zombie is incapacitated, they must remove the bandana from their arm, and they are not a zombie again until they put it back on. When a zombie kills a player, that player becomes a zombie (as soon as they mark themselves as dead on the site and start wearing a bright cloth). A Zombie is not a zombie unless they are wearing the piece of cloth, and any kills they achieve without the cloth and being marked as dead do not count.\r\n\r\nHumans: The humans are trying to survive and not become Zombies. Humans can be killed and turned into zombies from attacks by melee weapons or touch of a zombie (with a bandana) anywhere on their body. They must work together/run away/betray each other (but not directly attack), use other strategies to survive, and yet to get as many zombie kills as possible. In other words, you must excersize prudence, but also take risks in order to win. The winner is the surviving human with the most zombie kills. \r\n\r\nMore rules:\r\n-Humans aren''t allowed to kill humans and zombies aren''t allowed to kill zombies. Friendly fire is off.\r\n-Legal weapons for humans: Nerf Guns, Lightsabers, Rubberband guns. Consult Stefan for exceptions.\r\n-Legal Zombie weapons: Lightsabers, Hands, Katanas, plastic pirate swords, Breadsticks, (at the request of Tarzan). \r\n-If you want to have a time of truce with a zombie, then have them take off their bandana and give it to you for the duration of the truce. Zombies are not allowed to use alternate bandanas unless it is lost, or actively being kept from them. The idea is that to have a good truce, the zombie cannot then turn and take out another bandana and then kill. This is so that if they agree to give it up, they can''t use another one, UNLESS the term of the truce is expired and the other player has stolen it, or the bandana is somehow lost.\r\n-Same rules for inside and outside kills for normal assassins games apply unless otherwise stated.\r\n\r\nEDIT #1: You may not put clothes over the armband. It MUST be visible. This should be common sense, folks. Also if you''re going to put it on again, you can''t do it outside, and if you''re alive, you need to wear it unless you plan not on attacking anyone during the time that you''re outside. Meaning; you can''t psyche someone out by putting the armband on after they''ve already seen you a second ago without it.\r\n\r\nEDIT #2: As not everyone in this game knows each other, you MUST put up a clear picture of yourself in which you take up a significant part, and you must put up your first and last name.\r\n\r\nHappy Hunting!\r\n\r\nIf you can, get a nerf gun! And be vigilant!', '2007-10-15', 17, 'Zombies - Edition one by Stefan', 1, 1, '2007-10-19'),
(19, 'Time to start up assassins again.  Grab your nerf guns lightsabers and let''s rock!\r\nRemember, only attack outside and you are safe if you are in a class that is outdoors.', '2008-09-29', 1, 'It has been too long', 0, 1, '2008-09-29'),
(20, 'Here goes another game of assassins. If 15 or more people join, we will have 2 assassins.\r\n\r\nSince I have been informed that there will be several players involved in the Cardboard Boat Regatta, I grant immunity to those who are participating.\r\n\r\nRule reminders:\r\nYou can kill anyone in game, but it may be best not to. Remember, if you kill someone who isn''t the assassin, then you have assisted them.\r\nYou can only attack people outdoors. If you are in an outdoors class, you are safe.\r\nNerf bullets count as kills no matter where they hit. Light sabers (and foam swords) use dueling rules. That is, limbs can be lost so hits to the neck, head, and torso kill. If you loose the arm you were using, you have to switch arms, loose a leg, you''ll have to hop around, loose both legs then you are in trouble. Once a battle is over, you get your limbs back (unless you died).\r\nWhen entering/exiting buildings to provide some more safety, you are safe while holding the door handle/knob.  However you must let go of the door and become a possible target before you are allowed to attack.\r\n\r\nGAME UPDATES: 10/06\r\nIf the game hasn''t ended by thursday, you are safe waiting in line for airband or if you are in airband.\r\nIf the game hasn''t ended by friday, it will be put on a 24 hour hold for a 1 day zombies game.', '2008-10-03', 1, 'Dual Assassins', 0, 1, '2008-10-12'),
(22, 'Get ready for a zombies game of assassins. This is only be a 24 hour game on friday.  We will start out with 1 zombie (2 if we have over 18 people signup).  The goal of a zombies game is to survive (if you are human) and to infest all human scum (if you are a zombie).  If you are a zombie, you <i>must</i> wear a bandana (red or some bright color) on your right arm.  This bandana <i>must</i> be visible.\r\nLegal zombie weapons: standard melee weapons (EG: breadsticks, toy lightsabers) and your hands.\r\nLegal human weapons: standard melee weapons (EG: breadsticks, toy lightsabers) and standard ranged weapons (EG: blowguns (only with nerf bullets), nerf guns, rubberband guns).\r\nRules for zombies: You want to infest all humans so you may not kill other zombies.  To do so, kill them and they will instantly become one of them. Because you are a zombie, you can use your hands to touch a human anywhere (minus head/neck) to infect them. If you are using a melee weapon, you must hit the body.  If a human is attacking you, only blows to the body kills you.  Melee weapons and projectiles that hit a limb render that limb useless.  If a human does manage to kill you, you remain dead for until the next hour before you return to being undead.  So, say you are killed at 11:45, you only have to wait 15 minutes until 12:00 then you can start killing again. However if you died at 8:05 you would have to wait 55 minutes until 9:00 before you can start killing again.  While you are dead, please remove the bandana from your arm.\r\nRules for humans:  There are hoards of filthy zombies about, you must survive this infestation. To help humans survive, you may not kill other humans. One touch anywhere on your person from a zombie''s hands will instantly turn you into a zombie. Be careful attacking zombies as you can only kill them by a blow to the body. Work together and you should be able to get far. However, if you are killed, please mark yourself as dead to let everyone know you are now a zombie.\r\nMelee rules: When fighting with melee weapons, you can''t just sacrifice a limb to save yourself. If the swing would have hit your body if it weren''t for that block then you are dead. Once a battle is over, you regain any lost limbs.\r\nSafe areas: You are safe while indoors and in vehicles.  You are also safe if you are touching a door to a building/vehicle you have access to.  The skywalk between Berg and the DC is <i>not</i> a safe area. You may kill others in this skywalk.\r\nScoring: While you are a human, please update your name (within the edit profile page) after each kill you make. Do this by writing the following after your name " kills: #" where # is the number of kills you have made. If you are a zombie, please do the same but add " infested: #".  If you want, you can keep your kills in your name if you become a zombie. Example, I killed 5 zombies before becoming one, then I killed 1 human my name would be "Luke Schutt - kills: 5, infested 1".\r\nWhen the game is over, the human with the most kills (you must have at least one kill) wins. If there are no qualifying humans, the zombie who infested the most humans wins.\r\nAlso, please ignore the player "--NOT A PLAYER--" as it had to be added so the site doesn''t automatically mark the game as ended since it does not currently support zombie games.\r\n\r\nThe initial 3 zombies (Ben Byler, Jesse Denardo, and Jonathan Wideman) have a 1/2 hour regeneration time until noon.\r\nEveryone who can, please come to the field between Reade and Nussbaum for (hopefully) a final epic showdown at 11:00 PM. Zombies line up on the Reade side of the field and humans on the Nussbaum side. Good luck to all and happy hunting!', '2008-10-10', 96, 'Zombie swarm', 1, 1, '2008-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `a_ingame`
--

DROP TABLE IF EXISTS `a_ingame`;
CREATE TABLE IF NOT EXISTS `a_ingame` (
  `user_id` int(6) NOT NULL,
  `died` datetime default NULL,
  `assassin` tinyint(1) NOT NULL default '0',
  `game` int(6) NOT NULL,
  PRIMARY KEY  (`user_id`,`game`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a_ingame`
--

INSERT INTO `a_ingame` (`user_id`, `died`, `assassin`, `game`) VALUES
(17, NULL, 0, 11),
(16, '2006-12-09 23:30:00', 0, 10),
(27, '2006-12-06 17:15:00', 0, 10),
(20, '2006-12-04 13:54:00', 0, 10),
(26, '2006-12-06 23:10:00', 0, 10),
(17, '2006-12-04 22:00:00', 0, 10),
(3, NULL, 0, 10),
(19, '2006-12-04 17:40:00', 0, 10),
(25, '2006-12-06 17:20:00', 0, 10),
(12, '2006-12-04 23:30:00', 0, 10),
(13, '2006-12-06 20:40:00', 0, 10),
(14, '2006-12-06 15:50:00', 0, 10),
(1, '2006-12-06 17:10:00', 0, 10),
(12, '2007-02-27 18:25:00', 1, 11),
(13, NULL, 0, 11),
(3, NULL, 0, 11),
(1, NULL, 0, 11),
(24, NULL, 0, 11),
(32, NULL, 0, 11),
(30, NULL, 0, 11),
(34, NULL, 0, 11),
(36, NULL, 0, 11),
(12, NULL, 0, 12),
(17, NULL, 0, 12),
(13, NULL, 0, 12),
(34, NULL, 0, 12),
(3, NULL, 0, 12),
(32, '2007-03-05 07:00:00', 0, 12),
(24, '2007-03-06 15:50:00', 1, 12),
(36, '2007-03-05 18:08:00', 0, 12),
(37, NULL, 0, 12),
(1, NULL, 0, 12),
(25, '2007-03-06 08:55:00', 0, 12),
(27, NULL, 0, 12),
(30, NULL, 0, 12),
(38, NULL, 0, 12),
(3, NULL, 0, 14),
(12, NULL, 0, 14),
(14, '2007-10-01 15:18:00', 0, 14),
(13, NULL, 0, 14),
(1, NULL, 0, 14),
(17, NULL, 0, 14),
(26, '2007-10-01 22:20:00', 1, 14),
(41, NULL, 0, 14),
(42, '2007-10-01 21:30:00', 0, 14),
(43, NULL, 0, 14),
(14, '2007-10-09 09:50:00', 0, 15),
(13, NULL, 0, 15),
(12, '2007-10-09 11:59:00', 1, 15),
(3, '2007-10-08 15:02:00', 0, 15),
(1, '2007-10-09 09:50:00', 0, 15),
(26, NULL, 0, 15),
(17, '2007-10-09 18:00:00', 0, 15),
(41, '2007-10-09 11:55:00', 0, 15),
(44, NULL, 0, 15),
(42, NULL, 0, 15),
(45, '2007-10-08 09:00:00', 0, 15),
(46, NULL, 0, 15),
(47, NULL, 0, 15),
(48, '2007-10-09 18:11:00', 1, 15),
(49, NULL, 0, 15),
(50, NULL, 0, 15),
(43, NULL, 0, 15),
(17, '2007-10-19 15:21:00', 0, 18),
(3, '2007-10-15 08:00:00', 0, 18),
(47, '2007-10-15 10:55:00', 0, 18),
(1, '2007-10-16 11:30:00', 0, 18),
(41, '2007-10-15 11:55:00', 0, 18),
(12, '2007-10-16 14:55:00', 0, 18),
(52, '2007-10-16 16:05:00', 0, 18),
(50, '2007-10-15 11:47:00', 0, 18),
(51, '2007-10-17 11:03:00', 0, 18),
(53, '2007-10-16 13:31:00', 0, 18),
(25, '2007-10-15 17:36:00', 0, 18),
(13, '2007-10-15 15:55:00', 0, 18),
(46, '2007-10-15 11:55:00', 0, 18),
(1, NULL, 0, 19),
(55, '2007-10-15 16:31:00', 0, 18),
(43, '2007-10-15 17:15:00', 0, 18),
(20, '2007-10-18 01:52:00', 0, 18),
(32, '2007-10-17 10:57:00', 0, 18),
(44, '2007-10-15 13:57:00', 0, 18),
(26, '2007-10-15 09:56:00', 0, 18),
(56, '2007-10-15 23:20:00', 0, 18),
(57, '2007-10-16 23:18:00', 0, 18),
(58, '2007-10-15 13:58:00', 0, 18),
(42, '2007-10-16 13:25:00', 0, 18),
(59, '2007-10-16 13:11:00', 0, 18),
(60, '2007-10-15 13:00:00', 0, 18),
(61, '2007-10-19 15:00:00', 0, 18),
(64, NULL, 0, 19),
(47, NULL, 0, 19),
(56, NULL, 0, 19),
(3, NULL, 0, 19),
(66, NULL, 0, 19),
(43, NULL, 0, 19),
(65, NULL, 0, 19),
(14, NULL, 0, 19),
(12, NULL, 0, 19),
(67, '2008-09-29 19:05:00', 1, 19),
(68, NULL, 0, 19),
(61, NULL, 0, 19),
(70, NULL, 0, 19),
(51, NULL, 0, 19),
(71, '2008-09-30 12:00:00', 0, 19),
(69, NULL, 0, 19),
(72, NULL, 0, 19),
(1, '2008-10-12 18:10:00', 1, 20),
(56, '2008-10-05 22:22:00', 0, 20),
(68, '2008-10-06 09:58:00', 0, 20),
(65, '2008-10-07 20:07:00', 0, 20),
(43, '2008-10-09 11:05:00', 0, 20),
(71, '2008-10-07 17:10:00', 0, 20),
(70, NULL, 0, 20),
(64, '2008-10-06 22:15:00', 0, 20),
(3, '2008-10-06 20:00:00', 1, 20),
(47, '2008-10-09 23:09:00', 0, 20),
(61, '2008-10-03 21:53:00', 0, 20),
(66, '2008-10-06 18:22:00', 0, 20),
(69, '2008-10-07 16:00:00', 0, 20),
(73, '2008-10-04 11:00:00', 0, 20),
(74, NULL, 0, 20),
(75, '2008-10-08 23:06:00', 0, 20),
(60, '2008-10-07 19:57:00', 0, 20),
(76, '2008-10-03 21:30:00', 0, 20),
(77, '2008-10-05 23:20:00', 0, 20),
(78, '2008-10-07 16:00:00', 0, 20),
(1, '2008-10-10 17:45:00', 0, 22),
(80, '2008-10-06 09:56:00', 0, 20),
(67, '2008-10-08 13:54:00', 0, 20),
(72, NULL, 0, 20),
(79, '2008-10-08 23:15:00', 0, 20),
(66, '2008-10-10 17:50:00', 0, 22),
(56, '2008-10-10 12:56:00', 0, 22),
(67, '2008-10-10 00:00:00', 0, 22),
(68, '2008-10-10 09:55:00', 0, 22),
(26, '2008-10-10 10:00:00', 0, 22),
(3, '2008-10-10 11:55:00', 0, 22),
(47, '2008-10-10 02:55:00', 0, 22),
(64, NULL, 0, 22),
(75, NULL, 0, 22),
(71, '2008-10-10 12:00:00', 0, 22),
(20, '2008-10-10 23:05:00', 0, 22),
(43, '2008-10-10 00:00:00', 0, 22),
(81, '2008-10-10 13:50:00', 0, 22),
(80, '2008-10-10 17:10:00', 0, 22),
(14, '2008-10-10 11:55:00', 0, 22),
(72, NULL, 0, 22),
(83, '2008-10-10 16:01:00', 0, 22),
(69, '2008-10-10 10:50:00', 0, 22),
(85, '2008-10-10 09:00:00', 0, 22),
(79, '2008-10-10 17:10:00', 0, 22),
(86, '2008-10-10 05:02:00', 0, 22),
(87, '2008-10-10 12:51:00', 0, 22),
(46, NULL, 0, 22),
(88, '2008-10-10 17:20:00', 0, 22),
(60, NULL, 0, 22),
(77, '2008-10-10 17:20:00', 0, 22);

-- --------------------------------------------------------

--
-- Table structure for table `a_users`
--

DROP TABLE IF EXISTS `a_users`;
CREATE TABLE IF NOT EXISTS `a_users` (
  `id` int(6) NOT NULL auto_increment,
  `limbo` int(11) NOT NULL default '1',
  `name` char(48) NOT NULL,
  `password` char(32) NOT NULL,
  `ban` tinyint(1) NOT NULL default '0',
  `email` char(48) NOT NULL,
  `joined` datetime NOT NULL,
  `ava` longblob NOT NULL,
  `mime` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `a_users`
--

INSERT INTO `a_users` (`id`, `limbo`, `name`, `password`, `ban`, `email`, `joined`, `ava`, `mime`) VALUES
(1, 0, 'Luke Schutt', 'b76dd99e52f6551b4258d8f4de76d9db', 0, 'assassin@legoboy.com', '2006-10-10 00:00:00', '', ''),
(3, 0, 'Thomas Nicol', 'c51aa5660b1d126520448048f5c8cb2f', 0, 'quantumcat42@gmail.com', '2006-10-10 00:00:00', '', ''),
(10, 0, 'Adam Guntle', '91cc201af30bb61c38bc6f999df50ce9', 0, 'kb9oxl@juno.com', '2006-10-10 00:00:00', '', ''),
(11, 0, 'Becky', '248f6a3bb2698d79ac50b0b265b82c1f', 0, 'lil.agre@gmail.com', '0000-00-00 00:00:00', '', ''),
(12, 0, 'Andy "Tarzan" Trozan', 'bec57fae4d3d967bce51549b71556108', 0, 'atrozan@gmail.com', '0000-00-00 00:00:00', '', ''),
(13, 0, 'Ariel "Bethany" Stouter', 'a4082302124bc724a9baf01f1d1d3c4d', 0, 'everstouter@hotmail.com', '0000-00-00 00:00:00', '', ''),
(14, 0, 'Stephen "Friendly Petrov" Hensel', '1ea8e64d15b5d106d0170c4e2db0ddcb', 0, 'stephen_hensel@taylor.edu', '0000-00-00 00:00:00', '', ''),
(16, 0, 'Bri', '8965f282bf7d01512f572dec7fe78151', 0, 'brinic007@gmail.com', '0000-00-00 00:00:00', '', ''),
(17, 0, 'Stefan "Heretic" Wessman', '553b33b672cc8e3239acd32e2e8b9a0d', 0, 'matthiax@hotmail.com', '0000-00-00 00:00:00', '', ''),
(19, 0, 'Joshua Nathan', '1446c52f85292eabcd0cc536818b47a0', 0, 'zakk.carusqa@gmail.com', '0000-00-00 00:00:00', '', ''),
(20, 0, 'Elijah "The Godfather" Dixon', 'dfc25a4c24c6d114b54705c59a4b4dbd', 0, 'panthershadow@hotmail.com', '0000-00-00 00:00:00', '', ''),
(21, 0, 'Seth Bird', '09fb58826b5b94665f5f0e0ed731725e', 0, 'seth@math.com', '0000-00-00 00:00:00', '', ''),
(22, 0, 'Edwin Harcourt', '6b7fb903000780f1b110b7a00ee30bd1', 0, 'edwin_harcourt@taylor.edu', '0000-00-00 00:00:00', '', ''),
(23, 0, 'Philip VanderMeer', '531c47976206bd981dd3301003289c4e', 0, 'drkripper@gmail.com', '0000-00-00 00:00:00', '', ''),
(24, 0, 'Blake Sampson', '1844c56d171d1eac0c11a1b89957771c', 0, 'blake.sampson@gmail.com', '0000-00-00 00:00:00', '', ''),
(25, 0, 'The Gunslinger(Ben Mattice)', 'f5cf91714c25db81bbac74a5f38bf184', 0, 'worldtraveler217@aol.com', '0000-00-00 00:00:00', '', ''),
(26, 0, 'Matt "Sexy" Johnson', '0496b7668be0efd3afad6446617cb874', 0, 'matt_johnson3@tayloru.edu', '0000-00-00 00:00:00', '', ''),
(27, 0, 'No Shoes', '5be44bec514ece90d9d184abd09928c9', 0, 'rogue_9@imperialholonet.net', '0000-00-00 00:00:00', '', ''),
(28, 0, 'BK', '892bfe542da69469b650c99fcb4d57d7', 0, 'brian.kasen@gmail.com', '0000-00-00 00:00:00', '', ''),
(29, 0, 'Ruth Howard', '8aaec3e077378568d5014c1cf6c01290', 0, 'live4eternity01@msn.com', '0000-00-00 00:00:00', '', ''),
(30, 0, 'Janelle Jenkins', 'f581107abc4f1db84eeabc05b55cfe43', 0, 'tiggerknits@yahoo.com', '0000-00-00 00:00:00', '', ''),
(31, 0, 'ruppy', '58dad18b9021a291bd74e1203863530a', 0, 'smittysmacktard@yahoo.com', '0000-00-00 00:00:00', '', ''),
(32, 0, 'Reece "Pieces" Heinlein', '08650eda942ffac4ac8ca09f129ef1e0', 0, 'reeceheinlein@gmail.com', '0000-00-00 00:00:00', '', ''),
(33, 0, 'Flutterby', '828d703098a26dc0d9e49305495f02ea', 0, 'kalijo12@hotmail.com', '0000-00-00 00:00:00', '', ''),
(34, 0, 'Angela Mathis', '43ce1416f816b56c0d754113f0e0f755', 0, 'egyptianbabe2005@yahoo.com', '0000-00-00 00:00:00', '', ''),
(35, 0, 'Anna Gentile', 'c5eba85b7e58cae38a93e246f1912dfb', 0, 'mermaid1273@yahoo.com', '0000-00-00 00:00:00', '', ''),
(36, 0, 'Luke Ingram', '098d47ea2fcfd6b789b2c01e2256614b', 0, 'luke_ingram@taylor.edu', '0000-00-00 00:00:00', '', ''),
(37, 0, 'Marika', '12fd59265d5be72f6a4a7b9155f8f6bc', 0, 'trillity@gmail.com', '0000-00-00 00:00:00', '', ''),
(38, 0, 'Jo Anna Kolbe', 'adafff23fe27d62fa9d5220cc0b3a8ea', 0, 'joanna_kolbe@tayloru.edu', '0000-00-00 00:00:00', '', ''),
(39, 0, 'Nadeah Bikawi', 'f9acaf0295817246dcb77996117baba3', 0, 'nadeahb@yahoo.com', '0000-00-00 00:00:00', '', ''),
(40, 0, 'Devin Schreck', '1ce106a91cb457bafebc3920a99e1981', 0, 'neojesusfreak247@yahoo.com', '0000-00-00 00:00:00', '', ''),
(41, 0, 'Brent Fannin', '63461bd48a5cb1da9f8cc3a0ec9b87b6', 0, 'howyoudoin101@hotmail.com', '0000-00-00 00:00:00', '', ''),
(42, 0, 'Ryan Duncan', '9e8c01ce27e7646d2a5f24c18ffac8a7', 0, 'ryan_duncan@taylor.edu', '0000-00-00 00:00:00', '', ''),
(43, 0, 'Jonathan Wideman - "Maimed"', '685b244723c922c31d57693b6e7433e6', 0, 'huhwhozat@gmail.com', '0000-00-00 00:00:00', '', ''),
(44, 0, 'Brian "Monty" Fannin', '29da12a6033426d01a1669de0c156e6d', 0, 'palmtreeman06@hotmail.com', '0000-00-00 00:00:00', '', ''),
(45, 0, 'John', '796e69f952cf3e20a8159085543f1160', 0, 'john_moore@taylor.edu', '0000-00-00 00:00:00', '', ''),
(46, 0, 'James "SciFi" Burnside II', '0c6d6fb381392e3002774535c65b9105', 0, 'scifitu@gmail.com', '0000-00-00 00:00:00', '', ''),
(47, 0, 'Zach Palmer a.k.a. Gizmo', '092a20bfc6832da1c2832266eaf89d79', 0, 'zdpalmer@ameritech.net', '0000-00-00 00:00:00', '', ''),
(48, 0, 'John Fowler III', '4db6ae1ce143fe28f357871166d4597e', 0, 'john_fowler@taylor.edu', '0000-00-00 00:00:00', '', ''),
(49, 0, 'Emily Moore the 3rd', '2fe5814b926955b38f0c0bd4f9aa3cbf', 0, 'something.emily@gmail.com', '0000-00-00 00:00:00', '', ''),
(50, 0, 'Josh Smith', '5cecf6983cfa86b701eb4af7cb34fc75', 0, 'genericensign5@gmail.com', '0000-00-00 00:00:00', '', ''),
(51, 0, 'Brandon Knight', 'c89f9f4ef264e22001f9a9c3d72992ef', 0, 'zeldaman_4@hotmail.com', '0000-00-00 00:00:00', '', ''),
(52, 0, 'Jason "AKBAR" Griffin', '4253bb7da4e95f6427b0533fd5cac198', 0, 'jason_griffin@taylor.edu', '0000-00-00 00:00:00', '', ''),
(53, 0, 'Levi Warner', 'afb94ef09221efb2b79bf5a71c388a5b', 0, 'justajar988@hotmail.com', '0000-00-00 00:00:00', '', ''),
(54, 0, 'Aric Warner', 'fe417584d64537baa7cd5e48222ccdf8', 0, 'aricwarner@mac.com', '0000-00-00 00:00:00', '', ''),
(55, 0, 'Nick Estelle', '17d41261662d2df8956b0477039784c0', 0, 'dagufbal@gmail.com', '0000-00-00 00:00:00', '', ''),
(56, 0, 'Taylor Richards', '8cac6767f127f21c0435d9d9b7fe286c', 0, 'rancidska1664@gmail.com', '0000-00-00 00:00:00', '', ''),
(57, 0, 'Stephen "Tank" Rupsis', '1a33de6e43b0eac5f18400b9d9bd847b', 0, 'rupsisfam@yahoo.com', '0000-00-00 00:00:00', '', ''),
(58, 0, 'David Pomeroy', 'a170e23998d9b6a7346032070b0da33c', 0, 'msworkslol@gmail.com', '0000-00-00 00:00:00', '', ''),
(59, 0, 'Monica Swain', '555a1fe80d575f324b35f8c9ef7146f1', 0, 'monica_nell@yahoo.com', '0000-00-00 00:00:00', '', ''),
(60, 0, 'David Â· Thor Â· Hughes', '1102438e142e17a78b8dc1d7d1919188', 0, 'sdrawkcab321@gmail.com', '0000-00-00 00:00:00', '', ''),
(61, 0, 'Matthew Russell', 'c4cb01ea1063a0a4a5d6530d8556182d', 0, 'matthewcrussell@gmail.com', '0000-00-00 00:00:00', '', ''),
(62, 0, 'Satanus', 'a4f53a5b7221f89199c90bbbb7fc39a9', 1, 'suckmesideways666@gmail.com', '0000-00-00 00:00:00', '', ''),
(63, 0, 'Joe', '5f4dcc3b5aa765d61d8327deb882cf99', 0, 'anglinfrog62@aol.com', '0000-00-00 00:00:00', '', ''),
(64, 0, 'Jonathan "Ninja" Schrock', 'e82e99b7872385001da645058a06dc81', 0, 'jdlschrock@gmail.com', '0000-00-00 00:00:00', '', ''),
(65, 0, 'Humans Considered Harmful', '61e2055bac6e635e55e04da450b10b2f', 0, 'denaje@gmail.com', '0000-00-00 00:00:00', '', ''),
(66, 0, 'Drew "Mountain Drew" Korth', '812c070ce3132a868941715e940d4c15', 0, 'andrew.korth@gmail.com', '0000-00-00 00:00:00', '', ''),
(67, 0, 'Ben Byler - Mongoose - infested: 5.5', 'd5b98e82f86f3a7ac3e17a3d4046dd56', 0, 'bkbyler@gmail.com', '0000-00-00 00:00:00', '', ''),
(68, 0, 'Luke "The Hulk" Dornon', '09300df44b9d20cc219b25abddc3346e', 0, 'drodrigolotn@gmail.com', '0000-00-00 00:00:00', '', ''),
(69, 0, 'Sean Knutson', 'b685debc55eb7acd62a1caaa582eaa4f', 0, 'sean_knutson@taylor.edu', '0000-00-00 00:00:00', '', ''),
(70, 0, 'Jeffrey "The Count" Delgado', '5aa73c99841af089590e1e1d981d0a63', 0, 'jeff_delgado@taylor.edu', '0000-00-00 00:00:00', '', ''),
(71, 0, 'Anthony "No Pants" Rajaonarivony', 'f2f6ca16e070070fc5465ab4209586b5', 0, 'anthony_rajaonarivon@taylor.edu', '2008-09-29 04:03:20', '', ''),
(72, 0, 'Caleb "The Caffeinated" Carroll', 'bcd1b78c0189c68a3e86c91140ce34c8', 0, 'caleb_carroll@taylor.edu', '0000-00-00 00:00:00', '', ''),
(73, 0, 'Rebekah "Tim" Briner', 'c3b90b091283cbec3585763d1ce9b094', 0, 'rebekah_briner@taylor.edu', '0000-00-00 00:00:00', '', ''),
(74, 0, 'Katie "The Killer"  Breen', 'e0ce30862a539bd408a20d2467ea5dca', 0, 'katie_breen@taylor.edu', '0000-00-00 00:00:00', '', ''),
(75, 0, 'Kelsey Jones, "The Shadow"', '6ac9524e663da635ca3589933100ede3', 0, 'kelsey_jones@taylor.edu', '0000-00-00 00:00:00', '', ''),
(76, 0, 'Robert "Dilbert" Long', '4c38faacd762b095b79a54be790ad789', 0, 'force.distance@gmail.com', '0000-00-00 00:00:00', '', ''),
(77, 0, 'Mark - Infested: 0', '6c6c2af1611a328e6a5d0c6e649ecc98', 0, 'mark_koh@taylor.edu', '0000-00-00 00:00:00', '', ''),
(78, 0, 'Luke "Imposing Nickname" Larson', 'cef24c99917d83b2bf4e655cba5170d0', 0, 'luke_larson@tayloru.edu', '0000-00-00 00:00:00', '', ''),
(79, 0, 'Joshua Smith', '5a94296dc58f027ccb55ae9d49724b84', 0, 'joshsmith332@gmail.com', '0000-00-00 00:00:00', '', ''),
(80, 0, 'Caleb Kossian', 'c1d0633716dcae99001fed8ad44dcd55', 0, 'caleb_kossian@taylor.edu', '0000-00-00 00:00:00', '', ''),
(81, 0, 'Will "Crazyman" Mitchell', 'bb3ef1a0ba74f63ea3eefd956fdc63d3', 0, 'will_mitchell@taylor.edu', '0000-00-00 00:00:00', '', ''),
(83, 0, 'Michael Kasinger kills:3', 'cffc491b1b87458000549dff74c54924', 0, 'michael_kasinger@taylor.edu', '0000-00-00 00:00:00', '', ''),
(84, 0, 'Ryan', '15367cad5b809a8db03288f223b0056c', 0, 'ryan_mann@taylor.edu', '0000-00-00 00:00:00', '', ''),
(85, 0, 'Jeremy Erickson', 'b0dff564faeaf4b4940910b1cdba8d06', 0, 'jeremy_erickson@taylor.edu', '0000-00-00 00:00:00', '', ''),
(86, 0, 'Steven "Stettjawa" Barnett - Kills: 2', '8f773b12ae4de4019205f57fe1e1b694', 0, 'steven_barnett@taylor.edu', '0000-00-00 00:00:00', '', ''),
(87, 0, 'Jonathan "JJSpruce" Stoffel - Kills: 1', '4b395fe22a1a77fca05849eac9bbfca5', 0, 'jonathan_stoffel@tayloru.edu', '0000-00-00 00:00:00', '', ''),
(88, 0, 'Brady "The Snork" Schaar - kills: 1', 'b3b75e282acd40db14cd31be946de141', 0, 'brady_schaar@taylor.edu', '0000-00-00 00:00:00', '', ''),
(89, 0, 'Kevin Thomson', '5920f4cd7159fb0b7190aee766f40444', 0, 'emerald.kontact@gmail.com', '0000-00-00 00:00:00', '', '');
