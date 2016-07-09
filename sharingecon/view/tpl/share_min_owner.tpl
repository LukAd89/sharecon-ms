<div class="panel panel-default panel-share-object"> 
	<div class="panel-heading">
		<h4>{{$title}}</h4>
	</div>
	<div class="panel-body">
		<div class="media">
			<div class="media-left">
				<img class="media-object thumbnail" src="addon/sharingecon/standard.png" alt="...">
			</div>
			<div class="media-body">
				<div class="well">{{$shortdesc}}</div>
			</div>
		</div>
	</div>
	<div class="panel-footer">
		<div class="row">
			<div class="col-md-6">
				<div class="btn-group">
					<a href="sharingecon/editshare/{{$shareid}}" type="button" class="btn btn-default">Edit</a>
					<button name="btn-delete-share" type="button" class="btn btn-default" data-id="{{$shareid}}">Delete</button>
				</div>
			</div>
			<div class="col-md-6	">
				<div class="form-group field checkbox">
					<div class="pull-right">
						<input type="checkbox" onchange="toggleShare({{$shareid}}, (this.checked ? 0 : 1))" {{$checked}} value="1" id="active-toggle-{{$shareid}}" name="active-toggle-{{$shareid}}">
						<label for="active-toggle-{{$shareid}}" class="switchlabel">
							<span data-off="Off" data-on="On" class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
		</div>
	</div> 
</div>


