<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Screenshots</h1>
<table class="summary">
<tr>
<th class="center small"><?php echo $paginator->sort('#', 'Screenshot.id'); ?></th>
<th><?php echo $paginator->sort('Title', 'Screenshot.title'); ?></th>
<th class="options"><?php __('Options'); ?></th>
</tr>
<?php
foreach($screenshots as $screenshot) {
	echo "<tr>";
	echo "<td class=\"center small\">". $html->link($screenshot['Screenshot']['id'], '/admin/screenshots/edit/'. $screenshot['Screenshot']['id']) ."</td>";
	echo "<td>". $html->link($screenshot['Screenshot']['title'], '/admin/screenshots/edit/'. $screenshot['Screenshot']['id']) ."</td>";
	echo "<td>".
	$html->link($html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'title' => 'Delete screenshot', 'onclick' => 'return confirm(\'Delete screenshot?\')')), '/admin/screenshots/delete/'. $screenshot['Screenshot']['id'], array('escape' => false))
	."</td>";
	echo "</tr>";
}
?>
<tfoot>
<tr><td colspan="7">
<?php echo $html->link($html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add screenshot', true), '/admin/screenshots/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>