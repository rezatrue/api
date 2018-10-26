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
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set user property values
$user->userName = $data->name;
$user->userEmail = $data->email;
$user->userPassword = $data->password;
$user->userPhone = $data->phone;
$user->userCreated = date('Y-m-d H:i:s');

// don't need to return user id now
$id = 0;
if($user->createuser()){
	$status = "ok";
	$name = $user->userName;
}else {
	$status = "failed";
	$name = "null";
}

echo json_encode(array("response" => $status ,"name" => $name,"userid" => $id));

?>