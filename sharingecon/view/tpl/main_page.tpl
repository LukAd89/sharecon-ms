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
			<div class="col-md-12">Test Content</div>
		</div>
		<div class="tab-pane {{$tab2}}" role="tabpanel" id="tab-find-shares">
			<div class="page-header">
				<h1>Find Shares</h1>
			</div>
			<div class="col-md-12" id="tab-find-shares-content">Test Content</div>
		</div>
	</div>
</div>


<!-- Modal for entering new object -->
<div class="modal fade" id="modal-add-new-share">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add new Share</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="form-add-new-share" action="sharingecon" method="post">
					<input type="hidden" name="input-function" value="add-new-share">
					<div class="form-group">
						<div class="col-sm-2">
							<label for="inputTitle" class="control-label">Title</label>
						</div>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="input-title" id="input-title" placeholder="Name of the Object">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2">
							<label for="inputShortDesc" class="control-label">Short Description</label>
						</div>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="input-short-desc" id="input-short-desc" placeholder="Short Description of the Object">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Close</a>
				<button type="submit" class="btn btn-primary" id="btn-add-new-share">Add Share</button>
			</div>
		</div>
	</div>
</div>
