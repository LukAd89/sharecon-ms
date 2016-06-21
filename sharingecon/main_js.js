

function test(){
	$.post("addon/sharingecon/sharingecon.php", {function : "test"}, function(data){
		console.log(data);
	});
}
function test_ajax_json(){
	$.ajax({
		type : "POST",
		url : "addon/sharingecon/db_functions.php",
		dataType: "json",
		data : {test : true},
		success : function(data){
			console.log(data);
		},
		error: function(xhr, options, error) {
			alert("error:" + xhr.responseText);	
		}
	});
}

$(document).ready(function(){
	$("#btn-add-new-share").click(function(){
		addNewShare();
	});

	$('[href=#tab-find-shares]').on('shown.bs.tab', function(event){
		loadShares({range : "all"});
	});
});

function addNewShare(){

	$.ajax({
		type : "POST",
		url : "addon/sharingecon/sharingecon.php",
		data : $("#form-add-new-share").serialize() + "&function=add_new_share",
		success : function(msg){
			console.log(msg);
			$("#modal-add-new-share").modal('hide');
		},
		error : function(){
			console.log("error");
		}
	});
}

function loadShares(args){
	$.ajax({
		type : "POST",
		url : "addon/sharingecon/db_functions.php",
		dataType : "json",
		data : {function : "load_shares", args : args},
		success : function(data){
			var jsonObj = data;
			
			$('#tab-find-shares-content').html("");
			
			for(i=0; i<jsonObj.length; i++){
				$('#tab-find-shares-content').append('<div class="panel panel-default panel-share-object">' + 
					'<div class="panel-heading"><h4>' + jsonObj[i].Title + '</h4></div>' + 
					'<div class="panel-body"><div class="media"><div class="media-left"><img class="media-object thumbnail" src="addon/sharingecon/standard.png" alt="..."></div><div class="media-body"><div class="well">' + jsonObj[i].ShortDesc + '</div></div></div></div>' + 
					'<div class="panel-footer"><div class="row"><div class="col-md-12"><div class="btn-group"><a href="sharingecon/viewshare/' + jsonObj[i].ID + '" type="button" class="btn btn-default pull-right"><span class="glyphicon glyphicon-info-sign"></span> More Details</a><button type="button" class="btn btn-default pull-right"><span class="glyphicon glyphicon-envelope"></span> Write Message</button></div></div></div></div>' + 
					'</div>');
			}
		},
		error: function(xhr, options, error) {
			alert(xhr.responseText);
		}
	});
}