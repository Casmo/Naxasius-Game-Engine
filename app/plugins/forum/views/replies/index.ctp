<?php
/*
 * Created on Nov 7, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php echo $this->Html->link('Forum', '/forum'); ?> :: <?php echo $this->Html->link($topic['Forum']['name'], '/forum/view/'. $topic['Forum']['id']); ?> :: <?php echo $topic['Topic']['title']; ?></h1>
<div class="replies">
<?php
foreach($replies as $reply) {
	?>
	<div class="reply">
		<p><b><?php echo $reply['User']['username']; ?>:</b><br />
		<?php echo $this->Ubb->output($reply['Reply']['message']); ?></p>
	</div>
<?php
}
?>
</div>
<div class="numbers"><?php echo $this->Paginator->numbers(); ?></div>
<?php
if(isset($userInfo['id']) && !$this->Paginator->hasNext()) {
?>
<h2>Reply</h2>
<?php echo $this->Form->create('Reply', array('action' => 'add')); ?>
<?php echo $this->Form->input('Reply.topic_id', array('type' => 'hidden', 'value' => $topic['Topic']['id'])); ?>
<?php echo $this->Form->input('Reply.message', array('type' => 'textarea')); ?>
<?php echo $this->Form->end('Add reply'); ?>
<?php
}
elseif(!isset($userInfo['id'])) {
	echo $this->Html->link('Login', '/users/login') .' or '. $this->Html->link('Register', '/users/register') .' to reply.';
}
?>
<script type="text/javascript">
$('div.reply').borders();
</script>