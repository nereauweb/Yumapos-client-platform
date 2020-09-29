<script>
	function google_maps_add_marker(map,address,client) {

		var geocoder = new google.maps.Geocoder();

		geocoder.geocode( { 'address': address}, function(results, status) {

			if (status == google.maps.GeocoderStatus.OK) {
				
				console.log('OK geolocated ' + client + ': ' + address);
				
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();

				// SHOW LATITUDE AND LONGITUDE
				//document.getElementById('latitude').innerHTML += latitude;
				//document.getElementById('longitude').innerHTML += longitude;

				// MARKER
				var marker = new google.maps.Marker({
					map: map,
					//icon: "",
					title: '<strong>'+client+'</strong> <br /> ' + address,
					position: {lat: latitude, lng: longitude}
				});

				// INFO WINDOW
				var infowindow = new google.maps.InfoWindow();
				infowindow.setContent('<strong>'+client+'</strong> <br /> ' + address);

				//infowindow.open(map, marker);
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, marker);
				});

			} else {
				console.log(status);
				console.log('no geolocation ' + client + ': ' + address);
			}

		});

	}
</script>