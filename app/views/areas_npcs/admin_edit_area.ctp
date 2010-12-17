<?php
/*
 * Created on Aug 15, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php
echo $this->Form->create('AreasNpc', array('action' => 'edit_area', 'type' => 'file'));
$index = 0;
foreach($npcs as $npc) {
	$checked = '';
	$x = '0';
	$y = '0';
	$z = '0';
	if(isset($selectedNpcs[$npc['Npc']['id']])) {
		$checked = ' CHECKED';
		$x = $selectedNpcs[$npc['Npc']['id']]['x'];
		$y = $selectedNpcs[$npc['Npc']['id']]['y'];
		$z = $selectedNpcs[$npc['Npc']['id']]['z'];
	}
	echo '<input type="checkbox" name="data[Npc]['. $index .'][id]"'. $checked .' value="'. $npc['Npc']['id'] .'" id="InputNpcId'. $npc['Npc']['id'] .'">';
	echo '<label for="InputNpcId'. $npc['Npc']['id'] .'">'. $html->image('/img/game/npcs/'. $npc['Npc']['image']) .' '. $npc['Npc']['name'] .'</label> ';
	echo '<input type="input" value="'. $x .'" name="data[Npc]['. $index .'][x]" size="1"> '. __('X-pos', true) .' ';
	echo '<input type="input" value="'. $y .'" name="data[Npc]['. $index .'][y]" size="1"> '. __('Y-pos', true) .' ';
	echo '<input type="input" value="'. $z .'" name="data[Npc]['. $index .'][z]" size="1"> '. __('z-pos', true) .' ';
	echo '<input type="hidden" value="'. $area_id .'" name="data[Npc]['. $index .'][area_id]" size="1">';
	echo '<input type="hidden" value="'. $npc['Npc']['id'] .'" name="data[Npc]['. $index .'][npc_id]" size="1">';
	if(isset($selectedNpcs[$npc['Npc']['id']]['id'])) { echo '<input type="hidden" value="'. $selectedNpcs[$npc['Npc']['id']]['id'] .'" name="data[Npc]['. $index .'][unique_id]" size="1">'; }
	echo '<input type="file" name="data[Npc]['. $index .'][image]"> '. __('image', true) .'<br />';
	$index++;
}
echo $this->Form->end('Save');
?>
<script type="text/javascript">
$('form#AreasNpcEditAreaForm').ajaxForm(function() {
    hidePopup();
});
</script>