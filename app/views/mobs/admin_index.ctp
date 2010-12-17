<?php
/*
 * Created on Nov 28, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Mobs</h1>

<table class="summary">
<tr>
<th class="center small"><?php echo $paginator->sort('#', 'Mob.id'); ?></th>
<th class="icon">Icon</th>
<th><?php echo $paginator->sort('Name', 'Mob.name'); ?></th>
<th class="small center"><?php echo $paginator->sort('Level', 'Mob.level'); ?></th>
<th class="options">Options</th>
</tr>
<?php
foreach($mobs as $mob) {
	echo '<tr>';
	echo '<td class="center">'. $html->link($mob['Mob']['id'], '/admin/mobs/edit/'. $mob['Mob']['id']) .'</td>';
	echo '<td>'. $html->link($html->image('/img/game/mobs/32/'. $mob['Mob']['icon']), '/admin/mobs/edit/'. $mob['Mob']['id'], array('escape' => false)) .'</td>';
	echo '<td>'. $html->link($mob['Mob']['name'], '/admin/mobs/edit/'. $mob['Mob']['id']) .'</td>';
	echo '<td class="center">'. $html->link($mob['Mob']['level'], '/admin/mobs/edit/'. $mob['Mob']['id']) .'</td>';
	echo '<td>'. $html->link($html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'onclick' => 'return confirm(\'Delete?\')')), '/admin/mobs/delete/'. $mob['Mob']['id'], array('escape' => false)) .'</td>';
	echo '</tr>';
}
?>
<tfoot>
<tr><td colspan="5">
<?php echo $html->link($html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add', true), '/admin/mobs/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>