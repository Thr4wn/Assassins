<?
	$connection = mysql_connect("localhost", "assassins", "pfargtlASSASSINS")
		or die("<b>Could not connect to database.</b>");
	
	$bd = mysql_select_db("assassins", $connection)
		or die("<b>Could not select database.</b>");
?>
