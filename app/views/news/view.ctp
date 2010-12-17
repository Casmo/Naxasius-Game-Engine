<?php
/*
 * Created on Apr 9, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="news">
	<div class="newstitle_c">
	<h2><?php echo $item['News']['title']; ?></h2>
	<span class="small"><?php echo date("d/m/y", strtotime($item['News']['created'])); ?><?php if(!empty($item['User']['username'])){ echo ' | '. __('by', true). ': '. $item['User']['username']; } ?></span>
	</div>
	<div class="newsmessage_c">
		<?php if(!empty($item['News']['image'])) {
			?>
			<div class="image_c borders"><?php echo $html->image('/img/website/news/'. $item['News']['image'], array('title' => $item['News']['image_title'])); ?></div>
			<?php
		}
		?>
		<?php echo $ubb->output($item['News']['message'], true); ?>
	</div>
</div>
<?php
if(!empty($item['Reply'])) {
	?>
	<div class="clearboth"><?php echo $html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/borders/hr.png'); ?></div>
	<div class="replies_c">
	<h2 name="replies"><?php __('Replies'); ?></h2>
	<?php
	foreach($item['Reply'] as $reply) {
		?>
		<div class="reply">
		<p><span class="small"><?php echo date("d/m/y", strtotime($reply['created'])); ?> | <?php __('by'); ?>: <?php echo $reply['User']['username']; ?></b></span><br />
		<?php echo $ubb->output($reply['message']); ?>
		</p>
		</div>
		<?php
	}
	?>
	</div>
	<?php
}
?>
<div class="clearboth"><?php echo $html->image('/img/game/interfaces/'. Configure::read('Game.interface') .'/borders/hr.png'); ?></div>
<div class="news-social"><?php __('Did you like it? Help me by sharing it!'); ?> <?php
echo $html->link($html->image('/img/website/icons/digg.png', array('title' => 'Digg')), 'http://digg.com/submit?phase=2&title='. urlencode($item['News']['title']) .'&url='. urlencode('http://www.naxasius.com'. $html->url('/news/view/'. $item['News']['id'])), array('escape' => false, 'class' => 'nostyle'));
echo ' ';
echo $html->link($html->image('/img/website/icons/twitter.png', array('title' => 'Twitter')), 'http://twitter.com/?status=Enjoyed%20this%20article%20from%20Naxasius%3a%20'. urlencode($item['News']['title']) .'%20'. urlencode('http://www.naxasius.com'. $html->url('/news/view/'. $item['News']['id'])), array('escape' => false, 'class' => 'nostyle'));
echo ' ';
echo $html->link($html->image('/img/website/icons/delicious.png', array('title' => 'Delicious')), 'http://delicious.com/save?title='. urlencode($item['News']['title']) .'&url='. urlencode('http://www.naxasius.com'. $html->url('/news/view/'. $item['News']['id'])), array('escape' => false, 'class' => 'nostyle'));
echo ' ';
echo $html->link($html->image('/img/website/icons/facebook.png', array('title' => 'Facebook')), 'http://www.facebook.com/share.php?u='. urlencode('http://www.naxasius.com'. $html->url('/news/view/'. $item['News']['id'])) .'&t='. urlencode($item['News']['title']), array('escape' => false, 'class' => 'nostyle'));
echo ' ';
echo $html->link($html->image('/img/website/icons/reddit.png', array('title' => 'Reddit')), 'http://reddit.com/submit?url='. urlencode('http://www.naxasius.com'. $html->url('/news/view/'. $item['News']['id'])) .'&title='. urlencode($item['News']['title']), array('escape' => false, 'class' => 'nostyle'));
echo ' ';
echo $html->link($html->image('/img/website/icons/stumbleupon.png', array('title' => 'StumbleUpon')), 'http://www.stumbleupon.com/submit?url='. urlencode('http://www.naxasius.com'. $html->url('/news/view/'. $item['News']['id'])) .'&title='. urlencode($item['News']['title']), array('escape' => false, 'class' => 'nostyle'));
echo ' ';
echo $html->link($html->image('/img/website/icons/rss.png', array('title' => 'RSS')), '/news/rss/', array('escape' => false, 'class' => 'nostyle'));
?></div>
<div class="news_reaction">
<h2 name="reply"><?php __('Tell me what you think!'); ?></h2>
<p><?php __('Please tell me what you think! Tips and suggestions are always welcome.'); ?></p>
<?php
if(isset($userInfo['id']) && !empty($userInfo['id'])) {
	echo $form->create('Reply', array('action' => 'add'));
	echo $form->input('Reply.news_id', array('type' => 'hidden', 'value' => $item['News']['id']));
	echo $form->input('Reply.message', array('label' => '<b>'. $userInfo['username'] .'</b>', 'type' => 'textarea', 'rows' => '5', 'cols' => '30'));
	echo $form->end('Post reply');
}
else {
	?>
	<p><?php echo __('Please', true) .' '. $html->link(__('Login', true), '/users/login') .' '. __('or', true) .' '. $html->link(__('Register', true), '/users/register') .' '. __('to reply.', true); ?></p>
	<?php
}
?>
</div>