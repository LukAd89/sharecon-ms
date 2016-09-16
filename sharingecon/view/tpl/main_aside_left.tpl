<div class="col-md-12">
	<a href="sharingecon"><img src="addon/sharingecon/img/ercis.png" class="img-responsive"></a>
	<hr>
	<div class="widget">
		<div class="btn-group btn-group-vertical btn-group-vertical-justified">
			<a href="sharingecon" class="btn btn-default">Main Page</a>
			<a href="sharingecon/newshare" class="btn btn-default">Add new Share</a>
			<a href="sharingecon/enquiries" class="btn btn-default">See Transactions</a>
			<a href="sharingecon/matches" class="btn btn-default">See Matches</a>
		</div>
	</div>
	<hr>
	<div class="widget {{$filterhidden}}">
		<h4>Your Location</h4>
		<div class="input-group">
			<input type="text" id="filter-location" name="filter-location" placeholder="Enter Adress" class="form-control" value="{{$curlocation}}">
			<span class="input-group-btn">
				<button type="button" class="btn btn-default" id="btn-set-location">Go</button>
			</span>
		</div>
		<hr>
		<h4>Filters</h4>
		<div class="input-group">
			<input type="hidden" value="{{$cursearch}}" id="currentsearch">
			<input type="text" id="filter-search" name="filter-search" placeholder="Search..." class="form-control" value="{{$cursearch}}">
			<span class="input-group-btn">
				<button type="button" class="btn btn-default" id="btn-search">Go</button>
			</span>
		</div>
		<br>
		<div class="btn-group btn-group-justified">
			<input type="hidden" value="{{$curorderby}}" id="currentorder">
			<a class="btn btn-default dropdown-toggle" data-toggle="dropdown"> Order By <span class="fa fa-caret-down"></span></a>
			<ul class="dropdown-menu" role="menu">
				<li>
					<a href="javascript:orderBy(0);">Name</a>
				</li>
				<li>
					<a href="javascript:orderBy(1);">Rating</a>
				</li>
				<li>
					<a href="javascript:orderBy(2);">Distance</a>
				</li>
			</ul>
		</div>
		<div class="form-group field checkbox">
			<label for="filter-favsonly">Show Favorites only</label>
			<div class="pull-right">
				<input type="checkbox" onchange="setFavoritesFilter(this.checked)" {{$filterfavschecked}} value="1" id="filter-favsonly" name="filter-favsonly">
				<label for="filter-favsonly" class="switchlabel">
					<span data-off="Off" data-on="On" class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div>
		<div class="form-group field checkbox">
			<label for="filter-friendsonly">Show Friends only</label>
			<div class="pull-right">
				<input type="checkbox" onchange="setFriendsFilter(this.checked)" {{$filterfriendschecked}} value="1" id="filter-friendsonly" name="filter-friendsonly">
				<label for="filter-friendsonly" class="switchlabel">
					<span data-off="Off" data-on="On" class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
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
					<input type="hidden" name="action" value="add-new-share">
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