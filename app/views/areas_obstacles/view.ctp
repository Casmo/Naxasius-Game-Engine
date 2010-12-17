<?php
/*
 * Created on Nov 29, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
if(!empty($AreasObstacle['Item'])) {
	echo '<h1>Items</h1>';
	foreach($AreasObstacle['Item'] as $index => $item) {
		echo $this->Html->link($html->image('/img/game/items/'. $item['image'], array('alt' => 'item', 'id' => 'item_'. $item['AreasObstaclesItem']['id'])), '#loot', array('escape' => false, 'onclick' => 'loot(\''. $item['AreasObstaclesItem']['id'] .'\');'));
	}
}

if(!empty($AreasObstacle['Quest'])) {
	echo '<h1>Quests</h1>';
	foreach($AreasObstacle['Quest'] as $index => $quest) {
		echo '<div id="quest_'. $quest['id'] .'">';
		echo $this->Html->link($html->image('/img/icons/question.png') .' '. $quest['name'], '#quest', array('escape' => false, 'onclick' => 'quest(\''. $quest['id'] .'\');'));
		echo '</div>';
	}
}
?>
<script type="text/javascript">
<?php
if(!empty($AreasObstacle['Item'])) {
?>
	function loot(areas_obstacles_item_id) {
		$.get("<?php echo $html->url('/drops/loot/'); ?>" + areas_obstacles_item_id, '', function(data) {

			if(data == '1') {
				$('#item_' + areas_obstacles_item_id).fadeOut();
			}
			else {
				alert('<?php __('Item couldn\\\'t be looted'); ?>');
			}
		});
	}
<?php
}
if(!empty($AreasObstacle['Item'])) {
?>
	function quest(quest_id) {
		$.get("<?php echo $html->url('/quests/accept/'); ?>" + areas_obstacles_item_id, '', function(data) {

				if(data == '1') {
					$('#item_' + areas_obstacles_item_id).fadeOut();
				}
				else {
					alert('<?php __('Quest couldn\\\'t be accepted'); ?>');
				}
			});
	}
<?php
}
?>
</script>