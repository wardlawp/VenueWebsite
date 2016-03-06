<html>
	<!-- This document is commented in detail as per customer's requirements -->
	<head>
		<!-- Includes (JQuery) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
		<meta name="home_lat" content="<?php echo $homeLat?>">
		<meta name="home_long" content="<?php echo $homeLong ?>">
		<!-- Includes (Our custom JS) -->
		<script src="venue.js"></script>
		<!-- Includes (Our custom CSS) -->
		<link href="style.css" rel="stylesheet" type="text/css">
		<title>Venue Site</title>
	</head>
	<body style="background-color: #63b8ee;">

		<div class="AboutContent"> 
			<h1 style="text-align: center;">Venue Search</h1>
			<p style="text-align: center;">Text field. Enter random text – I will edit it later, with middle alignment </p>
			<br>
			<!-- Form Bar at the top of the page, used by the user for searching for venues -->
			<div class="floating-box" style="vertical-align: top;">
				<!-- Create a form which makes a GET request to /venue -->
				<form method="get" id="search" action="home.php"> 
					<!-- Create an input box for a location phrase, prepolated with data if it exists -->
					<input   class="textbox" style="display: inline;" type="text" name="location" 
						value="<?php echo isset($_GET['location'])? $_GET['location'] : '' ?>"
						placeholder="Enter a location here"  id="form_location">
		
					<!-- Create an input dropdown/select for speficying search range, prepolated with data if it exists -->
					<?php $dist =  isset($_GET['distance'])? $_GET['distance'] : 0 ?>
					<select class="textbox" style="display: inline;"name="distance">
						<option value="5000" <?php echo $dist == 5000 ? 'selected': '' ?>>5km</option>
						<option value="10000" <?php echo $dist == 10000 ? 'selected': '' ?>>10km</option>
						<option value="15000" <?php echo $dist == 15000 ? 'selected': '' ?>>15km</option>
					</select>
					
					<!-- Create an input box for specifying a serach phrase, like "pizza", prepolated with data if it exists -->
					<input  class="textbox" type="text"  style="display: inline;" name="keyword"
						value="<?php echo isset($_GET['keyword'])? $_GET['keyword'] : '' ?>"
						placeholder="Something like 'Pizza'">
		
					<!-- Create some hidden fields that will be set by google maps javascript, prepolated with data if it exists -->
					<input type="text"  style="display: none;" name="lat" id="form_lat"
						value="<?php echo isset($_GET['lat'])? $_GET['lat'] : '' ?>">
					<input type="text"  style="display: none;" name="long" id="form_long" 
						value="<?php echo isset($_GET['long'])? $_GET['long'] : '' ?>">
						
					<!-- Create a button to submit the form -->
					<input class="button" style="display: inline;  bottom: 10px;" type="submit" value="Search">
				</form>
			</div>
		</div>
		
		<div class="BottomBar" >
			<p> 
				Text field. Enter random text – I will edit it later, with middle alignment
			</p>
		</div>
	</body>
</html>