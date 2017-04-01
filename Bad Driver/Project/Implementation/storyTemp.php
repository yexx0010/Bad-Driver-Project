<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!---------------- replace "PAGE TITLE" below ------------------->
<title>Stories</title>

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
    <td width="20%"><a href="/~g4/welcome.html"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
	<!---------------- replace "Title of Page" below ------------------->
    <td width="69%" class="page_title">Stories</td>
  </tr>
</table>

	<?php
		session_start();
		require_once( "connection.php" ); // opens connection.php
		$idiots = new Connection( 'settings.ini' ); //creates new instance of connection class
		$conn = $idiots->getConnection(); //get the connection and assign it to conn
		
		print( "<hr>" );
		if ($_SESSION['inProgress']==2) {
			print( "<p>{$_SESSION['email']}: <a href=\"/~g4/logout.php\" class=\"page_logout\">Logout</a><span class=\"page_logout\"></span></p><hr>".PHP_EOL );
		}
		
		print( "<br><center><table width=\"90%\" border=\"0\" cellpadding=\"0\"><tr><td width=\"100%\">".PHP_EOL );
			
		if (isset($_POST['tags'])){
			$data = getStoryByTag($conn,$_POST['tags']);
		} else if (isset($_POST['location'])){
			
		} else if (isset($_POST['make']) || isset($_POST['colour'])){
			
		} else {
			$data = getAllStories($conn);
		}
		
		displayStories($data,$conn);	//calls function to display $data
		
		print( "</td></tr></table></center>".PHP_EOL );
	?>
		


</body>
</html>

<?php

	function getStoryByTag(&$conn,&$tags){

		$sql = 'SELECT v.story_title, v.make_name, v.colour_name, v.location, v.story_id, v.posted_date 
				FROM v_story AS v
				JOIN story_tag AS st ON st.story_id = v.story_id
				WHERE st.tag_id = ?
				ORDER BY posted_date DESC';
		$stmt = $conn->prepare( $sql ); //prepare the sql statement
		$stmt->bindValue(1,$tags[0]);
    	$stmt->execute(); //execute the sql statement 
    	$stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
		return $stmt->fetchAll();
		
	}
	function getAllStories(&$conn){
		$sql = 'SELECT story_title, make_name, colour_name, location, story_id, posted_date FROM v_story ORDER BY posted_date DESC';
		$stmt = $conn->prepare( $sql ); //prepare the sql statement
    	$stmt->execute(); //execute the sql statement 
    	$stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
		return $stmt->fetchAll();
	}
	
	function getTags(&$conn,&$story_id){
		
		$sql = 'SELECT tag_name FROM tag AS t JOIN story_tag AS st ON st.tag_id = t.tag_id WHERE story_id = ?';
		$stmt = $conn->prepare($sql);
		$stmt->bindValue( 1, $story_id );
		$stmt->execute(); //execute the sql statement 
		$stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
		return $stmt->fetchAll(); //get the result set
		
	}
	
	//code below will print results from $data
	function displayStories(&$data,&$conn){
		?>
		<table>
		<?php
		foreach ($data as $d){
			$datestr = date("F d, Y",strtotime($d['posted_date']));
		?>
			<tr>
				<td width="150"><?php
						print($datestr);
					?>
				</td>
				<td width="300">
					<?php
						print("<a href = \"/~g4/storyDetail.php?id={$d['story_id']}\"><strong>{$d['story_title']}:</strong> {$d['colour_name']} {$d['make_name']}, {$d['location']}</a>");
					?>
				</td>
				<td>
					<?php
						$tag = getTags($conn,$d['story_id']);
						if (count($tag)!=0){
					?>
						Tagged As: 
						<?php
							foreach($tag as $t){
								print($t['tag_name']);
						?>
						&nbsp; &nbsp;
					<?php
							}
						}
					?>
				</td>
			</tr>
		
		<?php		
		}
		?>
		</table>
<?php
    	return;
	}
?>
