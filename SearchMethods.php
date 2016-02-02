<?php



function distance($db_lat, $db_long)  {
	return sqrt(pow($db_lat - $_SESSION['lat'], 2)+ pow($db_long - $_SESSION['long'], 2));
}

function locationSearch($lat, $long, $limit = 10){
	
	$_SESSION['lat'] = $lat;
	$_SESSION['long'] = $long;
	
	
	
	$db = new SQLite3('Venue.db');
	$db->createFunction("DISTANCE", "distance");
	
	$statement = $db->prepare('SELECT venueId, name, lat, long, DISTANCE(lat, long) as distance FROM Venues ORDER BY distance ASC LIMIT :limit');
	$statement->bindValue(':limit', $limit);
	
	return  $statement->execute();
	
}

