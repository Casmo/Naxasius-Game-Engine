<?php
/*
 * Created on Aug 16, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo $this->Form->create('Obstacle', array('action' => 'admin_search')); ?>
<?php echo $this->Form->input('Group.id', array('options' => $groups, 'label' => __('Group', true), 'empty' => array(0 => __('Select group', true)))); ?>
<?php echo $this->Form->end(); ?>
<div>
<?php
foreach($obstacles as $obstacle) {
	echo $this->Html->image('/img/game/obstacles/'. $obstacle['Obstacle']['image'], array('id' => 'obstacle_'. $obstacle['Obstacle']['id'], 'class' => 'obstacle'));
}
?></div>
<script type="text/javascript">
$('select#GroupId').change(function(){$('form#ObstacleAdminSearchForm').submit();});
$('form#ObstacleAdminSearchForm').ajaxForm(function(data) {
	$('div#obstacleSearch').html(data);
});
$('img.obstacle').click(function() {
	theId = $(this).attr('id').replace(/[^0-9]+/, '');
	latestIndex = latestIndex + 1;
	addToForm = '';
	addToForm += '<p>';
	addToForm += '<input type="checkbox" name="data[Obstacle]['+ latestIndex +'][id]" CHECKED value="add" id="InputObstacleId'+ theId +'">';
	addToForm += '<label for="InputObstacleId'+ theId +'"><img src="'+ $(this).attr('src') +'"></label> ';
	addToForm += '<input type="input" value="0" name="data[Obstacle]['+ latestIndex +'][x]" size="1"> X-pos';
	addToForm += '<input type="input" value="0" name="data[Obstacle]['+ latestIndex +'][y]" size="1"> Y-pos';
	addToForm += '<input type="input" value="0" name="data[Obstacle]['+ latestIndex +'][z]" size="1"> Z-pos';
	addToForm += '<input type="hidden" value="'+ area_id +'" name="data[Obstacle]['+ latestIndex +'][area_id]" size="1">';
	addToForm += '<input type="hidden" value="'+ theId +'" name="data[Obstacle]['+ latestIndex +'][obstacle_id]" size="1">';
	addToForm += '</p>';
	$('div#newObstacles').append(addToForm);
});
</script>