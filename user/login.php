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
$user_email =  isset($_GET['user_email']) ? $_GET['user_email'] : null;
$user_password = isset($_GET['user_password']) ? $_GET['user_password'] : null;
}

// query user
$stmt = $user->login($user_email, $user_password); // need to pass parameter
$num = $stmt->rowCount();

// check if more than 0 record found

$status = "failed";
$name = "";
$id = "";
if($num > 0){
	// retrieve our table contents
	// fetch() is faster than fetchAll()
	// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		 $name = $row['userName'];
		 $id = $row['userSerialNo'];
		 if($name != null) {
			$status = "ok";
		 }else {
			$name = ""; 
		 }
	}
}

echo json_encode(array("response" => $status ,"name" => $name,"userid" => $id));

?>