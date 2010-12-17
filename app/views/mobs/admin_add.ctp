<?php
/*
 * Created on Mar 19, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add mob</h1>
<?php echo $form->create('Mob', array('action' => 'admin_add', 'type' => 'file')); ?>
<fieldset>
<legend>Mob details</legend>
<?php echo $form->input('Mob.name'); ?>
<?php echo $form->input('Mob.description', array('class' => 'tinymce')); ?>
<?php echo $form->input('Mob.level'); ?>
<?php echo $form->input('Mob.icon', array('type' => 'file')); ?>
<?php echo $form->input('Mob.image', array('type' => 'file')); ?>
</fieldset>
<?php echo $form->end('save'); ?>