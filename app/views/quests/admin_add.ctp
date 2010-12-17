<?php
/*
 * Created on Mar 11, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Add quest'); ?></h1>
<?php echo $form->create('Quest', array('action' => 'admin_add')); ?>
<fieldset>
<legend>Quest detail</legend>
<?php echo $form->input('Quest.name'); ?>
<?php echo $form->input('Quest.description_full', array('class' => 'tinymce')); ?>
<?php echo $form->input('Quest.description_summary', array('class' => 'tinymce')); ?>
<?php echo $form->input('Quest.removable', array('div' => false, 'type' => 'checkbox', 'value' => '1')); ?>
</fieldset>
<?php echo $form->end('Save'); ?>