<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Logout</title>

<style type="text/css">
.page_title {
	text-align: left;
	font-family: Courier New;
	font-size: 48px;
	font-variant: normal;
}
.page_text {
	font-size: 18px;
	text-align: left;
	color: white;
	font-family: Courier New;
}
table.console {
	border-width: 3px;
	border-spacing: 0px;
	border-style: solid;
	border-color: gray;
	border-collapse: collapse;
	background-color: blue;
}
table.console th {
	border-width: 0px;
	padding: 0px;
	border-style: none;
	border-color: gray;
	background-color: blue;
	-moz-border-radius: ;
}
table.console td {
	border-width: 0px;
	padding: 12px;
	border-style: none;
	border-color: gray;
	background-color: blue;
	-moz-border-radius: ;
}
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
    <td width="80%" class="page_title">Driving Car</td>
  </tr>
</table>
<hr>
<p>&nbsp;</p>

	<?php
		session_start();
		$_SESSION['inProgress'] = '0';
			
		print( "<br><center><table width=\"35%\" border=\"3\" class=\"console\" ><tr><td width=\"100%\">".PHP_EOL );
		print( "<p class=\"page_text\">  speeding up...<br />" );
		print( "  crashing car...<br />" );
		print( "  logging out...<br />" );
		print( "  C\:_</p>" );
		session_destroy();		// destroy current session, effectively logging out
		print( "<meta http-equiv=\"refresh\" content=\"3;url=/~g4/welcome.html\"/>");		// automatically redirect after 3 seconds
		print( "</td></tr></table>".PHP_EOL );
		print("<br><br><br>If you are not automatically redirected to the Idiot Drivers welcome page <a href=\"/~g4/welcome.html\">click here</a></center>".PHP_EOL);
    ?>
<br>
</body>
</html>