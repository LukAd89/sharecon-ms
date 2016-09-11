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

<div id="new-branch-dialog" title="Add Branch">
	<form action="" method="post">
		<label for="input-title">Title</label>
		<input id="input-title" name="input-title" type="text">
		<label for="input-tags">Tags</label>
		<input id="input-tags" name="input-tags" type="text">
		<button type="button" class="btn btn-primary" id="add-branch-submit">Submit</button>
	</form>
</div>