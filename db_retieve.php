<?php
    include_once 'SearchMethods.php';
    
    $limit = 50;
    $venues = null;

    if(isset($_GET['keyword']) &&
    		(isset($_GET['location']) || (!empty($_GET['lat']) && !empty($_GET['long']))) &&
    		isset($_GET['distance'])){
    	
    			
    	if(!empty($_GET['lat']) && !empty($_GET['long'])){
    		$location = ['lat' => $_GET['lat'], 'long' => $_GET['long']];
    	} else {
    		$location = getGoogleGeoCode($_GET['location']);
    	}
		
    	$venues = locationKeywordSearch($location['lat'], $location['long'], $_GET['keyword'], $_GET['distance']);

    }