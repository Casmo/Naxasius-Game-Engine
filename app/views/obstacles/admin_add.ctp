<?php
/*
 * Created on Nov 20, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Add Obstacle'); ?></h1>
<?php echo $form->create('Obstacle', array('action' => 'save', 'type' => 'file')); ?>
<fieldset>
<legend>Obstacle detail</legend>
<?php echo $form->input('Obstacle.group_id'); ?>
<?php echo $form->input('Obstacle.name'); ?>
<?php echo $form->input('Obstacle.image', array('type' => 'file')); ?>
</fieldset>
<?php echo $form->end('Save'); ?>