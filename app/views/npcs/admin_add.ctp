<?php
/*
 * Created on Nov 20, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Add Npc'); ?></h1>
<?php echo $form->create('Npc', array('action' => 'save', 'type' => 'file')); ?>
<?php echo $form->input('Npc.name'); ?>
<?php echo $form->input('Npc.description', array('type' => 'textarea')); ?>
<?php echo $form->input('Npc.image', array('type' => 'file')); ?>
<?php echo $form->end('Save'); ?>