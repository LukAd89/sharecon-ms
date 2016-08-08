<?php

define("SERVER_NAME", "localhost");
define("SERVER_USER", "root");
define("SERVER_PASSWORD", "dbroot");
define("SERVER_DBNAME", "hz_sharecon");
define ('SITE_ROOT', realpath(dirname(__FILE__)));
/*
if (isset($_POST['function'])) {
	if($_POST['function'] == "toggle_share"){
		toggleShare($_POST['id'], $_POST['state']);
	}
	else if($_POST['function'] == "delete_share"){
		deleteShare($_POST['id']);
	}

	return;
}
*/

function add_new_share($data){
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = "INSERT INTO sharedObjects (title, shortdesc, longdesc, imagename, owner, type, visibility) VALUES ('" . $data['title'] . "', '" . $data['shortdesc'] . "', '" . $data['longdesc'] . "', '" . $data['imagename'] . "', '" . $data['owner'] . "', 0, '" . $data['visibility'] . "')";
	
	if ($conn->query($sql_query) === TRUE) {
		echo "New record created successfully";
	} else {
		return "Error: " . $sql_query . "<br>" . $conn->error;
	}
	
	$share_id = $conn->insert_id;
	
	$sql_query = "INSERT INTO shareTags (shareID, tags) VALUES (" . $share_id . ", '" . $data['tags'] . "')";
	Logger($sql_query);
	if ($conn->query($sql_query) === TRUE) {
		echo "New record created successfully";
	} else {
		return "Error: " . $sql_query . "<br>" . $conn->error;
	}
	
	$conn->close();
}

function add_new_request($data){

	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql_query = "INSERT INTO sharedObjects (title, shortdesc, longdesc, owner, type) VALUES ('" . $data['title'] . "', '" . $data['shortdesc'] . "', '" . $data['longdesc'] . "', '" . $data['owner'] . "', 1)";

	if ($conn->query($sql_query) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql_query . "<br>" . $conn->error;
	}

	$conn->close();
}

function uploadImage($file){
	
	if (!isset($file['error']) || is_array($file['error']))
		return false;
	
	if($file['error'] != UPLOAD_ERR_OK)
		return false;
	
	if ($file['size'] > 1000000)
		return false;
	
	if(pathinfo($file['name'],PATHINFO_EXTENSION) != "jpg")
		return false;
	
	$filename = uniqid();
	if(move_uploaded_file($file['tmp_name'], SITE_ROOT . '/uploads/images/' . $filename))
		return $filename;
	else
		return false;
}

function load_shares($args){
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$resArray = array();
	$sql_query = "SELECT * FROM sharedObjects";
	
	if(isset($args['type'])){
		if($args['type'] == 2){
			$sql_query .= " WHERE type = 0 OR type = 1";
		}
		else
			$sql_query .= " WHERE type = '" . $args['type'] . "'";
	}
	else{
		$sql_query .= " WHERE type = '0'";
	}
	
	if(isset($args['owner'])){
		$sql_query .= " AND owner = '" . $args['owner'] . "'";
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
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = "UPDATE sharedObjects SET Status=" . $state . " WHERE ID=" . $id;
	
	if ($conn->query($sql_query) === TRUE) {
		return "Query successfull";
	} else {
		return "Error: " . $sql_query . "<br>" . $conn->error;
	}

	$conn->close();
}

function deleteShare($id){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = "DELETE FROM sharedObjects WHERE ID=" . $id;
	
	if ($conn->query($sql_query) === TRUE) {
		return "Query successfull";
	} else {
		return "Error: " . $sql_query . "<br>" . $conn->error;
	}

	$conn->close();
}

function write_message($subject, $body){
	require_once('include/message.php');
	$recipient = getShareOwner($_POST['input-message-shareid']);
	send_message(null, $recipient, $body, $subject);
}




?>