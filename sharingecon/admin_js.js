$(document).ready(function(){
	$("#new-branch-dialog").dialog({
		autoOpen: false
	});
});

function addNewBranch(parentid){
	$("#new-branch-dialog").dialog("open");
	console.log(parentid);
}