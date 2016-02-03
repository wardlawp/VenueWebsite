<html>
<head><title>Database Test</title></head>
<body>

<h1>Location Test</h1>
<?php
    include_once 'SearchMethods.php';


    $results = locationSearch(1.316272824483, 103.87997271077, 50);
    
    while ($row = $results->fetchArray()) {
        echo '<p>';
    	var_dump($row['name'], $row['distance'], $row['categories']);
    	echo '</p>';
    }

?>
<h1>Similarity Test</h1>
<?php
   


    $results = textSearch('pizz', 5);
    
    while ($row = $results->fetchArray()) {
        echo '<p>';
    	var_dump($row['name'], $row['categories'], $row['similarity']);
    	echo '</p>';
    }

?>
</body>
</html>

