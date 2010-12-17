<?php
/*
 * Created on Nov 13, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Login'); ?></h1>
<p><b><?php __('Note'); ?>:</b> <?php __('This game is not released yet. You can only login to reply on news.'); ?></p>
<?php
echo $form->create('User', array('action' => 'login'));
echo $form->input('User.username');
echo $form->input('User.password');
echo $form->end('login', array('value' => __('Login', true)));
__('Not a member?');
echo " ". $html->link(__('Register', true), '/users/register');
?>