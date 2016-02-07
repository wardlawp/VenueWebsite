<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<title>Venue Site</title>
<script type="text/javascript">

	var map;
	var markers = [];
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 1.33, lng: 103.89}, 
    		zoom: 12
		});


	$("a.mapLink").each(function() {
		var vals = $(this).attr('value').split(",");
		
		var lat =  parseFloat(vals[0]);
		var lng =  parseFloat(vals[1]);
		var name =  vals[2];
		  
		markers.push( new google.maps.Marker({
			position: {"lat": lat, "lng": lng},
			map: map,
			title: name
		}));
		
		var link = this;
		var marker = markers[markers.length - 1];
		marker.addListener('click', function() {
			map.setZoom(18);
			map.setCenter(marker.getPosition());
			markers.forEach(function(marker){ marker.setAnimation();});
			marker.setAnimation(google.maps.Animation.BOUNCE);
			$(link).focus();
		});

		$(this).click(function() {
			map.setZoom(18);
			map.setCenter(marker.getPosition());

			markers.forEach(function(marker){ marker.setAnimation();});
			
			marker.setAnimation(google.maps.Animation.BOUNCE);
			
		
		});

		
		  
	});

	google.maps.event.addListener(map, "click", function (event) {
	    $("#form_lat").val(event.latLng.lat());
	    $("#form_long").val( event.latLng.lng());
	    $("#form_location").val("Clicked location");
	    $("#search").submit();
	    
	}); 



	var latlngbounds = new google.maps.LatLngBounds();
	for (var i = 0; i < markers.length; i++) {
		latlngbounds.extend(markers[i].getPosition());
	}
	map.fitBounds(latlngbounds);
	  
	}
	
</script>
   
    

<style type="text/css">
.FormBar{
  width:100%;
  height:50px;
  left: 0px;
  float:left;
  position: fixed;
  top: 0px;
  z-index: 1;
  background-color:#005ce6;	
}

.LeftBar{
	position: fixed;
    top: 0px;
    left: 0px;
    padding-top: 50px;
    padding-bottom: 0;
    height: 100%;
    width: 300px;
    background-color:#0066ff;
    overflow:scroll;
}

.Content{
	position: fixed;
    top: 50px;
    left: 300px;
    width:100%;
    height:100%;
}

.venue {
    background: #1a75ff;
    margin-top: 10px;
    margin-bottom: 10px;
    overflow: hidden;
    padding: 5px .5%;
    position: relative;
    width: auto;
}

.floating-box {
    display: inline-block;
    margin-right: 20px;
}

#map {
 height: 100%;
}

</style>

</head>
<body>

<?php 
	var_dump($_GET);
	include_once 'db_retieve.php';
?>


<div class="FormBar"> 
	<div class="floating-box">
		<h2>Venue Site</h2>
	</div>
	<div class="floating-box">
		<form action="/venue"  method="get" id="search"> 
		 	Location:
			<input  style="display: inline;" type="text" name="location" 
				value="<?php echo isset($_GET['location'])? $_GET['location'] : '' ?>"
				placeholder="Enter a location here"  id="form_location">

			<?php $dist =  isset($_GET['distance'])? $_GET['distance'] : 0 ?>
		 	Distance:
			<select  style="display: inline;"name="distance">
				<option value="5000" <?php echo $dist == 5000 ? 'selected': '' ?>>5km</option>
				<option value="10000" <?php echo $dist == 10000 ? 'selected': '' ?>>10km</option>
				<option value="15000" <?php echo $dist == 15000 ? 'selected': '' ?>>15km</option>
			</select>
			Search Phrase:
			<input type="text"  style="display: inline;" name="keyword"
				value="<?php echo isset($_GET['keyword'])? $_GET['keyword'] : '' ?>"
				placeholder="Something like 'Pizza'">

			
			<input type="text"  style="display: none;" name="lat" id="form_lat"
				value="<?php echo isset($_GET['lat'])? $_GET['lat'] : '' ?>">
			<input type="text"  style="display: none;" name="long" id="form_long" 
				value="<?php echo isset($_GET['long'])? $_GET['long'] : '' ?>">
			<input  style="display: inline;" type="submit" value="Search">
		</form>
	
	</div>
</div>

<div class="LeftBar"> 
<?php 
	if(isset($venues)){
		while ($venue = $venues->fetchArray()){
			echo '<div class ="venue">';
			echo '<p>' .$venue['name'] . '</p>';
			echo '<p>' .$venue['categories'] . '</p>';
			echo '<a class="mapLink" value="'.$venue['lat'] . ',' . $venue['long'] .  ',' . $venue['name'] .  '"> See on Map </a>';
			echo '</div>';
			
		}
	}
?>

</div>

<div class="content">

<div id="map"></div>
 <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-C_CEWwKx2C8THaIM4bByzx2yBaza_HM&callback=initMap">
    </script>

</div>

</body>
</html>