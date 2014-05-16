<?php
/*
 * Created on Nov 7, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php echo $this->Html->link('Forum', '/forum'); ?> :: <?php echo $forum['Forum']['name']; ?></h1>
<p><?php echo $forum['Forum']['description']; ?></p>
<div class="forum_new_topic"><?php echo $this->Html->link(__('New topic', true), '/forum/topics/add/'. $forum['Forum']['id']); ?></div>
<div class="forum_topics_c">
<table width="100%" cellspacing="0" cellpadding="0" class="forum_topics">
<tr>
<th width="16">&nbsp;</th>
<th><?php __('Title'); ?></th>
<th width="40"><?php __('Replies'); ?></th>
<th width="75"><?php __('Author'); ?></th>
<th width="75"><?php __('Last reply'); ?></th>
</tr>
<?php
foreach($topics as $topic) {
	?>
	<tr>
	<td><?php echo $this->Html->image('/img/forum/topic.png'); ?></td>
	<td><?php echo $this->Html->link($topic['Topic']['title'], '/forum/topics/view/'. $topic['Topic']['id']); ?></td>
	<td class="replies"><?php echo count($topic['Reply']); ?></td>
	<td class="author"><?php echo $topic['FirstReply']['User']['username']; ?></td>
	<td class="author"><?php echo $topic['LastReply']['User']['username']; ?></td>
	</tr>
	<?php
}
?>
</table>
</div>
<div class="numbers"><?php echo $this->Paginator->numbers(); ?></div>
<script type="text/javascript">
$('div.forum_topics_c').borders();
</script>