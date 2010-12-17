<?php
/*
 * Created on Apr 11, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="item_c">
<div class="item" id="item_<?php echo $item['Item']['id']; ?>"><?php echo $html->image('/img/game/items/'. $item['Item']['icon']); ?></div>
<h1><?php echo $item['Item']['name']; ?></h1>
<p>
<?php echo $item['Item']['unique'] == '1' ? __('Unique', true) .'<br />' : ''; ?>
<?php echo $item['Item']['type'] != 'none' ? $item['Item']['type'] .'<br />' : ''; ?>
<?php echo $item['Item']['slot'] != 'none' ? $item['Item']['slot'] .'<br />' : ''; ?>
</p>
<?php
if(!empty($item['Stat'])) {
	?><p>
	<?php
	foreach($item['Stat'] as $stat){
		echo $stat['ItemsStat']['value'] > 0 ? '+'. $stat['ItemsStat']['value'] : $stat['ItemsStat']['value'];
		echo ' '. $stat['name'] .'<br />';
	}
	?></p><?php
}
?>
<?php
echo !empty($item['Item']['description']) ? '<div class="item_desc">'. $item['Item']['description'] .'</div>' : '';
?>
<?php
if(isset($item['Character']['name']) && !empty($item['Character']['name'])) {
	?>
	<div class="item_lootedby"><?php __('Discovered by:'); ?> <?php echo $item['Character']['name']; ?></div>
	<?php
}
?>
</div>
<script type="text/javascript">
setTimeout("$('div#item_<?php echo $item['Item']['id']; ?>').borders();", 1);
</script>