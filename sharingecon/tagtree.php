<?php

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

function get_TagTreeExt(){
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
		
		foreach($tagtree as $branch){
			if($branch['Parent'] != 0){
				$tagtree[$branch['Parent']]['subbranches'][] = $branch['ID'];
			}
		}
		
		return $tagtree;
	}
	
	$conn->close();
	return;
}

function get_TagTreeMin(){
	$tagtree = array();
	
	$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
	$sql_query = 'SELECT ID, Parent FROM tagBranches ORDER BY Parent';
	
	if($result = $conn->query($sql_query)){
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$row['subbranches'] = array();
			$tagtree[$row['ID']] = $row;
		}
		$conn->close();
	
		foreach($tagtree as $branch){
			if($branch['Parent'] != 0){
				$tagtree[$branch['Parent']]['relatives'][] = $branch['ID'];
			}
		}
	
		return $tagtree;
	}
	
	$conn->close();
	return;
}

function calc_NearestBranch($tagarray){
	$currentmaxcount = 0;
	$currentbranch = 0;
	
	$tagtree = get_TagTreeExt();
	
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
	
	$sql_query = 'SELECT Type, TagBranch FROM sharedObjects WHERE ID = ?';
	$prep = $conn->prepare($sql_query);
	$prep->bind_param('s', $shareid);
	$prep->execute();
	$result = $prep->get_result();
	$row = $result->fetch_assoc();
	$type = $row['Type'];
	$startBranch = $row['TagBranch'];
	$prep->close();
	
	$type = ($type == 0) ? 1 : 0;
	
	$args = array(
		'type' => $type,
		'channel' => (local_channel()) ? App::$channel['channel_hash'] : remote_channel()
	);
	
	$data = load_Shares($args);
	$returndata = array();
	
	foreach($data as $match){
		$tmp = array();
		$tmp['Title'] = $match['Title'];
		$tmp['ID'] = $match['ID'];
		$tmp['Distance'] = get_BranchDistance($startBranch, $match['TagBranch'], 0);
		
		$returndata[] = $tmp;
	}
	return $returndata;
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
			$tagsbranches[] = $row['Tag'];
		}
	}
	
	$conn->close();
	$unusedtags = array_diff(array_unique($tagsobjects), array_unique($tagsbranches));
	
	return $unusedtags;
}

function get_BranchDistance($start, $end, $type){
	if($start == $end) return 0;

	if($type == 1){
		$tmp = $start;
		$start = $end;
		$end = $tmp;
	}

	$tree = get_TagTreeMin();
	var_dump($tree);
	$distancedown = 0;
	$distanceup = -1;
	Logger('ST: ' . $start . '  :  ' . ' EN: ' . $end);
	while($distancedown == 0 && !is_null($start)){
		$distancedown = get_BranchDistanceRec($start, $end, $tree, 0);
		$start = $tree[$start]['parent'];
		$distanceup += 1;
		Logger('nSt: ' . $tree[$start]['parent']);
	}
	return ($distancedown*TREE_WEIGHT_SPECIAL) + ($distanceup*TREE_WEIGHT_GENERAL);
}

function get_BranchDistanceRec($start, $end, $tree, $count){

	if(in_array($end, $tree[$start]['relatives']))
		return $count+1;


	if(count($tree[$start]['relatives']) > 0){
		foreach($tree[$start]['relatives'] as $relative){
			$subcount = get_BranchDistanceRec($relative, $end, $tree, $count+1);
			if($subcount > 0) return $subcount;
		}
	}
	return 0;
}