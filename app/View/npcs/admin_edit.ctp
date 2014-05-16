<?php
/*
 * Created on Nov 20, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo $this->Form->create('Npc', array('action' => 'save', 'type' => 'file')); ?>
<h1><?php __('Edit npc'); ?> "<?php echo $this->data['Npc']['name']; ?>"</h1>
<fieldset>
<legend>Npc details</legend>
<?php echo $this->Form->input('Npc.name'); ?>
<?php echo $this->Form->input('Npc.description', array('type' => 'textarea', 'class' => 'tinymce', 'rows' => '5', 'cols' => '50')); ?>
<?php echo $this->Form->input('Npc.image', array('type' => 'file')); ?>
<?php
if(!empty($this->data['Npc']['image'])) {
	echo $this->Html->image('/img/game/npcs/'. $this->data['Npc']['image']);
}
?>
<?php echo $this->Form->input('Npc.icon', array('type' => 'file')); ?>
<?php
if(!empty($this->data['Npc']['icon'])) {
	echo $this->Html->image('/img/game/npcs/'. $this->data['Npc']['icon']);
}
?>
<?php echo $this->Form->hidden('Npc.id'); ?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>