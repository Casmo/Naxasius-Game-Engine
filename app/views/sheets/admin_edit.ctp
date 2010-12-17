<?php
/*
 * Created on Nov 20, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Edit Sheet'); ?></h1>
<?php echo $this->Form->create('Sheet', array('action' => 'save')); ?>
<fieldset>
<legend>Sheet detail</legend>
<?php echo $this->Form->input('Sheet.id'); ?>
<?php echo $this->Form->input('Sheet.name'); ?>
<div id="obstaclesForm">
<?php
foreach($this->data['Obstacle'] as $index_i => $obstacle) {
	echo $this->Html->image('/img/game/obstacles/'. $obstacle['image']);
	echo '<input type="checkbox" name="data[ObstaclesSheet]['. $index_i .'][obstacle_id]" value="'. $obstacle['id'] .'" CHECKED="CHECKED">';
	echo '<input type="text" name="data[ObstaclesSheet]['. $index_i .'][position_x]" value="'. $obstacle['ObstaclesSheet']['position_x'] .'" size="3"> x position ';
	echo '<input type="text" name="data[ObstaclesSheet]['. $index_i .'][position_y]" value="'. $obstacle['ObstaclesSheet']['position_y'] .'" size="3"> y position<br />';
}
?>
</div>
</fieldset>
<?php echo $form->end('Save'); ?>
<fieldset>
<legend>Preview</legend>
<?php echo $this->World->buildSheet($this->data['Obstacle']); ?>
</fieldset>
<fieldset>
<legend>Obstacles</legend>
<?php
foreach($obstacles as $obstacle) {
	echo $this->Html->image('/img/game/obstacles/'. $obstacle['Obstacle']['image'], array('id' => 'obstacle_'. $obstacle['Obstacle']['id']));
}
?>
</fieldset>
<script type="text/javascript">
$(document).ready(function() {
	var index_i = <?php echo ($index_i + 1); ?>;
	$('img[id^=obstacle_]').click(function() {
		obstacle_id = $(this).attr('id').replace(/[^0-9]+/,'');
		addHtml = '';
		addHtml += '<img src="'+ $(this).attr('src') +'">';
		addHtml += '<input type="checkbox" name="data[ObstaclesSheet]['+ index_i +'][obstacle_id]" value="'+ obstacle_id +'" CHECKED="CHECKED">';
		addHtml += '<input type="text" name="data[ObstaclesSheet]['+ index_i +'][position_x]" value="0" size="3"> x position ';
		addHtml += '<input type="text" name="data[ObstaclesSheet]['+ index_i +'][position_y]" value="0" size="3"> y position<br />';
		$('div#obstaclesForm').append(addHtml);
		index_i++;
	});
});
</script>