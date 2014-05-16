<?php
/*
 * Created on Mar 21, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit group "<?php echo $this->data['Group']['name']; ?>"</h1>
<?php echo $this->Form->create('Group', array('action' => 'admin_add')); ?>
<fieldset>
<legend>Group details</legend>
<?php echo $this->Form->input('Group.id'); ?>
<?php echo $this->Form->input('Group.type', array('options' => array('tile' => 'tile', 'obstacle' => 'obstacle', 'item' => 'item'))); ?>
<?php echo $this->Form->input('Group.name'); ?>
</fieldset>
<?php echo $this->Form->end('save'); ?>