<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// include database and restaurant files
include_once '../config/database.php';
include_once '../objects/restaurant.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$restaurant = new Restaurant($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

$res_arr = array();
	foreach ($data as $value) {
		
		$stmt = $restaurant->restaurantName($value);
		$num = $stmt->rowCount();
		if($num > 0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$res_info=array(
					"name" => $restaurantName
				);
				array_push($res_arr, $res_info);
			}
		}

	}
	echo json_encode($res_arr);

?>