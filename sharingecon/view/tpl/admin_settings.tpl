</form>
<h4>Tagtree</h4>
<div class="btn-group btn-group-vertical">
	<button type="button" class="btn btn-default btn-xs" id="new-root-branch" name="new-root-branch" data-toggle="modal" data-target="#new-branch-modal" data-branchid="0">Add Branch to Root</button>
</div>
<table class="table">
   	<thead>
		<tr>
			<th>Tag Branch ID</th>
			<th>Parent Branch</th>
			<th>Title</th>
			<th>Tags</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{{$tablebody}}
	</tbody>
</table>

<div id="new-branch-modal" class="modal fade" role="dialog" title="Add Branch">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add New Branch</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="form-new-branch" action="admin/plugins/sharingecon" method="post">
					<input type="hidden" name="action" value="new-tag-branch">
					<input class="hidden" id="input-branch-id" name="input-branch-id">
					<div class="">
						<label for="input-title" class="control-label">Title</label>
						<input id="input-title" name="input-title" type="text" class="form-control">
					</div>
					<div class="">
						<label for="input-tags" class="control-label">Tags</label>
						<input id="input-tags" name="input-tags" type="text" class="form-control">
					</div>
				</form>
			</div>
			<div class="modal-footer">
	        	<button type="button" class="btn btn-primary" id="new-branch-submit">Submit</button>
	      	</div>
		</div>
	</div>
</div>

<div id="edit-branch-modal" class="modal fade" role="dialog" title="Edit Branch">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Branch</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="form-edit-branch" action="admin/plugins/sharingecon" method="post">
					<input type="hidden" name="action" value="edit-tag-branch">
					<input class="hidden" id="input-branch-id" name="input-branch-id">
					<div class="">
						<label for="input-parent" class="control-label">Parent</label>
						<input id="input-parent" name="input-parent" type="text" class="form-control">
					</div>
					<div class="">
						<label for="input-title" class="control-label">Title</label>
						<input id="input-title" name="input-title" type="text" class="form-control">
					</div>
					<div class="">
						<label for="input-tags" class="control-label">Tags</label>
						<input id="input-tags" name="input-tags" type="text" class="form-control">
					</div>
				</form>
			</div>
			<div class="modal-footer">
	        	<button type="button" class="btn btn-primary" id="edit-branch-submit">Submit</button>
	      	</div>
		</div>
	</div>
</div>

<div id="delete-branch-modal" class="modal fade" role="dialog" title="Edit Branch">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Delete Branch</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="form-delete-branch" action="admin/plugins/sharingecon" method="post">
					<input type="hidden" name="action" value="delete-tag-branch">
					<input class="hidden" id="input-branch-id" name="input-branch-id">
					Do You really want to delete this Branch?
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	        	<button type="button" class="btn btn-primary" id="delete-branch-submit">Yes</button>
	      	</div>
		</div>
	</div>
</div>