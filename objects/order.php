<?php
class Order{

	// database connection and table name
	private $conn;
	private $table_name = "tbl_orders";

	// object properties
	public $orderID;
    public $restaurantSerialNo; 	
    public $userSerialNo; 	
    public $orderDate; 
    public $orderStatus; 
    public $deliverPhone; 
    public $deliverAddress; 	
    public $deliverLat; 
    public $deliverLng; 
	
	// constructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}
	
	
	// update products
	function updateStatus($order_id, $user_id, $status){
	// UPDATE `tbl_orders` SET `orderStatus`=[value-5] WHERE 1
	
	$query = "UPDATE " . $this->table_name . " SET orderStatus = ? WHERE orderID = ? AND userSerialNo = ?";
	
	// prepare query statement
	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $status);
	$stmt->bindParam(2, $order_id);
	$stmt->bindParam(3, $user_id);
	
	// execute query
	$stmt->execute();

	return $stmt;
}
	
	
	// read products
	function read(){

	// select all query
	//SELECT itemSerialNo, itemImageUrl, itemName, itemCatId, itemDescription, itemPrice, restaurantSerialNo, itemCreated FROM tbl_items WHERE 1 ORDER BY itemCreated DESC;
	$query = "SELECT
				orderID, restaurantSerialNo, userSerialNo, orderDate, orderStatus, deliverPhone, deliverAddress, deliverLat, deliverLng
			FROM
				" . $this->table_name . " ORDER BY orderDate ASC";

	// prepare query statement
	$stmt = $this->conn->prepare($query);

	// execute query
	$stmt->execute();

	return $stmt;
}

// read specific restaurant 
	function readWithRestaurantId($restaurant_id){
	
	$query = "SELECT
					orderID, restaurantSerialNo, userSerialNo, orderDate, orderStatus, deliverPhone, deliverAddress, deliverLat, deliverLng
				FROM
					" . $this->table_name . " WHERE restaurantSerialNo = ?";
	
	// prepare query statement
	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $restaurant_id);
	
	// execute query
	$stmt->execute();

	return $stmt;
	
	}

	
	// read specific restaurant 
	function readWithUserId($user_id){
	
	$query = "SELECT
					orderID, restaurantSerialNo, userSerialNo, orderDate, orderStatus, deliverPhone, deliverAddress, deliverLat, deliverLng
				FROM
					" . $this->table_name . " WHERE userSerialNo = ?";
	
	// prepare query statement
	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $user_id);
	
	// execute query
	$stmt->execute();

	return $stmt;
	
	}
	
	

	// create product
	function createOrder(){
     /*if($this->orderID == "" || $this->restaurantSerialNo == 0 || $this->userSerialNo == 0 
		|| $this->orderDate == 0 || $this->deliverPhone == 0 
		|| $this->deliverAddress == 0 || $this->deliverLat == 0 || $this->deliverLng == 0) return false; */
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                orderID=:oid, restaurantSerialNo=:rserialno, userSerialNo=:userserialno, orderDate=:odate, orderStatus=:ostatus, deliverPhone=:dphone, deliverAddress=:daddresss, deliverLat=:dlat, deliverLng=:dlng";
				
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->orderID=htmlspecialchars(strip_tags($this->orderID));
	$this->restaurantSerialNo=htmlspecialchars(strip_tags($this->restaurantSerialNo));
    $this->userSerialNo=htmlspecialchars(strip_tags($this->userSerialNo));
	$this->orderDate=htmlspecialchars(strip_tags($this->orderDate));
    $this->orderStatus=htmlspecialchars(strip_tags($this->orderStatus));
    $this->deliverPhone=htmlspecialchars(strip_tags($this->deliverPhone));
    $this->deliverAddress=htmlspecialchars(strip_tags($this->deliverAddress));
	$this->deliverLat=htmlspecialchars(strip_tags($this->deliverLat)); 
	$this->deliverLng=htmlspecialchars(strip_tags($this->deliverLng));  
	
    
	// bind values
    $stmt->bindParam(":oid", $this->orderID);
	$stmt->bindParam(":rserialno", $this->restaurantSerialNo);
    $stmt->bindParam(":userserialno", $this->userSerialNo);
	$stmt->bindParam(":odate", $this->orderDate);
    $stmt->bindParam(":ostatus", $this->orderStatus);
    $stmt->bindParam(":dphone", $this->deliverPhone);
    $stmt->bindParam(":daddresss", $this->deliverAddress);
	$stmt->bindParam(":dlat", $this->deliverLat);
	$stmt->bindParam(":dlng", $this->deliverLng);

	
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
	
	
}

	
