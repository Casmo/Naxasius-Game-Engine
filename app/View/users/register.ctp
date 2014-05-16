<?php
/*
 * Created on Nov 13, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Register'); ?></h1>
<p><b><?php __('Note'); ?>:</b> <?php __('This game is not released yet. You will receive an mail when it\'s ready!'); ?></p>
<p><?php __('You will also receive a beta key when the closed beta is ready.'); ?></p>
<?php echo $this->Form->create('User', array('action' => 'register')); ?>
<?php echo $this->Form->input('User.username'); ?>
<?php echo $this->Form->input('User.email'); ?>
<?php echo $this->Form->input('User.password', array('value' => '')); ?>
<?php echo $this->Form->end('Register'); ?>
<p><em><?php __('By registering you accept the '); ?><?php echo $this->Html->link(__('game rules', true), '/pages/view/6'); ?>.</em></p>