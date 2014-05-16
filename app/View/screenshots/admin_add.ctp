<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add screenshot</h1>
<?php echo $this->Form->create('Screenshot', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>Screenshot details</legend>
<?php echo $this->Form->input('Screenshot.title'); ?>
<?php echo $this->Form->input('Screenshot.description'); ?>
<?php echo $this->Form->input('Screenshot.image', array('type' => 'file')); ?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>