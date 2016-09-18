<?php

function get_CurrentTagTree(){
	$tagtree = array();
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	$sql_query = 'SELECT tagBranches.*,  GROUP_CONCAT(tags.Tag) AS tags FROM tagBranches LEFT JOIN tags ON tagBranches.ID = tags.BranchID GROUP BY ID ORDER BY Parent';
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$row['tags'] = explode(',', $row['tags']);
			$row['subbranches'] = array();
			$tagtree[$row['ID']] = $row;
		}
		$conn->close();
	}
	
	foreach($tagtree as $branch){
		if($branch['Parent'] != 0){
			$tagtree[$branch['Parent']]['subbranches'][] = $branch['ID'];
		}
	}
	
	return $tagtree;
}

function calc_NearestBranch($tagarray){
	$currentmaxcount = 0;
	$currentbranch = 0;
	
	$tagtree = get_CurrentTagTree();
	
	//$objecttags = array('vacuum cleaner');
	
	foreach($tagtree as $branch){
		$intersection = array_intersect($tagarray, $branch['tags']);
		if(count($intersection) > $currentmaxcount){
			$currentmaxcount = count($intersection);
			$currentbranch = $branch['ID'];
		}
	}
	return $currentbranch;
}

function set_NearestBranches(){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	$sql_query = 'SELECT ID, Tags FROM sharedObjects';
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$resArray[] = $row;
		}
		$conn->close();
		
		foreach($resArray as $resRow){
			set_NearestBranch($resRow['ID'], $resRow['Tags']);
		}
	}
	else{
		return;
	}
}

function set_NearestBranch($id, $tags){
	$branch = 0;
	if(strlen($tags) > 0)
		$branch = calc_NearestBranch(explode(',', $tags));
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	$sql_query = 'UPDATE sharedObjects SET TagBranch = ' . $branch . ' WHERE ID = ' . $id;
	$conn->query($sql_query);
	$conn->close();
}

function get_TagTree(){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql_query = 'SELECT tagBranches.*, GROUP_CONCAT(tags.Tag) AS Tags FROM tagBranches LEFT JOIN tags ON tagBranches.ID = tags.BranchID GROUP BY ID';
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

	$sql_query = 'INSERT INTO tagBranches (Parent, Title) VALUES (' . $parent . ', "' . $title . '")';
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

	$sql_query = 'UPDATE tagBranches SET Parent = ' . $parent . ', Title = "' . $title . '" WHERE ID = ' . $branchid;
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

	$sql_query = 'DELETE FROM tagBranches WHERE ID = ' . $branchid;
	$conn->query($sql_query);
	$sql_query = 'UPDATE tagBranches SET Parent = NULL WHERE Parent = ' . $branchid;
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

function get_UnusedTags(){
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	$tagsobjects = array();
	$tagsbranches = array();
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql_query = 'SELECT Tags FROM sharedObjects';
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$tagsobjects = array_merge($tagsobjects, explode(',', $row['Tags']));
		}
	}
	
	$sql_query = 'SELECT Tag FROM tags';
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$tagsbranches[] = $row['Tags'];
		}
	}
	
	$conn->close();
	
	$unusedtags = array_diff(array_unique($tagsobjects), array_unique($tagsbranches));
	
	return $unusedtags;
}