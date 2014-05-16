<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit screenshot "<?php echo $this->data['Screenshot']['title']; ?>"</h1>
<?php echo $this->Form->create('Screenshot', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>Screenshot details</legend>
<?php echo $this->Form->input('Screenshot.id'); ?>
<?php echo $this->Form->input('Screenshot.title'); ?>
<?php echo $this->Form->input('Screenshot.description'); ?>
<?php echo !empty($this->data['Screenshot']['image']) ? $this->Html->image('/img/website/screenshots/small/'. $this->data['Screenshot']['image']) : ''; ?>
<?php echo $this->Form->input('Screenshot.image', array('type' => 'file')); ?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>