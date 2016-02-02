<html>
<head><title>Addition php</title></head>
<body>

<?php
    $db = new SQLite3('Venue.db');

    
     function distance($lat, $long) {
       return sqrt(($lat - 1.316272824483)**2 + ($long -  103.87997271077)**2);
    }

    $db->createFunction("DISTANCE", "distance");
    
    $statement = $db->prepare('SELECT venueId, DISTANCE(lat, long) as distance FROM Venues ORDER BY distance ASC LIMIT 5');
    //$statement->bindValue(':id', '4d86d4acf1e56ea8c358a58a');
    $statement->bindValue(':input_lat', 1.316272824483);
    $statement->bindValue(':input_lat', 103.87997271077);

    
    $results = $statement->execute();
    
    while ($row = $results->fetchArray()) {
        var_dump($row);
    }

?>

</body>
</html>

