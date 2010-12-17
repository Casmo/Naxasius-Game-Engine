var last_action;
var mapLoading = false;
var actions = new Array();
$(document).ready(function() {
	$('div#map').load(url + 'game/maps');
	$(document).keyup(function(e){
		if(mapLoading == false) {
			mapLoading = true;
			if (e.keyCode == 37) {
		       $('div#map').load(url + 'game/areas/move/left', function(data){mapLoading = false;});
		    }
		    else if (e.keyCode == 38) {
		       $('div#map').load(url + 'game/areas/move/up', function(data){mapLoading = false;});
		    }
		    else if (e.keyCode == 39) {
		       $('div#map').load(url + 'game/areas/move/right', function(data){mapLoading = false;});
		    }
		    else if (e.keyCode == 40) {
		       $('div#map').load(url + 'game/areas/move/down', function(data){mapLoading = false;});
		    }
		    else {
		    	mapLoading = false;
		    }
	    }
		return;
	});
});

function showAction(target_url, action_id) {
	last_action = action_id;
	//$('div#action_' + action_id).fadeOut(500);
	$('div#actionsdetail_c').load(target_url, function(){
		$('div#actionsdetail_c').show();
		$('div#actionsdetail_c').borders();
	});
}
function hideAction() {
	$('div#actionsdetail_c').hide();
}
function removeAction() {
	hideAction();
	$('div#action_' + last_action).hide(0, function() {
		$('div#action_' + last_action).remove();
	});
}
function initActions() {
	$('div#actions_c').html('');
	divs = '';
	for(i=0;i<actions.length;i++) {
		divs = divs + '<div id="action_'+ i +'" class="action" style="margin-right: 10px;">'+ actions[i] +'</div>';
	}
	$('div#actions_c').html(divs);
	$('div.action').borders({offset: 3});
}
function initMap() {
	// Lopen in de map
	$('img[id^="move_"]').click(function(){
		direction = $(this).attr('id').replace(/move_/,'');
		if(mapLoading == false) {
		mapLoading = true;
		$('div#map').load(url + 'game/areas/move/'+ direction, function(data){mapLoading=false;});
		}
	});
}