<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add news</h1>
<?php echo $this->Form->create('News', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>News details</legend>
<?php echo $this->Form->input('News.title'); ?>
<?php echo $this->Form->input('News.summary', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo $this->Form->input('News.message', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo $this->Form->input('News.image', array('type' => 'file')); ?>
<?php echo $this->Form->input('News.image_title'); ?>
<?php echo !empty($this->data['News']['image']) ? $this->Html->image('/img/website/news/'. $this->data['News']['image']) : ''; ?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>