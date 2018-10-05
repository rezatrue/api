<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);

// please apply post later
if($_SERVER['REQUEST_METHOD'] == 'GET') {
$user_email =  isset($_GET['email']) ? $_GET['email'] : null;
$user_password = isset($_GET['password']) ? $_GET['password'] : null;
}

// query user
$stmt = $user->login($user_email, $user_password); // need to pass parameter
$num = $stmt->rowCount();

// check if more than 0 record found

$status = "failed";
$name = "null";
if($num > 0){
	
	$user_arr=array();
	$user_arr["user"]=array();
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		 $name = $row['userName'];
		 $status = "ok";
		 
		 $user_entity=array(
			"userName"	=> $row['userName'],
		);

		array_push($user_arr["user"], $user_entity);
	}
	
	echo json_encode($user_arr);
}

else{
    echo json_encode(
		array("message" => "No user found.")
	);

?>