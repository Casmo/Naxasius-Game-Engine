<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit promotion "<?php echo $this->data['Promotion']['title']; ?>"</h1>
<?php echo $form->create('Promotion', array('action' => 'admin_save', 'type' => 'file')); ?>
<fieldset>
<legend>Promotion details</legend>
<?php echo $form->input('Promotion.id'); ?>
<?php echo $form->input('Promotion.title'); ?>
<?php echo $form->input('Promotion.link'); ?>
<?php echo !empty($this->data['Promotion']['image']) ? $html->image('/img/website/promotions/'. $this->data['Promotion']['image']) : ''; ?>
<?php echo $form->input('Promotion.image', array('type' => 'file')); ?>
<?php echo $form->input('Promotion.show', array('type' => 'checkbox', 'value' => '1')); ?>
</fieldset>
<?php echo $form->end('Save'); ?>