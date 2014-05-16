<?php
/*
 * Created on Nov 8, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo $this->Form->create('Topic', array('action' => 'add')); ?>
<?php echo $this->Form->input('Topic.title'); ?>
<?php echo $this->Form->input('Topic.forum_id', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('Reply.0.message'); ?>
<?php echo $this->Form->end('Create topic'); ?>