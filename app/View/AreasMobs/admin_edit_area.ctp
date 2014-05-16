<?php
/*
 * Created on Aug 15, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php
echo $this->Form->create('AreasMob', array('action' => 'edit_area'));
$index = 0;
foreach($selectedMobs as $mob) {
echo $this->Form->input('AreasMob.id', array('name' => 'data[AreasMob]['. $index .'][id]', 'type' => 'hidden', 'value' => $mob['AreasMob']['id'], 'label' => false, 'div' => false));
echo $this->Form->input('AreasMob.area_id', array('name' => 'data[AreasMob]['. $index .'][area_id]', 'type' => 'hidden', 'value' => $area_id, 'label' => false, 'div' => false));
echo $this->Form->input('AreasMob.index', array('name' => 'data[AreasMob]['. $index .'][index]', 'type' => 'checkbox', 'value' => '1', 'checked' => 'checked', 'label' => false, 'div' => false));
echo $this->Form->input('AreasMob.mob_id', array('options' => $mobs, 'value' => $mob['AreasMob']['mob_id'], 'empty' => __('Select mob'), 'div' => false, 'label' => false, 'name' => 'data[AreasMob]['. $index .'][mob_id]')) .' ';
echo $this->Form->input('AreasMob.quest_id', array('options' => $quests, 'value' => $mob['AreasMob']['quest_id'], 'empty' => array(0 => __('Select required quest')), 'div' => false, 'label' => false, 'name' => 'data[AreasMob]['. $index .'][quest_id]')) .' ';
echo $this->Form->input('AreasMob.spawn_time', array('value' => $mob['AreasMob']['spawn_time'], 'title' => __('Spawn time'), 'name' => 'data[AreasMob]['. $index .'][spawn_time]', 'div' => false, 'label' => false, 'size' => '2')) .' '. __('sec.') .' ';
echo $this->Form->input('AreasMob.kill_limit', array('value' => $mob['AreasMob']['kill_limit'], 'title' => __('Kill limit'), 'name' => 'data[AreasMob]['. $index .'][kill_limit]', 'div' => false, 'label' => false, 'size' => '2')) .' '. __('Kill limit.') .' ';
echo $this->Form->input('AreasMob.player_only', array('checked' => $mob['AreasMob']['player_only'] == 1 ? 'checked' : null, 'value' => '1', 'title' => __('Player only'), 'name' => 'data[AreasMob]['. $index .'][player_only]', 'div' => false, 'label' => false, 'type' => 'checkbox')) .' '. __('Player only.');
echo '<br />';
$index++;
}
echo $this->Form->input('AreasMob.index', array('name' => 'data[AreasMob]['. $index .'][index]', 'type' => 'checkbox', 'value' => '1', 'label' => false, 'div' => false));
echo $this->Form->input('AreasMob.area_id', array('name' => 'data[AreasMob]['. $index .'][area_id]', 'type' => 'hidden', 'value' => $area_id, 'label' => false, 'div' => false));
echo $this->Form->input('AreasMob.mob_id', array('options' => $mobs, 'empty' => __('Select mob'), 'div' => false, 'label' => false, 'name' => 'data[AreasMob]['. $index .'][mob_id]')) .' ';
echo $this->Form->input('AreasMob.quest_id', array('options' => $quests, 'empty' => array(0 => __('Select required quest')), 'div' => false, 'label' => false, 'name' => 'data[AreasMob]['. $index .'][quest_id]')) .' ';
echo $this->Form->input('AreasMob.spawn_time', array('value' => '120', 'title' => __('Spawn time'), 'name' => 'data[AreasMob]['. $index .'][spawn_time]', 'div' => false, 'label' => false, 'size' => '2')) .' '. __('sec.') .' ';
echo $this->Form->input('AreasMob.kill_limit', array('value' => '0', 'title' => __('Kill limit'), 'name' => 'data[AreasMob]['. $index .'][kill_limit]', 'div' => false, 'label' => false, 'size' => '2')) .' '. __('Kill limit.') .' ';
echo $this->Form->input('AreasMob.player_only', array('value' => '1', 'title' => __('Player only'), 'name' => 'data[AreasMob]['. $index .'][player_only]', 'div' => false, 'label' => false, 'type' => 'checkbox')) .' '. __('Player only.');
echo $this->Form->end('Save');
?>
<script type="text/javascript">
$('form#AreasMobEditAreaForm').ajaxForm(function() {
    hidePopup();
});
</script>