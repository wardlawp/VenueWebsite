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
		<!-- Process GET request, get venues from database -->
		<?php
			$limit = 50;
			$venues = null;
			
			// Check for required search parameters
			if(isset($_GET['keyword']) &&
			  (isset($_GET['location']) || (!empty($_GET['lat']) && !empty($_GET['long']))) &&
			   isset($_GET['distance'])){
		 
			   	// Get Lat and Long required for database search
			   	// Either from the form or if necessary use google geocode services
				if(!empty($_GET['lat']) && !empty($_GET['long'])){
					$location = ['lat' => $_GET['lat'], 'long' => $_GET['long']];
				} else {
					$location = getGoogleGeoCode($_GET['location']);
				}
			
				// Get a list of Venues from the database for specified search parameters
				$venues = locationKeywordSearch($location['lat'], $location['long'], $_GET['keyword'], $_GET['distance']);
			}
		?>
		
		<!-- Form Bar at the top of the page, used by the user for searching for venues -->
		<div class="FormBar"> 
			<div class="floating-box" style="vertical-align: top;">
				<h1 >Venue Site|           </h1>
			</div>
			<div class="floating-box" style="vertical-align: top;">
				<!-- Create a form which makes a GET request to /venue -->
				<form method="get" id="search"> 
					<!-- Create an input box for a location phrase, prepolated with data if it exists -->
				 	<p  style="display: inline;">Location:</p>
					<input   class="textbox" style="display: inline;" type="text" name="location" 
						value="<?php echo isset($_GET['location'])? $_GET['location'] : '' ?>"
						placeholder="Enter a location here"  id="form_location">
		
					<!-- Create an input dropdown/select for speficying search range, prepolated with data if it exists -->
					<?php $dist =  isset($_GET['distance'])? $_GET['distance'] : 0 ?>
				 	<p  style="display: inline;">Distance:</p>
					<select class="textbox" style="display: inline;"name="distance">
						<option value="5000" <?php echo $dist == 5000 ? 'selected': '' ?>>5km</option>
						<option value="10000" <?php echo $dist == 10000 ? 'selected': '' ?>>10km</option>
						<option value="15000" <?php echo $dist == 15000 ? 'selected': '' ?>>15km</option>
					</select>
					
					<!-- Create an input box for specifying a serach phrase, like "pizza", prepolated with data if it exists -->
					<p  style="display: inline;">Search Phrase:</p>
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
		
		<!-- Left bar is where all the venues will be displayed -->
		<div class="LeftBar" id="LeftBar" > 
		<?php 
			// For each venue retrieved from the database, display them
			if(isset($venues)){
				foreach ($venues as $venue)
				{
					echo '<div class ="venue">';
					echo '<h2>' .$venue['name'] . '</h2>';
					echo '<p>' . rtrim($venue['categories'], ',') . '</p>';
					echo '<p>' .$venue['address'] . '</p>';
					echo '<a class="mapLink" value="'.$venue['lat'] . ',' . $venue['long'] .  ',' . $venue['name'] .  '"><button class="button"style="float:right;" type="button">Show</button> </a>';
					echo '</div>';
				}
			} else {
				echo '<p>Please enter a search phrase</p>';
			}
		?>
		</div>
		<!-- Content dive where google maps will be loaded -->
		<div class="content">
			<div id="map"></div>
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $googleAPIKey?>&callback=initMap"></script>
		</div>
	</body>
</html>