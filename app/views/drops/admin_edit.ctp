<?php
/*
 * Created on Nov 25, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php /* echo '<a href="#edit" onclick="popup(\''. $html->url('/drops/edit/'. $this->data['AreasObstacle']['id']) .'\');">'. __('Refresh', true) .'</a>'; */ ?>
<h1><?php __('Edit drops for area'); ?>: #<?php echo $this->data['AreasObstacle']['id']; ?></h1>
<?php
echo $form->create('Drop', array('action' => 'edit'));
echo $form->input('id', array('type' => 'hidden', 'name' => 'data[areaobstacle_id]', 'value' => $this->data['AreasObstacle']['id']));
$index = 0;
foreach($this->data['Item'] as $item) {
echo $form->input('AreasObstaclesItem.check', array('name' => 'data[AreasObstaclesItem]['. $index .'][check]', 'value' => 1, 'type' => 'checkbox', 'div' => false, 'label' => false, 'checked' => 'checked'));
echo $form->input('AreasObstaclesItem.areas_obstacle_id', array('type' => 'hidden', 'name' => 'data[AreasObstaclesItem]['. $index .'][areas_obstacle_id]', 'value' => $this->data['AreasObstacle']['id']));
echo $form->input('items', array('name' => 'data[AreasObstaclesItem]['. $index .'][item_id]', 'div' => false, 'value' => $item['AreasObstaclesItem']['item_id']));
echo $form->input('AreasObstaclesItem.spawn_time', array('name' => 'data[AreasObstaclesItem]['. $index .'][spawn_time]', 'div' => false, 'size' => 1, 'value' => $item['AreasObstaclesItem']['spawn_time']));
echo $form->input('AreasObstaclesItem.max_drop', array('name' => 'data[AreasObstaclesItem]['. $index .'][max_drop]', 'div' => false, 'size' => 1, 'value' => $item['AreasObstaclesItem']['max_drop']));
echo $form->input('AreasObstaclesItem.player_only', array('name' => 'data[AreasObstaclesItem]['. $index .'][player_only]', 'div' => false, 'checked' => $item['AreasObstaclesItem']['player_only'] == 1 ? 'checked' : '', 'value' => $item['AreasObstaclesItem']['player_only'], 'type' => 'checkbox'));
echo $form->input('AreasObstaclesItem.quest_id', array('name' => 'data[AreasObstaclesItem]['. $index .'][quest_id]', 'options' => $quests, 'div' => false, 'value' => $item['AreasObstaclesItem']['quest_id'], 'type' => 'select'));
echo '<br />';
$index++;
}
echo $form->input('AreasObstaclesItem.check', array('name' => 'data[AreasObstaclesItem]['. $index .'][check]', 'value' => 1, 'type' => 'checkbox', 'div' => false, 'label' => false));
echo $form->input('AreasObstaclesItem.areas_obstacle_id', array('type' => 'hidden', 'name' => 'data[AreasObstaclesItem]['. $index .'][areas_obstacle_id]'));
echo $form->input('items', array('name' => 'data[AreasObstaclesItem]['. $index .'][item_id]', 'div' => false));
echo $form->input('AreasObstaclesItem.spawn_time', array('name' => 'data[AreasObstaclesItem]['. $index .'][spawn_time]', 'div' => false, 'size' => 1));
echo $form->input('AreasObstaclesItem.max_drop', array('name' => 'data[AreasObstaclesItem]['. $index .'][max_drop]', 'div' => false, 'size' => 1, 'value' => '0'));
echo $form->input('AreasObstaclesItem.player_only', array('name' => 'data[AreasObstaclesItem]['. $index .'][player_only]', 'div' => false, 'type' => 'checkbox'));
echo $form->input('AreasObstaclesItem.quest_id', array('name' => 'data[AreasObstaclesItem]['. $index .'][quest_id]', 'options' => $quests, 'div' => false, 'value' => 0, 'type' => 'select'));
?>
<?php echo $form->end('save'); ?>
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