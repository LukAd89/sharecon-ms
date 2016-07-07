<div class="col-md-12">
	<a href="#"><img src="addon/sharingecon/ercis.png" class="img-responsive"></a>
	<hr>
	<div class="btn-group btn-group-vertical btn-group-vertical-justified">
		<a href="sharingecon/newshare" class="btn btn-default" data-toggle="modal" data-target="#modal-add-new-share">Add new Share</a>
		<div class="btn-group">
			<a class="btn btn-default dropdown-toggle" data-toggle="dropdown"> Order By <span class="fa fa-caret-down"></span></a>
			<ul class="dropdown-menu" role="menu">
				<li>
					<a href="#" onclick="test();">Name</a>
				</li>
				<li>
					<a href="#">Date</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<!--
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
							<label for="input-title" class="control-label">Title</label>
						</div>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="input-title" id="input-title" placeholder="Name of the Object">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2">
							<label for="input-short-desc" class="control-label">Short Description</label>
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
-->