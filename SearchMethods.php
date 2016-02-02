<?php


/**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * @return float Distance between points in [m] (same as earthRadius)
 */
function haversineGreatCircleDistance($lat, $long)
{
	$earthRadius = 6371000;
	
	// convert from degrees to radians
	$latFrom = deg2rad($_SESSION['lat']);
	$lonFrom = deg2rad($_SESSION['long']);
	$latTo = deg2rad($lat);
	$lonTo = deg2rad($long);

	$latDelta = $latTo - $latFrom;
	$lonDelta = $lonTo - $lonFrom;

	$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
			cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	return $angle * $earthRadius;
}

function locationSearch($lat, $long, $distance){
	
	$_SESSION['lat'] = $lat;
	$_SESSION['long'] = $long;
	
	
	
	$db = new SQLite3('Venue.db');
	$db->createFunction("DISTANCE", "haversineGreatCircleDistance");
	
	$statement = $db->prepare('SELECT venueId, name, lat, long, DISTANCE(lat, long)' .
			' as distance FROM Venues WHERE distance < :search_dist ORDER BY distance ASC'); //LIMIT :limit
		
	
	echo $statement;
	//$statement->bindValue(':limit', $limit);
	$statement->bindValue(':search_dist', $distance);
	
	return  $statement->execute();
	
}

