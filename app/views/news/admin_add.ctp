<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add news</h1>
<?php echo $form->create('News', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>News details</legend>
<?php echo $form->input('News.title'); ?>
<?php echo $form->input('News.summary', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo $form->input('News.message', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo $form->input('News.image', array('type' => 'file')); ?>
<?php echo $form->input('News.image_title'); ?>
<?php echo !empty($this->data['News']['image']) ? $html->image('/img/website/news/'. $this->data['News']['image']) : ''; ?>
</fieldset>
<?php echo $form->end('Save'); ?>