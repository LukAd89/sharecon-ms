<?php

if(isset($_POST['test'])){
	header('Content-Type: application/json');
	echo '{"test":{"titel":"wahr"}}';
	return;
}

if (isset($_POST['function'])) {
	if($_POST['function'] == "add_new_share"){
		echo add_new_share();
	}
	else if($_POST['function'] == "load_shares"){
		echo load_shares();
	}
	return;
}

function add_new_share(){
	
	$title = strip_tags($_POST['input-title']);
	$shortdesc = strip_tags($_POST['input-short-desc']);
	
	$server = "localhost";
	$user = "root";
	$password = "dbroot";
	$dbname = "hz_sharecon";
	
	$conn = new mysqli($server, $user, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$owner = get_current_App()::$channel['channel_guid'];
	$sql_query = ""; //INSERT INTO sharedObjects (title, shortdesc, Owner) VALUES ('" . $title . "', '" . $shortdesc . "', '" . $owner . "')";
	
	if ($conn->query($sql_query) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql_query . "<br>" . $conn->error;
	}

	$conn->close();
}

function load_shares(){
	header('Content-Type: application/json');
	
	$server = "localhost";
	$user = "root";
	$password = "dbroot";
	$dbname = "hz_sharecon";
	
	$conn = new mysqli($server, $user, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$resArray = array();
	$sql_query = "SELECT * FROM sharedObjects";
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$resArray[] = $row;
		}
		echo json_encode($resArray);
	}
	else { echo "";}

	$conn->close();
}

function load_share_details($id){
	header('Content-Type: application/json');
	
	$server = "localhost";
	$user = "root";
	$password = "dbroot";
	$dbname = "hz_sharecon";
	
	$conn = new mysqli($server, $user, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$resArray = array();
	$sql_query = "SELECT * FROM sharedObjects WHERE ID=" . $id;
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$resArray[] = $row;
		}
		return $resArray[0];
	}
	else { return "";}

	$conn->close();
}
?>