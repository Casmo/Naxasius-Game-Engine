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
<?php echo $this->Form->create('Tile', array('type' => 'file', 'action' => 'save')); ?>
<?php echo $this->Form->input('Tile.group_id'); ?>
<?php echo $this->Form->input('Tile.name'); ?>
<?php echo $this->Form->input('Tile.image', array('type' => 'file')); ?>
</fieldset>
<?php echo $this->Form->end('save', array('value' => __('Save', true))); ?>