<html>
<head><title>Database Test</title></head>
<body>

<?php
    include_once 'SearchMethods.php';


    $results = locationSearch(1.316272824483, 103.87997271077, 5);
    
    while ($row = $results->fetchArray()) {
        echo '<p>';
    	var_dump($row['name'], $row['lat'], $row['long']);
    	echo '</p>';
    }

?>

</body>
</html>

