<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit text "<?php echo $this->data['Text']['name']; ?>"</h1>
<?php echo $this->Form->create('Text', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>Text details</legend>
<?php echo $this->Form->input('Text.id'); ?>
<?php echo $this->Form->input('Text.page_id'); ?>
<?php echo $this->Form->input('Text.name'); ?>
<?php echo $this->Form->input('Text.title'); ?>
<?php echo $this->Form->input('Text.message', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo !empty($this->data['Text']['image']) ? $this->Html->image('/img/website/texts/'. $this->data['Text']['image']) : ''; ?>
<?php echo $this->Form->input('Text.image', array('type' => 'file')); ?>
<?php echo $this->Form->input('Text.image_title'); ?>
<?php echo $this->Form->input('Text.order'); ?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>