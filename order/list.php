<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// include database and restaurant files
include_once '../config/database.php';
include_once '../objects/order.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

if($_SERVER['REQUEST_METHOD'] == 'GET') {
$restaurant_id =  isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : null;
$user_id =  isset($_GET['user_id']) ? $_GET['user_id'] : null;
}

// query products
if($restaurant_id != null)
	$stmt = $order->readWithRestaurantId($restaurant_id);
if($user_id != null)
	$stmt = $order->readWithUserId($user_id);
//else 
//	$stmt = $order->read();

$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

	// products array
	$orders_arr=array();

	// retrieve our table contents
	// fetch() is faster than fetchAll()
	// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// extract row
		// this will make $row['name'] to
		// just $name only
		extract($row);

		
		$order_info=array(
			"orderid" => $orderID,
			"restaurantid" => $restaurantSerialNo,
			"userid" => $userSerialNo,
			"date" => $orderDate,
			"status" => $orderStatus,
			"phone" => $deliverPhone,
			"address" => $deliverAddress,
			"latitude" => $deliverLat,
			"longitude" => $deliverLng

		);

		array_push($orders_arr, $order_info);
	}

	echo json_encode($orders_arr);
}

else{
    echo json_encode(
		array("message" => "No products found.")
	);
}
?>