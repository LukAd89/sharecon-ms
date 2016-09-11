<h4>Tagtree</h4>
<div class="btn-group btn-group-vertical">
	<button type="button" class="btn btn-default btn-xs">Add Branch</button>
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
				<label for="input-title">Title</label>
				<input id="input-title" name="input-title" type="text">
				<label for="input-tags">Tags</label>
				<input id="input-tags" name="input-tags" type="text">
				<button type="button" class="btn btn-primary" id="add-branch-submit">Submit</button>
			</div>
			<div class="modal-footer">
	        	<button type="button" class="btn btn-primary">Submit</button>
	      	</div>
		</div>
	</div>
</div>