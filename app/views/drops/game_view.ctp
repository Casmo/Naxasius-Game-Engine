<?php
/*
 * Created on Nov 29, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */

if(empty($drops)) {
	echo '<h1>'. __('No items found here', true) .'</h1>';
}
else {
	foreach($drops as $index => $item) {
		echo $this->Html->link($this->Html->image('/img/game/items/'. $item['image'], array('alt' => 'item', 'id' => 'item_'. $index)), '#loot', array('escape' => false, 'onclick' => 'loot(\''. $index .'\');'));
	}
?>
<script type="text/javascript">
function loot(unique_id) {
	switch(unique_id) {
	<?php
	foreach($drops as $index => $item) {
		echo 'case "'. $index .'":';
		 // @TODO animate to bagslot
		?>
		$.get("<?php echo $html->url('/drops/loot/'. $item['areas_obstacles_item_id']); ?>", '', function(data) {

			if(data == '1') {
				$('#item_<?php echo $index; ?>').fadeOut();
				// Eventueel
			}
			else {
				// alert('<?php __('Item couldn\\\'t be looted'); ?>');
			}
		});
		<?php
		echo 'break;';
	}
	?>
	}
}
</script>
<?php
}
?>