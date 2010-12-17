<?php
/*
 * Created on Apr 14, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div id="bag_inventory" class="bag_inventory"></div>
<div id="bags" class="bags">
<?php
for($i = 0; $i < Configure::read('Game.max_bags'); $i++) {
	if(isset($bags[$i])){
	$bag = $bags[$i];
	?>
	<div class="bag"><?php echo $this->Html->link($html->image('/img/game/items/'. $bag['Item']['icon'], array('id' => 'bag_'. $bag['Bag']['id'])), '#bags_'. $bag['Bag']['id'], array('escape' => false)); ?></div>
	<?php
	}
	else {
		?>
		<div class="bag"><?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/bag-empty.png'); ?></div>
		<?php
	}
}
?>
</div>
<script type="text/javascript">
var last_bag_id;
$('div.bag').borders();
$('img[id^=bag_]').click(function() {
	bag_id = $(this).attr('id').replace(/[^0-9]+/,'');
	if($('div#bag_inventory').html() != '' && last_bag_id == bag_id) {
		$('div#bag_inventory').html('');
	}
	else {
		loadBag(bag_id);
		last_bag_id = bag_id;
	}
});
</script>