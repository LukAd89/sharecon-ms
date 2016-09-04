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
					<label for="input-short-desc" class="control-label">Short Description</label>
					<input type="text" class="form-control" name="input-short-desc" id="input-short-desc" placeholder="Short Description of the Object" value="{{$shortdescvalue}}">
				</div>
				<div class="form-group">
					<label for="text-long-desc" class="control-label">Detailed Description</label>
					<textarea class="form-control" rows="5" name="text-long-desc" id="text-long-desc" placeholder="Detailed Description of the Object">{{$longdescvalue}}</textarea>
				</div>
				
				<hr>
				
				<div class="form-group">
					<label for="select-range" class="control-label">Make Object visible by</label>
					<select class="form-control" name="select-range" id="select-range">
						<option value="0" {{$seleb}}>Everybody</option>
						<option value="1" {{$selfr}}>Friends only</option>
					</select>
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