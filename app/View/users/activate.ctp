<?php
/*
 * Created on Nov 13, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Login'); ?></h1>
<p><b><?php __('Note'); ?>:</b> <?php __('This game is not released yet. You can\'t activate your account yet.'); ?></p>
<?php
echo $this->Form->create('User', array('action' => 'activate'));
echo $this->Form->input('User.activation_code');
echo $this->Form->end('Activate');
?>