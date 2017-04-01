<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>

<link href="styles.css" rel="stylesheet">
</head>

<body>
<table width="100%" border="0" cellpadding="5">
 <tr>
   <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
   <td width="80%" class="page_title">Registration</td>
 </tr>
</table>
	<?php
		session_start();
		require_once( "connection.php" ); // opens connection.php
		// require_once( "accountClass.php" );

		$idiots = new Connection( 'settings.ini' ); //creates new instance of connection class
		$conn = $idiots->getConnection(); //get the connection and assign it to conn
		// _connect( $conn );
		
		if ( ($_POST['create_email'] == '') || ($_POST['create_pass'] == '') ) {		// if one of the fields is empty
			$_SESSION['accountStat'] = 0;
		} else if ( $_POST['create_pass'] != $_POST['create_pass2'] ) {			// if the passwords don't match, includes if the second password field is empty
			$_SESSION['accountStat'] = 2;
		} else if ( strpos( $_POST['create_email'], '@' ) == 0 ) {			// if the entered email does not contain "@"
			$_SESSION['accountStat'] = 1;
		} else {		// if all fields are good
			$sql = "SELECT * FROM account WHERE email_address = ?"; // sql statement
			$create_email = $_POST['create_email'];
			$stmt = $conn->prepare( $sql ); //prepare the sql statement
			$stmt->bindValue( 1, $create_email, PDO::PARAM_INT );
			$stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
			$stmt->execute(); //execute the sql statement 
			$data = $stmt->fetchAll(); //get the result set
			// $data->accountInfo($_POST['create_email']);
			
			if ( count($data) > 0 ) {		// if something is returned, the email is already in the database
				$_SESSION['accountStat'] = 3;
			} else {		// else the email is not in the database
				$sql = 'INSERT INTO account ';			// make new account
				$sql .= '( email_address, pass, rights_id ) ';
				$sql .= 'VALUES ( ?, ?, \'1\' )';
				$stmt = $conn->prepare( $sql ); //prepare the sql statement
				$i = 1;
				$stmt->bindValue( $i++, $_POST['create_email'] );
				$stmt->bindValue( $i++, $_POST['create_pass'] );
				$stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
				if($stmt->execute()){ //execute the sql statement 
					$account_id = $conn->lastInsertId();
				} else {
					$account_id = -1;
				}
				
				// accountReg($_POST['create_email'], $_POST['create_pass']);
				
				$_SESSION['accountStat'] = 4;			// create account successful
				$_SESSION['inProgress'] = 2;
				$_SESSION['email'] = $_POST['create_email'];
				$_SESSION['account_id'] = $account_id;
				$_SESSION['rights_id'] = 1;
			}
		}
		
		function draw_form() {		// draw registrationi form
			print( "<form name=\"regForm\" action=\"registration.php\" method=\"post\">".PHP_EOL);
			print( "<br>Email:<br><input type=\"text\" name=\"create_email\" size=\"30\" autofocus tabindex=\"1\"><br>".PHP_EOL);
			print( "<br>Password:<br><input type=\"password\" name=\"create_pass\" size=\"30\" tabindex=\"2\">".PHP_EOL);
			print( "<br>Re-enter Password:<br><input type=\"password\" name=\"create_pass2\" size=\"30\" tabindex=\"3\"><br>".PHP_EOL);
			print("<br/><input name=\"regButton\" type=\"submit\" value=\"Register\" tabindex=\"4\"/>".PHP_EOL);
			print("<br><br><br>Already a member? <a href=\"/~g4/login.php\">Login here</a>".PHP_EOL);
			print('</form>'.PHP_EOL);
		}

		print( "<hr>" );		
		include "header.php";
		print( "<hr>" );	
		
		print( "<br><center><table width=\"90%\" border=\"0\" cellpadding=\"0\"><tr><td width=\"100%\">".PHP_EOL );		// creates table
		
		if ($_SESSION['accountStat']==4) {		 // account created
			print( "Thank you for registering with the Idiot Drivers website, {$_POST['create_email']}!<br>" );		// display welcome message
			print("<br><br><br>Please continue to the <a href=\"/~g4/story.php\">Stories page</a>".PHP_EOL);			
		} else if ($_SESSION['accountStat']==3) {		 // account already exists
			print( "<h1>Registration:</h1>".PHP_EOL);
			print( "<p class=\"page_error\">There is already an account with the email {$_POST['create_email']}!</p>" );		// display warning
			draw_form();
		} else if ($_SESSION['accountStat']==2) {		 // password mismatch
			print( "<h1>Registration:</h1>".PHP_EOL);
			print( "<p class=\"page_error\">The passwords you have entered do not match!</p>" );		// display warning
			draw_form();
		} else if ($_SESSION['accountStat']==1) {		 // invalid email address
			print( "<h1>Registration:</h1>".PHP_EOL);
			print( "<p class=\"page_error\">The email you have entered is not valid!</p>" );		// display warning
			draw_form();
		} else { 
			print( "<h1>Registration:</h1>".PHP_EOL);
			draw_form();
		}
		
		print( "</td></tr></table></center>".PHP_EOL );
	?>

</body>
</html>