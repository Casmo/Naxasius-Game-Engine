<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Quests</h1>
<table class="summary">
<tr>
<th class="center small"><?php echo $paginator->sort('#', 'Quest.id'); ?></th>
<th><?php echo $paginator->sort('Name', 'Quest.name'); ?></th>
<th class="options">Options</th>
</tr>
<?php
foreach($quests as $quest) {
	echo '<tr>';
	echo '<td class="center">'. $html->link($quest['Quest']['id'], '/admin/quests/edit/'. $quest['Quest']['id']) .'</td>';
	echo '<td>'. $html->link($quest['Quest']['name'], '/admin/quests/edit/'. $quest['Quest']['id']) .'</td>';
	echo '<td>'. $html->link($html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'onclick' => 'return confirm(\'Delete quest?\')')), '/admin/quests/delete/'. $quest['Quest']['id'], array('escape' => false)) .'</td>';
	echo '</tr>';
}
?>
<tfoot>
<tr><td colspan="3">
<?php echo $html->link($html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add', true), '/admin/quests/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>