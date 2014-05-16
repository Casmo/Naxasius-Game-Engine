<?php
/*
 * Created on Nov 21, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="popup_title"><?php echo $npc['Npc']['name']; ?></div>
<div class="npc_c">
<div class="npc_text"><p><?php echo $this->Ubb->output($conversations['last_log']['Conversation']['answer'], true); ?></p></div>
<div class="conversations_c">
<?php
if(empty($conversations['available'])) {
	echo '<div class="noOption">'. __('You have nothing to say...', true) .'</div>';
}
else {
	foreach($conversations['available'] as $conversation) {
		echo '<div class="option" onclick="talk(\''. $conversation['Conversation']['id'] .'\')">';
		echo $this->Ubb->output($conversation['Conversation']['question'], true) .'</div>';
	}
}
?>
</div>
<div class="conversation_character_c">
<div class="character"><?php echo $this->Html->image('/img/game/avatars/'. $gameInfo['Avatar']['image_map'] .'/big.png', array('width' => '64', 'height' => '64')); ?></div>
</div>
</div>
<script type="text/javascript">
function talk(conversation_id) {
	$('div#popup').load('<?php echo $this->Html->url('/game/npcs/talk/'. $npc['Npc']['id']); ?>/' + conversation_id, function(data) {
		initPopup('<?php echo $this->Html->url('/img/game/npcs/'. $npc['Npc']['icon']); ?>');
	});
}
function npcBorders() {
	$('div.character').borders();
	$('div.conversations_c').borders({
			corner_s: 1,
			offset: 0,
			left_image: '',
			right_image: '',
			top_image: url + 'img/game/interfaces/<?php echo Configure::read('Game.interface'); ?>/borders/t.png',
			bottom_image: url + 'img/game/interfaces/<?php echo Configure::read('Game.interface'); ?>/borders/b.png',
			topleft_image: '',
			topright_image: '',
			bottomright_image: '',
			bottomleft_image: '',
			background_image: ''
		});
}

setTimeout("npcBorders()", 200);
<?php
echo $javascriptsActions;
?>
</script>