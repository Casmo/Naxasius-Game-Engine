<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit page "<?php echo $this->data['Page']['name']; ?>"</h1>
<?php echo $form->create('Page', array('action' => 'admin_save')); ?>
<fieldset>
<legend>Page details</legend>
<?php echo $form->input('Page.id'); ?>
<?php echo $form->input('Page.name'); ?>
<?php echo $form->input('Page.title'); ?>
<?php echo $form->input('Page.message', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo $form->input('Page.order'); ?>
<?php echo $form->input('Page.menu', array('type' => 'checkbox')); ?>
</fieldset>
<?php echo $form->end('Save'); ?>