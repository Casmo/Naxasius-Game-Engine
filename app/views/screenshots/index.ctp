<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Screenshots</h1>
<div class="screenshots">
<?php
foreach($screenshots as $screenshot) {
	echo '<div class="screenshot">';
	echo $html->link($html->image('/img/website/screenshots/small/'. $screenshot['Screenshot']['image'], array('title' => $screenshot['Screenshot']['title'])), '/img/website/screenshots/big/'. $screenshot['Screenshot']['image'], array('escape' => false, 'class' => 'nostyle screenshots', 'title' => $screenshot['Screenshot']['description']));
	echo '</div>';

}
?>
</div>
<div class="clearboth"></div>
<div class="summary_pages"><?php echo $paginator->counter(array('format' => 'Displaying %start% to %end% of %count% screenshots')); ?></div>
<div class="pages"><?php echo $paginator->numbers(); ?></div>
<script type="text/javascript">
$('div.screenshot').borders();
$('a.screenshots').fancybox();
</script>