<?php
/*
 * Created on Oct 27, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="popup_title"><?php echo $gameInfo['Character']['name']; ?> level <?php echo $gameInfo['Stat']['level']; ?> <?php echo $gameInfo['Type']['name']; ?></div>
<div class="popup_c">

<div class="charactersheet">

	<div class="left">
		<div class="item" id="equip_head" title="<?php echo __('Headpeace'); ?>"><?php echo isset($equiped_items['head']) ? $this->Html->image('/img/game/items/'. $equiped_items['head']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['head']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
		<div class="item" id="equip_neck" title="<?php echo __('Necklage'); ?>"><?php echo isset($equiped_items['neck']) ? $this->Html->image('/img/game/items/'. $equiped_items['neck']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['neck']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
		<div class="item" id="equip_shoulders" title="<?php echo __('Shoulders'); ?>"><?php echo isset($equiped_items['shoulders']) ? $this->Html->image('/img/game/items/'. $equiped_items['shoulders']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['shoulders']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
		<div class="item" id="equip_chest" title="<?php echo __('Chest'); ?>"><?php echo isset($equiped_items['chest']) ? $this->Html->image('/img/game/items/'. $equiped_items['chest']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['chest']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
		<div class="item" id="equip_wrist" title="<?php echo __('Wrist'); ?>"><?php echo isset($equiped_items['wrist']) ? $this->Html->image('/img/game/items/'. $equiped_items['wrist']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['wrist']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
	</div>

	<div class="center">
		<?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/character_sheet.png'); ?>
		<div class="main_hand item" id="equip_mainhand" title="<?php echo __('Mainhand'); ?>"><?php echo isset($equiped_items['mainhand']) ? $this->Html->image('/img/game/items/'. $equiped_items['mainhand']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['mainhand']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
		<div class="off_hand item" id="equip_offhand" title="<?php echo __('Offhand'); ?>"><?php echo isset($equiped_items['offhand']) ? $this->Html->image('/img/game/items/'. $equiped_items['offhand']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['offhand']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
	</div>

	<div class="right">
		<div class="item" id="equip_hands" title="<?php echo __('Gloves'); ?>"><?php echo isset($equiped_items['hands']) ? $this->Html->image('/img/game/items/'. $equiped_items['hands']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['hands']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
		<div class="item" id="equip_belt" title="<?php echo __('Belt'); ?>"><?php echo isset($equiped_items['belt']) ? $this->Html->image('/img/game/items/'. $equiped_items['belt']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['belt']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
		<div class="item" id="equip_legs" title="<?php echo __('Leggings'); ?>"><?php echo isset($equiped_items['legs']) ? $this->Html->image('/img/game/items/'. $equiped_items['legs']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['legs']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
		<div class="item" id="equip_feets" title="<?php echo __('Shoes'); ?>"><?php echo isset($equiped_items['feets']) ? $this->Html->image('/img/game/items/'. $equiped_items['feets']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['feets']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
		<div class="item" id="equip_ring" title="<?php echo __('Ring'); ?>"><?php echo isset($equiped_items['ring']) ? $this->Html->image('/img/game/items/'. $equiped_items['ring']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $equiped_items['ring']['name'] .'\');', 'class' => 'icon')) : ''; ?></div>
	</div>

	<div class="stats">
	<h2><?php echo __('Stats'); ?></h2>
	<div class="stat"><?php echo __('Health'); ?>: <span class="value" id="char_stat_hp"><?php echo $gameInfo['Stat']['hp'] .'/'. $gameInfo['Stat']['hp_max']; ?></span></div>
	<div class="stat"><?php echo __('Damage'); ?>: <span class="value" id="char_stat_damage"><?php echo $gameInfo['Stat']['min_damage'] .'-'. $gameInfo['Stat']['max_damage']; ?></span></div>
	<div class="stat"><?php echo __('Armor'); ?>: <span class="value" id="char_stat_armor"><?php echo isset($gameInfo['Stat']['armor']) ? $gameInfo['Stat']['armor'] : 0; ?></span></div>
	</div>

</div>

<div class="clearBoth">&nbsp;</div>

<h2><?php echo __('Inventory'); ?></h2>
<div class="items">
<?php
if(!empty($available_items)) {
	foreach($available_items as $item) {
		?>
		<div class="item" id="inv_c_item_<?php echo $item['Item']['id']; ?>"><?php echo $this->Html->image('/img/game/items/'. $item['Item']['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $item['Item']['name'] .'\');', 'class' => 'icon', 'id' => 'inv_item_'. $item['Item']['id'])); ?></div>
		<?php
	}
}
else {
echo __('No equipable items in your inventory...');
}
?>
</div>
<script type="text/javascript">
setTimeout("makeBorders()", 1);
$(document).ready(function() {
	setTimeout("initCharacterDragDrop();", 1000);
});
function makeBorders() {
	$('div.popup_c div.items > div.item').borders();
	$('div#equip_head').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_head.png'});
	$('div#equip_neck').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_neck.png'});
	$('div#equip_shoulders').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_shoulders.png'});
	$('div#equip_chest').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_chest.png'});
	$('div#equip_wrist').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_wrist.png'});
	$('div#equip_hands').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_hands.png'});
	$('div#equip_belt').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_belt.png'});
	$('div#equip_legs').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_legs.png'});
	$('div#equip_feets').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_feets.png'});
	$('div#equip_ring').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_ring.png'});
	$('div#equip_mainhand').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_mainhand.png'});
	$('div#equip_offhand').borders({background_image: url + 'img/game/interfaces/' + interface + '/icons/equip_offhand.png'});
}
</script>