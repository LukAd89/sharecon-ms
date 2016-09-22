<div class="col-md-12">
	<h1>Sharing Economy Plugin</h1>
	<hr>
	<div class="panel panel-default" id="panel-wholepage"> 
		<div class="panel-heading">
			<h4 class="panel-title">Edit Share</h4>
		</div>
		
		<form class="" role="form" id="form-edit-share" action="sharingecon" method="post" enctype="multipart/form-data">
		
			<div class="panel-body">
				<input type="hidden" name="action" value="edit-share">
				{{$additional}}
				<div class="form-group">
					<label for="input-title" class="control-label">Title</label>
					<input type="text" class="form-control" name="input-title" id="input-title" placeholder="Name of the Object" value="{{$titlevalue}}">
				</div>
				<div class="form-group">
					<label for="text-long-desc" class="control-label">Description</label>
					<textarea class="form-control" rows="5" name="text-description" id="text-long-desc" placeholder="Detailed Description of the Object">{{$descvalue}}</textarea>
				</div>
				<div class="form-group">
					<label for="input-image" class="control-label">Object Image</label>
					<input type="file" class="form-control" name="input-image" id="input-image">
				</div>
				
				<hr>
				
				<div class="form-group" style="{{$groupstyle}}">
					<label for="select-range" class="control-label">Make Object visible by</label>
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
					<label for="input-location" class="control-label">Address</label>
					<input type="text" class="form-control" name="input-location" id="input-location" value="{{$location}}">
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
			<button type="button" class="btn btn-primary" id="btn-edit-share">Submit Changes</button>
		</div>
	</div>
</div>