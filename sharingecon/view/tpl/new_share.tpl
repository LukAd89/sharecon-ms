<div class="col-md-12">
	<h1>Sharing Economy Plugin</h1>
	<hr>
	<div class="panel panel-default" id="panel-wholepage"> 
		<div class="panel-heading">
			<h4 class="panel-title">Add New Share</h4>
		</div>
		
		<form class="" role="form" id="form-add-new-share" action="sharingecon" method="post" enctype="multipart/form-data">
		
			<div class="panel-body">
				<input type="hidden" name="action" value="add-new-share">
				
				<div class="form-group">
					<label for="select-type" class="control-label">Type of Insertion</label>
					<select class="form-control" name="select-type" id="select-type">
						<option value="0">Offer this Object to others</option>
						<option value="1">Search for an Object</option>
					</select>
				</div>
				
				<hr>
				
				<div class="form-group">
					<label for="input-title" class="control-label">Title</label>
					<input type="text" class="form-control" name="input-title" id="input-title" placeholder="What do You want to offer / search?">
				</div>
				<div class="form-group">
					<label for="text-long-desc" class="control-label">Description</label>
					<textarea class="form-control" rows="5" name="text-description" id="text-long-desc" placeholder="Give a detailed description of the Object"></textarea>
				</div>
				<div class="form-group">
					<label for="input-image" class="control-label">Object Image</label>
					<input type="file" class="form-control" name="input-image" id="input-image">
				</div>
				
				<hr>
				
				<div class="form-group">
					<label for="select-visibility" class="control-label">Make Object visible for</label>
					<select class="form-control" name="select-visibility" id="select-visibility">
						<option value="0">Everybody</option>
						<option value="1">Friends only</option>
					</select>
				</div>
				
				<div class="form-group" style="display:none;">
					<label for="select-groups" class="control-label">Select Group</label>
					<select class="form-control" name="select-groups[]" id="select-groups" size="5" multiple>
						{{$groups}}
					</select>
				</div>
				
				<hr>
				
				<div class="form-group">
					<label for="input-location" class="control-label">Adress</label>
					<input type="text" class="form-control" name="input-location" id="input-location" placeholder="Where to find the Object or You">
				</div>
				
				<hr>
				
				<div class="form-group">
					<label for="input-tags" class="control-label">Tags</label>
					<input type="text" class="form-control" name="input-tags" id="input-tags" placeholder="">
					<button type="button" class="btn" id="btn-reload-tags">
						<span class="glyphicon glyphicon-refresh"></span>
					</button>
				</div>
			</div>
		</form>
		<div class="panel-footer">
			<button type="button" class="btn btn-primary" id="btn-add-new-share">Submit</button>
		</div>
	</div>
</div>