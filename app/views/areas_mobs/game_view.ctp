<?php
/*
 * Created on Oct 27, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="popup_title">Level <?php echo $areasMob['Mob']['level']; ?> <?php echo $areasMob['Mob']['name']; ?></div>
<div class="popup_c">
<div class="image_right"><?php echo $this->Html->image('/img/game/mobs/100/'. $areasMob['Mob']['icon'], array('class' => 'mob', 'align' => 'right')); ?></div>
<?php echo $areasMob['Mob']['description']; ?>
<?php
if(isset($areasMob['Mob']['Stat']) && !empty($areasMob['Mob']['Stat'])) {
	?>
	<h2>Stats</h2>
	<p>
	<?php
	foreach($areasMob['Mob']['Stat'] as $key => $value) {
		echo '<b>'. __($key, true) .':</b> '. $value .'<br />';
	}
	?>
	</p>
	<?php
}
?>
<div class="clearBoth">&nbsp;</div>
<div class="icon"><?php echo $this->Html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/icons/attack_auto.png', array('title' => __('Auto attack', true), 'style' => 'cursor: pointer;', 'onclick' => 'showPopup(\''. $this->Html->url('/game/areas_mobs/attack/'. $areasMob['AreasMob']['id']) .'\');')); ?></div>
</div>
<script type="text/javascript">
setTimeout("$('div.image_right').borders();$('div.icon').borders();", 10);
</script>