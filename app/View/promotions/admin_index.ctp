<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Promotions</h1>
<table class="summary">
<tr>
<th class="center small"><?php echo $this->Paginator->sort('#', 'Promotion.id'); ?></th>
<th><?php echo $this->Paginator->sort('Title', 'Promotion.title'); ?></th>
<th class="small center"><?php echo $this->Paginator->sort('Visible', 'Promotion.show'); ?></th>
<th class="options"><?php __('Options'); ?></th>
</tr>
<?php
foreach($promotions as $promotion) {
	echo "<tr>";
	echo "<td class=\"center small\">". $this->Html->link($promotion['Promotion']['id'], '/admin/promotions/edit/'. $promotion['Promotion']['id']) ."</td>";
	echo "<td>". $this->Html->link($promotion['Promotion']['title'], '/admin/promotions/edit/'. $promotion['Promotion']['id']) ."</td>";
	echo "<td>". $this->Html->link($promotion['Promotion']['show'], '/admin/promotions/edit/'. $promotion['Promotion']['id']) ."</td>";
	echo "<td>".
	$this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'title' => 'Delete promotion', 'onclick' => 'return confirm(\'Delete promotion?\')')), '/admin/promotions/delete/'. $promotion['Promotion']['id'], array('escape' => false))
	."</td>";
	echo "</tr>";
}
?>
<tfoot>
<tr><td colspan="7">
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add promotion', true), '/admin/promotions/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>