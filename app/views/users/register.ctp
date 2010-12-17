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
<?php echo $form->create('User', array('action' => 'register')); ?>
<?php echo $form->input('User.username'); ?>
<?php echo $form->input('User.email'); ?>
<?php echo $form->input('User.password', array('value' => '')); ?>
<?php echo $form->end('Register'); ?>
<p><em><?php __('By registering you accept the '); ?><?php echo $html->link(__('game rules', true), '/pages/view/6'); ?>.</em></p>