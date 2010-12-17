<?php
/*
 * Created on Mar 19, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add user</h1>
<?php echo $form->create('User', array('action' => 'admin_add')); ?>
<fieldset>
<legend>User details</legend>
<?php echo $form->input('User.username'); ?>
<?php echo $form->input('User.password', array('value' => '')); ?>
<?php echo $form->input('User.email'); ?>
<?php echo $form->input('User.activation_code'); ?>
<?php echo $form->input('User.role', array('options' => array('player' => 'player', 'admin' => 'admin'))); ?>
</fieldset>
<?php echo $form->end('save'); ?>