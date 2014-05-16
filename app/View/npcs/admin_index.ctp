<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Npcs'); ?></h1>
<table class="summary">
<tr>
<th class="center small"><?php echo $this->Paginator->sort('#', 'id'); ?></th>
<th><?php echo $this->Paginator->sort('Name', 'name'); ?></th>
<th class="options"><?php __('Options'); ?></th>
</tr>
<?php
foreach($npcs as $npc) {
	echo "<tr>";
	echo "<td class=\"center\">". $this->Html->link($npc['Npc']['id'], '/admin/npcs/edit/'. $npc['Npc']['id']) ."</td>";
	echo "<td>". $this->Html->link($npc['Npc']['name'], '/admin/npcs/edit/'. $npc['Npc']['id']) ."</td>";
	echo "<td>".
	$this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'title' => 'Delete npc', 'onclick' => 'return confirm(\'Delete?\')')), '/admin/npcs/delete/'. $npc['Npc']['id'], array('escape' => false))
	."</td>";
	echo "</tr>";
}
?>
<tfoot>
<tr><td colspan="3">
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add npc', true), '/admin/npcs/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>