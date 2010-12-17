<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Add tile'); ?></h1>
<fieldset>
<legend>Tile detail</legend>
<?php echo $form->create('Tile', array('type' => 'file', 'action' => 'save')); ?>
<?php echo $form->input('Tile.group_id'); ?>
<?php echo $form->input('Tile.name'); ?>
<?php echo $form->input('Tile.image', array('type' => 'file')); ?>
</fieldset>
<?php echo $form->end('save', array('value' => __('Save', true))); ?>