<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// include database and object files
include_once '../config/database.php';
include_once '../objects/item.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$item = new Item($db);


if($_SERVER['REQUEST_METHOD'] == 'GET') {
$restaurant_id =  isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : null;
}

// query products
if($restaurant_id != null || $restaurant_id != 0 )
	$stmt = $item->readWithId($restaurant_id);
else 
	$stmt = $item->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

	// products array
	$products_arr=array();
	$products_arr["items"]=array();

	// retrieve our table contents
	// fetch() is faster than fetchAll()
	// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// extract row
		// this will make $row['name'] to
		// just $name only
		extract($row);

		$product_item=array(
			"serialno" => $itemSerialNo,
			"imageurl" => $itemImageUrl,
			"name" => $itemName,
			"category" => $itemCatId,
			"description" => html_entity_decode($itemDescription),
			"price" => $itemPrice,
			"restaurantid" => $restaurantSerialNo,
			"created" => $itemCreated
		);

		array_push($products_arr["items"], $product_item);
	}

	echo json_encode($products_arr);
}

else{
    echo json_encode(
		array("message" => "No products found.")
	);
}
?>