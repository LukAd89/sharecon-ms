$(document).ready(function(){
	$('#new-branch-modal').on('show.bs.modal', function (e) {
		var branchid = $(e.relatedTarget).data('branchid');
		$('#input-branch-id').val(branchid);
	});
	
	$('#edit-branch-modal').on('show.bs.modal', function (e) {
		var branchid = $(e.relatedTarget).data('branchid');
		$('#input-branch-id').val(branchid);
		$('#input-parent').val($('#tr_' + branchid + ' .td_parent'));
		$('#input-title').val($('#tr_' + branchid + ' .td_title'));
		$('#input-tags').val($('#tr_' + branchid + ' .td_tags'));
	});
});

function addNewBranch(parentid){
	$("#new-branch-modal").modal("show");
	console.log(parentid);
}