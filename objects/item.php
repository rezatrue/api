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
	public $itemCreated;
	
	public $created;

	// constructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}
	
	// read products
	function read(){

	// select all query
	//SELECT itemSerialNo, itemImageUrl, itemName, itemCatId, itemDescription, itemPrice, itemCreated FROM tbl_items WHERE 1 ORDER BY itemCreated DESC;
	$query = "SELECT
				itemSerialNo, itemImageUrl, itemName, itemCatId, itemDescription, itemPrice, itemCreated, itemModified
			FROM
				" . $this->table_name . " ORDER BY itemCreated DESC";

	// prepare query statement
	$stmt = $this->conn->prepare($query);

	// execute query
	$stmt->execute();

	return $stmt;
}

	
	
}