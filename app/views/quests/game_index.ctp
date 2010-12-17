<?php
/*
 * Created on Jan 30, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="popup_title"><?php __('Quests'); ?></div>
<div class="popup_c">
<div id="quests_c" style="padding: 5px;">
<div class="quests" id="quests">
<?php
if(empty($quests)) {
	echo '<div class="noQuest">'. __('No Quests found...', true) .'</div>';
}
else {
	foreach($quests as $quest) {
		echo '<div class="quest" onclick="$(\'div#quest_detail\').load(\''. $this->Html->url('/game/quests/view/'. $quest['Quest']['id']) .'\');">'. $quest['Quest']['name'] .'</div>';
	}
}
?>
</div>
</div>
<div id="quest_detail_c">
<div id="quest_detail">
</div>
</div>
</div>
<script type="text/javascript">
tabs = new Array();
tablinks = new Array();
tabs[0] = '<?php __('Active'); ?>';
tabs[1] = '<?php __('Completed'); ?>';
tablinks[0] = '<?php echo $this->Html->url('/game/quests/index/active'); ?>';
tablinks[1] = '<?php echo $this->Html->url('/game/quests/index/completed'); ?>';
tabsPopup(tabs, tablinks, '<?php echo $html->url('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/quest_book.png'); ?>');
setTimeout("$('div#quests_c, div#quest_detail_c').borders({background_image: url + 'img/game/interfaces/' + interface +'/borders/background_dark.jpg'});", 10);
</script>