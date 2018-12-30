<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// include database and restaurant files
include_once '../config/database.php';
include_once '../objects/order.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

if($_SERVER['REQUEST_METHOD'] == 'GET') {
$order_id =  isset($_GET['order_id']) ? $_GET['order_id'] : null;
$user_id =  isset($_GET['user_id']) ? $_GET['user_id'] : null;
$status =  isset($_GET['status']) ? $_GET['status'] : null;
}

// query products
if($order_id != null && $user_id != null && $status != null)
	$stmt = $order->updateStatus($order_id, $user_id, $status);
	
echo $num = $stmt->rowCount();


?>