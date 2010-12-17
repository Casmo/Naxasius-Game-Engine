<?php
/*
 * Created on Mar 19, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit user "<?php echo $this->data['User']['username']; ?>"</h1>
<?php echo $form->create('User', array('action' => 'admin_edit')); ?>
<fieldset>
<legend>User details</legend>
<?php echo $form->input('User.id'); ?>
<?php echo $form->input('User.username'); ?>
<?php echo $form->input('User.email'); ?>
<?php echo $form->input('User.activation_code'); ?>
<?php echo $form->input('User.role', array('options' => array('player' => 'player', 'admin' => 'admin'))); ?>
</fieldset>
<?php echo $form->end('save'); ?>
<?php echo $form->create('User', array('action' => 'admin_edit')); ?>
<fieldset>
<legend>Change password</legend>
<?php echo $form->input('User.id'); ?>
<?php echo $form->input('User.password', array('value' => '')); ?>
</fieldset>
<?php echo $form->end('change password'); ?>