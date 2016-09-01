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