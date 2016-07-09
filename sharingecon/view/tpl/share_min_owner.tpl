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
			<div class="col-md-12">
				<div class="btn-group">
					<a href="sharingecon/editshare/{{$shareid}}" type="button" class="btn btn-default">Edit</a>
					<button name="btn-delete-share" type="button" class="btn btn-default" data-id="{{$shareid}}">Delete</button>
					<button name="btn-toggle-share" type="button" class="btn btn-default" data-id="{{$shareid}}" data-state="{{$btntoggle}}">{{$btntoggletext}}</button>
				</div>
			</div>
		</div>
	</div> 
</div>


