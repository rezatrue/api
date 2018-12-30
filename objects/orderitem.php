<?php
class Orderitem{

	// database connection and table name
	private $conn;
	private $table_name = "tbl_orderitems";

	// object properties
		public $orderID;
		public $userSerialNo;
		public $itemSerialNo;
		public $itemName;
		public $itemQuantity;
		public $itemPrice;
	
	// constructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}
	
	// read products
	function read(){

	// select all query
	$query = "SELECT
				orderID, userSerialNo, itemSerialNo, itemName, itemQuantity, itemPrice
			FROM
				" . $this->table_name . " ORDER BY orderID ASC";

	// prepare query statement
	$stmt = $this->conn->prepare($query);

	// execute query
	$stmt->execute();

	return $stmt;
}

// read specific restaurant 
	function readWithOrderSerial($orderID, $userSerialNo){
	
	$query = "SELECT
					orderID, userSerialNo, itemSerialNo, itemName, itemQuantity, itemPrice
				FROM
					" . $this->table_name . " WHERE orderID = ? AND userSerialNo = ?";
	
	// prepare query statement
	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $orderID);
	$stmt->bindParam(2, $userSerialNo);
	
	// execute query
	$stmt->execute();

	return $stmt;
	
	}

	// create product
	function create(){
     //if($this->orderID == "" || $this->userSerialNo == 0 || $this->itemSerialNo == 0 || $this->itemName == 0 || $this->itemQuantity == 0 || $this->itemPrice == 0) return false;
    
	// query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                orderID=:orderid, userSerialNo=:userserialno, itemSerialNo=:itemserialno, itemName=:name, itemQuantity=:quantity, itemPrice=:price";
				
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->orderID=htmlspecialchars(strip_tags($this->orderID));
	$this->userSerialNo=htmlspecialchars(strip_tags($this->userSerialNo));
	$this->itemSerialNo=htmlspecialchars(strip_tags($this->itemSerialNo));
    $this->itemName=htmlspecialchars(strip_tags($this->itemName));
	$this->itemQuantity=htmlspecialchars(strip_tags($this->itemQuantity));
    $this->itemPrice=htmlspecialchars(strip_tags($this->itemPrice));
    
    
	// bind values
    $stmt->bindParam(":orderid", $this->orderID);
	$stmt->bindParam(":userserialno", $this->userSerialNo);
	$stmt->bindParam(":itemserialno", $this->itemSerialNo);
    $stmt->bindParam(":name", $this->itemName);
	$stmt->bindParam(":quantity", $this->itemQuantity);
    $stmt->bindParam(":price", $this->itemPrice);
   
	
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
	
	
}

	
