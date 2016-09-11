$(document).ready(function(){
	$('#new-branch-modal').on('show.bs.modal', function (e) {
		var branchid = $(e.relatedTarget).data('branchid');
		$('#input-branch-id').val(branchid);
	});
	
	$('#edit-branch-modal').on('show.bs.modal', function (e) {
		var branchid = $(e.relatedTarget).data('branchid');
		$('#input-branch-id').val(branchid);
		$('#input-parent').val($('#tr_' + branchid + ' .td_parent').text());
		$('#input-title').val($('#tr_' + branchid + ' .td_title').text());
		$('#input-tags').val($('#tr_' + branchid + ' .td_tags').text());
	});
});

function addNewBranch(parentid){
	$("#new-branch-modal").modal("show");
	console.log(parentid);
}