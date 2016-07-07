<div class="col-md-12">
	<h1>Sharing Economy Plugin</h1>
	<hr>
	<ul class="nav nav-justified nav-tabs" role="tablist">
		<li role="presentation" class="{{$tab1}}">
			<a href="#tab-my-shares" role="tab" data-toggle="tab">My Shares<br></a>
		</li>
		 <li class="{{$tab2}}" role="presentation">
			<a href="#tab-find-shares" data-toggle="tab">Find Shares<br></a>
		 </li>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane {{$tab1}}" id="tab-my-shares">
			<div class="page-header">
				<h1>My Shares</h1>
			</div>
			<div class="col-md-12" id="tab-my-shares-content">{{$tab1content}}</div>
		</div>
		<div class="tab-pane {{$tab2}}" role="tabpanel" id="tab-find-shares">
			<div class="page-header">
				<h1>Find Shares</h1>
			</div>
			<div class="col-md-12" id="tab-find-shares-content">{{$tab2content}}</div>
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
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="form-write-message" action="sharingecon" method="post">
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
				</form>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Close</a>
				<button type="" class="btn btn-primary" id="btn-send-message">Send</button>
			</div>
		</div>
	</div>
</div>
