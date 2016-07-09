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
				<button type="submit" class="btn btn-primary" id="btn-add-new-share">{{$submitbutton}}</button>
			</div>
		
	</div>
</div>