<?php
/*
 * Created on Jan 30, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="item_c">
<h1><?php echo $quest['Quest']['name']; ?></h1>
<p><?php echo $this->Ubb->output($quest['Quest']['description_summary'], true); ?></p>
<h2><?php __('Description'); ?></h2>
<p><?php echo $this->Ubb->output($quest['Quest']['description_full'], true); ?></p>
<?php
if(!empty($quest['RequirementsItem']) || !empty($quest['RequirementsMob'])) {
?>
<h2><?php __('Requirements'); ?></h2>
<div class="quest_item_c" style="padding-left: 5px;">
<?php
foreach($quest['RequirementsItem'] as $item) {
	echo "<div class='quest_item' style='float: left; margin-right: 10px; margin-bottom: 10px;'>";
	if($item['ItemsQuest']['amount'] > 1) {
		echo '<span class="amount">'. $item['ItemsQuest']['amount'] .'</span>';
	}
	echo $this->Html->image('/img/game/items/'. $item['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'items/view/'. $item['name'] .'\');', 'class' => 'icon')) .'</div>';
}
foreach($quest['RequirementsMob'] as $mob) {
	echo "<div class='item' style='float: left; margin-right: 10px;'>";
	if($mob['MobsQuest']['amount'] > 1) {
		echo '<span class="amount">'. $mob['MobsQuest']['amount'] .'</span>';
	}
	echo $this->Html->image('/img/game/mobs/32/'. $mob['icon'], array('onmouseout' => 'hideMouseInfo();', 'onmouseover' => 'showMouseInfo(url + \'mobs/view/'. $mob['name'] .'\');', 'class' => 'icon')) .'</div>';
}
?>
</div>
<?php
}
?>
<div class="clearBoth">&nbsp;</div>
</div>
<script type="text/javascript">
//$(function () { // @TODO
setTimeout("$('div.quest_item').borders();", 1);
</script>