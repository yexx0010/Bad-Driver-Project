<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!---------------- replace "PAGE TITLE" below ------------------->
<title>PAGE TITLE</title>

<style type="text/css">
.page_title {
	text-align: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 48px;
	font-variant: normal;
}
.page_logout {
	font-size: 12px;
	text-align: left;
	font-family: Arial, Helvetica, sans-serif;
}
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
	<!---------------- replace "Title of Page" below ------------------->
    <td width="69%" class="page_title">Title of Page</td>
  </tr>
</table>

	<?php
		session_start();
		
		print( "<hr>" );
		if ($_SESSION['inProgress']==2) {
			print( "<p>{$_SESSION['email']}: <a href=\"/~g4/logout.php\" class=\"page_logout\">Logout</a><span class=\"page_logout\"></span></p><hr>".PHP_EOL );
		}
		
		print( "<br><center><table width=\"90%\" border=\"0\" cellpadding=\"0\"><tr><td width=\"100%\">".PHP_EOL );
			
		// -------------------------- PHP GOES HERE --------------------------------
		
		print( "</td></tr></table></center>".PHP_EOL );
    ?>

</body>
</html>
