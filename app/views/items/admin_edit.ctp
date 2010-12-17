<?php
/*
 * Created on Mar 12, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit item "<?php echo $this->data['Item']['name']; ?>"</h1>
<?php echo $form->create('Item', array('action' => 'admin_edit', 'type' => 'file')); ?>
<fieldset>
<legend>Item details</legend>
<?php echo $form->input('Item.id'); ?>
<?php echo $form->input('Item.name'); ?>
<?php echo $form->input('Item.group_id'); ?>
<?php echo $form->input('Item.quality', array('options' => array('trash' => 'trash', 'normal' => 'normal', 'good' => 'good', 'rare' => 'rare', 'epic' => 'epic', 'legendary' => 'legendary'))); ?>
<?php echo $form->input('Item.type', array('options' => array('none' => 'none', 'quest' => 'quest', 'reagent' => 'reagent', 'item' => 'item', 'consumable' => 'consumable', 'bag' => 'bag'))); ?>
<?php echo $form->input('Item.slot', array('options' => array('none' => 'none', 'mainhand' => 'mainhand', 'onehand' => 'onehand', 'twohand' => 'twohand', 'offhand' => 'offhand', 'head' => 'head', 'shoulders' => 'shoulders', 'hands' => 'hands', 'feets' => 'feets', 'legs' => 'legs', 'neck' => 'neck', 'ring' => 'ring', 'chest' => 'chest', 'wrist' => 'wrist', 'belt' => 'belt'))); ?>
<?php echo $form->input('Item.description', array('type' => 'textarea', 'class' => 'tinymce')); ?>
<?php echo $form->input('Item.unique', array('size' => '3')); ?>
<?php echo $form->input('Item.stackable', array('size' => '3')); ?>
<?php echo $form->input('Item.image', array('type' => 'file')); ?>
<?php echo $html->image('/img/game/items/'. $this->data['Item']['image']); ?>
</fieldset>
<fieldset>
<legend>Item stats</legend>
<?php
$stat_i = 0;
foreach($this->data['Stat'] as $stat) {
	?>
	<p>
	<?php echo $form->input('ItemsStat.'. $stat_i .'.check', array('label' => false, 'div' => false, 'type' => 'checkbox', 'checked' => 'checked', 'value' => '1')); ?>
	<?php echo $form->input('ItemsStat.'. $stat_i .'.stat_id', array('options' => $stats, 'value' => $stat['ItemsStat']['stat_id'], 'div' => false, 'label' => false)); ?>
	<?php echo $form->input('ItemsStat.'. $stat_i .'.value', array('size' => '3', 'value' => $stat['ItemsStat']['value'], 'title' => __('Value', true), 'div' => false, 'label' => false)); ?>
	</p>
	<?php
	$stat_i++;
}
?>
<p>
	<?php echo $form->input('ItemsStat.'. $stat_i .'.check', array('label' => false, 'div' => false, 'type' => 'checkbox', 'value' => '1')); ?>
	<?php echo $form->input('ItemsStat.'. $stat_i .'.stat_id', array('options' => $stats, 'div' => false, 'label' => false)); ?>
	<?php echo $form->input('ItemsStat.'. $stat_i .'.value', array('size' => '3', 'title' => __('Value', true), 'div' => false, 'label' => false)); ?>
</p>
</fieldset>
<?php echo $form->end('Save'); ?>