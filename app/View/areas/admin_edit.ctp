<?php
/*
 * Created on Nov 17, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Edit area #<?php echo $this->data['Area']['id']; ?></h1>
<?php
echo $this->Form->create('Area', array('action' => 'edit', 'type' => 'file'));
?>
<fieldset>
<legend>Area details</legend>
<div class="text input">
<label>Id</label>
<?php echo $this->data['Area']['id']; ?>
</div>
<div class="text input">
<label>Position</label>
<?php echo $this->data['Map']['name']; ?> <?php echo $this->data['Area']['x']; ?>, <?php echo $this->data['Area']['y']; ?>
</div>
<?php echo $this->Form->input('Area.access', array('options' => array(0 => __('No'), 1 => __('Yes')))); ?>
<?php echo $this->Form->input('Area.restriction', array('options' => array('none' => __('None'), 'up' => __('Up'), 'right' => __('Right'), 'left' => __('left'), 'down' => __('Down')))); ?>
<?php echo $this->Form->input('Area.travel_to', array('label' => 'Travel to area #', 'size' => 1)); ?>
<?php
echo $this->Form->input('Area.travel_to_quest_id', array('options' => $quests, 'label' => 'Quest needed', 'empty' => array(0 => '')));
?>
<div class="text input">
<label>Background</label>
<?php echo $this->Html->image('/img/game/tiles/'. $this->data['Tile']['image']) . '<br />'; ?>
</div>
</fieldset>

<?php
echo $this->Form->end('Save');
?>

<fieldset>
<legend id="legendTiles"><?php echo __('Background tiles'); ?></legend>
<div id="tiles" style="display: none;"></div>
</fieldset>
<fieldset>
<legend id="legendMobs"><?php echo __('Mobs'); ?></legend>
<div id="mobs" style="display: none;">
</div>
</fieldset>
<fieldset>
<legend id="legendNpcs"><?php echo __('Npc\'s'); ?></legend>
<div id="npcs" style="display: none;">
</div>
</fieldset>
<fieldset>
<legend id="legendObstacles"><?php echo __('Obstacles'); ?></legend>
<div id="obstacles" style="display: none;"></div>
</fieldset>
<fieldset>
<legend id="legendSheets"><?php echo __('Sheets'); ?></legend>
<div id="sheets" style="display: none;"></div>
</fieldset>
<script type="text/javascript">

var tilesLoaded = false;
var npcsLoaded = false;
var mobsLoaded = false;
var obstaclesLoaded = false;
var sheetsLoaded = false;

$('legend#legendTiles').click(function() {
	$('div#tiles').toggle(function() {
		if(tilesLoaded == false) {
			$('div#tiles').load('<?php echo $this->Html->url('/admin/tiles/search'); ?>');
			tilesLoaded = true;
		}
	});
});

$('legend#legendNpcs').click(function() {
	$('div#npcs').toggle(function() {
		if(npcsLoaded == false) {
			$('div#npcs').load('<?php echo $this->Html->url('/admin/areas_npcs/edit_area/'. $this->data['Area']['id']); ?>');
			npcsLoaded = true;
		}
	});
});

$('legend#legendMobs').click(function() {
	$('div#mobs').toggle(function() {
		if(mobsLoaded == false) {
			$('div#mobs').load('<?php echo $this->Html->url('/admin/areas_mobs/edit_area/'. $this->data['Area']['id']); ?>');
			mobsLoaded = true;
		}
	});
});

$('legend#legendObstacles').click(function() {
	$('div#obstacles').toggle(function() {
		if(obstaclesLoaded == false) {
			$('div#obstacles').load('<?php echo $this->Html->url('/admin/areas_obstacles/edit_area/'. $this->data['Area']['id']); ?>');
			obstaclesLoaded = true;
		}
	});
});

$('legend#legendSheets').click(function() {
	$('div#sheets').toggle(function() {
		if(sheetsLoaded == false) {
			$('div#sheets').load('<?php echo $this->Html->url('/admin/sheets/add_to_area/'. $this->data['Area']['id']); ?>');
			sheetsLoaded = true;
		}
	});
});

var options = {
	success:       showResponse  // post-submit callback
};
$('#AreaEditForm').ajaxForm(options);
function showResponse(responseText, statusText) {
//	$('div#area_<?php echo $this->data['Area']['id']; ?>').css('background-image', 'url(<?php echo $this->Html->url('/img/game/tiles/'); ?>'+ ($('input[id^=tileId]:checked').attr('img') +')'));
	hidePopup();
}

</script>