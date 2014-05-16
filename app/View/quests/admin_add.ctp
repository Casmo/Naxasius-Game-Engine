<?php
/*
 * Created on Mar 11, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Add quest'); ?></h1>
<?php echo $this->Form->create('Quest', array('action' => 'admin_add')); ?>
<fieldset>
<legend>Quest detail</legend>
<?php echo $this->Form->input('Quest.name'); ?>
<?php echo $this->Form->input('Quest.description_full', array('class' => 'tinymce')); ?>
<?php echo $this->Form->input('Quest.description_summary', array('class' => 'tinymce')); ?>
<?php echo $this->Form->input('Quest.removable', array('div' => false, 'type' => 'checkbox', 'value' => '1')); ?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>