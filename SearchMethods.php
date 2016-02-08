<?php
	include_once 'config.php';
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
	
	/**
	 * Determine how similar a string describing a category taken 
	 * from the database is with string $_SESSION['keyword']
	 * Use in SQL query
	 * 
	 * Returns integer of matching characters
	 */
	function stringSimilarity($db_phrase)
	{
		$catagories = explode(',', $db_phrase);
		$max_similarity = 0;
	
		foreach($catagories as $cat){
			$sim = similar_text(strtolower($_SESSION['keyword']) , strtolower($cat));
			$max_similarity = $max_similarity > $sim ? $max_similarity : $sim;
		}
	
		return $max_similarity;
	}
	

	
	/**
	 * Get a list of venues which are whitin $distance of location ($lat, long)
	 * and have a category similar to $keyword
	 * 
	 * returns list of venue information
	 */
	function locationKeywordSearch($lat, $long, $keyword, $distance,  $limit = 25) 
	{
	
		$_SESSION['lat'] = $lat;
		$_SESSION['long'] = $long;
		$_SESSION['keyword'] = $keyword;
	
		global $databaseName;
		$db = new SQLite3($databaseName);
		
		// Attach methods haversineGreatCircleDistance,stringSimilarity to
		// Database engine so that we can use them in our query
		$db->createFunction("DISTANCE", "haversineGreatCircleDistance");
		$db->createFunction("SIMILARITY", "stringSimilarity");
	
		// Search query: get venue information for venues close to location, with categories most similar to the keyword/phrase
		$statement = $db->prepare('SELECT venueId, name, lat, long, categories, address, DISTANCE(lat, long) as distance, SIMILARITY(categories)' .
				" as similarity FROM Venues WHERE distance < :dist ORDER BY similarity DESC LIMIT :limit");
	
	
		// Bind some parameters to the query
		$statement->bindValue(':limit', $limit);
		$statement->bindValue(':dist', $distance, SQLITE3_INTEGER);
		
		// Obtain the venues from the db and put them in a list
		$qry = $statement->execute();
		$venues = [];
		
		while ($venue = $qry->fetchArray())
		{
			$venues[] = $venue;
		}
		
		$db->close();
		
		return $venues;
	}
	
	/**
	 * Use Google geo code services to get lat/long coordinates for a location
	 */
	function getGoogleGeoCode($address)
	{
		global $homeCountry;
		$address = urlencode($address . $homeCountry); 
		$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$homeCountry";
		
		// Use curl to make the GET request
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		// Process Google's response and get the lat/long
		$response = curl_exec($ch);
		curl_close($ch);
		
		$response_a = json_decode($response);
		$lat = $response_a->results[0]->geometry->location->lat;
		$long = $response_a->results[0]->geometry->location->lng;
		
		return ['lat' => $lat, 'long' => $long];
	}
	
	
	
