<?php
/*
 * Created on Mar 21, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add group</h1>
<?php echo $form->create('Group', array('action' => 'admin_add')); ?>
<fieldset>
<legend>Group details</legend>
<?php echo $form->input('Group.type', array('options' => array('tile' => 'tile', 'obstacle' => 'obstacle', 'item' => 'item'))); ?>
<?php echo $form->input('Group.name'); ?>
</fieldset>
<?php echo $form->end('save'); ?>