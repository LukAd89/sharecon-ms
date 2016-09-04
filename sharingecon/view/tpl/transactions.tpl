<div class="col-md-12">
	<h1>Sharing Economy Plugin</h1>
	<hr>
	<h4>Incoming Enquiries</h4>
	<table class="table">
    	<thead>
			<tr>
				<th>Share Object</th>
				<th>Customer</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			{{$tablebodyenq}}
		</tbody>
	</table>
	
	<hr>
	
	<h4>Past Transactions</h4>
	<table class="table">
    	<thead>
			<tr>
				<th>Share Object</th>
				<th>Owner</th>
				<th>Lend on</th>
				<th>Lend until</th>
				<th>Rating</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			{{$tablebodypast}}
		</tbody>
	</table>
</div>

<div class="modal fade" id="modal-set-rating">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Rate Sharing Object</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="form-set-rating" action="" method="post">
					<input type="hidden" name="input-rating-transid" id="input-rating-transid" value="">
					<input type="hidden" name="action" value="set-rating">
					<div class="form-group">
						<div class="col-sm-12">
							<select class="form-control" name="select-rating" id="select-rating">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Close</a>
				<button type="button" class="btn btn-primary" id="btn-set-rating">OK</button>
			</div>
		</div>
	</div>
</div>