<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Edit tile'); ?> "<?php echo $this->data['Tile']['name']; ?>"</h1>
<?php echo $this->Form->create('Tile', array('type' => 'file', 'action' => 'admin_save')); ?>
<fieldset>
<legend>Tile details</legend>
<?php echo $this->Form->input('Tile.group_id', array('empty' => '')); ?>
<?php echo $this->Form->input('Tile.name'); ?>
<?php echo $this->Form->input('Tile.image', array('type' => 'file')); ?>
<?php echo !empty($this->data['Tile']['image']) ? $this->Html->image('/img/game/tiles/'. $this->data['Tile']['image']) : ''; ?>
<?php echo $this->Form->hidden('Tile.id'); ?>
</fieldset>
<?php echo $this->Form->end('save', array('value' => __('Save', true))); ?>