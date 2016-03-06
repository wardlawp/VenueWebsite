<?php
	include_once 'config.php';
	include_once 'SearchMethods.php';
?>

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
	<body>
		
		
		<div class="FormBar"> 
			<h1>Work in progress. Page will display venue info (Category, address, review, google maps street view)</h1>
		</div>
		
		<!-- Left bar is where all the venues will be displayed -->
		<div class="LeftBar" id="LeftBar" > 
			Reviews will go here
		
		</div>
		<!-- Content dive where google maps will be loaded -->
		<div class="content">
			Google Maps street view will go here
		</div>
		
		<div class="BottomBar" >
		
			<p><a href="home.php">Home</a> | <a href="about.php">About Us</a></p>
			<p> 
				Text field. Enter random text – I will edit it later, with middle alignment
			</p>
		</div>
	</body>
</html>