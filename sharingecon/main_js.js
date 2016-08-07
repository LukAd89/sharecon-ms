
/*
function test(){
	$.post("addon/sharingecon/sharingecon.php", {test : "test"}, function(data){
		console.log(data);
	});
}
function test_ajax_json(){
	$.ajax({
		type : "POST",
		url : "addon/sharingecon/sharingecon.php",
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
*/
$(document).ready(function(){
	
	nlp = window.nlp_compromise;
	
	$("#btn-add-new-share").click(function(){
		//addNewShare();
		$("#form-add-new-share").submit();
	});
	
	$("#btn-add-new-request").click(function(){
		$("#form-add-new-request").submit();
	});
	
	$("#btn-edit-share").click(function(){
		$("#form-add-new-share").submit();
	});
	
	$("#btn-send-message").click(function(){
		//$("#form-write-message").submit();
		sendMessage();
		$("#modal-write-message").modal('hide');
	});
	
	$("#btn-reload-tags").click(function(){
		reloadTags();
	});
	
	$('#modal-write-message').on('show.bs.modal', function(e) {
		$('#input-message-shareid').val($(e.relatedTarget).data('id'));
	});
	
	/*
	$("button[name='btn-toggle-share']").click(function(){
		$.ajax({
			type : "POST",
			url : "sharingecon",
			data : {action : "toggle-share",
				id : $(this).attr('data-id'),
				state : $(this).attr('data-state')
			},
			success : function(msg){
				location.reload();
			}
		});
	});*/
	
	$("button[name='btn-delete-share']").click(function(){
		$.ajax({
			type : "POST",
			url : "sharingecon",
			data : {action : "delete-share",
				id : $(this).attr('data-id')
			},
			success : function(msg){
				location.reload();
			}
		});
	});
	
	/*
	$('[href=#tab-find-shares]').on('shown.bs.tab', function(event){
		loadShares({range : "all"});
	});
	*/
});

function toggleShare(id, newstate){
	$.ajax({
		type : "POST",
		url : "sharingecon",
		data : {"action" : "toggle-share",
			"id" : id,
			"state" : newstate
		},
		success : function(msg){
			location.reload();
		}
	});
}

function toggleFav(id, newstate){
	$.ajax({
		type : "POST",
		url : "sharingecon",
		data : {"function" : "toggle-fav",
			"id" : id,
			"state" : newstate
		},
		success : function(msg){
			location.reload();
		}
	});
}


function addNewShare(){

	$.ajax({
		type : "POST",
		url : "sharingecon",
		data : $("#form-add-new-share").serialize(),
		success : function(msg){
			location.href = "sharingecon/myshares";
		}
	});
}

function sendMessage(){
	$.ajax({
		type : "POST",
		url : "sharingecon",
		data : $("#form-write-message").serialize(),
		success : function(msg){
			//location.reload();
			$.jGrowl("Message sent", { sticky: false, theme: 'info', life: 2000 });
		}
	});
}

function reloadTags(){
	var inputstr = "This is a text as an example.";
	var tags = "";
	var inputterms = nlp.text(inputstr).terms();
	
	for(i=0; i<inputterms.length; i++){
		if(inputterms[i].tag == "Noun")
			tags = tags + ", " + inputterms[i].normal;
	}
	$("#dinput-tags").val(tags);
}

/*
function loadShares(args){
	$.ajax({
		type : "POST",
		url : "addon/sharingecon/sharingecon.php",
		dataType : "json",
		data : {function : "load-shares"},
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
*/