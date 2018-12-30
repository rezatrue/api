<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// include database and object files
include_once '../config/database.php';
include_once '../objects/type.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$type = new Type($db);


if($_SERVER['REQUEST_METHOD'] == 'GET') {
$type_id =  isset($_GET['type_id']) ? $_GET['type_id'] : null;
}

// query products
if($type_id != null || $type_id != 0 )
	$stmt = $type->readTypeId($type_id);
else 
	$stmt = $type->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

	// products array
	$types_arr=array();

	// retrieve our table contents
	// fetch() is faster than fetchAll()
	// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// extract row
		// this will make $row['name'] to
		// just $name only
		extract($row);
		
		
		$res_type=array(
			"typeid" => $typeID,
			"resType" => $resType,
		);

		array_push($types_arr, $res_type);
	}

	echo json_encode($types_arr);
}

else{
    echo json_encode(
		array("message" => "No products found.")
	);
}
?>