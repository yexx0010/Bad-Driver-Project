<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!---------------- replace "PAGE TITLE" below ------------------->
<title>How To Guide</title>

<link href="styles.css" rel="stylesheet">
</head>

<body>
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td width="20%"><a href="/~g4/story.php"><img src="bad_drivers.png" width="200" height="200" alt="logo" /></a></td>
    <td width="80%" class="page_title">How To Guide</td>
  </tr>
</table> 
	<?php
		session_start();
		print( "<hr>" );
		include "header.php";
	?>
<hr/>
<center>
<table width="95%" border="0" cellpadding="10">
<tr>
<td width="100%">
	<p>
		As we have realized, since there are many idiot drivers there are also idiot website/database users! 
		Please follow this handy-dandy How-To Guide on how to use our website. There is also a convenient list of references provided at the bottom of the page.
	</p>
	<h3>The Welcome Page</h3>
	<p>
	Upon first loading the website, you are greeted with a welcome page. Press the ENTER! button to get to our Stories page. Given that you've already found the guide, you probably managed to figure that step out on your own. Congratulations! </p>
	<h3>The Stories Page</h3>
	<p>This page gives you a list of all stories currently submitted to our database. There are three columns which display the date the story was posted, the story title, 
		and the tags associated with the story. What's a tag? We'll get to that in a moment! By clicking on a story title, you are taken to a page with the full details of the selected story which we will call
		the Story Detail page, for future reference in this document.</p>
	<h3>Registration and Logging In</h3>
	<p>The first two links that you will notice in our navigation bar are Login and Register. In order to submit a story or make a comment on a story, you must have an account. 
		You can register for an account by clicking the Register link. </p>
	<ol>
	<li>First, you must submit an email address of the form "zombies@eatyourbrains.com". </li> 
	<li>Then select a password and type it into the password field. </li>
	<li>Re-enter your password in the next field to ensure you didn't make any typos. </li>
	<li>Press the register button to register your account. </li>
	</ol>
	<p>Upon completing this, you are now a registered member, hooray! After registering your account, you are automatically logged in and returned to the Stories page. 
		Your email address will serve as your username for our site, and it will be added to our database along with your password, which we encrypt for privacy.</p>
	<p>Already a member? Simply press the Login link and enter your email address (which serves as your username) and your password. Press the Login button and voila! You are now logged in. 
		We will check your email address and password against your registered account to protect your privacy. You will be automatically redirected to the Stories page.</p>
	<p>You may also choose to not register/login and you will still be able to view and search stories, but you will not be able to add stories of your own nor comment on stories. 
		So stop lurking and get an account!</p>
	<h3>Show All Stories Page</h3>
	<p>This link will return you back to the Stories page, allowing you to view all submitted stories. And that's it... Nothing else.</p>
	<h3>Search By Tag Page</h3>
	<p>By pressing this link, you are able to search through our database of stories based on a selected tag. A tag is a generic description that tells you the type of story you are viewing. 
		For example: If you wish to view stories about women drivers, simply select the Woman Driver tag from the drop-down menu and press the Search button. 
		This will return all stories that have been given this tag. </p>
	<h3>Search By Make and Colour Page</h3>
	<p>Similar to the Search By Tag page, you may search for stories about a certain make (i.e. brand name) and colour of vehicle. 
		Stories will be returned based on your selections from the two drop-down menus.</p>
	<h3>Search By Location Page</h3>
	<p>Similar to the previous two pages, this page allows you to search for stories by location. Simply type in a location, and stories that happened in that area will be returned.</p>
	<h3>Add New Story Page</h3>
	<p>Finally we've reached the good stuff! If you are logged in with your fancy schmancy account, you may choose to submit your own story to our database of idiot drivers. 
		Simply fill out the provided form with as much information as possible about that crazy person who somehow managed to get a license (nevermind that they haven't lost it yet!),
		 and press the Post button. Fields with an '*' MUST be filled out to submit a post.</p>
	<h3>Edit Story</h3>
	<p>When viewing your own posted stories, you may notice an Edit Story link. This link will take you to a form to make any changes you wish to your own story. You may not edit other users' stories and is 
		only available if you are logged in.
	<h3>Commenting</h3>
	<p>Upon viewing a selected story (see The Stories Page), you may notice that some of your fellow account-holders have posted comments. 
		You can do this too by typing into the convenient text box labelled "Add New Comment" and then press the Post button. Your comment can now be seen by anyone else who decides to view this story. </p>
	<h3>Logging Out</h3>
	<p>By pressing the Logout link, you will be logged out of your account. If you logged out by accident, simply press the Login link to log back in. 
		If you logged out on purpose, well, why would you? That's just crazy talk.</p>
	<h3>Administrator Capabilities</h3>
	<p>If you are an administrator, you have the ability to delete both any stories and any comments. To do so, you must go to the details page of any story, and links will be available to both delete comments and delete
		the story. A dialogue box pops up asking you to confirm your decision. You must hit ok for the delete to succeed!</p>
	<h3>About Us Page</h3>
	<p>A page about the amazing authors of this website. 'Nuff said.</p>
	<h3>Documented Changes</h3>
	<p>A page outlining what changes have occurred since the design/analysis phase.</p>
	<h3>References</h3>
	<p>The following is a list of handy references that you may find useful.
	<ul>
		<li><a href="/~g4/analysis.html">Our Group Analysis </a></li>
		<li><a href="/~g4/design.html">Our Group Design </a></li>
	</ul>
</td>
</tr>
</table>
</center>

</body>
</html>