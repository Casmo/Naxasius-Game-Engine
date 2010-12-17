<?php
/*
 * Created on Mar 9, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo $form->create('Conversation', array('action' => 'admin_edit')); ?>
<h1><?php __('Edit conversation'); ?> #<?php echo $this->data['Conversation']['id']; ?></h1>
<fieldset>
<legend>Npc detail</legend>
<?php
if(!empty($this->data['Npc']['image'])) {
	echo $html->image('/img/game/npcs/'. $this->data['Npc']['image']);
	echo '<br />';
}
echo $this->data['Npc']['name'];
echo $form->input('Conversation.npc_id', array('type' => 'hidden'));
?>
</fieldset>

<fieldset>
<legend>Conversation</legend>
<?php echo $form->input('Conversation.id'); ?>
<?php echo $form->input('Conversation.parent_id', array('options' => $conversations, 'escape' => false, 'empty' => array(0 =>''), 'label' => __('Parent', true))); ?>
<?php echo $form->input('Conversation.conversation_id', array('options' => $conversations, 'escape' => false, 'empty' => array(0 =>''), 'label' => __('Conversation needed for this question', true))); ?>
<?php echo $form->input('Conversation.quest_id', array('options' => $quests, 'empty' => array(0 =>''), 'label' => __('Quest needed (finished) for this question', true))); ?>
<?php echo $form->input('Conversation.question', array('type' => 'textarea', 'class' => 'tinymce', 'label' => __('Question (Your response)', true))); ?>
<?php echo $form->input('Conversation.answer', array('type' => 'textarea', 'class' => 'tinymce', 'label' => __('Response (witch the NPC will tell)', true))); ?>
<?php echo $form->input('Conversation.conversation_goto', array('options' => $conversations, 'empty' => array(0 =>''), 'escape' => false)); ?>
</fieldset>
<fieldset>
<legend>Actions - quests</legend>
<p><?php __('If a user gives this question, the following action will be performed.'); ?></p>
<?php
$action_i = 0;
if(isset($this->data['Quest']) && !empty($this->data['Quest'])) {
	foreach($this->data['Quest'] as $quest) {
		echo $form->input('ActionsConversation.'. $action_i .'.check', array('type' => 'checkbox', 'value' => '1', 'checked' => 'checked', 'label' => false, 'div' => false));
		echo $form->input('ActionsConversation.'. $action_i .'.type', array(
			'options' => array(
				'' => '',
				'getquest' => 'getquest',
				'completequest' => 'completequest'
			),
			'label' => false,
			'div' => false,
			'value' => $quest['ActionsConversation']['type']
		));
		echo $form->input('ActionsConversation.'. $action_i .'.target_id', array('options' => $quests, 'value' => $quest['id'], 'div' => false, 'label' => false));
		$action_i++;
		echo '<br />';
		// echo '['. $quest['ActionsConversation']['type'] .'] '. $quest['name'] .'<br />';
	}
}
?>
<?php
echo $form->input('ActionsConversation.'. $action_i .'.check', array('type' => 'checkbox', 'value' => '1', 'label' => false, 'div' => false));
echo $form->input('ActionsConversation.'. $action_i .'.type', array(
	'options' => array(
		'' => '',
		'getquest' => 'getquest',
		'completequest' => 'completequest'
	),
	'label' => false,
	'div' => false
));
echo $form->input('ActionsConversation.'. $action_i .'.target_id', array('options' => $quests, 'div' => false, 'label' => false));
$action_i++;
?>
</fieldset>
<?php echo $form->end('Save'); ?>