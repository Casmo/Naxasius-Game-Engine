<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php
if(isset($images)) {
?>
	<h1><?php __('Images'); ?></h1>
	<fieldset>
	<legend>Obstaclesheet detail</legend>
	<?php echo $this->Form->create('Obstacle', array('type' => 'file', 'action' => 'import')); ?>
	<?php echo $this->Form->input('Obstacle.group_id'); ?>
	<?php
	foreach($images as $tile_i => $image) {
		echo '<div class="transparent"><input type="checkbox", name="data[Obstacle][images][]" id="obstacle_'. $tile_i .'" value="'. $image .'" CHECKED="CHECKED">';
		echo '<label for="obstacle_'. $tile_i .'">'. $this->Html->image('/img/admin/tmp/'. $image) .'</label></div>';
	}
	echo $this->Form->input('Obstacle.save', array('value' => '1', 'type' => 'hidden'));
	?>
	</fieldset>
	<?php echo $this->Form->end('save', array('value' => __('Save', true))); ?>
<?php
}
else {
?>
	<h1><?php __('Import from obstaclesheet'); ?></h1>
	<fieldset>
	<legend>Obstaclesheet detail</legend>
	<?php echo $this->Form->create('Obstacle', array('type' => 'file', 'action' => 'import')); ?>
	<?php echo $this->Form->input('Obstacle.group_id'); ?>
	<?php echo $this->Form->input('Obstacle.image', array('type' => 'file')); ?>
	</fieldset>
	<?php echo $this->Form->end('import'); ?>
<?php
}
?>