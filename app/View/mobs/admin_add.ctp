<?php
/*
 * Created on Mar 19, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add mob</h1>
<?php echo $this->Form->create('Mob', array('action' => 'admin_add', 'type' => 'file')); ?>
<fieldset>
<legend>Mob details</legend>
<?php echo $this->Form->input('Mob.name'); ?>
<?php echo $this->Form->input('Mob.description', array('class' => 'tinymce')); ?>
<?php echo $this->Form->input('Mob.level'); ?>
<?php echo $this->Form->input('Mob.icon', array('type' => 'file')); ?>
<?php echo $this->Form->input('Mob.image', array('type' => 'file')); ?>
</fieldset>
<?php echo $this->Form->end('save'); ?>