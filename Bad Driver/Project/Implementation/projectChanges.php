<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!---------------- replace "PAGE TITLE" below ------------------->
<title>Documented Changes</title>

<link href="styles.css" rel="stylesheet">
</head>

<body>
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
	<!---------------- replace "Title of Page" below ------------------->
    <td width="69%" class="page_title">Documented Changes</td>
  </tr>
</table>

	<hr/>
	<?php
		session_start();
		include "header.php";	
	?>
	<hr/>

	<br><center><table width="90%" border="0" cellpadding="0"><tr><td width="100%">

	<h3>
		What Has Changed You Ask?
	</h3>
	<ul>
		<li>
			The "user" table from the Design Paper is now called "account" as it seems as though the word "user" was a reserved word.
		</li>
		<li>
			Consequently, user_id is now account_id.
		</li>
		<li>
			Another view was added entitled v_story_detail which holds information in regards to, you guessed it, story details.
		</li>
		<li>
			No index was necessary for posted_date in the story table.
		</li>
		<li>
			An index was however created on email_address in the account table.
		</li>
		<li>
			The only change made in terms of web structure was that you can link to the Registration page from the Stories page now. This was not included in the Design UML diagram.
		</li>
		<li>
			story_date is now a DATE, rather a DATETIME data type. 
		</li>
	</ul>
	
	<h3>References</h3>
	<p>The following is a list of handy references that you may find useful.
	<ul>
		<li><a href="/~g4/analysis.html">Our Group Analysis </a></li>
		<li><a href="/~g4/design.html">Our Group Design </a></li>
	</ul>
	
	</td></tr></table></center>


</body>
</html>
