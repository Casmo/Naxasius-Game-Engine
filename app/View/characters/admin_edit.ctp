<?php
/*
 * Created on Mar 19, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit character "<?php echo $this->data['Character']['name']; ?>"</h1>
<?php echo $this->Form->create('Character', array('action' => 'admin_edit')); ?>
<fieldset>
<legend>Character details</legend>
<?php echo $this->Form->input('Character.id'); ?>
<?php echo $this->Form->input('Character.name'); ?>
<?php echo $this->Form->input('Character.type_id'); ?>
<?php echo $this->Form->input('Character.area_id', array('type' => 'text')); ?>
</fieldset>
<?php echo $this->Form->end('save'); ?>