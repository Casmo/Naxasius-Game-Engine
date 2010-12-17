<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Add item</h1>
<?php echo $form->create('Item', array('action' => 'admin_add', 'type' => 'file')); ?>
<fieldset>
<legend>Item details</legend>
<?php echo $form->input('Item.name'); ?>
<?php echo $form->input('Item.group_id'); ?>
<?php echo $form->input('Item.quality', array('options' => array('trash' => 'trash', 'normal' => 'normal', 'good' => 'good', 'rare' => 'rare', 'epic' => 'epic', 'legendary' => 'legendary'))); ?>
<?php echo $form->input('Item.type', array('options' => array('none' => 'none', 'quest' => 'quest', 'reagent' => 'reagent', 'item' => 'item', 'consumable' => 'consumable', 'bag' => 'bag'))); ?>
<?php echo $form->input('Item.slot', array('options' => array('none' => 'none', 'mainhand' => 'mainhand', 'onehand' => 'onehand', 'twohand' => 'twohand', 'offhand' => 'offhand', 'head' => 'head', 'shoulders' => 'shoulders', 'hands' => 'hands', 'feets' => 'feets', 'legs' => 'legs', 'neck' => 'neck', 'ring' => 'ring', 'chest' => 'chest', 'wrist' => 'wrist', 'belt' => 'belt'))); ?>
<?php echo $form->input('Item.description', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo $form->input('Item.unique', array('size' => '3')); ?>
<?php echo $form->input('Item.stackable', array('size' => '3')); ?>
<?php echo $form->input('Item.image', array('type' => 'file')); ?>
</fieldset>
<?php echo $form->end('Save'); ?>