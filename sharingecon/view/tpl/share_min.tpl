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
					<a href="sharingecon/viewshare/{{$shareid}}" type="button" class="btn btn-default pull-right">
						<span class="glyphicon glyphicon-info-sign"></span> More Details
					</a>
					<button type="button" class="btn btn-default pull-right">
						<span class="glyphicon glyphicon-envelope"></span> Write Message
					</button>
				</div>
			</div>
		</div>
	</div> 
</div>