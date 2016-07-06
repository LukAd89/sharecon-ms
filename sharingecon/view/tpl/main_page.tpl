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

