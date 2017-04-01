<?php
		if ($_SESSION['inProgress']==2) {
			print( "<p class=\"page_logout\">{$_SESSION['email']}: <a href=\"/~g4/logout.php\">Logout</a></p>".PHP_EOL );
		}
	?>
		
		<table class="page_logout" style="width: 100%;">
			<tr>
				<td style="text-align: left;">
					<?php
			
						if ($_SESSION['inProgress'] != 2){
					?>
							<a href="/~g4/login.php">Login</a>&nbsp&nbsp;
							or &nbsp&nbsp;
							<a href="/~g4/registration.php">Register</a>&nbsp&nbsp;
					<?php
						}
					?>
			
					<a href="/~g4/story.php">Show All Stories</a>&nbsp;&nbsp;
					<a href="/~g4/searchByTag.php">Search By Tag</a> &nbsp;&nbsp;
					<a href="/~g4/searchByMakeAndColour.php">Search By Make and Colour</a>&nbsp;&nbsp;
					<a href="/~g4/searchByLocation.php">Search By Location</a>&nbsp;&nbsp;
					<?php
						if ($_SESSION['inProgress'] == 2){
					?>
							<a href="/~g4/addNewStory.php">Add New Story</a>&nbsp;&nbsp
					<?php
						}
					?>	
				</td>
				<td style="text-align: right;">
					<a href="/~g4/about.php">About Us</a>&nbsp;&nbsp;
					<a href="/~g4/howToGuide.php">How To Guide</a>&nbsp;&nbsp;
					<a href="/~g4/projectChanges.php">Documented Changes</a>&nbsp;&nbsp;
				</td>
			</tr>
		</table>	
