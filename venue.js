// Javascript file for google maps integration

// The google map we will be using, and the markers we will be displaying
var map;
var markers = [];
	
// initMap() is called by google maps and used to set up the map correctly
function initMap() {
	
	// Center the map at home_lat home_long
	map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: parseFloat($('meta[name=home_lat]').attr("content")), lng:  parseFloat($('meta[name=home_long]').attr("content"))}, 
		zoom: 12
	});

	// Look at the map links and create markers for each of them
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
		
		// Bind a click method so that when markers are clicked they highlight the venue in question
		var link = this;
		var marker = markers[markers.length - 1];
		marker.addListener('click', function() {
			// Focus on the marker
			map.setZoom(18);
			map.setCenter(marker.getPosition());
			
			// Animare the marker (make it bounce)
			markers.forEach(function(marker){ marker.setAnimation();});
			marker.setAnimation(google.maps.Animation.BOUNCE);
			
			// Scroll to and highlight the Venue info on the left pannel
			$('#LeftBar').animate({scrollTop: $(link).closest(".venue").offset().top - $('#LeftBar').offset().top + $('#LeftBar').scrollTop() - 50});
			$(link.closest(".venue")).effect("highlight", {}, 3000);
		});
	
		// Bind a method so that when a link is clicked the map will focus on the venue in question
		$(this).click(function() {
			map.setZoom(18);
			map.setCenter(marker.getPosition());
	
			// Animare the marker (make it bounce)
			markers.forEach(function(marker){ marker.setAnimation();});
			marker.setAnimation(google.maps.Animation.BOUNCE);
		});  
	});
	
	var geocoder = new google.maps.Geocoder;	
	// Bind an event so when the map is clicked it will prepopulate the search bar with location info
	google.maps.event.addListener(map, "click", function (event) {
		//Get  the lat and long and set it to the private fields in the form
		$("#form_lat").val(event.latLng.lat());
	    $("#form_long").val( event.latLng.lng());
	
	    // Get the location name
		geocoder.geocode({'location': event.latLng}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				$("#form_location").val(results[1].formatted_address);
			} else {
				$("#form_location").val("Clicked location");
			}
		});
	
		// Highlight the form bar so the user understands what has happened
	    $(".FormBar").effect("highlight", {}, 1000);
	    $("#form_location").effect("highlight", {}, 2000);
	}); 
	
	// If markers are present center the map so that it shows all of them nicely
	if( markers.length > 0){
		var latlngbounds = new google.maps.LatLngBounds();
		for (var i = 0; i < markers.length; i++) {
			latlngbounds.extend(markers[i].getPosition());
		}
		map.fitBounds(latlngbounds);
	}
}