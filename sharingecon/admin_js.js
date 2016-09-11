$(document).ready(function(){
	$('#new-branch-modal').on('show.bs.modal', function (e) {
		$('#input-parent-branch').val($(e.relatedTarget).data('parentid'));
	});
});

function addNewBranch(parentid){
	$("#new-branch-modal").modal("show");
	console.log(parentid);
}