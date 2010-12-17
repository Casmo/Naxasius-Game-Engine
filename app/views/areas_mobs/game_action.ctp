<?php
/*
 * Created on Apr 2, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="action_actions"><?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/attack_auto.png', array('title' => __('Auto attack', true), 'onclick' => 'attack_mob(\''. $areasMob['AreasMob']['id'] .'\')')); ?></div>
<div class="action_actions"><?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/eye.png', array('title' => __('Inspect mob', true), 'onclick' => 'view_mob(\''. $areasMob['AreasMob']['id'] .'\')')); ?></div>
<div class="action_icon"><?php echo $this->Html->image('/img/game/mobs/32/'. $areasMob['Mob']['icon']); ?></div>
<div class="action_detail"><span class="title"><?php echo $areasMob['Mob']['name']; ?></span></div>
<script type="text/javascript">
function attack_mob(areas_mobs_id) {
	showPopup(url + 'game/areas_mobs/attack/' + areas_mobs_id, '<?php echo $this->Html->url('/img/game/mobs/32/'. $areasMob['Mob']['icon']); ?>');
}
function view_mob(areas_mobs_id) {
	showPopup(url + 'game/areas_mobs/view/' + areas_mobs_id, '<?php echo $this->Html->url('/img/game/mobs/32/'. $areasMob['Mob']['icon']); ?>');
}
setTimeout('actionBorders()', 10);
</script>