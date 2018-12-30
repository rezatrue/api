<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/order.php';
include_once '../objects/orderitem.php';


$database = new Database();
$db = $database->getConnection();
 
$order = new Order($db);
$orderitem = new Orderitem($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

$order->orderID = date('His');
//$order->orderID = $data->orderid; // date('His');
$order->restaurantSerialNo = $data->restaurantid; 	
$order->userSerialNo = $data->userid; 
$orItems = $data->items; // order items	

    $orderitem->orderID = $order->orderID;
	$orderitem->userSerialNo = $order->userSerialNo;
	$error = false;
	foreach ($orItems as $value) {
		$orderitem->itemSerialNo = $value->id;
		$orderitem->itemName = $value->name;
		$orderitem->itemQuantity = $value->quantity;
		$orderitem->itemPrice = $value->price;
		
		if(!($orderitem->create())){
		$error = true;	
		break;
		}
	}

$order->orderDate = date('Y-m-d H:i:s'); // need to set this when order is sent to server 
$order->orderStatus = $data->status; //  when this is created it must set to ZERO status
$order->deliverPhone = $data->phone; 
$order->deliverAddress = $data->address; 	
$order->deliverLat = $data->latitude; 
$order->deliverLng = $data->longitude;


// inserting new restaurant data
$status = "failed";
$id = "null";
if(!$error){  
	if($order->createOrder()){
		// response status
		$status = "ok";
		$id = $order->orderID;
	}
}	
/*
else {
	$status = "failed";
	$id = "null";
}*/

echo json_encode(array("response" => $status ,"id" => $id));

?>