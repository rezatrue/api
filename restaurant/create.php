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
include_once '../objects/restaurant.php';
 
$database = new Database();
$db = $database->getConnection();
 
$restaurant = new Restaurant($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

$pid = $data->phone;


$imageName = '../images/restaurant/'. $pid . '.jpg';
$imageData = base64_decode($data->base64encodedImage);
$source = imagecreatefromstring($imageData);
$rotate = imagerotate($source, $angle, 0); // if want to rotate the image
$imageSave = imagejpeg($rotate,$imageName,100);
imagedestroy($source);




// set product property values
$restaurant->restaurantName = $data->name;
$restaurant->restaurantImageUrl = 'images/restaurant/'. $pid . '.jpg';
$restaurant->restaurantAddress = $data->address;
$restaurant->restaurantPhone = $pid;
$restaurant->restaurantLatitude = $data->latitude;
$restaurant->restaurantLongitude = $data->longitude;
$restaurant->userSerialNo = $data->userid;
$restaurant->restaurantCreated = date('Y-m-d H:i:s');

if($restaurant->create()){
	$status = "ok";
	$name = $restaurant->restaurantName;
}else {
	$status = "failed";
	$name = "null";
}


echo json_encode(array("response" => $status ,"name" => $name));



?>