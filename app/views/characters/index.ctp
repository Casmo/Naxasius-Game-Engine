<?php
/*
 * Created on Nov 13, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Character overview'); ?></h1>
<?php
foreach($characters as $character) {
	echo '<div class="characters_c">';
	echo '<div class="avatar">'. $this->Html->link($this->Html->image('/img/game/avatars/'. $character['Avatar']['image_map'] .'/big.png', array('width' => '100', 'height' => '100')), '/characters/play/'. $character['Character']['id'], array('escape' => false, 'class' => 'nostyle')) .'</div>';
	echo '<div class="info">';
	echo '<div class="char_name">'. $this->Html->link($character['Character']['name'], '/characters/play/'. $character['Character']['id']) .' ('. __('level', true) .' '. $character['Stat']['level'] .' '. $character['Type']['name'] .')</div>';
	echo '<div class="xp_bar" title="'. __('Experience', true) .'"><div class="xp_bar_process" style="width: '. ceil((100 / $character['Stat']['xp_needed'] * $character['Stat']['xp_real'])) .'%;"></div><div class="xp_bar_text">'. $character['Stat']['xp_real'] .' / '. $character['Stat']['xp_needed'] .'</div></div>';
	echo '<div class="hp_bar" title="'. __('Health', true) .'"><div class="hp_bar_process" style="width: '. ceil((100 / $character['Stat']['hp_max'] * $character['Stat']['hp'])) .'%;"></div><div class="hp_bar_text">'. $character['Stat']['hp'] .' / '. $character['Stat']['hp_max'] .'</div></div>';
	echo '</div>';
	echo '</div>';
}
echo '<p>';
if(empty($characters)) {
	__('You don\'t have any characters.');
	echo '<br />';
}
echo $html->link(__('Create a new character', true), '/characters/add'); ?></p>

<script type="text/javascript">
$('div.characters_c').borders({
	left_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/l.png'); ?>',
	right_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/r.png'); ?>',
	top_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/t.png'); ?>',
	bottom_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/b.png'); ?>',
	topleft_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/tl.png'); ?>',
	topright_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/tr.png'); ?>',
	bottomright_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/br.png'); ?>',
	bottomleft_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/bl.png'); ?>'
});
$('div.avatar').borders({
	left_image: '',
	right_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/r.png'); ?>',
	top_image: '',
	bottom_image: '',
	topleft_image: '',
	topright_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/tr_c.png'); ?>',
	bottomright_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/br_c.png'); ?>',
	bottomleft_image: '',
	background_image: ''
});
$('div.xp_bar, div.hp_bar').borders({
	left_image: '',
	right_image: '',
	top_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/t.png'); ?>',
	bottom_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/b.png'); ?>',
	topleft_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/tlm_c.png'); ?>',
	topright_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/trm_c.png'); ?>',
	bottomright_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/brm_c.png'); ?>',
	bottomleft_image: '<?php echo $html->url('/img/game/interfaces/wood/borders/blm_c.png'); ?>'
});
</script>