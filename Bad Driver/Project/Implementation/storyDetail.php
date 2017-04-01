<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!---------------- replace "PAGE TITLE" below ------------------->
<title>storyDetail</title>

<link href="styles.css" rel="stylesheet">
</head>

<body>
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
	<!---------------- replace "Title of Page" below ------------------->
    <td width="69%" class="page_title">
    	<?php
    		session_start();
			
    		require_once( "connection.php" ); // opens connection.php
    		$story_id = $_REQUEST['id'];
		    $idiots = new Connection( 'settings.ini' ); //creates new instance of connection class
		    $conn = $idiots->getConnection();
			$data = getStory($conn,$story_id);
			if (count($data)==0){
				header("Location: /~g4/story.php");
				exit;
			}
			print($data[0]['story_title']);
    	?>
    </td>
  </tr>
</table>
<hr />
	<?php
		include "header.php";
	?>
	<div>
		<?php
			if ($_SESSION['inProgress'] == 2 && $_SESSION['account_id']==$data[0]['account_id']){
		?>
				&nbsp;<a href="/~g4/editStory.php?id= <?php print($story_id); ?>" class="page_logout">Edit Story</a>
				&nbsp; 
		<?php
			}

			if ($_SESSION['inProgress']==2 && $_SESSION['rights_id']==2){
		?>
		<form id="form" style="display:inline;" action="/~g4/storyDetail.php" method="post">
			&nbsp;<a class = "page_logout" href="javascript:void();" onclick="if(confirm('Are you sure you want to delete?'))form.submit();">Delete Story</a>			
			<input name="id" type="hidden" value="<?php print($story_id);?>"/>
			<input name="bool" type="hidden" value="True"/>
		</form>
		<?php
			}
		?>
	</div>
<hr/>

<center>
  <table width="95%" border="0" cellpadding="10">
<tr>
<td width="100%">
	<?php
		if (isset($_POST['commentTextBox'])){
			//someone is posting a comment
			postComment($conn,$_POST['id'],$_SESSION['account_id'],$_POST['commentTextBox']);
			$id = $_POST['id'];
			header("Location: /~g4/storyDetail.php?id=$id");
			exit;
		} else if (isset($_POST['bool'])){
			deleteStory($conn, $_POST['id']);
			header("Location: /~g4/story.php");
			exit;
		} else if(isset($_POST['deleteComment'])){
			deleteComment($conn,$_POST['comment_id']);
			$id = $_POST['id'];
			header("Location: /~g4/storyDetail.php?id=$id");
			exit;
		}
		
	?>
	<p>

		<strong>Location:</strong>
		<?php
			print($data[0]['location']);
		?>
		&nbsp; &nbsp; &nbsp; &nbsp;
		
		<strong>Plate:</strong> 
		<?php
			print($data[0]['plate']);
		?>

	 	&nbsp; &nbsp; &nbsp; &nbsp; 
	 
	 	<strong>Vehicle Colour:</strong>
	 	<?php
	 		print($data[0]['colour']);
	 	?>
	 	&nbsp; &nbsp; &nbsp; &nbsp; 
	 	
	 	<strong>Vehicle Make:</strong> 
	 	<?php
	 		print($data[0]['make']);
	 	?>
	</p>
	<p>
		<?php
			$posteddatestr = date('F d, Y',strtotime($data[0]['posted_date'])); //format posted date
			if($data[0]['story_date']!=0){
				$storydatestr = date('F d, Y',strtotime($data[0]['story_date'])); //format story date
			} else {
				$storydatestr = "";
			}
			
		?>
		
		<strong>Posted Date:</strong>
		<?php
			print($posteddatestr);
		?>
		&nbsp; &nbsp; &nbsp; &nbsp;
		
		<strong>Story Date:</strong>
		<?php
			print($storydatestr);
		?>
	</p>
	<?php
		$tags = getTags($conn,$story_id); //get tags
	?>
	<p>
		<strong>Tags: </strong>
		<?php
			foreach($tags as $t){
				print("{$t['tag_name']} &nbsp; &nbsp; &nbsp; &nbsp;"); //print all associated tags
			}
		?>
		
	</p>
	<p>
		<strong>Story:</strong>
	</p>
	<p>
		<div class="border">
			<?php
				print($data[0]['story_text']);
				$comments = getComments($conn,$story_id);
			?>
		</div>
		
	</p>
		
	<p>
		<strong>Comments:</strong>
	</p>
	<table>
	<?php
		foreach($comments as $c){
	?>
		<tr>
			<td>
				<i>
					<?php
						print($c['email'])
					?>
				</i>
			</td>
			<?php
				if ($_SESSION['rights_id']==2){
			?>
				<td>
					<form style="display:inline" action="/~g4/storyDetail.php" method="post" onsubmit="return confirm('Are you sure you want to delete this comment?')">
						<input class="button" name="deleteComment" type="submit" value ="Delete"/>
						<input name="id" type = "hidden" value = "<?php print($story_id); ?>"/>
						<input name="comment_id" type = "hidden" value = "<?php print($c['comment_id']); ?>"/>
						
					</form>
				</td>
			<?php
				}
			?>
		</tr>
		<tr>
			<td>
				<?php
					print($c['comment_text']);
				?>
			</td>
		</tr>

	<?php
		}
	?>
	</table>
	<?php
		if ($_SESSION['inProgress']==2){
	?>
		<form action="/~g4/storyDetail.php" method="post">
			<p>
				<strong>Add New Comment:</strong>
			</p>
			<textarea name="commentTextBox" rows = "5" cols="75"></textarea><br><br>
			<input class="button" name="submitComment" type="submit" value="Post"/>
			<input name="id" type="hidden" value="<?php print($story_id);?>"/>
		</form>
	<?php
		}
	?>
	
		
</td>
</tr>
</table>
</center>
<hr />
<br>
<a href="/~g4/logout.php"></a>
</body>
</html>


<?php
	//Functions
	function getStory(&$conn,&$story_id){
		$sql = 'SELECT story_title, story_text, plate, location, posted_date, story_date, make, colour, account_id FROM v_story_detail WHERE story_id = ?'; // sql statement
	    $stmt = $conn->prepare( $sql ); //prepare the sql statement
	    $stmt->bindValue( 1, $story_id );
	    $stmt->execute(); //execute the sql statement 
	    $stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
	    return $stmt->fetchAll(); //get the result set
	}

	function getTags(&$conn,&$story_id){
		
		$sql = 'SELECT tag_name FROM tag AS t JOIN story_tag AS st ON st.tag_id = t.tag_id WHERE story_id = ?';
		$stmt = $conn->prepare($sql);
		$stmt->bindValue( 1, $story_id );
		$stmt->execute(); //execute the sql statement 
		$stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
		return $stmt->fetchAll(); //get the result set
		
	}
	
	function getComments(&$conn,&$story_id){
		$sql = 'SELECT c.comment_text, (SELECT email_address FROM account AS a WHERE a.account_id = c.account_id) AS email, c.comment_id FROM comments AS c WHERE c.story_id = ?'; // sql statement
		$stmt = $conn->prepare($sql);
		$stmt->bindValue( 1, $story_id );
		$stmt->execute(); //execute the sql statement 
		$stmt->setFetchMode( PDO::FETCH_ASSOC ); //something DB had in his code
		return $stmt->fetchAll(); //get the result set
	}
	
	function postComment(&$conn,&$story_id,&$account_id,&$comment_text){
		$sql = 'INSERT INTO comments(account_id, comment_text, story_id)VALUES(?, ?, ?)';
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $account_id );
		$stmt->bindValue(2, $comment_text );
		$stmt->bindValue(3, $story_id );
		$stmt->execute(); //execute the sql statement 
		return;
	}
	
	function deleteStory(&$conn, &$story_id){
		$sql = 'DELETE FROM story WHERE story_id = ?';
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $story_id );
		$stmt->execute(); //execute the sql statement 
		return;
	}

	function deleteComment(&$conn, &$comment_id){
		$sql = 'DELETE FROM comments WHERE comment_id = ?';
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $comment_id );
		$stmt->execute(); //execute the sql statement 
		return;
	}
	
?>
