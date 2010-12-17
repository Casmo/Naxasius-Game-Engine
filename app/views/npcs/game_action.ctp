<?php
/*
 * Created on Apr 2, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="action_actions">
<?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/talk.png', array('title' => __('Talk with this npc', true), 'onclick' => 'talkpopup(\''. $npc['AreasNpc']['npc_id'] .'\')')); ?>
</div>
<div class="action_icon"><?php echo $html->image('/img/game/npcs/'. $npc['Npc']['icon']); ?></div>
<div class="action_detail"><span class="title"><?php echo $npc['Npc']['name']; ?></span></div>
<script type="text/javascript">
function talkpopup(npc_id) {
	showPopup(url + 'game/npcs/view/' + npc_id, '<?php echo $this->Html->url('/img/game/npcs/'. $npc['Npc']['icon']); ?>')
}
setTimeout('actionBorders()', 10);
</script>