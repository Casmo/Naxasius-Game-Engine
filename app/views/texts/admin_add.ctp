<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add text</h1>
<?php echo $form->create('Text', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>Text details</legend>
<?php echo $form->input('Text.page_id'); ?>
<?php echo $form->input('Text.name'); ?>
<?php echo $form->input('Text.title'); ?>
<?php echo $form->input('Text.message', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo $form->input('Text.image', array('type' => 'file')); ?>
<?php echo $form->input('Text.image_title'); ?>
<?php echo $form->input('Text.order'); ?>
</fieldset>
<?php echo $form->end('Save'); ?>