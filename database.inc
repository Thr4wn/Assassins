<?php
  include_once("config.php");

  $connection = mysql_connect($_CONFIG['db_serv'],$_CONFIG['db_user'],$_CONFIG['db_pass'])
    or die("<b>Could not connect to database.</b>");

  $bd = mysql_select_db($_CONFIG['db_database'], $connection)
    or die("<b>Could not select database.</b>");

  function bad($result) {
    return !$result || !mysql_num_rows($result);
  }

  function sql($sql, $ignore_errors=false) {
    global $_CONFIG;

    $result = mysql_query($sql);
    if (mysql_errno() != 0 && !$ignore_errors) {
      include_once("top.php");
      ob_start();
      debug_print_backtrace();
      $text = "<div class='error'>".mysql_error()."<br><br>".ob_get_contents()."</div>";

      $success = mail($_CONFIG['email'], "SQL Error", mysql_error()."\n\n".ob_get_contents(), $_CONFIG['addheaders']);
      ob_end_clean();

      $text = preg_replace('/\r?\n/','<br>',$text);
      $text = preg_replace('/"/','\"',$text);

      if ($success) {
        $text .= "<br/><br/>This error has been reported. Sorry for the inconvenience.";
      }

      #echo "<script type='text/javascript'>\ndocument.body.innerHTML=\"$text\";\n</script>";
      echo "$text";
      exit;
    }
    return $result;
  }
?>
