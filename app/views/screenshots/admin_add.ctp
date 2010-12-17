<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add screenshot</h1>
<?php echo $form->create('Screenshot', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>Screenshot details</legend>
<?php echo $form->input('Screenshot.title'); ?>
<?php echo $form->input('Screenshot.description'); ?>
<?php echo $form->input('Screenshot.image', array('type' => 'file')); ?>
</fieldset>
<?php echo $form->end('Save'); ?>