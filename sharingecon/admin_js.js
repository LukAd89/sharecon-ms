$(document).ready(function(){
	$('#new-branch-modal').on('show.bs.modal', function (e) {
		var branchid = $(e.relatedTarget).data('branchid');
		$('#new-branch-modal #input-branch-id').val(branchid);
	});
	
	$('#edit-branch-modal').on('show.bs.modal', function (e) {
		var branchid = $(e.relatedTarget).data('branchid');
		$('#edit-branch-modal #input-branch-id').val(branchid);
		$('#edit-branch-modal #input-parent').val($('#edit-branch-modal #tr_' + branchid + ' .td_parent').text());
		$('#edit-branch-modal #input-title').val($('#edit-branch-modal #tr_' + branchid + ' .td_title').text());
		$('#edit-branch-modal #input-tags').val($('#edit-branch-modal #tr_' + branchid + ' .td_tags').text());
	});
});

function addNewBranch(parentid){
	$("#new-branch-modal").modal("show");
	console.log(parentid);
}