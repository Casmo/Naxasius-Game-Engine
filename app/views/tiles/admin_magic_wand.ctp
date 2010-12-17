<?php
/*
 * Created on Mar 17, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */

foreach($tiles as $tile) {
	echo $html->image('/img/game/tiles/'. $tile['Tile']['image'], array('id' => 'tile_'. $tile['Tile']['id']));
}
?>
<script type="text/javascript">
// This is the magic wand functions
$('img[id^=tile_]').click(function() {
	tile_id = $(this).attr('id').replace(/[^0-9]+/,'');
	$('div.wand_area').css('background-image','url('+ $(this).attr('src') +')');
	hidePopup();
});
</script>