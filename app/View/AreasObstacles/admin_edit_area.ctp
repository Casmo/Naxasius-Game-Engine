<?php
/*
 * Created on Aug 16, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php
echo $this->Form->create('AreasObstacle', array('action' => 'edit_area'));
$index = 0;
echo '<p><b>'. __('Current obstacles') .'</b></p>';
foreach($selectedObstacles as $index => $obstacle) {
	echo '<p>';
	echo '<input type="checkbox" name="data[Obstacle]['. $index .'][id]" CHECKED value="'. $obstacle['id'] .'" id="InputObstacleId'. $obstacle['id'] .'">';
	echo '<input type="hidden" name="data[Obstacle]['. $index .'][delete_id]" CHECKED value="'. $obstacle['id'] .'" id="InputObstacleDeleteId'. $obstacle['id'] .'">';
	echo '<label for="InputObstacleId'. $obstacle['id'] .'">'. $this->Html->image('/img/game/obstacles/'. $obstacle['image']) .'</label> ';
	echo '<input type="input" value="'. $obstacle['x'] .'" name="data[Obstacle]['. $index .'][x]" size="1"> '. __('X-pos') .' ';
	echo '<input type="input" value="'. $obstacle['y'] .'" name="data[Obstacle]['. $index .'][y]" size="1"> '. __('Y-pos') .' ';
	echo '<input type="input" value="'. $obstacle['z'] .'" name="data[Obstacle]['. $index .'][z]" size="1"> '. __('Z-pos') .' ';
	echo '<input type="hidden" value="'. $area_id .'" name="data[Obstacle]['. $index .'][area_id]" size="1">';
	echo '<input type="hidden" value="'. $obstacle['obstacle_id'] .'" name="data[Obstacle]['. $index .'][obstacle_id]" size="1">';
	echo '<a href="#edit" onclick="popup(\''. $this->Html->url('/admin/drops/edit/'. $obstacle['id']) .'\');">'. __('Edit Drops') .'</a>';
	echo '</p>';
}
echo '<div id="newObstacles"></div>';
echo $this->Form->input('Area.id', array('value' => $area_id));
echo $this->Form->end('save');
?>
<div id="obstacleSearch"></div>
<script type="text/javascript">
var area_id = <?php echo $area_id; ?>;
var latestIndex = <?php echo $index; ?>;
$('form#AreasObstacleEditAreaForm').ajaxForm(function() {
    hidePopup();
	$('div#area_<?php echo $area_id; ?>').load('<?php echo $this->Html->url('/admin/areas/view/'. $area_id); ?>');
});
$('div#obstacleSearch').load('<?php echo $this->Html->url('/admin/obstacles/search'); ?>');
</script>