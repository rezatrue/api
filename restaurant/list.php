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

if($_SERVER['REQUEST_METHOD'] == 'GET') {
$user_id =  isset($_GET['user_id']) ? $_GET['user_id'] : null;
}

// query products
if($user_id != null)
	$stmt = $restaurant->readWithId($user_id);
else 
	$stmt = $restaurant->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

	// products array
	$restaurants_arr=array();
	$restaurants_arr["restaurants"]=array();

	// retrieve our table contents
	// fetch() is faster than fetchAll()
	// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// extract row
		// this will make $row['name'] to
		// just $name only
		extract($row);

		
		$restaurant_info=array(
			"serialno" => $restaurantSerialNo,
			"imageurl" => $restaurantImageUrl,
			"name" => $restaurantName,
			"address" => $restaurantAddress,
			"phone" => $restaurantPhone,
			"latitude" => $restaurantLatitude,
			"longitude" => $restaurantLongitude,
			"userid" => $userSerialNo,
			"created" => $restaurantCreated
		);

		array_push($restaurants_arr["restaurants"], $restaurant_info);
	}

	echo json_encode($restaurants_arr);
}

else{
    echo json_encode(
		array("message" => "No products found.")
	);
}
?>