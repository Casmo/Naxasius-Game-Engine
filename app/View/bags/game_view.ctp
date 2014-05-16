<?php
/*
 * Created on Apr 15, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
$items_a_row = floor(($bag['Item']['Stat'][0]['ItemsStat']['value'] / 3));
$item_i = 1;
for($i = 1; $i <= $bag['Item']['Stat'][0]['ItemsStat']['value']; $i++) {
	$index = $i;
	if($item_i == $items_a_row) {
		?>
		<div class="inventory_c">
		<?php
	}
	if(isset($inventories[$i])) {
		$inventory = $inventories[$i];
		?>
		<div class="inventory item" id="inventory_<?php echo $bag['Bag']['id']; ?>_<?php echo $index; ?>"><?php
		echo $this->Html->image('/img/game/items/'. $inventory['Item']['icon'], array('id' => 'item_bag_'. $bag['Bag']['id'] .'_'. $index, 'onMouseover' => 'showMouseInfo(url + \'items/view/'. $inventory['Item']['name'] .'\');', 'onmouseout' => 'hideMouseInfo();'));
		if($inventory[0]['count'] > 1) {
			echo '<span class="amount">'. $inventory[0]['count'] .'</span>';
		}
		?></div>
		<?php
	}
	else {
		?>
		<div class="inventory" id="inventory_<?php echo $bag['Bag']['id']; ?>_<?php echo $index; ?>"></div>
		<?php
	}
	if($item_i == $items_a_row) {
		?>
		</div>
		<?php
		$item_i = 0;
	}
	$item_i++;
}
?>
<script type="text/javascript">
$('div.inventory').borders();
initBagDragDrop();
</script>