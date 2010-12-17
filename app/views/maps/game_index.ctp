<?php
/*
 * Created on Nov 14, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/map/move_up_1.png', array('id' => 'move_up', 'class' => 'top')); ?>
<?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/map/move_down_1.png', array('id' => 'move_down', 'class' => 'bottom')); ?>
<?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/map/move_left_1.png', array('id' => 'move_left', 'class' => 'left')); ?>
<?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/map/move_right_1.png', array('id' => 'move_right', 'class' => 'right')); ?>
<?php echo $world->show($areas, '', array('playerPosition' => $gameInfo['Character']['area_id'])); ?>
<script type="text/javascript">
actions = new Array();
<?php
foreach($actions as $i => $action) {
	if($action['type'] == 'Npc') {
	?>
	actions[<?php echo $i; ?>] = '<?php echo $this->Html->image('/img/game/npcs/'. $action['data']['icon'], array('onclick' => 'showAction(\''. $this->Html->url('/game/npcs/action/'. $action['data']['AreasNpc']['npc_id']) .'\', \''. $i .'\')')); ?>';
	<?php
	}
	elseif($action['type'] == 'Item') {
	?>
	actions[<?php echo $i; ?>] = '<?php echo $this->Html->image('/img/game/items/'. $action['data']['icon'], array('onclick' => 'showAction(\''. $this->Html->url('/game/areas_obstacles_items/action/'. $action['data']['AreasObstaclesItem']['id']) .'\', \''. $i .'\')')); ?>';
	<?php
	}
	elseif($action['type'] == 'Quest') {
	?>
	actions[<?php echo $i; ?>] = '<?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/quest-turnin.png', array('onclick' => 'showAction(\''. $this->Html->url('/game/quests/action/'. $action['data']['ActionsObstacle']['target_id'] .'/'. $action['data']['ActionsObstacle']['type']) .'\', \''. $i .'\')')); ?>';
	<?php
	}
	elseif($action['type'] == 'Area') {
	?>
	actions[<?php echo $i; ?>] = '<?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/move.png', array('onclick' => 'showAction(\''. $this->Html->url('/game/areas/action/'. $action['data']['Area']['id']) .'\', \''. $i .'\')')); ?>';
	<?php
	}
	elseif($action['type'] == 'Mob') {
	?>
	actions[<?php echo $i; ?>] = '<?php echo $this->Html->image('/img/game/mobs/32/'. $action['data']['Mob']['icon'], array('onclick' => 'showAction(\''. $this->Html->url('/game/areas_mobs/action/'. $action['data']['id']) .'\', \''. $i .'\')')); ?>';
	<?php
	}
}

// Change the map if it has been changed...
if(isset($gameInfo['Map']['image'])) {
?>
currentImage = $('img#minimap').html();
if(currentImage != '<?php echo addslashes($this->Html->url('/img/game/maps/medium/'. $gameInfo['Map']['image'])); ?>') {
	$('img#minimap').attr('src', '<?php echo $this->Html->url('/img/game/maps/medium/'. $gameInfo['Map']['image']); ?>');
	$('img#minimap').attr('title', '<?php echo addslashes($gameInfo['Map']['name']); ?>');
	$('span#map_title').html('<?php echo addslashes($gameInfo['Map']['name']); ?>');
	$('span#map_desc').html('(<?php echo addslashes($gameInfo['Map']['subname']); ?>)');
	$('span#map_system').html('<?php echo __('Battle type:', true) .' <span class="battletype_'. $gameInfo['Map']['battle_system'] .'">'. $gameInfo['Map']['battle_system']; ?></span>');
}
<?php
}
?>
hideAction();
initMap();
initActions();
</script>