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
	$title = strip_tags($_POST['inputTitle']);
	$shortdesc = strip_tags($_POST['inputShortDesc']);
	
	$server = "localhost";
	$user = "root";
	$password = "dbroot";
	$dbname = "hz_sharecon";
	
	$conn = new mysqli($server, $user, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = "INSERT INTO sharedobjects (title, shortdesc) VALUES ('" . $title . "', '" . $shortdesc . "')";
	
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
		return json_encode($resArray);
	}
	else { return "";}

	$conn->close();
}
?>