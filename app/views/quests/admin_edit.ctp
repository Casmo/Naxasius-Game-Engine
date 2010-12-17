<?php
/*
 * Created on Mar 11, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit quest "<?php echo $this->data['Quest']['name']; ?>"</h1>
<?php echo $form->create('Quest', array('action' => 'admin_edit')); ?>
<fieldset>
<legend>Quest detail</legend>
<?php echo $form->input('Quest.id'); ?>
<?php echo $form->input('Quest.name'); ?>
<?php echo $form->input('Quest.description_full', array('class' => 'tinymce')); ?>
<?php echo $form->input('Quest.description_summary', array('class' => 'tinymce')); ?>
<?php echo $form->input('Quest.removable', array('div' => false, 'type' => 'checkbox', 'value' => '1')); ?>
</fieldset>
<?php
$item_i = 0;
?>
<fieldset>
<legend>Items - rewards/needed</legend>
<?php
foreach($this->data['Item'] as $item) {
	echo '<p>';
	echo $form->input('ItemsQuest.'. $item_i .'.check', array('value' => '1', 'checked' => 'checked', 'type' => 'checkbox', 'label' => false, 'div' => false));
	echo $form->input('ItemsQuest.'. $item_i .'.amount', array('value' => $item['ItemsQuest']['amount'], 'size' => '1', 'label' => false, 'div' => false));
	echo 'x ';
	echo $form->input('ItemsQuest.'. $item_i .'.item_id', array('options' => $items, 'value' => $item['ItemsQuest']['item_id'], 'label' => false, 'div' => false));
	echo $form->input('ItemsQuest.'. $item_i .'.type', array('value' => $item['ItemsQuest']['type'], 'options' => array('needed' => 'needed', 'reward' => 'reward'), 'label' => false, 'div' => false));
	echo '</p>';
	$item_i++;
}
?>
<?php
foreach($this->data['Reward'] as $item) {
	echo '<p>';
	echo $form->input('ItemsQuest.'. $item_i .'.check', array('value' => '1', 'checked' => 'checked', 'type' => 'checkbox', 'label' => false, 'div' => false));
	echo $form->input('ItemsQuest.'. $item_i .'.amount', array('value' => $item['ItemsQuest']['amount'], 'size' => '1', 'label' => false, 'div' => false));
	echo 'x ';
	echo $form->input('ItemsQuest.'. $item_i .'.item_id', array('options' => $items, 'value' => $item['ItemsQuest']['item_id'], 'label' => false, 'div' => false));
	echo $form->input('ItemsQuest.'. $item_i .'.type', array('value' => $item['ItemsQuest']['type'], 'options' => array('needed' => 'needed', 'reward' => 'reward'), 'label' => false, 'div' => false));
	echo '</p>';
	$item_i++;
}
?>
<?php
echo '<p>';
echo $form->input('ItemsQuest.'. $item_i .'.check', array('value' => '1', 'type' => 'checkbox', 'label' => false, 'div' => false));
echo $form->input('ItemsQuest.'. $item_i .'.amount', array('value' => '1', 'size' => '1', 'label' => false, 'div' => false));
echo 'x ';
echo $form->input('ItemsQuest.'. $item_i .'.item_id', array('options' => $items, 'label' => false, 'div' => false));
echo $form->input('ItemsQuest.'. $item_i .'.type', array('options' => array('needed' => 'needed', 'reward' => 'reward'), 'label' => false, 'div' => false));
echo '</p>';
?>
</fieldset>
<fieldset>
<legend>Mobs - needed</legend>
<?php
$stat_i = 0;
foreach($this->data['Mob'] as $mob) {
	echo '<p>';
	echo $form->input('MobsQuest.'. $stat_i .'.check', array('value' => '1', 'checked' => 'checked', 'type' => 'checkbox', 'label' => false, 'div' => false));
	echo $form->input('MobsQuest.'. $stat_i .'.mob_id', array('options' => $mobs, 'value' => $mob['MobsQuest']['mob_id'], 'label' => false, 'div' => false));
	echo $form->input('MobsQuest.'. $stat_i .'.amount', array('value' => $mob['MobsQuest']['amount'], 'size' => '1', 'label' => false, 'div' => false));
	echo '</p>';
	$stat_i++;
}
?>
<?php
echo '<p>';
echo $form->input('MobsQuest.'. $stat_i .'.check', array('value' => '1', 'type' => 'checkbox', 'label' => false, 'div' => false));
echo $form->input('MobsQuest.'. $stat_i .'.mob_id', array('options' => $mobs, 'label' => false, 'div' => false));
echo $form->input('MobsQuest.'. $stat_i .'.amount', array('value' => '0', 'size' => '1', 'label' => false, 'div' => false));
echo '</p>';
?>
</fieldset>
<fieldset>
<legend>Stats - reward</legend>
<?php
$stat_i = 0;
foreach($this->data['Stat'] as $stat) {
	echo '<p>';
	echo $form->input('QuestsStat.'. $stat_i .'.check', array('value' => '1', 'checked' => 'checked', 'type' => 'checkbox', 'label' => false, 'div' => false));
	echo $form->input('QuestsStat.'. $stat_i .'.stat_id', array('options' => $stats, 'value' => $stat['QuestsStat']['stat_id'], 'label' => false, 'div' => false));
	echo $form->input('QuestsStat.'. $stat_i .'.amount', array('value' => $stat['QuestsStat']['amount'], 'size' => '1', 'label' => false, 'div' => false));
	echo '</p>';
	$stat_i++;
}
?>
<?php
echo '<p>';
echo $form->input('QuestsStat.'. $stat_i .'.check', array('value' => '1', 'type' => 'checkbox', 'label' => false, 'div' => false));
echo $form->input('QuestsStat.'. $stat_i .'.stat_id', array('options' => $stats, 'label' => false, 'div' => false));
echo $form->input('QuestsStat.'. $stat_i .'.amount', array('value' => '0', 'size' => '1', 'label' => false, 'div' => false));
echo '</p>';
?>
</fieldset>
<?php echo $form->end('Save'); ?>