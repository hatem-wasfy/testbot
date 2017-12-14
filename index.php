<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->text;

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
