<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Edit tile'); ?> "<?php echo $this->data['Tile']['name']; ?>"</h1>
<?php echo $form->create('Tile', array('type' => 'file', 'action' => 'admin_save')); ?>
<fieldset>
<legend>Tile details</legend>
<?php echo $form->input('Tile.group_id', array('empty' => '')); ?>
<?php echo $form->input('Tile.name'); ?>
<?php echo $form->input('Tile.image', array('type' => 'file')); ?>
<?php echo !empty($this->data['Tile']['image']) ? $html->image('/img/game/tiles/'. $this->data['Tile']['image']) : ''; ?>
<?php echo $form->hidden('Tile.id'); ?>
</fieldset>
<?php echo $form->end('save', array('value' => __('Save', true))); ?>