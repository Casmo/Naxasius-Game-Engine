<?php
/*
 * Created on Nov 25, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php /* echo '<a href="#edit" onclick="popup(\''. $this->Html->url('/drops/edit/'. $this->data['AreasObstacle']['id']) .'\');">'. __('Refresh', true) .'</a>'; */ ?>
<h1><?php echo __('Edit drops for area'); ?>: #<?php echo $this->data['AreasObstacle']['id']; ?></h1>
<?php
echo $this->Form->create('Drop', array('action' => 'edit'));
echo $this->Form->input('id', array('type' => 'hidden', 'name' => 'data[areaobstacle_id]', 'value' => $this->data['AreasObstacle']['id']));
$index = 0;
foreach($this->data['Item'] as $item) {
echo $this->Form->input('AreasObstaclesItem.check', array('name' => 'data[AreasObstaclesItem]['. $index .'][check]', 'value' => 1, 'type' => 'checkbox', 'div' => false, 'label' => false, 'checked' => 'checked'));
echo $this->Form->input('AreasObstaclesItem.areas_obstacle_id', array('type' => 'hidden', 'name' => 'data[AreasObstaclesItem]['. $index .'][areas_obstacle_id]', 'value' => $this->data['AreasObstacle']['id']));
echo $this->Form->input('items', array('name' => 'data[AreasObstaclesItem]['. $index .'][item_id]', 'div' => false, 'value' => $item['AreasObstaclesItem']['item_id']));
echo $this->Form->input('AreasObstaclesItem.spawn_time', array('name' => 'data[AreasObstaclesItem]['. $index .'][spawn_time]', 'div' => false, 'size' => 1, 'value' => $item['AreasObstaclesItem']['spawn_time']));
echo $this->Form->input('AreasObstaclesItem.max_drop', array('name' => 'data[AreasObstaclesItem]['. $index .'][max_drop]', 'div' => false, 'size' => 1, 'value' => $item['AreasObstaclesItem']['max_drop']));
echo $this->Form->input('AreasObstaclesItem.player_only', array('name' => 'data[AreasObstaclesItem]['. $index .'][player_only]', 'div' => false, 'checked' => $item['AreasObstaclesItem']['player_only'] == 1 ? 'checked' : '', 'value' => $item['AreasObstaclesItem']['player_only'], 'type' => 'checkbox'));
echo $this->Form->input('AreasObstaclesItem.quest_id', array('name' => 'data[AreasObstaclesItem]['. $index .'][quest_id]', 'options' => $quests, 'div' => false, 'value' => $item['AreasObstaclesItem']['quest_id'], 'type' => 'select'));
echo '<br />';
$index++;
}
echo $this->Form->input('AreasObstaclesItem.check', array('name' => 'data[AreasObstaclesItem]['. $index .'][check]', 'value' => 1, 'type' => 'checkbox', 'div' => false, 'label' => false));
echo $this->Form->input('AreasObstaclesItem.areas_obstacle_id', array('type' => 'hidden', 'name' => 'data[AreasObstaclesItem]['. $index .'][areas_obstacle_id]'));
echo $this->Form->input('items', array('name' => 'data[AreasObstaclesItem]['. $index .'][item_id]', 'div' => false));
echo $this->Form->input('AreasObstaclesItem.spawn_time', array('name' => 'data[AreasObstaclesItem]['. $index .'][spawn_time]', 'div' => false, 'size' => 1));
echo $this->Form->input('AreasObstaclesItem.max_drop', array('name' => 'data[AreasObstaclesItem]['. $index .'][max_drop]', 'div' => false, 'size' => 1, 'value' => '0'));
echo $this->Form->input('AreasObstaclesItem.player_only', array('name' => 'data[AreasObstaclesItem]['. $index .'][player_only]', 'div' => false, 'type' => 'checkbox'));
echo $this->Form->input('AreasObstaclesItem.quest_id', array('name' => 'data[AreasObstaclesItem]['. $index .'][quest_id]', 'options' => $quests, 'div' => false, 'value' => 0, 'type' => 'select'));
?>
<?php echo $this->Form->end('save'); ?>
<script type="text/javascript">

var options = {
	success:       showResponse  // post-submit callback
};
$('#DropEditForm').ajaxForm(options);
function showResponse(responseText, statusText) {
	// .css('background-image','url(whatever)');
	hidePopup();
}

</script>