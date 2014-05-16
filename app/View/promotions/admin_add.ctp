<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add promotion</h1>
<?php echo $this->Form->create('Promotion', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>Promotion details</legend>
<?php echo $this->Form->input('Promotion.title'); ?>
<?php echo $this->Form->input('Promotion.link'); ?>
<?php echo $this->Form->input('Promotion.image', array('type' => 'file')); ?>
<?php echo $this->Form->input('Promotion.show', array('type' => 'checkbox', 'value' => '1')); ?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>