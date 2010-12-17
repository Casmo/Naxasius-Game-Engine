<?php
/*
 * Created on Nov 20, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit obstacle "<?php echo $this->data['Obstacle']['name']; ?>"</h1>
<?php echo $form->create('Obstacle', array('action' => 'save', 'type' => 'file')); ?>
<fieldset>
<legend>Obstacle detail</legend>
<?php echo $form->input('Obstacle.group_id'); ?>
<?php echo $form->input('Obstacle.name'); ?>
<?php echo $form->input('Obstacle.image', array('type' => 'file')); ?>
<?php echo $form->hidden('Obstacle.id'); ?>
</fieldset>
<?php echo $form->end('Save'); ?>