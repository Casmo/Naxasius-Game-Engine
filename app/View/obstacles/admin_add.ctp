<?php
/*
 * Created on Nov 20, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Add Obstacle'); ?></h1>
<?php echo $this->Form->create('Obstacle', array('action' => 'save', 'type' => 'file')); ?>
<fieldset>
<legend>Obstacle detail</legend>
<?php echo $this->Form->input('Obstacle.group_id'); ?>
<?php echo $this->Form->input('Obstacle.name'); ?>
<?php echo $this->Form->input('Obstacle.image', array('type' => 'file')); ?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>