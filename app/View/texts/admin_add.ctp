<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add text</h1>
<?php echo $this->Form->create('Text', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>Text details</legend>
<?php echo $this->Form->input('Text.page_id'); ?>
<?php echo $this->Form->input('Text.name'); ?>
<?php echo $this->Form->input('Text.title'); ?>
<?php echo $this->Form->input('Text.message', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo $this->Form->input('Text.image', array('type' => 'file')); ?>
<?php echo $this->Form->input('Text.image_title'); ?>
<?php echo $this->Form->input('Text.order'); ?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>