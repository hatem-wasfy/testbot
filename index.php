<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$geo-city = $json->result->parameters->geo-city;

	switch ($geo-city) {
		case 'Tokyo':
			$speech = "Tokyo is fantastic city, let ,e tell you some good places around.";
			break;

		case 'Fukuoka':
			$speech = "Fukuoka is fantastic city, let ,e tell you some good places around.";
			break;

		case 'Alexandria':
			$speech = "Alexandria is fantastic city, let ,e tell you some good places around.";
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