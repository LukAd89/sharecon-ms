

function test(){
	console.log("This is a Test");
}
function test_ajax(){
	$.ajax({
		type : "POST",
		url : "db_functions.php",
		data : {test : true},
		success : function(msg){
			console.log(msg);
		},
		error : function(){
			console.log("error");
		}
	});
}

$(document).ready(function(){
	/* Called when Submit button of Add New Share form is clicked */
	$("#btn_addNewShare").click(function(){
		addNewShare();
	});

	$('[href=#tab-find-shares]').on('shown.bs.tab', function(event){
		loadShares();
	});
});

function addNewShare(){
	$.ajax({
		type : "POST",
		url : "sharingecon/db_functions.php",
		data : $("#form_addNewShare").serialize() + "&function=addNewShare",
		success : function(msg){
			console.log(msg);
			$("#modal_addNewShare").modal('hide');
		},
		error : function(){
			console.log("error");
		}
	});
}

function loadShares(){
	$.ajax({
		type : "POST",
		url : "addon/sharingecon/db_functions.php",
		dataType : "json",
		data : {function : "loadShares"},
		success : function(msg){
			console.log(msg);
			var jsonObj = jQuery.parseJSON(msg);
			
			$('#tab-find-shares-content').html("");
			
			for(i=0; i<jsonObj.length; i++){
				$('#tab-find-shares-content').append('<div class="panel panel-default">' + 
					'<div class="panel-heading"><i class="fa fa-file"></i>' + jsonObj[i].Title + '</div>' + 
					'<div class="panel-body"><div class="media"><div class="media-left"><img class="media-object" src="standard.png" alt="..."></div><div class="media-body"><div class="well">' + jsonObj[i].ShortDesc + '</div></div></div></div>' + 
					'<div class="panel-footer"><div class="row"></div></div>' + 
					'</div>');
			}
		},
		error: function(xhr, options, error) {
			alert(xhr.responseText);
		}
	});
}