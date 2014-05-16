<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?php echo $title_for_layout; ?></title>
<script type="text/javascript">
var url = '<?php echo $this->Html->url('/'); ?>';
var interface = '<?php echo Configure::read('Game.interface'); ?>';
</script>
<?php
echo $this->Html->script(array('j', 'game/ui', 'game/map', 'game/item', 'game/inventory', 'game/character', 'game/chat', 'j.borders', 'j.ui.c'));
echo $this->Html->css(array('reset.css', 'game.css'));
?>
</head>
<body>
<div class="c">
	<div class="statusbar_c borders" title="<?php echo __('Experience'); ?>"><div class="xp_bar_c"><div class="ding_bar" id="ding_bar"></div><div class="xp_bar" id="xp_bar" style="width: <?php echo floor((100 / $gameInfo['Stat']['xp_needed']) * $gameInfo['Stat']['xp_real']); ?>%;"></div><div class="xp_amount" id="xp_amount"><?php echo '<span id="char_xp">'. $gameInfo['Stat']['xp_real'] .'</span> / <span id="char_xp_max">'. $gameInfo['Stat']['xp_needed'] .'</span>'; ?></div></div></div>
	<div class="user_c">
		<div class="avatar_c" id="avatar_c"><?php echo $this->Html->image('/img/game/avatars/'. $gameInfo['Avatar']['image_map'] .'/big-ingame.png', array('width' => '123', 'height' => '123')); ?></div>
		<div class="characterinfo_c" id="characterinfo_c">
			<div class="charactername"><b><?php echo $gameInfo['Character']['name']; ?></b> (level <span id="character_level"><?php echo $gameInfo['Stat']['level']; ?></span> <?php echo $gameInfo['Type']['name']; ?>)</div>
			<div class="hp_bar_c" id="hp_bar_c" title="<?php echo __('Health'); ?>"><div class="hp_bar" id="hp_bar" style="width: <?php echo floor((100 / $gameInfo['Stat']['hp_max']) * $gameInfo['Stat']['hp']); ?>%;"></div><div class="hp_amount"><?php echo '<span id="char_hp">'. $gameInfo['Stat']['hp'] .'</span> / <span id="char_hp_max">'. $gameInfo['Stat']['hp_max'] .'</span>'; ?></div></div>
		</div>
	</div>
	<div class="message_c borders" id="message"></div>
	<div class="map_c borders" id="map_c">
	<div id="map" class="map">
	</div>
	</div>
	<div class="actions_c" id="actions_c"></div>
	<div class="actionsdetail_c" id="actionsdetail_c"></div>
	<div class="menu_c">
	<div class="menu_item"><?php echo $this->Html->link($this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/menu_home.png', array('title' => __('Home'))), '/game', array('escape' => false)); ?></div>
	<div class="menu_item"><?php echo $this->Html->link($this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/menu_character.png', array('title' => __('Character info'))), '#character', array('escape' => false, 'onclick' => 'showPopup(\''. $this->Html->url('/game/characters/view') .'\', \''. $this->Html->url('/img/game/avatars/'. $gameInfo['Avatar']['image_map'] .'/big-ingame.png') .'\')')); ?></div>
	<div class="menu_item"><?php echo $this->Html->link($this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/menu_quest.png', array('title' => __('Quests book'))), '#quests', array('escape' => false, 'onclick' => 'showPopup(\''. $this->Html->url('/game/quests') .'\', \''. $this->Html->url('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/quest_book.png') .'\')')); ?></div>
	<div class="menu_item"><?php echo $this->Html->link($this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/menu_messages.png', array('title' => __('Messages'))), '#messages', array('escape' => false, 'onclick' => 'showPopup(\''. $this->Html->url('/game/messages') .'\', \''. $this->Html->url('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/menu_messages.png') .'\')')); ?></div>
	<div class="menu_item"><?php echo $this->Html->link($this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/menu_ranking.png', array('title' => __('Rankings'))), '#rankings', array('escape' => false, 'onclick' => 'showPopup(\''. $this->Html->url('/game/rankings') .'\')')); ?></div>
	<div class="menu_item"><?php echo $this->Html->link($this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/menu_logout.png', array('title' => __('Logout'))), '/users/logout', array('escape' => false)); ?></div>
	</div>
	<div class="worldmap_c">
		<div class="minimap_c" id="minimap_c"><?php echo $this->Html->image('/img/game/maps/medium/empty.png', array('id' => 'minimap')); ?></div>
		<div class="minimapinfo_c" id="minimapinfo_c">
		<span class="map_title" id="map_title"></span>
		<span class="map_desc" id="map_desc"></span><br />
		<span class="map_system" id="map_system"></span>
		</div>
	</div>
	<div class="karma_c borders" title="<?php echo __('Good/evil rating'); ?>"><div class="karma_bar" id="karma_bar" style="width: 50%;"></div><div class="karma_amount" id="karma_amount">50%</div></div>
	<div class="chat_c borders" id="chat_c">
		<div id="chat"></div>
		<div class="talk_c">
			<div class="talk_character"><?php echo $gameInfo['Character']['name']; ?></div>
			<div class="chat_input"><input type="text" id="chat"></div>
		</div>
	</div>
	<div class="bags_c" id="bags_c">
	</div>
</div>
<div id="popup"></div>
<div id="popup_container"></div>
<div id="mouseInfo"></div>
<div id="x"></div>
</body>
</html>