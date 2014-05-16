<?php
/*
 * Created on Nov 29, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php echo __('Inventory'); ?></h1>
<?php
foreach($items as $item) {
	echo $this->Html->image('/img/game/items/'. $item['Item']['image']);
}
?>