<div class="col-md-12">
	<h1>Sharing Economy Plugin</h1>
	<hr>
	<ul class="nav nav-justified nav-tabs" role="tablist">
		<li role="presentation" class="active">
			<a href="#tab-my-shares" role="tab" data-toggle="tab">My Shares<br></a>
		</li>
		 <li class="" role="presentation">
			<a href="#tab-find-shares" data-toggle="tab">Find Shares<br></a>
		 </li>
		</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="tab-my-shares">
			<div class="page-header">
				<h1>My Shares</h1>
			</div>
			<div class="col-md-12">Test Content</div>
		</div>
		<div class="tab-pane" role="tabpanel" id="tab-find-shares">
			<div class="page-header">
				<h1>Find Shares</h1>
			</div>
			<div class="col-md-12" id="tab-find-shares-content">Test Content</div>
		</div>
	</div>
</div>


<!-- Modal for entering new object -->
<div class="modal fade" id="modal_addNewShare">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add new Share</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="form_addNewShare">
					<div class="form-group">
						<div class="col-sm-2">
							<label for="inputTitle" class="control-label">Title</label>
						</div>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="inputTitle" id="inputTitle" placeholder="Name of the Object">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2">
							<label for="inputShortDesc" class="control-label">Short Description</label>
						</div>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="inputShortDesc" id="inputShortDesc" placeholder="Short Description of the Object">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Close</a>
				<button type="submit" class="btn btn-primary" id="btn_addNewShare">Add Share</a>
			</div>
		</div>
	</div>
</div>
