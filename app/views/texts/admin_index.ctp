<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Texts</h1>
<table class="summary">
<tr>
<th class="center small"><?php echo $paginator->sort('#', 'Text.id'); ?></th>
<th class="medium"><?php echo $paginator->sort('Name', 'Text.name'); ?></th>
<th><?php echo $paginator->sort('Title', 'Text.title'); ?></th>
<th class="medium"><?php echo $paginator->sort('Page', 'Page.name'); ?></th>
<th class="small center"><?php echo $paginator->sort('Order', 'Text.order'); ?></th>
<th class="options"><?php __('Options'); ?></th>
</tr>
<?php
foreach($texts as $text) {
	echo "<tr>";
	echo "<td class=\"center small\">". $html->link($text['Text']['id'], '/admin/texts/edit/'. $text['Text']['id']) ."</td>";
	echo "<td>". $html->link($text['Text']['name'], '/admin/texts/edit/'. $text['Text']['id']) ."</td>";
	echo "<td>". $html->link($text['Text']['title'], '/admin/texts/edit/'. $text['Text']['id']) ."</td>";
	echo "<td>". $html->link($text['Page']['name'], '/admin/pages/edit/'. $text['Page']['id']) ."</td>";
	echo "<td>". $html->link($text['Text']['order'], '/admin/texts/edit/'. $text['Text']['id']) ."</td>";
	echo "<td>".
	$html->link($html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'title' => 'Delete text', 'onclick' => 'return confirm(\'Delete text?\')')), '/admin/texts/delete/'. $text['Text']['id'], array('escape' => false))
	."</td>";
	echo "</tr>";
}
?>
<tfoot>
<tr><td colspan="7">
<?php echo $html->link($html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add text', true), '/admin/texts/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>