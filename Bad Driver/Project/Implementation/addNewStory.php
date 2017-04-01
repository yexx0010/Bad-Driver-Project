<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!---------------- replace "PAGE TITLE" below ------------------->
<title>Add New Story</title>

<link href="styles.css" rel="stylesheet">
</head>

<body>
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
	<!---------------- replace "Title of Page" below ------------------->
    <td width="69%" class="page_title">Add New Story</td>
  </tr>
</table>

	<?php
		session_start();
		require_once( "connection.php" ); // opens connection.php
		$idiots = new Connection( 'settings.ini' ); //creates new instance of connection class
		$conn = $idiots->getConnection();
		$user_id = $_SESSION['account_id'];
		
		print( "<hr>" );
		include "header.php";
		print( "<hr>" );

		print( "<br><center><table width=\"90%\" border=\"0\" cellpadding=\"0\"><tr><td width=\"100%\">".PHP_EOL );
		
		if (isset($_POST['storyText'])){
			try{
				if($_POST['storyText']=="" || $_POST['storyTitle']==""){
					throw new Exception('*Fields must be filled in.');
				} else if ($_POST['storyDate'] != ""){
					$pieces = explode("-", $_POST['storyDate']);
					if(count($pieces) != 3 || checkdate($pieces[1], $pieces[2], $pieces[0])==False){
						throw new Exception('Invalid Story Date.');
					}
				}
				$story_id = insertstory($conn,$_POST,$user_id);
				foreach($_POST['tag'] as $mt){
					insertTags($conn, $story_id, $mt);
				}
				header("Location:/~g4/story.php");
				exit;
			} catch (Exception $e){
	?>
				<p style="color: red;">
					
	<?php
				print($e->getMessage());
			}
		}
	?>	
		</p>
		<form name="newStoryForm" action="/~g4/addNewStory.php" method="post">
			<table>
				<tr>
					<td width="100">
						Story Date:
					</td>
					<td>
						<input type="text" name="storyDate" /> (YYYY-MM-DD)
					</td>
				</tr>
				<tr>
					<td>
						Plate:
					</td>
					<td>
						<input type="text" name="plate" />
					</td>
				</tr>
				<tr>
					<td>
						Make:
					</td>
					<td>
						<select name="makes"
						<?php
							$make = selectAllMakes($conn);
							foreach( $make as $m ) {
			        			print("<option value=\"{$m['make_id']}\">{$m['make_name']}</option>".PHP_EOL);
			    			}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Colour:
					</td>

					<td>
						<select name="colours">
						<?php
							$colour = selectAllColours($conn);
							foreach( $colour as $c ) {
			        			print("<option value=\"{$c['colour_id']}\">{$c['colour_name']}</option>".PHP_EOL);
			    			}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Location:
					</td>
					<td>
						<input type="text" name="location" />
					</td>
				</tr>
				<tr>
					<td>
						Tags:
					</td>
					<td>
						<?php
							$tag = selectAllTags($conn);
							foreach( $tag as $t ) {
			        			print("<input type=\"checkbox\" name =\"tag[]\" value=\"{$t['tag_id']}\">{$t['tag_name']}</input> &nbsp; &nbsp;");
			    			}
						?>
					</td>
				</tr>
				<tr>
					<td>
						*Story Title:
					</td>
					<td>
						<input style=width:600px type="text" name="storyTitle"/>
					</td>
				</tr>
			</table>
				
			<p>*Story Text:</p>
			<textarea name="storyText" rows="10" cols="150"></textarea>
			<br/><br/>
			<input type="submit" value="Post" class="button">

				
			
				
		</form>
	<?php	
		print( "</td></tr></table></center>".PHP_EOL );
    ?>

</body>
</html>
 <?php
function insertstory( &$conn, &$story, &$user_id ) {
    $sql = 'INSERT INTO story ( colour_id, make_id, location, 
    		plate, story_date, account_id, story_text, story_title ) 
    		VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare( $sql );
    $i = 1;
    $stmt->bindValue( $i++, $story['colours'] );
    $stmt->bindValue( $i++, $story['makes'] );
    $stmt->bindValue( $i++, $story['location'] );
    $stmt->bindValue( $i++, $story['plate'] );
    $stmt->bindValue( $i++, $story['storyDate'] );
    $stmt->bindValue( $i++, $user_id);
    $stmt->bindValue( $i++, $story['storyText'] );
	$stmt->bindValue( $i++, $story['storyTitle'] );
    if($stmt->execute()) {
        $story_id = $conn->lastInsertId();
      } else {
        $story_id = -1;
      }
      return $story_id;
  } 
  
function insertTags(&$conn, &$story_id, &$tag_id){
 	$sql = 'INSERT INTO story_tag (tag_id,story_id) VALUES (?,?)';
	$stmt = $conn->prepare( $sql );
 	$stmt->bindValue( 1, $tag_id );
    $stmt->bindValue( 2, $story_id );
	$stmt->execute();
	return;
 }
 
function selectAllTags(&$conn){
	$sql = 'SELECT * FROM tag';
	$stmt = $conn->prepare( $sql ); //prepare the sql statement
    $stmt->execute(); //execute the sql statement 
    $stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
    return $stmt->fetchAll(); //get the result set
}

function selectAllColours(&$conn){
	$sql = 'SELECT * FROM colour';
	$stmt = $conn->prepare( $sql ); //prepare the sql statement
    $stmt->execute(); //execute the sql statement 
    $stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
    return $stmt->fetchAll(); //get the result set
}

function selectAllMakes(&$conn){
	$sql = 'SELECT * FROM make';
	$stmt = $conn->prepare( $sql ); //prepare the sql statement
    $stmt->execute(); //execute the sql statement 
    $stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
    return $stmt->fetchAll(); //get the result set
}

?>