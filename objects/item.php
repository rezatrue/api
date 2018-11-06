<?php
class Item{

	// database connection and table name
	private $conn;
	private $table_name = "tbl_items";

	// object properties
	public $itemSerialNo;
	public $itemImageUrl;
	public $itemName;
	public $itemCatId;
	public $itemDescription;
	public $itemPrice;
	public $restaurantSerialNo;
	public $itemCreated;
	//public $itemTimeStamp;
	
	// constructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}
	
	// read products
	function read(){

	// select all query
	//SELECT itemSerialNo, itemImageUrl, itemName, itemCatId, itemDescription, itemPrice, restaurantSerialNo, itemCreated FROM tbl_items WHERE 1 ORDER BY itemCreated DESC;
	$query = "SELECT
				itemSerialNo, itemImageUrl, itemName, itemCatId, itemDescription, itemPrice, restaurantSerialNo, itemCreated, itemModified
			FROM
				" . $this->table_name . " ORDER BY itemCreated ASC";

	// prepare query statement
	$stmt = $this->conn->prepare($query);

	// execute query
	$stmt->execute();

	return $stmt;
}


// read specific restaurant 
	function readWithId($restaurant_id){
	
	$query = "SELECT
					itemSerialNo, itemImageUrl, itemName, itemCatId, itemDescription, itemPrice, restaurantSerialNo, itemCreated, itemModified
				FROM
					" . $this->table_name . " WHERE restaurantSerialNo = ?";
	
	// prepare query statement
	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $restaurant_id);
	
	// execute query
	$stmt->execute();

	return $stmt;
	
	}



	
	// create product
	function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                itemName=:name, itemImageUrl=:imageurl, itemPrice=:price, restaurantSerialNo=:restaurant_id, itemDescription=:description, itemCatId=:category_id, itemCreated=:created";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->itemName=htmlspecialchars(strip_tags($this->itemName));
	$this->itemImageUrl=htmlspecialchars(strip_tags($this->itemImageUrl));
    $this->itemPrice=htmlspecialchars(strip_tags($this->itemPrice));
	$this->restaurantSerialNo=htmlspecialchars(strip_tags($this->restaurantSerialNo));
    $this->itemDescription=htmlspecialchars(strip_tags($this->itemDescription));
    $this->itemCatId=htmlspecialchars(strip_tags($this->itemCatId));
    $this->itemCreated=htmlspecialchars(strip_tags($this->itemCreated));
	//$this->itemTimeStamp=htmlspecialchars(strip_tags($this->itemTimeStamp));  // , itemTimeStamp=:timeStamp
    
	// bind values
    $stmt->bindParam(":name", $this->itemName);
	$stmt->bindParam(":imageurl", $this->itemImageUrl);
    $stmt->bindParam(":price", $this->itemPrice);
	$stmt->bindParam(":restaurant_id", $this->restaurantSerialNo);
    $stmt->bindParam(":description", $this->itemDescription);
    $stmt->bindParam(":category_id", $this->itemCatId);
    $stmt->bindParam(":created", $this->itemCreated);
	//$stmt->bindParam(":timeStamp", $this->itemTimeStamp);
	
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
	
	
}