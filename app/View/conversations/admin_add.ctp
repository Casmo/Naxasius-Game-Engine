<?php
/*
 * Created on Mar 9, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo $this->Form->create('Conversation', array('action' => 'admin_add')); ?>
<h1>Add conversation</h1>
<fieldset>
<legend>Npc detail</legend>
<?php
if(!empty($this->data['Npc']['image'])) {
	echo $this->Html->image('/img/game/npcs/'. $this->data['Npc']['image']);
	echo '<br />';
}
?>
<?php
echo $this->Form->input('Conversation.npc_id', array('onChange' => 'location.href=\''. $this->Html->url('/admin/conversations/add') .'/\' + this.value + \'\'', 'options' => $npcs, 'empty' => '', 'label' => false, 'div' => false));
?>
</fieldset>
<?php
if(isset($this->data['Conversation']['npc_id']) || !empty($this->data['Conversation']['npc'])) {
?>
<fieldset>
<legend>Conversation</legend>
<?php echo $this->Form->input('Conversation.parent_id', array('options' => $conversations, 'escape' => false, 'empty' => array(0 =>__('root')), 'label' => __('Parent'))); ?>
<?php echo $this->Form->input('Conversation.conversation_id', array('options' => $conversations, 'escape' => false, 'empty' => array(0 =>''), 'label' => __('Conversation needed for this question', true))); ?>
<?php echo $this->Form->input('Conversation.quest_id', array('options' => $quests,  'empty' => array(0 =>''), 'label' => __('Quest needed (finished) for this question'))); ?>
<?php echo $this->Form->input('Conversation.question', array('type' => 'textarea', 'class' => 'tinymce', 'label' => __('Question (Your response)'))); ?>
<?php echo $this->Form->input('Conversation.answer', array('type' => 'textarea', 'class' => 'tinymce', 'label' => __('Response (witch the NPC will tell)'))); ?>
<?php echo $this->Form->input('Conversation.conversation_goto', array('options' => $conversations, 'empty' => array(0 =>''), 'escape' => false)); ?>
</fieldset>
<fieldset>
<legend>Actions - quests</legend>
<p><?php echo __('If a user gives this question, the following action will be performed.'); ?></p>
<?php
$action_i = 0;
echo $this->Form->input('ActionsConversation.'. $action_i .'.check', array('type' => 'checkbox', 'value' => '1', 'label' => false, 'div' => false));
echo $this->Form->input('ActionsConversation.'. $action_i .'.type', array(
	'options' => array(
		'' => '',
		'getquest' => 'getquest',
		'completequest' => 'completequest'
	),
	'label' => false,
	'div' => false
));
echo $this->Form->input('ActionsConversation.'. $action_i .'.target_id', array('options' => $quests, 'div' => false, 'label' => false));
$action_i++;
?>
</fieldset>
<?php echo $this->Form->end('Save'); ?>
<?php
} // Check if an npc is set...
?>