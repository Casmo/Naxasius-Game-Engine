<?php
/*
 * Created on Apr 2, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="action_actions">
<?php
if($type == 'completequest') {
	echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/action_quest-turnin.png', array('title' => __('Turn in this quest', true), 'onclick' => 'quest(\''. $quest['Quest']['id'] .'\', \'completequest\')'));
}
else {
	echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/quest-available-small.png', array('title' => __('Get this quest', true), 'onclick' => 'quest(\''. $quest['Quest']['id'] .'\', \'getquest\')'));
}
?>
</div>
<div class="action_icon">
<?php
if($type == 'completequest') {
	echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/quest-turnin.png');
}
else {
	echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/quest-available.png');
}
?>
</div>
<div class="action_detail"><span class="title"><?php echo $quest['Quest']['name']; ?></span></div>
<script type="text/javascript">
function quest(quest_id, type) {
	$.get(url + 'game/quests/do_action/' + quest_id + '/' + type, function(data) {
		// Data can be 1 or 0
		if(data == 1) {
			<?php
			if($type == 'completequest') { ?>
			showMessage('<?php printf(__('Quest %s completed.', true), addslashes($this->Ubb->output('[quest]'. $quest['Quest']['name'] .'[/quest]'))); ?>');
			updateCharacterInfo();
			<?php } else { ?>
			showMessage('<?php printf(__('Quest %s accepted.', true), addslashes($this->Ubb->output('[quest]'. $quest['Quest']['name'] .'[/quest]'))); ?>');
			<?php } ?>
		}
		else {
			showMessage('<?php printf(__('Quest %s could not be found.', true), addslashes($quest['Quest']['name'])); ?>');
		}
		removeAction();
	});
}
setTimeout('actionBorders()', 10);
</script>