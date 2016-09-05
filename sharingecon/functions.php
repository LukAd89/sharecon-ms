<?php

define('SERVER_NAME', "localhost");
define('SERVER_USER', "root");
define('SERVER_PASSWORD', "dbroot");
define('SERVER_DBNAME', "hz_sharecon");
define('SERVER_HUB_DBNAME', "hubzilla");
define('SITE_ROOT', realpath(dirname(__FILE__)));
define('GOOGLEAPI_KEY', 'AIzaSyDHMXzuvg32pFTh2XTvps89IoAOgzcaOzU');
/*
if (isset($_POST['function'])) {
	if($_POST['function'] == "toggle_share"){
		toggleShare($_POST['id'], $_POST['state']);
	}
	else if($_POST['function'] == "delete_share"){
		delete_Share($_POST['id']);
	}

	return;
}
*/

function add_NewShare($data){
	
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
	
	if ($conn->query($sql_query) === TRUE) {
		echo "New record created successfully";
	} else {
		return "Error: " . $sql_query . "<br>" . $conn->error;
	}
	
	$conn->close();
}

function add_NewRequest($data){

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

function edit_Share($data){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'UPDATE sharedObjects SET Title = "' . $data["title"] . '", ShortDesc = "' . $data["shortdesc"] . '", LongDesc = "' . $data["longdesc"] . '", Visibility = ' . $data["visibility"];
	
	if ($conn->query($sql_query) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql_query . "<br>" . $conn->error;
	}
	
	$conn->close();
}

function upload_Image($file){
	
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

function load_Shares($args){
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
	
	if(isset($args['ownerid'])){
		$sql_query .= " AND OwnerID = '" . $args['ownerid'] . "'";
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

function load_ShareDetails($shareid){
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

function get_ShareOwner($shareid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$resArray = array();
	$sql_query = "SELECT OwnerID FROM sharedObjects WHERE ID=" . $shareid;
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$resArray[] = $row;
		}
	return $resArray[0]['OwnerID'];
	}
	else { return "";}

	$conn->close();
}

function toggle_Share($id, $state){
	
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

function delete_Share($id){
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

function write_Message($subject, $body){
	require_once('include/message.php');
	$recipient = get_ShareOwner($_POST['input-message-shareid']);
	Logger($recipient . '  :  ' . $_POST['input-message-shareid']);
	send_message(null, $recipient, $body, $subject);
}

function load_Enquiries(){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = "SELECT * FROM enquiries";
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$resArray[] = $row;
		}
		$conn->close();
		return $resArray;
	}
	$conn->close();
	return [];
}

function load_Transactions(){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql_query = "SELECT transactions.*, sharedObjects.OwnerID FROM transactions, sharedObjects WHERE transactions.ObjectID = sharedObjects.ID";

	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$resArray[] = $row;
		}
		$conn->close();
		return $resArray;
	}
	$conn->close();
	return [];
}

function manage_Enquiry($id){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT * FROM enquiries WHERE ID = ' . $id;

	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$resArray[] = $row;
		}
		$curStatus = $resArray[0]["Status"];
	}
	
	switch($curStatus){
		case 0:
			$sql_query = 'UPDATE enquiries SET Status = 1 WHERE ID = ' . $id;
			$conn->query($sql_query);
			$sql_query = 'UPDATE enquiries SET Status = 2 WHERE ID <> ' . $id . ' AND ObjectID = ' . $resArray[0]["ObjectID"];
			$conn->query($sql_query);
			
			$sql_query = 'INSERT INTO transactions (ObjectID, CustomerID, LendingStart) VALUES (' . 
				$resArray[0]["ObjectID"] . ', "' .
				$resArray[0]["CustomerID"] . '", ' .
				'CURRENT_TIMESTAMP)';
			$conn->query($sql_query);
			
			break;
			
		case 1:
			$sql_query = 'UPDATE enquiries SET Status = 0 WHERE ID <> ' . $id . ' AND ObjectID = ' . $resArray[0]["ObjectID"];
			$conn->query($sql_query);
			
			$sql_query = 'UPDATE transactions SET LendingEnd = CURRENT_TIMESTAMP WHERE ObjectID = ' . $resArray[0]["ObjectID"] . ' AND LendingEnd IS NULL';
			$conn->query($sql_query);
			
			$sql_query = 'DELETE FROM enquiries WHERE ID = ' . $id;
			$conn->query($sql_query);
			
			break;
	}

	$conn->close();
}

function add_Enquiry($id, $customerid){
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT * FROM enquiries WHERE ObjectID = ' . $id . ' AND CustomerID = "' . $customerid . '"';
	if($result = $conn->query($sql_query)){
		if($result->num_rows > 0){
			$conn->close();
			return;
		}
	}
	
	$sql_query = 'INSERT INTO enquiries (ObjectID, CustomerID, Status) VALUES (' . $id . ', "' . $customerid . '", 0)';
	$conn->query($sql_query);
	
	$conn->close();
}

function get_ChannelName($channelid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_HUB_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT channel_name FROM channel WHERE channel_hash = "' . $channelid . '"';
	if($result = $conn->query($sql_query)){
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$conn->close();
		return $row["channel_name"];
	}
	$conn->close();
	return;
}

function get_ObjectTitle($objectid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT Title FROM sharedObjects WHERE ID = ' . $objectid ;
	if($result = $conn->query($sql_query)){
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$conn->close();
		return $row["Title"];
	}
	$conn->close();
	return;
}

function set_Rating($transid, $rating){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'UPDATE transactions SET Rating = ' . $rating . ' WHERE ObjectID = ' . $transid  . ' AND Rating IS NULL';
	$conn->query($sql_query);
	$conn->close();
}

function get_AvgRating($objectid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT AVG(Rating) AS AvgRating FROM transactions WHERE ObjectID = ' . $objectid ;
	if($result = $conn->query($sql_query)){
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$conn->close();
		return $row["AvgRating"];
	}
	$conn->close();
	return 0;
}

function get_LatestRatings($objectid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT LendingStart, LendingEnd, DATEDIFF(LendingEnd, LendingStart) + 1 AS Timespan, Rating FROM transactions WHERE ObjectID = ' . $objectid . ' AND LendingEnd IS NOT NULL LIMIT 5';
	if($result = $conn->query($sql_query)){
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$resArray[] = $row;
		}
	}
	$conn->close();
	return $resArray;
}

?>