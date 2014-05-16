<?php
/*
 * Created on Apr 2, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="action_actions"><?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/pickup.png', array('title' => __('Loot item'), 'onclick' => 'pickup_item(\''. $item['AreasObstaclesItem']['id'] .'\')')); ?></div>
<div class="action_icon"><?php echo $this->Html->image('/img/game/items/'. $item['Item']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $item['Item']['name'] .'\');')); ?></div>
<div class="action_detail"><span class="title"><?php echo $item['Item']['name']; ?></span></div>
<script type="text/javascript">
function pickup_item(areas_obstacles_items_id) {
	$.get(url + 'game/drops/loot/' + areas_obstacles_items_id, function(data) {
		// Data can be 1 or 0
		if(data == '0') {
			message = '<?php echo printf(__('Item %s could not be looted.'), addslashes($item['Item']['name'])); ?>';
			showMessage(message);
		}
		else {
			message = '<?php echo printf(__('Item %s looted.'), addslashes($this->Ubb->output('[item]'. $item['Item']['name'] .'[/item]'))); ?>';
			showMessage(message);
			refreshInventory();
		}
		removeAction();
	});
}
setTimeout('actionBorders()', 10);
</script>