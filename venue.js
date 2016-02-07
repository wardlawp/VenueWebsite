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
			$('#LeftBar').animate({scrollTop: $(link).closest(".venue").offset().top - $('#LeftBar').offset().top + $('#LeftBar').scrollTop() - 50});
			$(link.closest(".venue")).effect("highlight", {}, 3000);
		});
	
		$(this).click(function() {
			map.setZoom(18);
			map.setCenter(marker.getPosition());
	
			markers.forEach(function(marker){ marker.setAnimation();});
			
			marker.setAnimation(google.maps.Animation.BOUNCE);
			
		
		});
	
		
		  
	});
	
	var geocoder = new google.maps.Geocoder;	
	google.maps.event.addListener(map, "click", function (event) {
	    $("#form_lat").val(event.latLng.lat());
	    $("#form_long").val( event.latLng.lng());
	
	
	    
		geocoder.geocode({'location': event.latLng}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				$("#form_location").val(results[1].formatted_address);
			} else {
				$("#form_location").val("Clicked location");
			}
		});
	
	
	
	    
	    $(".FormBar").effect("highlight", {}, 1000);
	    $("#form_location").effect("highlight", {}, 2000);
	}); 
	
	
	
	var latlngbounds = new google.maps.LatLngBounds();
	for (var i = 0; i < markers.length; i++) {
		latlngbounds.extend(markers[i].getPosition());
	}
	map.fitBounds(latlngbounds);
  
}