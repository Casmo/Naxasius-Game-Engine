<?php
/*
 * Created on Nov 20, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Add Npc'); ?></h1>
<?php echo $this->Form->create('Npc', array('action' => 'save', 'type' => 'file')); ?>
<?php echo $this->Form->input('Npc.name'); ?>
<?php echo $this->Form->input('Npc.description', array('type' => 'textarea')); ?>
<?php echo $this->Form->input('Npc.image', array('type' => 'file')); ?>
<?php echo $this->Form->end('Save'); ?>