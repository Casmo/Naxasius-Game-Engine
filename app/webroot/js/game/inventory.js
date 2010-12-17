var last_bag_id;
$(document).ready(function() {
	initBags();
});
function initBags() {
	$('div#bags_c').load(url + 'game/bags');
}
function refreshInventory() {
// Bag refreshen
	if(last_bag_id != undefined) {
		if($('div#bag_inventory').html() != '') {
			loadBag(last_bag_id);
		}
	}
}
function loadBag(bag_id) {
	$('div#bag_inventory').load(url + 'game/bags/view/'+ bag_id);
}
function initBagDragDrop() {
	// Drop and draggable
	// Images (items) are drag and dropable
	// 'item_bag_'. $bag['Bag']['id'] .'_'. $index
	$('img[id^=item_bag_]').draggable({
		snap: 'div[id^=inventory_]', snapMode: 'inner',
		start: function() {
			$(this).css('zIndex', '102');
		},
		stop: function() {
			$(this).css('zIndex', '4');
		},
		revert: 'invalid'
	});
	// inventory_<?php echo $bag['Bag']['id']; ?>_<?php echo $index; ?>
	$('div[id^=inventory_]').droppable({
		drop: function(event, ui) {
			// Request old index
			from_bag_index = ui.draggable.attr('id');
			parts = from_bag_index.split(/_([0-9]+)/g);
			from_bag_id = parts[1];
			from_index = parts[3];
			// Request new index
			to_bag_index = $(this).attr('id');
			parts = to_bag_index.split(/_([0-9]+)/g);
			to_bag_id = parts[1];
			to_index = parts[3];
			completeUrl = url +'game/bags/change/'+ from_bag_id + '/' + from_index + '/' + to_bag_id + '/' + to_index;
			$('div#bag_inventory').load(completeUrl);
		}
	});
}
function initCharacterDragDrop() {
	var originalLeft = 0;
	var originalTop = 0;
	// Drop and draggable
	// Images (items) are drag and dropable
	// 'item_bag_'. $bag['Bag']['id'] .'_'. $index
	$('img[id^=inv_item_]').draggable({
		snap: 'div[id^=equip_]', snapMode: 'inner',
		start: function() {
			$(this).css('zIndex', '102');
			originalLeft = $(this).css('left');
			originalTop = $(this).css('top');
		},
		stop: function() {
			$(this).css('zIndex', '4');
		},
		revert: 'invalid'
	});
	// inventory_<?php echo $bag['Bag']['id']; ?>_<?php echo $index; ?>
	$('div[id^=equip_]').droppable({
		drop: function(event, ui) {
			// Item ID
			imgItemId = ui.draggable.attr('id');
			item_id = imgItemId.replace(/([^0-9]+)/, '');

			// Request the equiped area
			divEquipToId = $(this).attr('id');
			parts = divEquipToId.split(/_([a-z]+)/g);
			equip_to = parts[1];
			completeUrl = url +'game/characters/equip/'+ item_id + '/' + equip_to;
			$.ajax({
				url: completeUrl,
				success: function(data) {
					if(data == '1') {
						$('img#'+ imgItemId).draggable("destroy");
						$('div#inv_c_item_' + item_id).fadeOut();
						updateCharacterInfo(updateCharacterSheet);
						imageId = $('img#'+ imgItemId).attr('id');
						imageSrc = $('img#'+ imgItemId).attr('src');
						imageMouseover = $('img#'+ imgItemId).attr('onmouseover');
						imageMouseout = $('img#'+ imgItemId).attr('onmouseout');
						imgHtml = '<img src="'+ imageSrc +'" id="'+ imageId +'">';
						$('img#' + imageId).remove();
						$('div#' + divEquipToId).append(imgHtml);
						$('img#' + imageId).bind('mouseover', imageMouseover);
						$('img#' + imageId).bind('mouseout', imageMouseout);
					}
					else {
						$('img#'+ imgItemId).animate({
							left: originalLeft,
							top: originalTop
						},
						500);
					}
				}
			});
			//$('div#popup').load(completeUrl, function() {
			//	initPopup();
			//});
		}
	});
}