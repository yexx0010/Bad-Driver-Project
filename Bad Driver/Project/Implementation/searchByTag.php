<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search by Tag</title>


<link href="styles.css" rel="stylesheet">
</head>

<body>
<table width="100%" border="0" cellpadding="5">
 <tr>
   <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
   <td width="69%" class="page_title">Search by Tag</td>
 </tr>
</table>

<?php
	session_start();
    require_once( "connection.php" ); // opens connection.php

    $idiots = new Connection( 'settings.ini' ); //creates new instance of connection class
    $sql = 'SELECT * FROM tag'; // sql statement
    $conn = $idiots->getConnection(); //get the connection and assign it to conn
    $stmt = $conn->prepare( $sql ); //prepare the sql statement
    $stmt->execute(); //execute the sql statement 
    $stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
    $data = $stmt->fetchAll(); //get the result set

	print( "<hr>" );
	include "header.php";
?>
	<hr />
	
	<br><center><table width="90%" border="0" cellpadding="0"><tr><td width="100%">
	<p>
		Select the tag you would like to search for:
	</p>
    <form name="tagName" action="/~g4/story.php" method="post">
    	<select name="tags">
			<?php
				foreach( $data as $t ) {
        			print("<option value=\"{$t['tag_id']}\">{$t['tag_name']}</option>".PHP_EOL);
    			}
			?>    		
    	</select>

    <br/><br/><input class="button" name="byTag" type="submit" value="Search"/>
    </form>
	</td></tr></table></center>

</body>
</html>