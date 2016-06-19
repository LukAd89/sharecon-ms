

function test(){
	console.log("This is a Test");
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
		success : function(data){
			console.log("returned: ");
			console.log(data);
			console.log(jQuery.parseJSON('[{"Title":"T1","ShortDesc":"SD1"},{"Title":"T2","ShortDesc":"SD2"}]'));
			var jsonObj = data[0]; //jQuery.parseJSON(data[0]);
			
			$('#tab-find-shares-content').html("");
			
			for(i=0; i<jsonObj.length; i++){
				$('#tab-find-shares-content').append('<div class="panel panel-default">' + 
					'<div class="panel-heading">' + jsonObj[i].Title + '</div>' + 
					'<div class="panel-body"><div class="media"><div class="media-left"><img class="media-object" src="sharecon/standard.png" alt="..."></div><div class="media-body"><div class="well">' + jsonObj[i].ShortDesc + '</div></div></div></div>' + 
					'<div class="panel-footer"><div class="row"></div></div>' + 
					'</div>');
			}
		},
		error: function(xhr, options, error) {
			alert(xhr.responseText);
		}
	});
}