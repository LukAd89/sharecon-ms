<?php

class TagTree{
	var $tagtree = array();
	
	function TagTree(){
		$conn = new mysqli(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DBNAME);
		$sql_query = 'SELECT tagBranches.*,  GROUP_CONCAT(tags.Tag) AS tags FROM tagBranches LEFT JOIN tags ON tagBranches.ID = tags.BranchID GROUP BY ID ORDER BY Parent';
		//print_r($sql_query);
		
		if($result = $conn->query($sql_query)){
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$row['tags'] = explode(',', $row['tags']);
				$row['subbranches'] = array();
				$this->tagtree[$row['ID']] = $row;
			}
			$conn->close();
		}
		
		foreach($this->tagtree as $branch){
			if($branch['Parent'] != 0){
				$this->tagtree[$branch['Parent']]['subbranches'][] = $branch['ID'];
			}
		}
	}
	
	function get_NearestBranch(){
		$currentmaxcount = 0;
		$currentbranch;
		
		$objecttags = array('vacuum cleaner');
		foreach($this->tagtree as $branch){
			$intersection = array_intersect($objecttags, $branch['tags']);
			if(count($intersection) > $currentmaxcount){
				$currentmaxcount = count($intersection);
				$currentbranch = $branch['ID'];
			}
		}
		return $currentbranch;
	}
}