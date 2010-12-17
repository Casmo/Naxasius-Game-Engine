<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit text "<?php echo $this->data['Text']['name']; ?>"</h1>
<?php echo $form->create('Text', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>Text details</legend>
<?php echo $form->input('Text.id'); ?>
<?php echo $form->input('Text.page_id'); ?>
<?php echo $form->input('Text.name'); ?>
<?php echo $form->input('Text.title'); ?>
<?php echo $form->input('Text.message', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo !empty($this->data['Text']['image']) ? $html->image('/img/website/texts/'. $this->data['Text']['image']) : ''; ?>
<?php echo $form->input('Text.image', array('type' => 'file')); ?>
<?php echo $form->input('Text.image_title'); ?>
<?php echo $form->input('Text.order'); ?>
</fieldset>
<?php echo $form->end('Save'); ?>