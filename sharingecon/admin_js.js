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
	
	$("#new-branch-submit").click(function(){
		var parent = $('#new-branch-modal #input-branch-id').val();
		var title = $('#new-branch-modal #input-title').val();
		var tags = $('#new-branch-modal #input-tags').val();
		console.log("New: " + parent + "  :  " + title + "  :  " + tags);
		
		$("#new-branch-modal").modal('hide');
	});
	
	$("#edit-branch-submit").click(function(){
		var branch = $('#edit-branch-modal #input-branch-id').val();
		var parent = $('#edit-branch-modal #input-parent').val();
		var title = $('#edit-branch-modal #input-title').val();
		var tags = $('#edit-branch-modal #input-tags').val();
		console.log("Edit: " + branch + "  :  " + parent + "  :  " + title + "  :  " + tags);
		
		$("#edit-branch-modal").modal('hide');
	});
	
	$("#delete-branch-submit").click(function(){
		var branch = $('#delete-branch-modal #input-branch-id').val();
		console.log("Delete: " + branch);
		
		$("#delete-branch-modal").modal('hide');
	});
});