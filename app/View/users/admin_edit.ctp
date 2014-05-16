<?php
/*
 * Created on Mar 19, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit user "<?php echo $this->data['User']['username']; ?>"</h1>
<?php echo $this->Form->create('User', array('action' => 'admin_edit')); ?>
<fieldset>
<legend>User details</legend>
<?php echo $this->Form->input('User.id'); ?>
<?php echo $this->Form->input('User.username'); ?>
<?php echo $this->Form->input('User.email'); ?>
<?php echo $this->Form->input('User.activation_code'); ?>
<?php echo $this->Form->input('User.role', array('options' => array('player' => 'player', 'admin' => 'admin'))); ?>
</fieldset>
<?php echo $this->Form->end('save'); ?>
<?php echo $this->Form->create('User', array('action' => 'admin_edit')); ?>
<fieldset>
<legend>Change password</legend>
<?php echo $this->Form->input('User.id'); ?>
<?php echo $this->Form->input('User.password', array('value' => '')); ?>
</fieldset>
<?php echo $this->Form->end('change password'); ?>