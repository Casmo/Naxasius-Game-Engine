<?php
/*
 * Created on Oct 27, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="popup_title">Level <?php echo $battleInfo['defender']['level']; ?> <?php echo $battleInfo['defender']['name']; ?></div>
<div class="popup_c">
<div class="image_left"><div class="damage_info" id="damage_you"></div><?php echo $this->Html->image('/img/game/avatars/'. $gameInfo['Avatar']['image_map'] .'/big-ingame.png', array('class' => 'mob', 'align' => 'left', 'width' => '100', 'height' => '100')); ?></div>
<div class="image_right"><div class="damage_info" id="damage_mob"></div><?php echo $this->Html->image('/img/game/mobs/100/'. $battleInfo['defender']['icon'], array('class' => 'mob', 'align' => 'right')); ?></div>
<div class="clearBoth battleLog" style="padding: 10px; margin-bottom: 20px;" id="log"></div>
<?php
if(!empty($loot)) {
?>
<h2>Loot</h2>
<div class="items">
<?php
foreach($loot as $item) {
	?>
	<div class="item" id="loot_<?php echo $item['Loot']['id']; ?>"><?php echo $this->Html->image('/img/game/items/'. $item['Item']['icon'], array('onclick' => 'lootItem(\''. $item['Loot']['id'] .'\')', 'onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $item['Item']['name'] .'\');', 'class' => 'icon')); ?></div>
	<?php
}
?>
</div>
<?php
}
?>
</div>
<script type="text/javascript">
setTimeout("$('div.image_right').borders();$('div.image_left').borders();$('div.center').borders();$('div.battleLog').borders();$('div.item').borders();", 10);
removeAction();
updateCharacterInfo();

function showLog() {
	<?php
	$timeOut = 0;
	$timeBetween = 1000; // Time in miliseconds between messages
	$max = 6; // Max count messages
	foreach($battleInfo['log'] as $index => $log) {
		$system_log = $battleInfo['log_system'][$index];
		$documentId = $system_log['battle_key'] == 'you' ? 'mob' : 'you';
		?>
		setTimeout("$('div#log').append('<div class=\"message <?php echo $battleInfo['log_system'][$index]['battle_key']; ?>\" style=\"display:none;\" id=\"message_<?php echo $index; ?>\"><?php echo addslashes($log); ?></div>');", <?php echo $timeOut; ?>);
		setTimeout("$('div#damage_<?php echo $documentId; ?>').text('<?php echo $system_log['damage']; ?>')", <?php echo $timeOut; ?>);
		<?php
		if($system_log['damage'] > 0) {
		?>
			setTimeout("$('div#damage_<?php echo $documentId; ?>').fadeIn(200);", <?php echo ($timeOut + 500); ?>);
		<?php
		}
		?>
			setTimeout("$('div#message_<?php echo $index; ?>').slideDown(200);", <?php echo ($timeOut + 500); ?>);

		<?php
		if(isset($battleInfo['log_system'][($index-1)])) {
			?>
			setTimeout("$('div#damage_<?php echo $documentId; ?>').fadeOut(200);", <?php echo ($timeOut - $timeBetween + 500); ?>);
			<?php
		}
		?>
		<?php
		if($index >= $max) {
			?>
			setTimeout("$('div#message_<?php echo $index - $max; ?>').slideUp(200);", <?php echo $timeOut; ?>);
			<?php
		}
		$timeOut = $timeOut + $timeBetween;
	}
	?>
}
function lootItem(loot_id) {
	$.get(url + '/game/loots/loot/' + loot_id, function(data) {
		if(data == '1') {
			$('div#loot_' + loot_id).fadeOut();
		}
		else {
			showMessage('<?php echo addslashes('The item couldn\'t be looted. Check your bags.'); ?>');
		}
	});
}
showLog();
</script>