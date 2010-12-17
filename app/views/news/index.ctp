<?php
/*
 * Created on Apr 9, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="header_c">
	<div class="header_w borders">
	<div class="header">
	<?php
	foreach($promotions as $index => $promotion) {
		echo $html->link($html->image('/img/website/promotions/'. $promotion['Promotion']['image'], array('id' => 'header_'. $index, 'class' => 'header')), $promotion['Promotion']['link'], array('escape' => false, 'class' => 'nostyle'));
		echo '<div class="header_text" id="header_text_'. $index .'">'. $promotion['Promotion']['title'] .'</div>';
	}
	?>
	</div>
	</div>
	<div class="features">
	<h2>What is Naxasius?</h2>
	<p>Naxasius is a <i>free</i> <strong>browser based</strong> <abbr title="Massive Multiplayer Online Role Playing Game">mmorpg</abbr> where you play with thousands of other players in a fantasy world.</p>
	<p>Play with your favorite class (Warrior, Priest, Magier or Assassin) and battle up against monsters, raid bosses, npcs and other players.</p>
	<p><?php echo $html->link(__('Game features', true), '/pages/view/3'); ?></p>
	</div>
</div>
<div class="news_c">
<div class="menu_c">
	<div class="menu"><?php echo $html->link(__('Item database', true), '/items', array('class' => 'nostyle')); ?></div>
</div>
<?php
foreach($news as $index => $item) {
	?>
	<div class="news">
		<div class="newstitle_c">
		<h2><?php echo $html->link($item['News']['title'], '/news/view/'. $item['News']['id']); ?></h2>
		<span class="small"><?php echo date("d/m/y", strtotime($item['News']['created'])); ?><?php if(!empty($item['User']['username'])){ echo ' | '. __('by', true). ': '. $item['User']['username']; } ?> | <?php echo $html->link(count($item['Reply']) == 1 ? count($item['Reply']) .' '. __('reply', true) : count($item['Reply']) .' '. __('replies', true), '/news/view/'. $item['News']['id'] .'#reply'); ?></span>
		</div>
		<div class="newsmessage_c">
			<?php if(!empty($item['News']['image'])) {
				?>
				<div class="image_c borders"><?php echo $this->Html->link($html->image('/img/website/news/'. $item['News']['image'], array('title' => $item['News']['image_title'], 'class' => 'nostyle')), '/news/view/'. $item['News']['id'], array('escape' => false, 'class' => 'nostyle')); ?></div>
				<?php
			}
			?>
			<?php echo $ubb->output($item['News']['summary'], true); ?>
		</div>
	</div>
	<div class="clearboth"><?php echo $html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/borders/hr.png'); ?></div>
	<?php
}
?>
<?php echo $this->Paginator->numbers(); ?>
</div>