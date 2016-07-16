<div class="col-md-12">
	<h1>Sharing Economy Plugin</h1>
	<hr>
	<div class="panel panel-default" id="panel-wholepage"> 
		<div class="panel-heading">
			<h4 class="panel-title">{{$title}}</h4>
		</div>
		
		<form class="" role="form" id="form-add-new-share">
		
			<div class="panel-body">
				<input type="hidden" name="action" value="{{$action}}">
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
					<label for="select-range" class="control-label">Make Object visible by</label>
					<select class="form-control" name="select-range" id="select-range">
						<option value="everybody">Everybody</option>
						<option value="friends">Friends only</option>
					</select>
				</div>
				
			
			</div>
		</form>
		<div class="panel-footer">
			<button type="button" class="btn btn-primary" id="btn-add-new-share">{{$submitbutton}}</button>
		</div>
	</div>
</div>