<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add promotion</h1>
<?php echo $form->create('Promotion', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>Promotion details</legend>
<?php echo $form->input('Promotion.title'); ?>
<?php echo $form->input('Promotion.link'); ?>
<?php echo $form->input('Promotion.image', array('type' => 'file')); ?>
<?php echo $form->input('Promotion.show', array('type' => 'checkbox', 'value' => '1')); ?>
</fieldset>
<?php echo $form->end('Save'); ?>