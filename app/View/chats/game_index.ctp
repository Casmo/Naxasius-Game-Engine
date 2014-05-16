<?php
/*
 * Created on Apr 10, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
foreach($chats as $chat) {
	echo '<p class="chat chat_'. $chat['Chat']['type'] .'">';
	echo date('H:i:s', strtotime($chat['Chat']['created'])) .' | ';
	if($chat['Chat']['character_id_from'] == $gameInfo['Character']['id'] && isset($chat['CharacterTo']['name']) && !empty($chat['CharacterTo']['name'])) {
		echo __('to') .' ';
		echo $chat['CharacterTo']['name'] .': ';
	}
	elseif($chat['Chat']['character_id_to'] == $gameInfo['Character']['id'] && isset($chat['CharacterFrom']['name']) && !empty($chat['CharacterFrom']['name'])) {
		echo __('from') .' ';
		echo $chat['CharacterFrom']['name'] .': ';
	}
	elseif($chat['Chat']['character_id_from'] == 0) {
	}
	else {
		echo $chat['CharacterFrom']['name'] .': ';
	}
	echo $this->Ubb->output($chat['Chat']['message']);
	echo '</p>';
}
if(!empty($messages)) {
	$start = 0;
	$timeOut = 10000;
	?>
	<script type="text/javascript">
	<?php
	foreach($messages as $message) {
		?>
		setTimeout(function(){showMessage('<?php echo $this->Ubb->output($message, false, true); ?>');}, <?php echo $start; ?>);
		<?php
		$start = $start + $timeOut;
	}
	?>
	</script>
	<?php
}
?>