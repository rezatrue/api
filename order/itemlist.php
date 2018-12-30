<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// include database and restaurant files
include_once '../config/database.php';
include_once '../objects/orderitem.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$orderitem = new Orderitem($db);

if($_SERVER['REQUEST_METHOD'] == 'GET') {
$order_id =  isset($_GET['order_id']) ? $_GET['order_id'] : null;
$user_id =  isset($_GET['user_id']) ? $_GET['user_id'] : null;
}

// query products
if($order_id != null && $user_id != null)
	$stmt = $orderitem->readWithOrderSerial($order_id, $user_id);
else{
    echo json_encode(	array("message" => "No products found.")	);
	return;
	}
	
$num = $stmt->rowCount();

// check if more than 0 record found
if($num > 0){

	// products array
	$item_arr=array();

	// retrieve our table contents
	// fetch() is faster than fetchAll()
	// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// extract row
		// this will make $row['name'] to
		// just $name only
		extract($row);

		$item_info=array(
			"orderid" => $orderID,
			"userid" => $userSerialNo,
			"id" => $itemSerialNo,
			"name" => $itemName,
			"quantity" => $itemQuantity,
			"price" => $itemPrice
		);

		array_push($item_arr, $item_info);
	}

	echo json_encode($item_arr);
}

else{
    echo json_encode(
		array("message" => "No products found.1")
	);
}
?>