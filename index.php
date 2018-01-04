<?php
// address to map
$map_address = "";
$url = "http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=".urlencode($map_address);
$lat_long = get_object_vars(json_decode(file_get_contents($url)));
// pick out what we need (lat,lng)
$lat_long = $lat_long['results'][0]->geometry->location->lat . "," . $lat_long['results'][0]->geometry->location->lng;
?>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<div id="map_canvas"></div>
			
<script>
(function() { 
function initialize() {
	var myLatlng = new google.maps.LatLng(<?php echo $lat_long; ?>),
	mapOptions = {
		zoom: 15,
		center: myLatlng
	},
	map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions),
	marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: '<?php echo $map_address; ?>'
	});
}
google.maps.event.addDomListener(window, 'load', initialize);
})();
</script>
