<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->city;
////java script for google maps api/////////////////////////
	//echo "<script type='text/javascript'>
          //      alert('JavaScript is awesome!');
            //</script>";
///////////////////////////////////////////////////////////
	
	switch ($text) {
		case 'Tokyo':
			//$speech = "Tokyo is a beauiful city, I'll tell you what places to visit there. Here we go, check this https://www.google.com/maps/search/places+near+Tokyo";
			$speech = "Tokyo is a beauiful city, I'll tell you what places to visit there. Here we go";
			
			break;

		case 'Fukuoka':
			$speech = "Fukuoka is a beauiful city, I'll tell you what places to visit there.";
			break;

		case 'Alexandria':
			$speech = "Alexandria is a beauiful city, I'll tell you what places to visit there.";
			break;
		
		default:
			$speech = "Sorry, I didnt get that. Please ask me something else.";
			break;
	}

	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>


//-----------------------------------------------------------------

    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 100%;
      }

      #right-panel i {
        font-size: 12px;
      }
      #right-panel {
        font-family: Arial, Helvetica, sans-serif;
        position: absolute;
        right: 5px;
        top: 60%;
        margin-top: -195px;
        height: 330px;
        width: 200px;
        padding: 5px;
        z-index: 5;
        border: 1px solid #999;
        background: #fff;
      }
      h2 {
        font-size: 22px;
        margin: 0 0 5px 0;
      }
      ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        height: 271px;
        width: 200px;
        overflow-y: scroll;
      }
      li {
        background-color: #f1f1f1;
        padding: 10px;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
      }
      li:nth-child(odd) {
        background-color: #fcfcfc;
      }
      #more {
        width: 100%;
        margin: 5px 0 0 0;
      }
    </style>





<script>
	//////////////////////////////////////////////////////////////////////////////////////
	var geocoder;
	var map;
	//var address = "Tokyo";
	var address = " <?php echo $text ?> ";
	var typeinp = ""; //"store";//"restaurant";
	//hatem check types https://developers.google.com/places/supported_types
	
  
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
      zoom: 8,
      center: latlng
    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
	// hatem ;)
	codeAddress();
	//
	
	//
	geocoder.geocode( { 'address': address}, function(results, status) {
	pyrmont = results[0].geometry.location;
	///alert('pyrmont inside geco is now: ' + pyrmont);
	//
	initMap();
	//
	});
	
	//
	//alert('geocoder is now: ' + geocoder);
	///alert('pyrmont is now: ' + pyrmont);
	//alert('px is now: ' + px);

	//alert('latlng is now: ' + latlng);
	
	
	
  }
  
  
  

  function codeAddress() {
    //var address = document.getElementById('address').value;
		// hatem, here i put city name
		//var address = "Tokyo";
		
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {

		//
		pyrmont = results[0].geometry.location;
		//
			///alert('pyrmont inside codeAddress function is now: ' + pyrmont);

        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
	
	
	
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////
	
// var val = " <?php echo $val ?> ";
	
	
	
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      //var map;

      function initMap() {
        //var pyrmont = {lat: -33.866, lng: 151.196};

        map = new google.maps.Map(document.getElementById('map'), {
          center: pyrmont,
          zoom: 17
        });

        var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: pyrmont,
          radius: 500,
          type: typeinp //'restaurant' //type: ['store']
        }, processResults);
      }

      function processResults(results, status, pagination) {
        if (status !== google.maps.places.PlacesServiceStatus.OK) {
          return;
        } else {
          createMarkers(results);

          if (pagination.hasNextPage) {
            var moreButton = document.getElementById('more');

            moreButton.disabled = false;

            moreButton.addEventListener('click', function() {
              moreButton.disabled = true;
              pagination.nextPage();
            });
          }
        }
      }

      function createMarkers(places) {
        var bounds = new google.maps.LatLngBounds();
        var placesList = document.getElementById('places');

        for (var i = 0, place; place = places[i]; i++) {
          var image = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

          var marker = new google.maps.Marker({
            map: map,
            icon: image,
            title: place.name,
            position: place.geometry.location
          });

          placesList.innerHTML += '<li>' + place.name + '</li>';

          bounds.extend(place.geometry.location);
        }
        map.fitBounds(bounds);
      }
    </script>
  </head>
  <body onload="initialize()">
    <div id="map"></div>
    <div id="right-panel">
      <h2>Results</h2>
      <ul id="places"></ul>
      <button id="more">More results</button>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADsZZiGIWF2laJkl5qNE5EUkSXkye4HG4&libraries=places&callback=initMap" async defer></script>






//.......................................................
