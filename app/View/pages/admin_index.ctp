<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1>Pages</h1>
<table class="summary">
<tr>
<th class="center small"><?php echo $this->Paginator->sort('#', 'Pages.id'); ?></th>
<th class="medium"><?php echo $this->Paginator->sort('Name', 'Page.name'); ?></th>
<th><?php echo $this->Paginator->sort('Title', 'Page.title'); ?></th>
<th class="center small"><?php echo $this->Paginator->sort('Order', 'Page.order'); ?></th>
<th class="options"><?php __('Options'); ?></th>
</tr>
<?php
foreach($pages as $page) {
	echo "<tr>";
	echo "<td class=\"center\">". $this->Html->link($page['Page']['id'], '/admin/pages/edit/'. $page['Page']['id']) ."</td>";
	echo "<td>". $this->Html->link($page['Page']['name'], '/admin/pages/edit/'. $page['Page']['id']) ."</td>";
	echo "<td>". $this->Html->link($page['Page']['title'], '/admin/pages/edit/'. $page['Page']['id']) ."</td>";
	echo "<td class=\"center\">". $page['Page']['order'] ."</td>";
	echo "<td>".
	$this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'title' => 'Delete page', 'onclick' => 'return confirm(\'Delete page?\')')), '/admin/pages/delete/'. $page['Page']['id'], array('escape' => false))
	."</td>";
	echo "</tr>";
}
?>
<tfoot>
<tr><td colspan="7">
<?php echo $this->Html->link($this->Html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add news', true), '/admin/pages/add', array('escape' => false)); ?>
<div class="summary_pages"><?php echo $this->Paginator->counter(array('format' => 'Displaying %start% to %end% of %count% items')); ?></div>
<div class="pages"><?php echo $this->Paginator->numbers(); ?></div>
</td></tr>
</tfoot>
</table>