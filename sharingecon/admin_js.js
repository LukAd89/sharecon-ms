$(document).ready(function(){
	$("#new-branch-dialog").dialog({
		autoOpen: false
	});
});

function addNewBranch(parentid){
	$("#new-branch-modal").modal("open");
	console.log(parentid);
}