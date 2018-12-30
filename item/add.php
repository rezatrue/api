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
include_once '../objects/item.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Item($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
$pid = date('YmdHis');
// set product property values
$item->itemName = $data->name;
//$item->itemImageUrl = $data->imageurl;
$item->itemImageUrl = 'images/item/'. $pid . '.jpg';
$item->itemPrice = $data->price;
$item->itemDescription = $data->description;
$item->itemCatId = $data->category;
$item->itemCreated = date('Y-m-d H:i:s');
$item->restaurantSerialNo = $data->restaurantid;
$item->itemModified = $item->itemCreated;


if($item->create()){
	// copy image
	
	$imageName = '../images/item/'. $pid . '.jpg';
	$imageData = base64_decode($data->base64encodedImage);
	file_put_contents($imageName, $imageData);
	
	// response status
	$status = "ok";
	$name = $item->itemName;

}else {
	$status = "failed";
	$name = "null";

}

echo json_encode(array("response" => $status ,"name" => $name));

?>