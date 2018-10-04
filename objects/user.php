<?php
class User{

	// database connection and table name
	private $conn;
	private $table_name = "tbl_users";

	// user properties
	public $userSerialNo;
	public $userEmail;
	public $userName;
	public $userPassword;
	public $userPhone;
	public $userCreated;

	
	// constructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}
	
	// read users
	function read(){

	// select all query
	$query = "SELECT
				userSerialNo, userName, userPassword, userPhone, userCreated
			FROM
				" . $this->table_name . " ORDER BY userSerialNo ASC";

	// prepare query statement
	$stmt = $this->conn->prepare($query);

	// execute query
	$stmt->execute();

	return $stmt;
}

	// login user
	function login($email, $password){

	// select all query
	$query = "SELECT userName FROM 
				" . $this->table_name . " WHERE userEmail = ? AND userPassword = ? ORDER BY userSerialNo ASC";

	// prepare query statement
	$stmt = $this->conn->prepare($query);
	
	$stmt->bindParam(1, $email);
	$stmt->bindParam(2, $password);
	// execute query
	$stmt->execute();

	return $stmt;
}


	
	// create product
	function createuser(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                userName=:name, userEmail=:email, userPassword=:password, userPhone=:phone, userCreated=:created";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->userName=htmlspecialchars(strip_tags($this->userName));
	$this->userEmail=htmlspecialchars(strip_tags($this->userEmail));
	$this->userPassword=htmlspecialchars(strip_tags($this->userPassword));
    $this->userPhone=htmlspecialchars(strip_tags($this->userPhone));
    $this->userCreated=htmlspecialchars(strip_tags($this->userCreated));
    
	// bind values
    $stmt->bindParam(":name", $this->userName);
	$stmt->bindParam(":email", $this->userEmail);
	$stmt->bindParam(":password", $this->userPassword);
    $stmt->bindParam(":phone", $this->userPhone);
    $stmt->bindParam(":created", $this->userCreated);
	
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
	
	
}