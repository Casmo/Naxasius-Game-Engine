<?php
/*
 * Created on Aug 14, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo $this->Form->input('Group.id', array('options' => $groups, 'empty' => __('Select a group', true), 'label' => __('Group', true))); ?>
<div class="results">
<?php
foreach($tiles as $tile) {
	echo $this->Html->image('/img/game/tiles/'. $tile['Tile']['image'], array('id' => 'tile_'. $tile['Tile']['id'], 'class' => 'tile'));
}
?>
</div>
<script type="text/javascript">
$('select#GroupId').change(function(){
	$.ajax({
	  type: 'POST',
	  url: '<?php echo $this->Html->url('/admin/tiles/search'); ?>',
	  data: ({"data[Group][id]": $('select#GroupId').val()}),
	  success: function(data) {
		$('div#tiles').html(data);
	  }
	});
});
$('img.tile').each(function() {
	$(this).attr('title', '<?php __('Insert into area'); ?>');
});
$('img.tile').click(function() {
	theId = $(this).attr('id').replace(/[^0-9]+/, '');
	theSrc = $(this).attr('src');
	$.ajax({
		url: '<?php echo $this->Html->url('/admin/areas/change_tile/'); ?>' + area_id + '/' + theId,
		success: function(data) {
			$('div#area_' + area_id).css('background-image', 'url('+ theSrc +')');
			hidePopup();
		}
	});
});
</script>