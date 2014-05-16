<?php
/*
 * Created on Mar 19, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit class "<?php echo $this->data['Type']['name']; ?>"</h1>
<?php echo $this->Form->create('Type', array('action' => 'admin_edit')); ?>
<fieldset>
<legend>Class details</legend>
<?php echo $this->Form->input('Type.id'); ?>
<?php echo $this->Form->input('Type.name'); ?>
<?php echo $this->Form->input('Type.description', array('class' => 'tinymce')); ?>
</fieldset>
<fieldset>
<legend>Stats details</legend>
<?php
$stat_i = 0;
foreach($this->data['Stat'] as $stat) {
	?>
	<p>
	<?php echo $this->Form->input('StatsType.'. $stat_i .'.check', array('label' => false, 'div' => false, 'type' => 'checkbox', 'checked' => 'checked', 'value' => '1')); ?>
	<?php echo $this->Form->input('StatsType.'. $stat_i .'.stat_id', array('options' => $stats, 'value' => $stat['StatsType']['stat_id'], 'div' => false, 'label' => false)); ?>
	<?php echo $this->Form->input('StatsType.'. $stat_i .'.amount', array('size' => '3', 'value' => $stat['StatsType']['amount'], 'title' => __('Value', true), 'div' => false, 'label' => false)); ?>
	</p>
	<?php
	$stat_i++;
}
?>
<p>
	<?php echo $this->Form->input('StatsType.'. $stat_i .'.check', array('label' => false, 'div' => false, 'type' => 'checkbox', 'value' => '1')); ?>
	<?php echo $this->Form->input('StatsType.'. $stat_i .'.stat_id', array('options' => $stats, 'div' => false, 'label' => false)); ?>
	<?php echo $this->Form->input('StatsType.'. $stat_i .'.amount', array('size' => '3', 'title' => __('Value', true), 'div' => false, 'label' => false)); ?>
</p>
</fieldset>
<?php echo $this->Form->end('save'); ?>