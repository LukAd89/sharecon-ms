<div class="col-md-12">
	<h1>Sharing Economy Plugin</h1>
	<hr>
	<div class="panel panel-default" id="panel-wholepage"> 
		<div class="panel-heading">
			<h4 class="panel-title">{{$title}}</h4>
		</div>
		
		
			<div class="panel-body">
				<input type="hidden" name="input-function" value="{{$function}}">
				<div>
					{{$sharebody}}
				</div>
				<hr>
				<div>
					<img src="addon/sharingecon/standard.png" class="img-responsive center-block" alt="Responsive image">
				</div>
			
			</div>
			<div class="panel-footer">
				<button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#modal-write-message" data-id="{{$shareid}}">
					<span class="glyphicon glyphicon-envelope"></span> Write Message
				</button>
			</div>
		
	</div>
</div>


<div class="modal fade" id="modal-write-message">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Write Message to Owner</h4>
			</div>
			<form class="form-horizontal" role="form" id="form-write-message" action="sharingecon" method="post">
				<div class="modal-body">
					
						<input type="hidden" name="input-message-shareid" id="input-message-shareid" value="">
						<input type="hidden" name="input-function" value="write-message">
						<div class="form-group">
							<div class="col-sm-2">
								<label for="input-message-subject" class="control-label">Subject</label>
							</div>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="input-message-subject" id="input-message-subject" placeholder="Subject">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2">
								<label for="input-message-body" class="control-label">Body</label>
							</div>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="input-message-body" id="input-message-body" placeholder="">
							</div>
						</div>
					
				</div>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Close</a>
					<button type="" class="btn btn-primary" id="btn-send-message">Send</button>
				</div>
			</form>
		</div>
	</div>
</div>