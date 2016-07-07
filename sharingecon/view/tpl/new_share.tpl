<div class="col-md-12">
	<h1>Sharing Economy Plugin</h1>
	<hr>
	<div class="panel panel-default panel-share-object"> 
		<div class="panel-heading">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">Add new Share</h4>
		</div>
		
		<form class="form-horizontal" role="form" id="form-add-new-share" action="sharingecon" method="post">
		
		<div class="panel-body">
				<input type="hidden" name="input-function" value="add-new-share">
				<div class="form-group">
					<label for="input-title" class="control-label">Title</label>
					<input type="text" class="form-control" name="input-title" id="input-title" placeholder="Name of the Object">
				</div>
				<div class="form-group">
					<label for="input-short-desc" class="control-label">Short Description</label>
					<input type="text" class="form-control" name="input-short-desc" i="input-short-desc" placeholder="Short Description of the Object">
				</div>
				<div class="form-group">
					<label for="text-long-desc" class="control-label">Detailed Description</label>
					<textarea class="form-control" rows="5" name="text-long-desc" id="text-long-desc" placeholder="Detailed Description of the Object"></textarea>
				</div>
				
				<hr>
				
				<div class="form-group">
					<label for="select-range" class="control-label">Short Description</label>
					<select class="form-control" name="select-range" id="select-range">
						<option>Everybody</option>
						<option>Friends only</option>
					</select>
				</div>
				
			
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary" id="btn-add-new-share">Add Share</button>
		</div>
		
		</form>
		
	</div>
</div>