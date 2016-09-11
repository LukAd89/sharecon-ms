$(document).ready(function(){
	$('#new-branch-modal').on('show.bs.modal', function (e) {
		$('#input-branch-id').val($(e.relatedTarget).data('branchid'));
	});
});

function addNewBranch(parentid){
	$("#new-branch-modal").modal("show");
	console.log(parentid);
}