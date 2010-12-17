<?php
/*
 * Created on Nov 28, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Items</h1>

<table class="summary">
<tr>
<th class="center small"><?php echo $paginator->sort('#', 'Item.id'); ?></th>
<th class="center small">Image</th>
<th><?php echo $paginator->sort('Name', 'Item.name'); ?></th>
<th class="medium"><?php echo $paginator->sort('Group', 'Group.name'); ?></th>
<th class="options">Options</th>
</tr>
<?php
foreach($items as $item) {
	echo '<tr>';
	echo '<td class="center">'. $html->link($item['Item']['id'], '/admin/items/edit/'. $item['Item']['id']) .'</td>';
	echo '<td>'. $html->link($html->image('/img/game/items/'. $item['Item']['image']), '/admin/items/edit/'. $item['Item']['id'], array('escape' => false)) .'</td>';
	echo '<td>'. $html->link($item['Item']['name'], '/admin/items/edit/'. $item['Item']['id']) .'</td>';
	echo '<td>'. $html->link($item['Group']['name'], '/admin/group/edit/'. $item['Group']['id']) .'</td>';
	echo '<td>'. $html->link($html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'onclick' => 'return confirm(\'Delete?\')')), '/admin/items/delete/'. $item['Item']['id'], array('escape' => false)) .'</td>';
	echo '</tr>';
}
?>
<tfoot>
<tr><td colspan="5">
<?php echo $html->link($html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add', true), '/admin/items/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>