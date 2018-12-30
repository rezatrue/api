<?php
class Type{

	// database connection and table name
	private $conn;
	private $table_name = "tbl_type";

	// object properties
	public $typeID;
	public $resType;
	
	
	// constructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}
	
	// read products
	function read(){

	// select all query
	$query = "SELECT
				typeID, resType
			FROM
				" . $this->table_name . " ORDER BY typeID ASC";

	// prepare query statement
	$stmt = $this->conn->prepare($query);

	// execute query
	$stmt->execute();

	return $stmt;
}

// read specific restaurant 
	function readTypeId($type_id){
	
	$query = "SELECT
					typeID, resType
				FROM
					" . $this->table_name . " WHERE typeID = ?";
	
	// prepare query statement
	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $type_id);
	
	// execute query
	$stmt->execute();

	return $stmt;
	
	}

	// create product
	function create(){
     if($this->itemName == "" || $this->itemPrice == 0) return false;
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                typeID=:typeid, resType=:restype";
				
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->typeID=htmlspecialchars(strip_tags($this->typeID));
	$this->resType=htmlspecialchars(strip_tags($this->resType)); 
    
	// bind values
    $stmt->bindParam(":typeid", $this->typeID);
	$stmt->bindParam(":restype", $this->resType);

	
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
	
	
}

	
