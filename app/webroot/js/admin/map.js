$(document).ready(function() {
	// put all your jQuery goodness in here.
	var wand_mode = 0;
	$('div.area').click(function() {
		org_area_id = $(this).attr('id');
		area_id = $(this).attr('id').replace(/[^0-9]+/,'');
		access = $('select#access').val();
		if(wand_mode == 0) {
			popup(url + '/admin/areas/edit/' + area_id);
		}
		else {
			// Opslaan van deze tile
			$.get(url + '/admin/areas/change_tile/' + area_id + '/' + tile_id +'/'+ access, function(data) {
				$('div#'+ org_area_id).css('background-image',$('div.wand_area').css('background-image'));
			});
		}
	});

	// This is the magic wand functions
	$('div.wand_area').click(function() {
		var tile_id = 0;
		popup(url + '/admin/tiles/magic_wand');
	});
	$('img#magic_wand').click(function() {
		if(wand_mode == 1) {
			// Turn off wand mode
			alert('Wand mode turned off');
			wand_mode = 0;
		}
		else {
			alert('Wand mode turned on');
			wand_mode = 1;
		}
	});
});