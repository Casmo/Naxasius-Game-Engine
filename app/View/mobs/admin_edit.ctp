<?php
/*
 * Created on Mar 19, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit mob "<?php echo $this->data['Mob']['name']; ?>"</h1>
<?php echo $this->Form->create('Mob', array('action' => 'admin_edit', 'type' => 'file')); ?>
<fieldset>
<legend>Mob details</legend>
<?php echo $this->Form->input('Mob.id'); ?>
<?php echo $this->Form->input('Mob.name'); ?>
<?php echo $this->Form->input('Mob.description', array('class' => 'tinymce')); ?>
<?php echo $this->Form->input('Mob.level'); ?>
<?php echo $this->Form->input('Mob.icon', array('type' => 'file')); ?>
<?php echo $this->Form->input('Mob.image', array('type' => 'file')); ?>
</fieldset>
<fieldset>
<legend>Stats details</legend>
<?php
$stat_i = 0;
foreach($this->data['Stat'] as $stat) {
	?>
	<p>
	<?php echo $this->Form->input('MobsStat.'. $stat_i .'.check', array('label' => false, 'div' => false, 'type' => 'checkbox', 'checked' => 'checked', 'value' => '1')); ?>
	<?php echo $this->Form->input('MobsStat.'. $stat_i .'.stat_id', array('options' => $stats, 'value' => $stat['MobsStat']['stat_id'], 'div' => false, 'label' => false)); ?>
	<?php echo $this->Form->input('MobsStat.'. $stat_i .'.amount', array('size' => '3', 'value' => $stat['MobsStat']['amount'], 'title' => __('Amount', true), 'div' => false, 'label' => false)); ?>
	</p>
	<?php
	$stat_i++;
}
?>
<p>
	<?php echo $this->Form->input('MobsStat.'. $stat_i .'.check', array('label' => false, 'div' => false, 'type' => 'checkbox', 'value' => '1')); ?>
	<?php echo $this->Form->input('MobsStat.'. $stat_i .'.stat_id', array('options' => $stats, 'div' => false, 'label' => false)); ?>
	<?php echo $this->Form->input('MobsStat.'. $stat_i .'.amount', array('size' => '3', 'title' => __('Amount', true), 'div' => false, 'label' => false)); ?>
</p>
</fieldset>
<fieldset>
<legend>Loot</legend>
<?php
$stat_i = 0;
foreach($this->data['Item'] as $item) {
	?>
	<p>
	<?php echo $this->Form->input('ItemsMob.'. $stat_i .'.check', array('label' => false, 'div' => false, 'type' => 'checkbox', 'checked' => 'checked', 'value' => '1')); ?>
	<?php echo $this->Form->input('ItemsMob.'. $stat_i .'.item_id', array('options' => $items, 'value' => $item['ItemsMob']['item_id'], 'div' => false, 'label' => false)); ?>
	<?php echo $this->Form->input('ItemsMob.'. $stat_i .'.quest_id', array('options' => $quests, 'empty' => array(0 => 'Selected required quest'), 'value' => $item['ItemsMob']['quest_id'], 'div' => false, 'label' => false)); ?>
	<?php echo $this->Form->input('ItemsMob.'. $stat_i .'.chance', array('size' => '3', 'value' => ($item['ItemsMob']['chance']/100), 'title' => __('Chance', true), 'div' => false, 'label' => false)); ?>
	%
	</p>
	<?php
	$stat_i++;
}
?>
<p>
	<?php echo $this->Form->input('ItemsMob.'. $stat_i .'.check', array('label' => false, 'div' => false, 'type' => 'checkbox', 'value' => '1')); ?>
	<?php echo $this->Form->input('ItemsMob.'. $stat_i .'.item_id', array('options' => $items, 'div' => false, 'label' => false)); ?>
	<?php echo $this->Form->input('ItemsMob.'. $stat_i .'.quest_id', array('options' => $quests, 'empty' => array(0 => 'Selected required quest'), 'div' => false, 'label' => false)); ?>
	<?php echo $this->Form->input('ItemsMob.'. $stat_i .'.chance', array('size' => '3', 'title' => __('Chance', true), 'div' => false, 'label' => false)); ?>
	%
</p>
</fieldset>
<?php echo $this->Form->end('save'); ?>