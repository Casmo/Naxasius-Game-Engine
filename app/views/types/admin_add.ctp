<?php
/*
 * Created on Mar 19, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add class</h1>
<?php echo $form->create('Type', array('action' => 'admin_add')); ?>
<fieldset>
<legend>Class details</legend>
<?php echo $form->input('Type.name'); ?>
<?php echo $form->input('Type.description', array('class' => 'tinymce')); ?>
</fieldset>
<fieldset>
<legend>Stats details</legend>
@TODO
</fieldset>
<?php echo $form->end('save'); ?>