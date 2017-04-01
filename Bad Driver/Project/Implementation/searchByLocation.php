<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search By Location</title>


<link href="styles.css" rel="stylesheet">
</head>

<body>
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
    <td width="69%" class="page_title">Search By Location</td>
  </tr>
</table>
	<?php
		session_start();
		print( "<hr>" );
		include "header.php"
	?>
	<hr/>
<center>
	<table width="95%" border="0" cellpadding="10">
		<tr>
			<td width="100%">
	
			<p>Enter your location search criteria:</p>
				<form name="locationForm" action="story.php" method="post">
					Location: <input type="text" name="location"/>
					<br/>
					<br/>
					<input class="button" name="byLocation" type="submit" value="Search"/>
				</form>
	
			</td>
		</tr>
	</table>
</center>
<hr />
<br>
<a href="/~g4/logout.php"></a>
</body>
</html>
