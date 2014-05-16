<?php
/*
 * Created on Apr 2, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="action_actions">
<?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/move.png', array('title' => __('Move here', true), 'onclick' => 'move(\''. $area['Area']['id'] .'\')')); ?>
</div>
<div class="action_icon">
<?php echo $this->World->showArea($area); ?>
</div>
<div class="action_detail"><span class="title"><?php echo $area['Map']['name']; ?></span></div>
<script type="text/javascript">
function move(area_id) {
	$.get(url + 'game/areas/move/' + area_id, function(data) {
		// Data can be 1 or 0
		if(data == 0) {
			showMessage('<?php echo __('Your character couldn\\\'t be moved.'); ?>');
		}
		else {
			$('div#map').load(url + 'game/maps');
		}
		removeAction();
	});
}
setTimeout('actionBorders()', 10);
</script>