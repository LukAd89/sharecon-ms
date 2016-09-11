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
				<div class="well">{{$wellbody}}</div>
			</div>
		</div>
	</div>
	<div class="panel-footer">
		<div class="row">
			<div class="col-md-12">
				<div class="btn-group">
					<input type="checkbox" class="hidden" onchange="toggleFav({{$shareid}}, (this.checked ? 1 : 0))" value="1" id="fav-toggle-{{$shareid}}" name="fav-toggle-{{$shareid}}">
						<label for="fav-toggle-{{$shareid}}">
							<span id="fav-toggle-btn-{{$shareid}}" class="btn btn-default glyphicon glyphicon-star{{$favstar}}" {{$checked}}>Favorite</span>
						</label>
					
					<a href="sharingecon/viewshare/{{$shareid}}" type="button" class="btn btn-default pull-right">
						<span class="glyphicon glyphicon-info-sign"></span> More Details
					</a>
					<button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#modal-write-message" data-id="{{$shareid}}">
						<span class="glyphicon glyphicon-envelope"></span> Write Message
					</button>
				</div>
			</div>
		</div>
	</div> 
</div>


