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