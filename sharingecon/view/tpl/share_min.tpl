<div class="panel panel-default panel-share-object" style="display:{{$display}}"> 
	<div class="panel-heading">
		<h4>{{$title}}</h4>
	</div>
	<div class="panel-body">
		<div class="media">
			<div class="media-left">
				<img class="media-object thumbnail share-thumbnail" src="addon/sharingecon/uploads/images/{{$imagename}}" alt="...">
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
					<button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#modal-write-message" data-id="{{$shareid}}">
						<span class="glyphicon glyphicon-envelope"></span> Write Message
					</button>
				</div>
				<div class="form-group field checkbox">
					<div class="pull-right">
						<input type="checkbox" onchange="toggleFac({{$shareid}}, (this.checked ? 0 : 1))" {{$checked}} value="1" id="fav-toggle-{{$shareid}}" name="fav-toggle-{{$shareid}}">
						<label for="fav-toggle-{{$shareid}}">
							<span class="glyphicon glyphicon-star{{$favstar}}"></span>
						</label>
					</div>
				</div>
			</div>
		</div>
	</div> 
</div>


