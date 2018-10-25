<?php

// NOT NEED FOR IMPLEMETAION THIS RIGHT NOW LOGIN IS ENOUGH 

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
$userPhone =  isset($_GET['phone']) ? $_GET['phone'] : null;
$userCreated = isset($_GET['created']) ? $_GET['created'] : null;
}

$stmt = $user->searchUserId($userPhone , $userCreated );

$num = $stmt->rowCount();

// check if more than 0 record found
$status = "failed";
$id = null;
if($num > 0){
	// fetch() is faster than fetchAll()
	// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		 $id = $row['userSerialNo'];
		 if($id == null) {
			$id = 0; 
		 }
	}
}
echo $id;
return $id;

?>