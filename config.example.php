<?

/* Below are the places $_CONFIG is used (gathered by grep at the time of this writing)

./database.inc:4:  $connection = mysql_connect($_CONFIG['db_serv'],$_CONFIG['db_user'],$_CONFIG['db_pass'])
./database.inc:7:  $bd = mysql_select_db($_CONFIG['db_database'], $connection)
./database.inc:15:    global $_CONFIG;
./database.inc:24:      $success = mail($_CONFIG['email'], "SQL Error", mysql_error()."\n\n".ob_get_contents(), $_CONFIG['addheaders']);
./changeemail.php:28:    $resp = recaptcha_check_answer($_CONFIG['privatekey'],
./changeemail.php:57:          "{$user->getFullName()} has requested that this email address be set as their preferred email for Taylor Assassins.\n\nIf this was you, please click on or copy-and-paste the following link to verify your email address:\nhttp://{$_CONFIG['hostname']}/changeemail.php?verify=$verify\n\nIf this was not you, then you may disregard this email. You may also reply to this email address to report the abuse.\n\n- Taylor Assassins Administrator",
./changeemail.php:58:          $_CONFIG['addheaders']
./changeemail.php:100:    <?= recaptcha_get_html($_CONFIG['publickey'], $recaptchaerror); ?>
./send.php:28:  $resp = recaptcha_check_answer($_CONFIG['privatekey'],
./send.php:45:  else if(!mail($_CONFIG['email'],
./send.php:49:      $_CONFIG['addheaders']))
./send.php:89:    <?= recaptcha_get_html($_CONFIG['publickey'], $recaptchaerror); ?>
./util.inc:14:    global $_CONFIG, $isimpersonating, $phpCAS;
./util.inc:28:        $page = "http://".$_CONFIG['hostname'].$_SERVER['REQUEST_URI'];
./util.inc:34:#        $domain = $_CONFIG['hostname'];
./util.inc:86:    global $_CONFIG, $phpCAS;
./util.inc:90:      phpCAS::client(CAS_VERSION_2_0, $_CONFIG['cas_server'], $_CONFIG['cas_port'], $_CONFIG['cas_dir']);
./util.inc:105:    global $_CONFIG;
./util.inc:111:    phpCAS::client(CAS_VERSION_2_0, $_CONFIG['cas_server'], $_CONFIG['cas_port'], $_CONFIG['cas_dir']);
./util.inc:121:    header('Location: http://my.taylor.edu/content/jsp/clearcookies.jsp?redirect='.urlencode("http://".$_CONFIG['hostname']));
./util.inc:141:    global $_CONFIG;
./util.inc:143:    return in_array($user->getUsername(), $_CONFIG['admin_usernames']);
./util.inc:147:    global $_CONFIG;
./util.inc:289:    global $_CONFIG;
./util.inc:296:      $success = mail($player->getEmail(), $subject, $message, $_CONFIG['addheaders']);
./mail.php:51:        "A new game of \"{$game->getTypeName()}\" assassins is starting on {$game->getStart()}!\n\nSign up today at http://{$_CONFIG['hostname']}/game.php?id={$game->getId()}\n\n- Your friendly neighborhood Assassins administrator",
./reqmail.php:21:  mail($_CONFIG['email'],
./reqmail.php:26:      "http://{$_CONFIG['hostname']}/mail.php?id={$game->getId()}&username={$user->getUsername()}&type=mailall&subject=".urlencode($_POST['subject']),
./reqmail.php:27:      $_CONFIG['addheaders']);
./game.inc:485:              "Your previous assassins target, $me, has been neutralized! Your new target is:\n\n$them\n\nYou may find their profile picture here: http://".$_CONFIG['hostname']."/who.php?username=$target"

*/

global $_CONFIG;
$_CONFIG = array();
$_CONFIG['db_serv'] = ;
$_CONFIG['db_user'] = ;
$_CONFIG['db_pass'] = ;
$_CONFIG['db_database'] = ;
$_CONFIG['email'] = ;
$_CONFIG['addheaders'] = ;
$_CONFIG['publickey'] = ;
$_CONFIG['privatekey'] = ;
$_CONFIG['hostname'] = ;
$_CONFIG['cas_server'] = ;
$_CONFIG['cas_port'] = ;
$_CONFIG['cas_dir'] = ;
$_CONFIG['admin_usernames'] = ;

