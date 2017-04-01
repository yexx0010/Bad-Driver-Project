<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!---------------- replace "PAGE TITLE" below ------------------->
<title>Edit Story</title>


<link href="styles.css" rel="stylesheet">
</head>

<body>
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
	<!---------------- replace "Title of Page" below ------------------->
    <td width="69%" class="page_title">Edit Story</td>
  </tr>
</table>

	<?php
		session_start();
		$story_id = $_REQUEST['id'];
		require_once( "connection.php" ); // opens connection.php
		$idiots = new Connection( 'settings.ini' ); //creates new instance of connection class
		$conn = $idiots->getConnection(); //get connection
		$story = getStory($conn,$story_id); //get story from DB
		$story_tags = getTags($conn, $story_id); //get tags for particular story
	?>
	<hr />
	<?php
		include "header.php";
	?>
	<hr/>
	<?php
		print( "<br><center><table width=\"90%\" border=\"0\" cellpadding=\"0\"><tr><td width=\"100%\">".PHP_EOL );
		//check if the person logged in, is the person on the story (to prevent people who are being sneaky and type in URLs)
		if ($_SESSION['account_id']!=$story[0]['account_id']){
			header("Location:/~g4/story.php");
			exit;
		}
		if (isset($_POST['storyText'])){
			try{
				if($_POST['storyText']=="" || $_POST['storyTitle']==""){
					throw new Exception('*Fields must be filled in.');
				} else if ($_POST['storyDate'] != "") {
					$pieces = explode("-", $_POST['storyDate']);
					if(count($pieces) != 3 || checkdate($pieces[1], $pieces[2], $pieces[0])==False){
						throw new Exception('Invalid Story Date.');
					}
				}
				updateStory($conn,$_POST,$story_id);
				deleteTags($conn, $story_id);
				foreach($_POST['tag'] as $mt){
					insertTags($conn, $story_id, $mt);
				}
				//redirect to story detail page
				header("Location:/~g4/storyDetail.php?id=$story_id");
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
				
		<form name="editStoryForm" action="/~g4/editStory.php" method="post">
			<table>
				<tr>
					<td width="100">
						Story Date:
					</td>
					<td>
						<?php
							$dateArray = explode($story[0]['story_date']);
							if(checkdate($dateArray[1],$dateArray[2],$dateArray[0])){
						?>
								<input type="text" name="storyDate" value ="<?php print($story[0]['story_date']); ?>" />
								(YYYY-MM-DD)
						<?php
							} else {
						?>
								<input type="text" name="storyDate"/>
								(YYYY-MM-DD)
						<?php
							}
						?>
						
					</td>
				</tr>
				<tr>
					<td>
						Plate:
					</td>
					<td>
						<input type="text" name="plate" value ="<?php print($story[0]['plate']); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						Make:
					</td>
					<td>
						<select name="makes">
						<?php
							$make = selectAllMakes($conn);
							foreach( $make as $m ) {
								if ($m['make_name']==$story[0]['make']) {
									print("<option selected=\"selected\" value=\"{$m['make_id']}\">{$m['make_name']}</option>".PHP_EOL);
								} else {
									print("<option value=\"{$m['make_id']}\">{$m['make_name']}</option>".PHP_EOL);
								}
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
			        			if ($c['colour_name']==$story[0]['colour']) {
									print("<option selected=\"selected\" value=\"{$c['colour_id']}\">{$c['colour_name']}</option>".PHP_EOL);
								} else {
									print("<option value=\"{$c['colour_id']}\">{$c['colour_name']}</option>".PHP_EOL);
								}
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
						<input type="text" name="location" value ="<?php print($story[0]['location']); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						Tags:
					</td>
					<td>
						<?php
							$tagnames = array();
							$i = 0;
							$tag = selectAllTags($conn);
							foreach($story_tags as $st){
								$tagnames[$i++] = $st['tag_name'];
							}
							foreach($tag as $t){
								if(in_array($t['tag_name'],$tagnames)){
									print("<input type=\"checkbox\" checked = \"checked\" name =\"tag[]\" value=\"{$t['tag_id']}\">{$t['tag_name']}</input> &nbsp; &nbsp;");
								} else {
									print("<input type=\"checkbox\" name =\"tag[]\" value=\"{$t['tag_id']}\">{$t['tag_name']}</input> &nbsp; &nbsp;");
								}
							}
							
						?>
					</td>
				</tr>
				<tr>
					<td>
						*Story Title:
					</td>
					<td>
						<input style=width:600px type="text" name="storyTitle" value ="<?php print($story[0]['story_title']); ?>" />
					</td>
				</tr>
			</table>
				
			<p>*Story Text:</p>
			<textarea name="storyText" rows="10" cols="150"><?php print($story[0]['story_text']);?> </textarea>
			<br/><br/>
			<input type="submit" value="Update" class = "button"/>
			<input type="hidden" name = "id" value="<?php print($story_id);?>"/>

				
			
				
		</form>
	<?php	
		print( "</td></tr></table></center>".PHP_EOL );
    ?>

</body>
</html>
 <?php
 //all sql functions
function updateStory( &$conn, &$story,$story_id) {
    $sql = 'UPDATE story SET colour_id = ?, make_id =?, location=?, 
    		plate=?, story_date=?, story_text=?, story_title=?
    		WHERE story_id = ?';
    $stmt = $conn->prepare( $sql );
    $i = 1;
    $stmt->bindValue( $i++, $story['colours'] );
    $stmt->bindValue( $i++, $story['makes'] );
    $stmt->bindValue( $i++, $story['location'] );
    $stmt->bindValue( $i++, $story['plate'] );
    $stmt->bindValue( $i++, $story['storyDate'] );
    $stmt->bindValue( $i++, $story['storyText'] );
	$stmt->bindValue( $i++, $story['storyTitle'] );
	$stmt->bindValue( $i++, $story_id );
    $stmt->execute();
	return;
  } 
  
function getStory(&$conn,&$story_id){
	$sql = 'SELECT story_title, story_text, plate, location, posted_date, story_date, make, colour, account_id FROM v_story_detail WHERE story_id = ?'; // sql statement
    $stmt = $conn->prepare( $sql ); //prepare the sql statement
    $stmt->bindValue( 1, $story_id );
    $stmt->execute(); //execute the sql statement 
    $stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
    return $stmt->fetchAll(); //get the result set
}
  
function insertTags(&$conn, &$story_id, &$tag_id){
 	$sql = 'INSERT INTO story_tag (tag_id,story_id) VALUES (?,?)';
	$stmt = $conn->prepare( $sql );
 	$stmt->bindValue( 1, $tag_id );
    $stmt->bindValue( 2, $story_id );
	$stmt->execute();
	return;
 }

function getTags(&$conn,&$story_id){
		
	$sql = 'SELECT tag_name FROM tag AS t JOIN story_tag AS st ON st.tag_id = t.tag_id WHERE story_id = ?';
	$stmt = $conn->prepare($sql);
	$stmt->bindValue( 1, $story_id );
	$stmt->execute(); //execute the sql statement 
	$stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
	return $stmt->fetchAll(); //get the result set
		
}

function deleteTags(&$conn, &$story_id){
 	$sql = 'DELETE FROM story_tag WHERE story_id=?';
	$stmt = $conn->prepare( $sql );
    $stmt->bindValue( 1, $story_id );
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