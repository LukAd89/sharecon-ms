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

function get_SharesList($args){
	$data = load_Shares($args);
	
	$maxResPerPage = 5;
	$display = 'block';

	$result = "";

	foreach($data as $dataval){
		$shareids[] = $dataval['ID'];
	}
	
	//DEACTIVATED BECAUSE 2500 MAX PER DAY 
	//$distances = get_MultipleDistances(local_channel(), $shareids);
	
	for($i=0; $i<count($data); $i++){
		$data[$i]['distance'] = 0.123;//$distances[$i];
	}
	
	//ORDER BY DISTANCE IF WANTED
	if(isset($args['orderby']) && $args['orderby'] == 2){
		usort($data, function($a, $b){
			return ($a['distance'] < $b['distance']) ? -1 : 1;
		});
	}
	
	$favorites = get_ChannelFavorites($args['channel']);
	
	for($i=0; $i<count($data); $i++){
		if($i == $maxResPerPage)
			$display = 'none';

			if($data[$i]['Imagename'] === NULL || $data[$i]['Imagename'] == ''){
				$data[$i]['Imagename'] ='default.jpg';
			}

			if($args['ownerview']){
				$status='';
				$wellbody = 'Type: ';
					
				if($data[$i]['Status']==0){
					$status='checked="checked"';
				}
					
				if($data[$i]['Type']==0){
					$wellbody .= 'Offer';
				}
				else{
					$wellbody .= 'Request';
				}
				$wellbody .= '<br>Visible for: ';
				if($data[$i]['Visibility']==0){
					$wellbody .= 'Everybody';
				}
				else{
					$wellbody .= $data[$i]['visiblefor'];
				}
				$wellbody .= '<br>Location: ' . $data[$i]['Location'];
					
				$result .= replace_macros(get_markup_template('share_min_owner.tpl','addon/sharingecon/'), array(
						'$shareid' 		=> $data[$i]['ID'],
						'$title' 		=> $data[$i]['Title'],
						'$imagename'	=> $data[$i]['Imagename'],
						'$wellbody'		=> $wellbody,
						'$checked'		=> $status
				));
			}
			else{
				$wellbody = 'Rating: ' . get_AvgRating($data[$i]['ID']) . '<br>Distance: ';
				if($distances == -1){
					$wellbody .= 'You have to set your own location';
				}
				else{
					$wellbody .= ($data[$i]['distance'] / 1000) . ' km';
				}
				$isfavorite = in_array($data[$i]['ID'], $favorites);
				$result .= replace_macros(get_markup_template('share_min.tpl','addon/sharingecon/'), array(
						'$display'		=> $display,
						'$shareid' 		=> $data[$i]['ID'],
						'$title' 		=> $data[$i]['Title'],
						'$imagename'	=> $data[$i]['Imagename'],
						'$wellbody'		=> $wellbody,
						'$checked'		=> ($isfavorite) ? 'checked="checked"' : '',
						'$favstyle'		=> ($isfavorite) ? 'style="background-color:lightgreen;"' : ''
				));
			}
	}

	//ADD PAGINATION NAV
	if(!$args['ownerview']){
		$result .=  '<ul class="pagination" id="pager">';
		for($k=0; ($k*$maxResPerPage)<count($data); $k++){
			$result .= '<li><a href="javascript:void(0)">' . ($k+1) . '</a></li>';
		}
		$result .= '</ul>';
	}

	return $result;
}

function add_NewShare($data){
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'INSERT INTO sharedObjects (title, description, imagename, ownerid, type, visibility, location, tags) VALUES ("' . $data['title'] . '", "' . $data['description'] . '", "' . $data['imagename'] . '", "' . $data['owner'] . '", "' . $data['type'] . '", "' . $data['visibility'] . '", "' . $data['location'] . '", "' . $data['tags'] . '")';
	
	if ($conn->query($sql_query) === TRUE) {
		echo "New record created successfully";
	} else {
		return "Error: " . $sql_query . "<br>" . $conn->error;
	}
	
	$sql_query = 'INSERT INTO visibilityRange (ObjectID, VisibleFor) VALUES ';
	foreach($data['groups'] as $group){
		$sql_query .= '(' . $conn->insert_id . ', ' . $group . '),';
	}
	$sql_query = substr($sql_query, 0, -1);
	
	$conn->query($sql_query);
	
	//OLD. TAGS ARE NOW IN SHAREDOBJECTS TABLE
	/*
	$share_id = $conn->insert_id;
	
	$sql_query = "INSERT INTO shareTags (shareID, tags) VALUES (" . $share_id . ", '" . $data['tags'] . "')";
	
	if ($conn->query($sql_query) === TRUE) {
		echo "New record created successfully";
	} else {
		return "Error: " . $sql_query . "<br>" . $conn->error;
	}
	*/
	$conn->close();
	return;
}

function edit_Share($data){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'UPDATE sharedObjects SET Title = "' . $data["title"] . '", Description = "' . $data["description"] . '", Visibility = ' . $data["visibility"] . ', Location = "' . $data["location"] . '", Tags = "' . $data["tags"] . '"';
	
	if(strcmp($data['imagename'], '') != 0){
		
		$result = $conn->query('SELECT Imagename FROM sharedObjects WHERE ID=' . $data['shareid']);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		Logger($data['shareid'] . '  :  ' . count($row));
		$currentimage = $row[0]['Imagename'];
		unlink('addon/sharingecon/uploads/images/' . $currentimage);
		$sql_query .= ', Imagename = "' . $data['imagename'] . '"';
	}
	
	$sql_query .= ' WHERE ID = ' . $data['shareid'];
	
	if ($conn->query($sql_query) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql_query . "<br>" . $conn->error;
	}
	
	$conn->close();
	return;
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
	if(move_uploaded_file($file['tmp_name'], SITE_ROOT . '/uploads/images/' . $filename . '.jpg'))
		return $filename . '.jpg';
	else
		return false;
}

function load_Shares($args){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$resArray = array();
	
	if(isset($args['ownerview']) && $args['ownerview'] == true){
		$sql_query = 'SELECT * FROM sharedObjects WHERE OwnerID = ' . $args['ownerid'];
	}
	
	else{
		$sql_query = "SELECT sharedObjects.*, visibilityRange.VisibleFor, T.avgrating FROM sharedObjects LEFT JOIN visibilityRange ON sharedObjects.ID = visibilityRange.ObjectID LEFT JOIN (SELECT ObjectID, AVG(Rating) as avgrating from transactions GROUP BY ObjectID) AS T ON sharedObjects.ID = T.ObjectID WHERE 1";
		
		if(isset($args['filterfriends']) && $args['filterfriends'] == 1){
			//$sql_query .= ' AND sharedObjects.OwnerID in ( SELECT DISTINCT xchan FROM ' . SERVER_HUB_DBNAME . '.group_member WHERE gid in (SELECT gid FROM ' . SERVER_HUB_DBNAME . '.group_member WHERE xchan = "' . $args['channel'] . '"))';
			$sql_query .= ' AND sharedObjects.OwnerID IN ( SELECT DISTINCT channel_id FROM ' . SERVER_HUB_DBNAME . '.channel RIGHT JOIN ' . SERVER_HUB_DBNAME . '.group_member ON channel_hash = xchan WHERE gid IN (SELECT DISTINCT id FROM ' . SERVER_HUB_DBNAME . '.groups WHERE uid = ' . $args['channel'] . '))';
		}
		
		if(isset($args['filterfavs']) && $args['filterfavs'] == 1){
			$sql_query .= ' AND sharedObjects.ID IN (' . implode(',', get_ChannelFavorites($args['channel'])) . ')';
		}
		
		if(isset($args['type'])){
			if($args['type'] == 2){
				$sql_query .= " AND (type = 0 OR type = 1)";
			}
			else
				$sql_query .= " AND type = '" . $args['type'] . "'";
		}
		else{
			$sql_query .= " AND type = '0'";
		}
		
		if(isset($args['channel'])){
			$sql_query .= " AND OwnerID <> '" . $args['channel'] . "'";
		}
	
		$sql_query .= 'AND (visibility = 0 OR visibility = 1 AND VisibleFor IN (SELECT DISTINCT gid from ' . SERVER_HUB_DBNAME . '.group_member LEFT JOIN ' . SERVER_HUB_DBNAME . '.channel ON ' . SERVER_HUB_DBNAME . '.group_member.xchan = ' . SERVER_HUB_DBNAME . '.channel.channel_hash WHERE ' . SERVER_HUB_DBNAME . '.channel.channel_id=' . $args['channel'] .'))';
	}
	
	if(isset($args['orderby'])){
		switch($args['orderby']){
			case 0:
				$sql_query .= ' ORDER BY title ASC';
				break;
			case 1:
				$sql_query .= ' ORDER BY avgrating DESC';
				break;
			case 2:
				//$sql_query .= ' ORDER BY title';
				break;
			default:
				break;
		}
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
	
	$sql_query = "SELECT OwnerID FROM sharedObjects WHERE ID=" . $shareid;
	
	if($result = $conn->query($sql_query)){
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row['OwnerID'];
	}
	else { return "";}

	$conn->close();
}

function get_ChannelHash($channelid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_HUB_DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql_query = "SELECT channel_hash FROM channel WHERE channel_id=" . $channelid;
	
	if($result = $conn->query($sql_query)){
		$row = $result->fetch_array(MYSQLI_ASSOC);

		return $row['channel_hash'];
	}
	else { return "";}

	$conn->close();
}

function toggle_Share($id, $state){
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = "UPDATE sharedObjects SET Status=" . $state . " WHERE ID=" . $id . ' AND OwnerID = ' . local_channel();
	
	if ($conn->query($sql_query) === TRUE) {
		return "Query successfull";
	} else {
		return "Error: " . $sql_query . "<br>" . $conn->error;
	}

	$conn->close();
}

function toggle_Favorite($objectid, $state){

	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	if($state == 1){
		$sql_query = 'REPLACE INTO favorites (ChannelID, ObjectID) VALUES (' . local_channel() . ', ' . $objectid . ')';
	}
	else{
		$sql_query = 'DELETE FROM favorites WHERE ChannelID = ' . local_channel() . ' AND ObjectID = ' . $objectid;
	}
	
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
	$recipient = get_ChannelHash(get_ShareOwner($_POST['input-message-shareid']));
	send_message(null, $recipient, $body, $subject);
}

function load_Enquiries($channelid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT enquiries.ID, Title, channel_name, enquiries.Status FROM enquiries LEFT JOIN sharedObjects ON enquiries.ObjectID = sharedObjects.ID LEFT JOIN ' . SERVER_HUB_DBNAME . '.channel ON enquiries.CustomerID = ' . SERVER_HUB_DBNAME . '.channel.channel_id WHERE sharedObjects.OwnerID = ' . $channelid;
	
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

function load_Transactions($channelid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	//$sql_query = "SELECT transactions.*, sharedObjects.OwnerID FROM transactions, sharedObjects WHERE transactions.ObjectID = sharedObjects.ID";
	$sql_query = 'SELECT transactions.*, Title, channel_name FROM transactions LEFT JOIN sharedObjects ON transactions.ObjectID = sharedObjects.ID LEFT JOIN ' . SERVER_HUB_DBNAME . '.channel ON sharedObjects.OwnerID = ' . SERVER_HUB_DBNAME . '.channel.channel_id WHERE transactions.CustomerID = ' . $channelid;

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
	
	$sql_query = 'SELECT * FROM enquiries WHERE ObjectID = ' . $id . ' AND CustomerID = ' . $customerid . '';
	if($result = $conn->query($sql_query)){
		if($result->num_rows > 0){
			$conn->close();
			return;
		}
	}
	
	$sql_query = 'INSERT INTO enquiries (ObjectID, CustomerID, Status) VALUES (' . $id . ', ' . $customerid . ', 0)';
	$conn->query($sql_query);
	
	$conn->close();
}

function get_ChannelName($channelid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_HUB_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT channel_name FROM channel WHERE channel_id = "' . $channelid . '"';
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

function get_Location($channelid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql_query = 'SELECT Adress FROM locations WHERE ChannelID = ' . $channelid;

	if($result = $conn->query($sql_query)){
		if($result->num_rows > 0){
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$conn->close();
			return $row['Adress'];
		}
		
		$conn->close();
	}
	return -1;
}

function set_Location($channelid, $adress){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	if(get_Location($channelid) == -1){
		$sql_query = 'INSERT INTO locations (ChannelID, Adress) VALUES ("' . $channelid . '","' . $adress . '")';
	}
	else{
		$sql_query = 'UPDATE locations SET Adress ="' . $adress . '" WHERE ChannelID = "' . $channelid . '"';
	}
	
	$conn->query($sql_query);
	$conn->close();
}

function get_Distance($customerid, $shareid){
	$customerlocation = get_Location($customerid);
	if($customerlocation == -1){
		return -1;
	}
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT Location FROM sharedObjects WHERE ID = ' . $shareid;
	
	if($result = $conn->query($sql_query)){
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$objectlocation = $row["Location"];
		$conn->close();
	}
	
	$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . urlencode($customerlocation) . '&destinations=' . urlencode($objectlocation) . '&key=' . GOOGLEAPI_KEY;
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_SSL_VERIFYPEER, false,
			CURLOPT_URL => $url
	));
	$curlresult = curl_exec($curl);
	curl_close($curl);
	
	$jsonresult = json_decode($curlresult, true);
	
	return $jsonresult['rows'][0]['elements'][0]['distance']['value'];
}

function get_MultipleDistances($customerid, $shareids){
	$customerlocation = get_Location($customerid);
	if($customerlocation == -1){
		return -1;
	}
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT Location FROM sharedObjects WHERE id IN (';
	foreach($shareids as $shareid){
		$sql_query .= $shareid . ',';
	}
	$sql_query = substr($sql_query, 0, -1);
	$sql_query .= ')';
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC))
			$objectlocations[] = $row["Location"];
	}
	
	$conn->close();
	
	$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . urlencode($customerlocation) . '&destinations=';
	
	foreach($objectlocations as $objectlocation){
		$url .= urlencode($objectlocation) . '|';
	}
	$url .= '&key=' . GOOGLEAPI_KEY;
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_SSL_VERIFYPEER, false,
			CURLOPT_URL => $url
	));
	$curlresult = curl_exec($curl);
	curl_close($curl);
	
	$jsonresult = json_decode($curlresult, true);
	
	foreach($jsonresult['rows'][0]['elements'] as $singledistance){
		$distances[] = $singledistance['distance']['value'];
	}
	return $distances;
}

function get_ChannelGroups($channelid, $isowner){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_HUB_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	//$sql_query = 'SELECT group_member.gid, groups.gname FROM group_member, groups WHERE group_member.xchan = "' . $channelid . '" AND group_member.gid = groups.id';
	if($isowner){
		$sql_query = 'SELECT id, gname FROM groups WHERE uid = ' . $channelid;
	}
	else{
		$sql_query = 'SELECT group_member.gid, groups.gname FROM groups LEFT JOIN group_member ON groups.id = group_member.gid LEFT JOIN channel ON group_member.xchan = channel.channel_hash WHERE channel.channel_id = ' . $channelid;
	}
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$resArray[] = $row;
		}
		$conn->close();
		return $resArray;
	}
	$conn->close();
	return null;
}

function is_ChannelMemberOfGroup($channelid, $groupids){
	$channelgroups = get_ChannelGroups($channelid, false);
	
	foreach($channelgroups as $group){
		if(in_array($group['gid'], $groupids))
			return true;
	}
	return false;
}

function is_ChannelAllowedToView($channelid, $shareid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT Visibility, VisibleFor FROM sharedObjects WHERE ID = "' . $shareid . '"';
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$resArray[] = $row;
		}
		$conn->close();
		return $resArray;
	}
	$conn->close();
	return null;
}

function get_ChannelFavorites($channelid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT ObjectID FROM favorites WHERE channelID = ' . $channelid;
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$resArray[] = $row['ObjectID'];
		}
		$conn->close();
		return $resArray;
	}
	$conn->close();
	return null;
}

function get_TagTree(){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql_query = 'SELECT tagTree.*, GROUP_CONCAT(tags.Tag) AS Tags FROM tagTree LEFT JOIN tags ON tagTree.ID = tags.BranchID GROUP BY ID';
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$resArray[] = $row;
		}
		$conn->close();
		return $resArray;
	}
	$conn->close();
	return null;
}

function new_TagTreeBranch($parent, $title, $tags){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	if($parent == '') $parent = 'NULL';
	
	$sql_query = 'INSERT INTO tagTree (Parent, Title) VALUES (' . $parent . ', "' . $title . '")';
	$conn->query($sql_query);
	
	
	$newtags = explode(',', $tags);
	$sql_query = 'INSERT INTO tags (BranchID, Tag) VALUES ';
	foreach($newtags as $newtag){
		$sql_query .= '(' . $conn->insert_id . ',"' . $newtag . '"),';
	}
	$sql_query = substr($sql_query, 0, -1);
	$conn->query($sql_query);
	
	$conn->close();
}

function edit_TagTreeBranch($branchid, $parent, $title, $tags){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	if($parent == '') $parent = 'NULL';
	
	$sql_query = 'UPDATE tagTree SET Parent = ' . $parent . ', Title = "' . $title . '" WHERE ID = ' . $branchid;
	$conn->query($sql_query);
	
	$sql_query = 'DELETE FROM tags WHERE BranchID = ' . $branchid;
	$conn->query($sql_query);
	
	$newtags = explode(',', $tags);
	$sql_query = 'INSERT INTO tags (BranchID, Tag) VALUES ';
	foreach($newtags as $newtag){
		$sql_query .= '(' . $branchid . ',"' . $newtag . '"),';
	}
	$sql_query = substr($sql_query, 0, -1);
	$conn->query($sql_query);
	
	$conn->close();
}

function delete_TagTreeBranch($branchid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'DELETE FROM tagTree WHERE ID = ' . $branchid;
	$conn->query($sql_query);
	$sql_query = 'UPDATE tagTree SET Parent = NULL WHERE Parent = ' . $branchid;
	$conn->query($sql_query);
	$sql_query = 'DELETE FROM tags WHERE BranchID = ' . $branchid;
	$conn->query($sql_query);
	
	$conn->close();
}

function get_MatchesForShare($shareid){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT * FROM sharedObjects';
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$resArray[] = $row;
		}
		$conn->close();
		return $resArray;
	}
	$conn->close();
	return null;
}