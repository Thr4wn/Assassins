<?php


/*
   Comments by Seth Bird:

    I wanted to put the rules into a hierarchy.

    The "title" class is meant for all headers which should be clickable to show/hide it's content.
    The "rule_content" class is meant to wrap around the very content which will be shown/hidden by clicking the title 
    The "subrule" class is simply for formatting purposes.

*/

$title = "rules";
$headers = "<style type='text/css'>
h3
{
    margin:0;
    padding:0;
}
.subrule
{
    margin-left: 1.3em;
    font-weight: bold;
}
p {
    margin-left: 2em;
    margin-right: 2em;
}

span.b {
  font-weight: bold;
}
span.u {
  text-decoration: underline;
}
</style>
";
include("top.php");

?>


<h2>Rules for Taylor Assassins</h2>

<h3 class="title" id="rule_1"> [+] Rule #1</h3><span class="rule_content">
<p>Be awesome. Above and beyond all else, our goal is to increase the awesomeness of Taylor University!</p>

<p>THIS MEANS THAT YOU CANNOT WHINE! Everyone knows that mistakes will be made, so expect those moments to come every once in a while. If there are genuine questions/concerns (and those do come up) then ____ </p>

</span>
<h3 class="title" id="safe_zones"> [+] Safe Zones (kills do not count)</h3><span class="rule_content">

<span class="subrule title"> [+] Permanent Safe Zones</span><br/><span class="rule_content">
<ul>
  <li>Inside permanently-enclosed buildings (roofed and walled) or cars.</li>
  <li>When touching a door or door handle to a building or car you have legal and immediate access to. (If the door is locked, you must provide keys upon request, or else you are considered outside.)</li>
  <li>When <i>at</i> church (always give a little more leniency to this one if church is being held outside)</li>
  <li>Taylor Events (see below)</li>
  <li>Truces: If certain people agree on a place/circumstance being a "Safe Zone", kills do not count <i>for those who agreed to it for the time agreed to</i>.</li>
  <li>Note: Despite being an enclosed structure, the Bergwall-DC Skywalk is <span class="b u">NOT</span> considered a safe zone (see below).</li>
</ul>

<p>In order to attack another player, a player must <span class="b u">NOT</span> be in a safe zone! Thus, you may not hold the door and swing your lightsaber or shoot your gun. Neither can you participate in a "drive-by" shooting.</p>

</span>
<span class="subrule title" id="events"> [+] Taylor Events</span><br/><span class="rule_content">
<p>
Taylor Events are always safe zones. By "Taylor Event", we mean any place wherein you are <i>currently a part of</i> a Taylor sanctioned organized event (sport practices/events, wing retreats etc.). Arriving to or leaving from the event is not a part of the event.
</p>
<p>
<span class="b">Wherever the organizer specifically states the event is supposed to happen is where the event happens.</span> That may sound obvious, but the implications may not be so obvious. For example, if a floor dinner is declared by the PA to meet at Swallow lounge and to walk to DC for floor dinner from there, then the actual walking to the DC is considered a part of the event because the PA (organizer of event) said so. If the PA just said "floor dinner on Thursday" and fails to ever state specifically to meet somewhere, then the walking is no longer a part of the event. If you ask the PA "does walking to the DC count as a part of the event", and they say "yes", then the walk suddently becomes officially a part of the event. I am assuming that no one intentially bends this rule.
</p>

</span>
<span class="subrule title" id="skywalk_rule"> [+] SkyWalk Rule</span><br/><span class="rule_content">
<p>The Bergwall-DC SkyWalk is considered outside because we have simply found it to be too biased for Bergwallians. As in the <a href="#safe_zones">Safe Zone</a> rule, touching the handle to a door on either side is considered "inside".</p>

</span>
</span>

<h3 class="title" id="weapons"> [+] Weapons</h3><span class="rule_content">

<span class="subrule title" id="allowed_weapons"> [+] Allowed Weapons</span><br/><span class="rule_content">

<p>
Allowed melee weapons: Anything that is safe and obviously weapon-like when used. We really trust common sense here. Specifically allowed are:
</p>

<ul>
  <li>Lightsabers</li>
  <li>Self-made, but safe, melee weapons</li>
  <li>Breadsticks</li>
  <li>Stabbing someone with a nerf dart (the dart is treated like a poisoned knife)</li>
  <li>NOTE: random sticks are not considered safe</li>
  <li>NOTE: Bare hands by themselves are <span class="b u">NOT</span> a weapon (unless you're a zombie).</li>
</ul>

<p>
Allowed range weapons: Anything that is safe, obviously weapon-like when used, and has a clearly defined projectile. Specifically allowed are:
</p>

<ul>
  <li>Any Nerf or Nerf-like product (No matter how much they are modded, they still count.)</li>
  <li>Rubber band guns</li>
  <li>Marshmallow guns</li>
  <li>PVC Blow Guns</li>
  <li>Snowballs</li>
  <li>Manually throwing a Nerf dart</li>
  <li>NOTE: simply throwing sand at someone does not count as a weapon</li>
</ul>

<p>
If there is dispute about the legitimacy of a weapon, err on assuming it's not a weapon. Why? Because it is probably your fault for not checking in advance if you are using a weapon that's so "creative" as to cause dispute ;-) .
</p>

</span>
<span class="subrule title" id="defense"> [+] No Defense-only Objects</span><br/><span class="rule_content">
<p>You can block any weapon with any other weapon. (for blocking lightsabers, we are assuming that all weapons have <a href="http://starwars.wikia.com/wiki/Phrik">phrink</a> plating.)</p>

<p>No defense-only shields are allowed. A "shield" is an object which is intentionally used only to defend the person. Players (non-civilians) are not objects. A backpack is considered an extension of your torso (a.k.a. a hunchback) and is <span class="b u">NOT</span> a shield.</p>

<p>Note: other weapons may be used as shields, but only if they are also an offensive weapon too. This rule is supposed to prevent people from building ridiculous, cheeze defenses and armour which make the game less enjoyable.</p>

</span>
<span class="subrule title" id="limb_rule"> [+] Limb Rule</span><br/><span class="rule_content">
<p>Unless explicitly stated otherwise, attacks hitting an arm or a leg will instantly put that limb out of service. The person who lost a limb must hop on one foot if a leg is lost or put the arm behind his/her back (or anywhere out of the way) if an arm is lost. It is possible to lay there armless and legless (as opposed to <a href="http://en.wikipedia.org/wiki/Legolas">Legolas</a>).</p>

<p>If you're not in a battle (for example, if your opponent cuts off your arm and then suddenly runs off), then you can stand and use your severed limbs again. But as soon as you're "in" a battle again, you can't use your severed limbs. You are "in" a battle when another player sees you and declares, implicitly or explicitly, to be in a battle with you. (But if they aren't aware enough to notice your presence, then you never entered a battle and it's their loss.).</p>

<p>You are allowed to explicitly use a limb to block a single attack. A single attack is a single swing and/or a single projectile launched at you. For example, if someone shoots at you, you are allowed to smack the bullet with you hand and continue charging with a lightsaber. Obviously this immediately puts your limb out of service. No holding on to weapons.</p>

</span>
<span class="subrule title" id="gauntlet_rule"> [+] Gauntlet Rule</span><br/><span class="rule_content">
<p>Only melee attacks <i>above</i> the wrist count, since we are assuming everyone is wearing a gauntlet made of <a href="http://starwars.wikia.com/wiki/Phrik">phrink</a>.</p>

</span>
<span class="subrule title" id="article_rule"> [+] Articles Rule</span><br/><span class="rule_content">
<p>If there is a dispute on if you "hit them" or not, anything that you are "wearing" (including backpacks and coats) is considered a part of you and can be attacked.  If it is explicitly worn on the arm/leg, then the limb rule applies. Otherwise it counts as a part of the torso or head. If it's too ambiguous whether the article is worn on a limb or the torso/head, always assume it's a part of the torso/head.</p>

<p>Anything being carried is considered being "worn" and is therefore a part of that person, unless the item is discarded during a battle.  If an item is too ambiguous in regards to being "worn" or not, then assume they are wearing it.</p>

</span>
<span class="subrule title" id="grab_rule"> [+] Grab Rule</span><br/><span class="rule_content">
<p>You are not allowed to grab another player's melee weapons in combat. You are also not allowed to grab the other player or do anything which starts reducing the game to wrestling or physical combat.</p>

</span>
</span>
<h3 class="title" id="misc"> [+] Misc</h3><span class="rule_content">

<span class="subrule title" id="deaths"> [+] Marking Your Death</span><br/><span class="rule_content">
<p>You must mark yourself as dead within 6 hours of being killed. There is no way currently to enforce that rule at all and there won't actually be any punishment, but please, please follow the rule :).  </p> 
<p> 
Once you die, you may divulge <span class="u">ONLY</span> the following information (even if others already know, you can only say the following): The fact that you were gruesomely killed (not how or by whom), and the time of your gruesome death.
</p>

</span>
<span class="subrule title" id="who"> [+] Who Can Play</span><br/><span class="rule_content">
<ul>
  <li>Current Taylor Students</li>
  <li>Taylor Alumni who are on Taylor's campus during the game</li>
</ul>

</span>
<span class="subrule title" id="civilian_rule"> [+] Civilians (non-players)</span><br/><span class="rule_content">

<p>
Civilians cannot be shilds or be used as shields, even if the want to. This includes dancing around civilians to avoid being hit. As for any other interaction with civilians as long as it is legal behavior, it is allowed.
</p>

</span>
<span class="subrule title" id="murder_rule"> [+] Murder Rule</span><br/><span class="rule_content">
<p>Don't literally kill someone. Please. I claim no responsibility for your villainous actions. (Also, do not injure anyone. Please play responsibly.)</p>


</span>
</span>

<br/>
<br/>
<br/>
<br/>
<br/>

<h2 id="game_types">Game Types</h2>

<h3>Classic</h3>
<p>One or more players are secretly, randomly chosen to be the "assassins". They are sent an email telling them that they are an assassin. Everyone else tries to guess who the assassins are and kill them, and the assassins try to kill everyone else.</p>

<h3>Zombies</h3>
<p>A few people are publicly, randomly declared to be "Zombies" and the rest are "humans". All zombies <span class="b u">must</span> wear a clearly visible bandanna (or flag or similar piece of clearly visible cloth) on either arm, and can only use melee weapons. (Zombies may use their hands as melee weapons, if they desire.) If a zombie strikes a human <span class="b u">anywhere</span>, the human immediately becomes a zombie (but they can't infect/kill anyone until they both put on a bandanna and go "inside" somewhere first). If a zombie dies, they resurrect at the first sound of the TU bell tower at the top of the hour (it is therefore possible for a zombie to resurrect only minutes after death).</p>

<p>The humans' goal is to survive as long as possible. The zombies' goal is to infect all the humans. If a zombie does not have a bandanna on as they are leaving a building, they cannot secretly put it on later until they get inside a building again. A zombie cannot kill or be killed without a bandanna on their arm.</p>

<h3>Circle of Death</h3>
<p>Everyone is secretly emailed the name of another player (heretofore known as their "target"). Only battles between target and attacker count. (That is, it is not possible to kill someone other than your target or the player who is targeting you.) When you kill your target, they should tell you who <i>their</i> target was, which is now your new target. (When your deceased target marks themself dead on the website, your new target will also be emailed to you.)</p>


<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
function go(e){
    var classname = '.rule_content';
    var elem = $(e.target).nextAll(classname)[0];
    var $elem = $(elem);
    if(elem.style.display == 'none')
         $elem.show();
    else
    {
         $elem.hide();                       
    }
}
$('.rule_content').hide();
$('.title').click(go);
</script>

<?php include("bottom.php"); ?>
