<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php __('Conversations'); ?></h1>
<table class="summary">
<tr>
<th class="small">#</th>
<th><?php __('Conversation'); ?></th>
<th class="medium"><?php __('Actions'); ?></th>
<th class="medium"><?php __('Conditions'); ?></th>
<th class="options"><?php __('Options'); ?></th>
</tr>
<?php
foreach($rootConversations as $conversations) {
	foreach($conversations as $index => $conversation) {
		if($index > 0) {
			$conversation['tree_prefix'] = $conversation['tree_prefix'] . $prefix;
		}
		preg_match_all('/'. $prefix .'/', $conversation['tree_prefix'], $matches);
		$prefix_padding = count($matches[0]) * 20;
		echo '<tr>';
		echo '<td>'. $conversation['Conversation']['id'] .'</td>';
		echo '<td style="padding-left: '. $prefix_padding .'px;" id="conversation_'. $conversation['Conversation']['id'] .'">';
		if($index == 0) {
			echo '<b>&lt;root&gt; '. $conversation['Npc']['name'] .'</b><br />';
		}
		else {
			echo '<span class="question">'. strip_tags($conversation['Conversation']['question']) .'</span><br />';
		}
		echo '<span class="answer">'. strip_tags($conversation['Conversation']['answer']) .'</span>'.
		'</td>';
		echo '<td>';
		foreach($conversation['Quest'] as $Quest) {
			echo '&lt;'. $Quest['ActionsConversation']['type'] .'&gt; "'. $this->Html->link($Quest['name'], '/admin/quests/edit/'. $Quest['id']) .'"<br />';
		}
		if($conversation['Conversation']['conversation_goto'] != 0) {
			echo '&lt;Goto Conversation&gt; <span onmouseover="showConversation('. $conversation['Conversation']['conversation_goto'] .');" onmouseout="hideConversation('. $conversation['Conversation']['conversation_goto'] .');">#'. $conversation['Conversation']['conversation_goto'] .'</span>';
		}
		echo '</td>';
		echo '<td>';
		if(isset($conversation['QuestNeeded']['id']) && !empty($conversation['QuestNeeded']['id'])) {
			echo '&lt;'. __('Quest', true) .'&gt; "'. $this->Html->link($conversation['QuestNeeded']['name'], '/admin/quests/edit/'. $conversation['QuestNeeded']['id']) .'"<br />';
		}
		if(isset($conversation['ConversationNeeded']['id']) && !empty($conversation['ConversationNeeded']['id'])) {
			echo '&lt;'. __('Conversation', true) .'&gt; <span onmouseover="showConversation('. $conversation['ConversationNeeded']['id'] .');" onmouseout="hideConversation('. $conversation['ConversationNeeded']['id'] .');">#'. $conversation['ConversationNeeded']['id'] .'</span>';
		}
		echo '</td>';
		echo "<td>".
		$this->Html->link($this->Html->image('/img/admin/icons/small/pencil.png', array('alt' => 'edit', 'title' => 'Edit conversations')), '/admin/conversations/edit/'. $conversation['Conversation']['id'], array('escape' => false)) .
		'&nbsp;'.
		$this->Html->link($this->Html->image('/img/admin/icons/small/minus-button.png', array('alt' => 'delete', 'title' => 'Delete conversations', 'onclick' => 'return confirm(\'Delete all conversations?\')')), '/admin/conversations/delete/'. $conversation['Conversation']['id'], array('escape' => false)) .
		"</td>";
		echo '</tr>';
	}
}
?>
<tfoot>
<tr><td colspan="5">
<?php echo $html->link($html->image('/img/admin/icons/small/plus-button.png', array('alt' => 'add', 'class' => 'icon')). ' '. __('Add conversation', true), '/admin/conversations/add', array('escape' => false)); ?>
</td></tr>
</tfoot>
</table>
<script type="text/javascript">
function showConversation(conversation_id) {
	$('td#conversation_' + conversation_id).css('backgroundColor', '#c7ffb1');
}
function hideConversation(conversation_id) {
	$('td#conversation_' + conversation_id).css('backgroundColor', 'transparent');
}
</script>