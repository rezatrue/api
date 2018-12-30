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

if($_SERVER['REQUEST_METHOD'] == 'GET') {
$userid =  isset($_GET['user_id']) ? $_GET['user_id'] : null;
}

if($userid != null){
$stmt = $user->searchUser($userid);
$num = $stmt->rowCount();

	if($num > 0){
		
			$user_arr=array();
		// fetch() is faster than fetchAll()
		// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			 extract($row);
			$user_info=array(
				"serialno" => $userSerialNo,
				"name" => $userName,
				"email" => $userEmail,
				"phone" => $userPhone,
				"created" => $userCreated
			);

			array_push($user_arr, $user_info);
			 }
		echo json_encode($user_info);
	}
	else{
		echo json_encode(
			array("message" => "User Not found.")
		);
	}
}	
else{
    echo json_encode(
		array("message" => "User Not found.")
	);
}
?>