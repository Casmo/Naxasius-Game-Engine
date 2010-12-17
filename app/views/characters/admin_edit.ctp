<?php
/*
 * Created on Mar 19, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit character "<?php echo $this->data['Character']['name']; ?>"</h1>
<?php echo $form->create('Character', array('action' => 'admin_edit')); ?>
<fieldset>
<legend>Character details</legend>
<?php echo $form->input('Character.id'); ?>
<?php echo $form->input('Character.name'); ?>
<?php echo $form->input('Character.type_id'); ?>
<?php echo $form->input('Character.area_id', array('type' => 'text')); ?>
</fieldset>
<?php echo $form->end('save'); ?>