<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit page "<?php echo $this->data['Page']['name']; ?>"</h1>
<?php echo $this->Form->create('Page', array('action' => 'admin_save')); ?>
<fieldset>
<legend>Page details</legend>
<?php echo $this->Form->input('Page.id'); ?>
<?php echo $this->Form->input('Page.name'); ?>
<?php echo $this->Form->input('Page.title'); ?>
<?php echo $this->Form->input('Page.message', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo $this->Form->input('Page.order'); ?>
<?php echo $this->Form->input('Page.menu', array('type' => 'checkbox')); ?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>