<?php
class Restaurant{

	// database connection and table name
	private $conn;
	private $table_name = "tbl_restaurants";

	// restaurant properties
	public $restaurantSerialNo;
	public $restaurantImageUrl;
	public $restaurantName;
	public $restaurantAddress;
	public $restaurantPhone;
	public $restaurantLatitude;
	public $restaurantLongitude;
	public $userSerialNo;
	public $restaurantCreated;
	
	// constructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}
	
	// read all restaurants
	function read(){

	// select all query
	
	$query = "SELECT
				restaurantSerialNo, restaurantImageUrl, restaurantName, restaurantAddress, restaurantPhone, restaurantLatitude, restaurantLongitude, userSerialNo, restaurantCreated
			FROM
				" . $this->table_name . " ORDER BY restaurantCreated ASC";

	// prepare query statement
	$stmt = $this->conn->prepare($query);

	// execute query
	$stmt->execute();

	return $stmt;
	}


// read specific owner restaurants 
	function readWithId($user_id){

	$query = "SELECT
				restaurantSerialNo, restaurantImageUrl, restaurantName, restaurantAddress, restaurantPhone, restaurantLatitude, restaurantLongitude, userSerialNo, restaurantCreated
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
	function createRestaurant(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                restaurantName=:name, restaurantImageUrl=:imageurl, restaurantAddress=:address, restaurantPhone=:phone, restaurantLatitude=:latitude, restaurantLongitude=:longitude, userSerialNo=:userSerial, restaurantCreated=:created";
 
    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->restaurantName=htmlspecialchars(strip_tags($this->restaurantName));
	$this->restaurantImageUrl=htmlspecialchars(strip_tags($this->restaurantImageUrl));
    $this->restaurantAddress=htmlspecialchars(strip_tags($this->restaurantAddress));
	$this->restaurantPhone=htmlspecialchars(strip_tags($this->restaurantPhone));
    $this->restaurantLatitude=htmlspecialchars(strip_tags($this->restaurantLatitude));
    $this->restaurantLongitude=htmlspecialchars(strip_tags($this->restaurantLongitude));
    $this->userSerialNo=htmlspecialchars(strip_tags($this->userSerialNo));
    $this->restaurantCreated=htmlspecialchars(strip_tags($this->restaurantCreated));
	
	// bind values
    $stmt->bindParam(":name", $this->restaurantName);
	$stmt->bindParam(":imageurl", $this->restaurantImageUrl);
    $stmt->bindParam(":address", $this->restaurantAddress);
	$stmt->bindParam(":phone", $this->restaurantPhone);
    $stmt->bindParam(":latitude", $this->restaurantLatitude);
    $stmt->bindParam(":longitude", $this->restaurantLongitude);
    $stmt->bindParam(":userSerial", $this->userSerialNo);
	$stmt->bindParam(":created", $this->restaurantCreated);

	
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
	
	
	
	
}