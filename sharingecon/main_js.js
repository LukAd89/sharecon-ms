
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
	var maxResPerPage = 5;
	
	$("#btn-add-new-share").click(function(){
		//addNewShare();
		$("#form-add-new-share").submit();
	});
	
	$("#btn-add-new-request").click(function(){
		$("#form-add-new-request").submit();
	});
	
	$("#btn-edit-share").click(function(){
		$("#form-edit-share").submit();
	});
	
	$("#btn-send-message").click(function(){
		//$("#form-write-message").submit();
		sendMessage();
		$("#modal-write-message").modal('hide');
		addEnquiry($("#form-write-message #input-message-shareid").val());
	});
	
	$("#btn-reload-tags").click(function(){
		reloadTags();
	});
	
	$('#modal-write-message').on('show.bs.modal', function(e) {
		$('#input-message-shareid').val($(e.relatedTarget).data('id'));
	});
	
	$("#btn-set-rating").click(function(){
		setRating();
		$("#modal-write-message").modal('hide');
	});
	
	$('#modal-set-rating').on('show.bs.modal', function(e) {
		$('#input-rating-transid').val($(e.relatedTarget).data('id'));
	});
	
	$("#btn-set-location").click(function(){
		setLocation();
	});
	
	$("#btn-search").click(function(){
		searchShares($("#filter-search").val());
	});
	
	$("#select-visibility").change(function() {
		if($("#select-visibility").val() == 1){
			$("#select-groups").parent().slideDown();
		}
		else{
			$("#select-groups").parent().slideUp();
		}
	})
	
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
	
	$("#pager li a").click(function(){
		var start = $(this).html().valueOf() - 1;
		var end = start + maxResPerPage;
		
		$("#pager .active").removeClass("active");
		$(this).parent().addClass("active");
		
		$("#tab-my-shares-content").children().css("display", "none");
		$("#tab-my-shares-content").children().slice(start,end).css("display", "block");
		$("#pager").css("display", "block");
	});
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
			//location.reload();
		}
	});
}

function toggleFav(id, newstate){
	$.ajax({
		type : "POST",
		url : "sharingecon",
		data : {"action" : "toggle-fav",
			"id" : id,
			"state" : newstate
		},
		success : function(msg){
			if(newstate == 1)
				$('#fav-toggle-btn-' + id).css("background-color", "lightgreen");
			else
				$('#fav-toggle-btn-' + id).css("background-color", "transparent");
			//location.reload();
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
	//var inputstr = "This is an example text text as an example.";
	var inputstr = $("#input-title").val() + ". " + $("#input-short-desc").val();
	var tags = [];
	var inputterms = nlp.text(inputstr).terms();
	
	for(i=0; i<inputterms.length; i++){
		if(inputterms[i].tag == "Noun"){
			var newEntry = inputterms[i].normal;
			if(jQuery.inArray(newEntry, tags) == -1)
				tags.push(newEntry);
		}
	}
	$("#input-tags").val(tags);
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

function manageEnquiry(enqid){
	$.ajax({
		type : "POST",
		url : "sharingecon",
		data : {"action" : "manage-enquiry",
			"id" : enqid
		},
		success : function(msg){
			location.href = "sharingecon/enquiries";
		}
	});
}

function addEnquiry(objid){
	$.ajax({
		type : "POST",
		url : "sharingecon",
		data : {"action" : "add-enquiry",
			"id" : objid
		},
		success : function(msg){
			//location.href = "sharingecon/findshares";
		}
	});
}

function setRating(){
	$.ajax({
		type : "POST",
		url : "sharingecon",
		data : {"action" : "set-rating",
			"transid" : $("#input-rating-transid").val(),
			"rating" : $("#select-rating").val()
		},
		success : function(msg){
			location.href = "sharingecon/enquiries";
		}
	});
}

function setLocation(){
	$.ajax({
		type : "POST",
		url : "sharingecon",
		data : {"action" : "set-location",
			"adress" : $("#filter-location").val(),
		},
		success : function(msg){
			location.href = "sharingecon/findshares";
		}
	});
}

function getDistance(shareid){
	$.ajax({
		type : "POST",
		url : "sharingecon",
		data : {"action" : "get-distance",
			"shareid" : shareid
		},
		success : function(msg){
			$("#distance").text(msg);
		}
	});
}

function searchShares(term){
		location.href = generateFilterParams(4, term);
}

function orderBy(criteria){
	location.href = generateFilterParams(0, criteria);
}

function setFavoritesFilter(seton){
	location.href = generateFilterParams();
}

function setFriendsFilter(seton){
	location.href = generateFilterParams();
}

function generateFilterParams(changedparam, value){
	var newHref = window.location.pathname;
	
	newHref += "?orderby=";
	newHref += (changedparam == 0) ? value : $('#currentorder').val();
	newHref += "&filterfavs=";
	newHref += ($('#filter-favsonly').is(':checked')) ? "1" : "0";
	newHref += "&filterfriends="
	newHref += ($('#filter-friendsonly').is(':checked')) ? "1" : "0";
	newHref += "&search="
	newHref += (changedparam == 4) ? value : $('#currentsearch').val();
	
	return newHref;
}