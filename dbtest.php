<html>
<head><title>Database Test</title></head>
<body>

<h1>Search Test</h1>
<?php
    include_once 'SearchMethods.php';

    $location = getGoogleGeoCode('novea');
    $results = locationKeywordSearch($location['lat'], $location['long'], 'pizza', 5000);
    
    while ($row = $results->fetchArray()) {
        echo '<p>';
    	var_dump($row['name'], $row['distance'], $row['categories']);
    	echo '</p>';
    }

?>

</body>
</html>

