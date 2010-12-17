<?php
/*
 * Created on Apr 9, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<div class="page_c">
	<div class="page_header">
	<h1><?php echo $page['Page']['title']; ?></h1>
	<p><?php echo $ubb->output($page['Page']['message'], true); ?></p>
	</div>
	<div class="messages_c">
		<?php
		foreach($page['Text'] as $text) {
			?>
			<div class="message">
			<?php if(!empty($text['image'])) {
				?>
				<div class="image_c borders"><?php echo $html->image('/img/website/texts/'. $text['image'], array('title' => $text['image_title'])); ?></div>
				<?php
			}
			?>
			<h2 name="<?php echo $text['name']; ?>"><?php echo $text['title']; ?></h2>
			<p><?php echo $ubb->output($text['message'], true); ?></p>
			</div>
			<?php
		}
		?>
	</div>
</div>