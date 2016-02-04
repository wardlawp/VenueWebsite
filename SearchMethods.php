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

function locationSearch($lat, $long, $distance, $limit = 100)
{
	
	$_SESSION['lat'] = $lat;
	$_SESSION['long'] = $long;

	$db = new SQLite3('Venue.db');
	$db->createFunction("DISTANCE", "haversineGreatCircleDistance");
	
	$statement = $db->prepare('SELECT venueId, name, lat, long, categories, DISTANCE(lat, long)' .
			" as distance FROM Venues WHERE distance < :dist ORDER BY distance ASC LIMIT :limit");
		
	
	$statement->bindValue(':limit', $limit);
	$statement->bindValue(':dist', $distance, SQLITE3_INTEGER);
	
	return  $statement->execute();
}

function getGoogleGeoCode($address)
{
	//TODO: make region location configurable
	$address = urlencode($address . ' Singapore'); 
	//TODO: make region location configurable
	$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Singapore";
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	$response = curl_exec($ch);
	curl_close($ch);
	
	$response_a = json_decode($response);
	$lat = $response_a->results[0]->geometry->location->lat;
	$long = $response_a->results[0]->geometry->location->lng;
	
	return ['lat' => $lat, 'long' => $long];
}


function stringSimilarity($db_phrase)
{
	$catagories = explode(',', $db_phrase);
	$max_similarity = 0;
	
	foreach($catagories as $cat){
		$sim = similar_text(strtolower($_SESSION['phrase']) , strtolower($cat));
		$max_similarity = $max_similarity > $sim ? $max_similarity : $sim;
	}
	
	return $max_similarity;
}

function textSearch($phrase, $limit = 100)
{
	
	$_SESSION['phrase'] = $phrase;
	

	$db = new SQLite3('Venue.db');
	$db->createFunction("SIMILARITY", "stringSimilarity");
	
	$statement = $db->prepare('SELECT venueId, name, lat, long, categories, SIMILARITY(categories)' .
			" as similarity FROM Venues ORDER BY similarity DESC LIMIT :limit");
	
	
	$statement->bindValue(':limit', $limit);
	
	return  $statement->execute();
}


