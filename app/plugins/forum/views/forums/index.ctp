<?php
/*
 * Created on Nov 7, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Forum'); ?></h1>
<p><?php __('Welcome to the Naxasius forums.'); ?></p>
<?php
foreach($forums as $forum) {
	?>
	<div class="forum">
	<h2><?php echo $this->Html->link($forum['Forum']['name'], '/forum/view/'. $forum['Forum']['id']); ?></h2>
	<p><?php echo $forum['Forum']['description']; ?></p>
	</div>
	<?php
}
?>
<script type="text/javascript">
$('div.forum').borders();
</script>