<?php

if (isset($_POST['function'])) {
	if($_POST['function'] == "toggle_share"){
		toggleShare($_POST['id'], $_POST['state']);
	}

	return;
}

define("SERVER_NAME", "localhost");
define("SERVER_USER", "root");
define("SERVER_PASSWORD", "dbroot");
define("SERVER_DBNAME", "hz_sharecon");

function add_new_share($data){
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = "INSERT INTO sharedObjects (title, shortdesc, owner) VALUES ('" . $data['title'] . "', '" . $data['shortdesc'] . "', '" . $data['owner'] . "')";
	
	if ($conn->query($sql_query) === TRUE) {
		return "New record created successfully";
	} else {
		return "Error: " . $sql_query . "<br>" . $conn->error;
	}

	$conn->close();
}

function load_shares($args){
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$resArray = array();
	$sql_query = "SELECT * FROM sharedObjects";
	
	if(isset($args['owner'])){
		$sql_query .= " WHERE owner = '" . $args['owner'] . "'";
	}
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$resArray[] = $row;
		}
		return $resArray;
	}
	else return null;

	$conn->close();
}

function load_share_details($shareid){
	header('Content-Type: application/json');
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$resArray = array();
	$sql_query = "SELECT * FROM sharedObjects WHERE ID=" . $shareid;
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$resArray[] = $row;
		}
		return $resArray[0];
	}
	else { return "";}

	$conn->close();
}

function getShareOwner($shareid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$resArray = array();
	$sql_query = "SELECT owner FROM sharedObjects WHERE ID=" . $shareid;
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$resArray[] = $row;
		}
	return $resArray[0]['owner'];
	}
	else { return "";}

	$conn->close();
}

function toggleShare($id, $state){
	$newstate = 1;
	if($state == 1) $newstate = 0;
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = "UPDATE sharedObjects SET State=" . $newstate . " WHERE ID=" . $id;
	
	if ($conn->query($sql_query) === TRUE) {
		return "Query successfull";
	} else {
		return "Error: " . $sql_query . "<br>" . $conn->error;
	}

	$conn->close();
}

?>