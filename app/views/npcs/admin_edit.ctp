<?php
/*
 * Created on Nov 20, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo $form->create('Npc', array('action' => 'save', 'type' => 'file')); ?>
<h1><?php __('Edit npc'); ?> "<?php echo $this->data['Npc']['name']; ?>"</h1>
<fieldset>
<legend>Npc details</legend>
<?php echo $form->input('Npc.name'); ?>
<?php echo $form->input('Npc.description', array('type' => 'textarea', 'class' => 'tinymce', 'rows' => '5', 'cols' => '50')); ?>
<?php echo $form->input('Npc.image', array('type' => 'file')); ?>
<?php
if(!empty($this->data['Npc']['image'])) {
	echo $html->image('/img/game/npcs/'. $this->data['Npc']['image']);
}
?>
<?php echo $form->input('Npc.icon', array('type' => 'file')); ?>
<?php
if(!empty($this->data['Npc']['icon'])) {
	echo $html->image('/img/game/npcs/'. $this->data['Npc']['icon']);
}
?>
<?php echo $form->hidden('Npc.id'); ?>
</fieldset>
<?php echo $form->end('Save'); ?>