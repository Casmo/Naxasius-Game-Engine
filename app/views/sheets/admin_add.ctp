<?php
/*
 * Created on Nov 20, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Add Sheet'); ?></h1>
<?php echo $this->Form->create('Sheet', array('action' => 'save')); ?>
<fieldset>
<legend>Sheet detail</legend>
<?php echo $this->Form->input('Sheet.name'); ?>
<div id="obstaclesForm"></div>
</fieldset>
<?php echo $form->end('Save'); ?>
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
	var index_i = 0;
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