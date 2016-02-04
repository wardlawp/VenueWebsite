<?php
    include_once 'SearchMethods.php';
    
    $limit = 50;
    $venues = null;
    
    if(isset($_GET['category'])){
    	$venues = textSearch($_GET['category'], $limit);
    } else if (isset($_GET['location']) && isset($_GET['distance'])){
    	
		$location = getGoogleGeoCode($_GET['location']);
    	$venues = locationSearch($location['lat'], $location['long'], $_GET['distance']);
    	var_dump($venues);
    }