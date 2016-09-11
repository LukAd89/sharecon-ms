$(document).ready(function(){
	$('#new-branch-modal').on('show.bs.modal', function (e) {
		var branchid = $(e.relatedTarget).data('branchid');
		$('#new-branch-modal #input-branch-id').val(branchid);
	});
	
	$('#edit-branch-modal').on('show.bs.modal', function (e) {
		var branchid = $(e.relatedTarget).data('branchid');
		$('#edit-branch-modal #input-branch-id').val(branchid);
		$('#edit-branch-modal #input-parent').val($('#tr_' + branchid + ' .td_parent').text());
		$('#edit-branch-modal #input-title').val($('#tr_' + branchid + ' .td_title').text());
		$('#edit-branch-modal #input-tags').val($('#tr_' + branchid + ' .td_tags').text());
	});
	
	$('#delete-branch-modal').on('show.bs.modal', function (e) {
		var branchid = $(e.relatedTarget).data('branchid');
		$('#delete-branch-modal #input-branch-id').val(branchid);
	});
});

function addNewBranch(parentid){
	$("#new-branch-modal").modal("show");
	console.log(parentid);
}