<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Members Login</title>

<link href="styles.css" rel="stylesheet">
</head>

<body>
<table width="100%" border="0" cellpadding="5">
 <tr>
   <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
   <td width="80%" class="page_title">Members Login</td>
 </tr>
</table>

	<?php
		session_start();
		require_once( "connection.php" ); // opens connection.php

		$idiots = new Connection( 'settings.ini' ); //creates new instance of connection class
		$sql = "SELECT * FROM account WHERE email_address = ?"; // sql statement
		$get_email = $_POST['page_email'];
		$conn = $idiots->getConnection(); //get the connection and assign it to conn
		$stmt = $conn->prepare( $sql ); //prepare the sql statement
		$stmt->bindValue( 1, $get_email, PDO::PARAM_INT );
		$stmt->execute(); //execute the sql statement 
		$stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
		$data = $stmt->fetchAll(); //get the result set
		
		$t = $data[0];
		if ( $_SESSION['inProgress'] == '2') { 			// if a session is currently in progress
			$_SESSION['inProgress'] = '2';
		} else {			// if there is no session in progress
			if ( count($data) == 1 ) {					// if there is a record returned, aka email match
				if ( hash('sha256', $_POST['page_pass']) == $t['pass'] ) { 			// if password matches
					$_SESSION['inProgress'] = '3';
					$_SESSION['account_id'] = $t['account_id'];
					$_SESSION['rights_id'] = $t['rights_id'];
					$_SESSION['email'] = $t['email_address'];
				} else {		// if passwaords mismatch
					$_SESSION['inProgress'] = '1';
				}
			} else { 			// if no records returned
				if ( ($_POST['page_email'] == '') || ($_POST['page_pass'] == '') ) {		// if oen of the fields is empty
					$_SESSION['inProgress'] = '0';
				} else {
					$_SESSION['inProgress'] = '1';
				}
			}
		}
		
		function draw_form() {		// display login form
			print( "<form name=\"loginForm\" action=\"login.php\" method=\"post\">".PHP_EOL);
			print( "<br>Email:<br><input type=\"text\" name=\"page_email\" size=\"30\" autofocus tabindex=\"1\">".PHP_EOL);
			print( "<br>Password:<br><input type=\"password\" name=\"page_pass\" size=\"30\" tabindex=\"2\"><br>".PHP_EOL);
			print("<br/><input name=\"loginButton\" type=\"submit\" value=\"Login\" tabindex=\"3\"/>".PHP_EOL);
			print("<br><br><br>Not a member? <a href=\"/~g4/registration.php\">Register here</a>".PHP_EOL);
			print('</form>'.PHP_EOL);
		}
		
		print( "<hr>" );
		include "header.php";
		print( "<hr>" );
		
		print( "<center><table width=\"90%\" border=\"0\" cellpadding=\"0\"><tr><td width=\"100%\">".PHP_EOL );		// create table

		if ($_SESSION['inProgress']==3) { 		// just logged in
			print( "Welcome to the Idiot Drivers database, {$_SESSION['email']}!" );		// display welcome
			print( "<meta http-equiv=\"refresh\" content=\"3;url=/~g4/story.php\"/>");		// automatically redirect to story.php after 3 seconds
			print("<br><br><br>If this page does not automatically redirect, please continue to the <a href=\"/~g4/story.php\">Stories page</a>".PHP_EOL);
			$_SESSION['inProgress'] = '2'; // if recently logged in, change
		} else if ($_SESSION['inProgress']==2) { 		// already logged in
			print( "You are already logged in!" );		// display warning
			print("<br><br><br>Please continue to the <a href=\"/~g4/story.php\">Stories page</a>".PHP_EOL);
		} else if ($_SESSION['inProgress']==1) { 		// bad email or password
			print( "<h1>Login:</h1>".PHP_EOL);
			print( "<p class=\"page_error\">EMAIL OR PASSWORD ERROR!</p>" );		// display warning
			draw_form();
		} else { 	// not logged in	
			print( "<h1>Login:</h1>".PHP_EOL);
			draw_form();
		}
		
		print( "</td></tr></table></center>".PHP_EOL );
	?>
	
</td>
</tr>
</table>
</center>
</body>
</html>