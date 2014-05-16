<?php
/**
 * Converstions with NPCs
 *
 * Talking with NPCs through a Tree dialog
 *
 * Naxasius : a CakePHP powered Game Engine to create a MMORPG (http://www.naxasius.com)
 * Copyright 2009-2010, Fellicht (http://www.fellicht.nl)
 *
 * Licensed under Creative Commons 3.0
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright 2009-2010, Fellicht (http://www.fellicht.nl)
 * @link		http://www.naxasius.com Game Engine to create a Browser MMORPG
 * @author		Mathieu (mathieu@fellicht.nl)
 * @license		Creative Commons 3.0 (http://creativecommons.org/licenses/by/3.0/)
 */
class ConversationsController extends AppController {
	var $name = 'Conversations';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Conversation.question' => 'asc'),
		'contain' => array('Npc')
	);

/**
 * This function creates a nice tree list of conversations for a npc.
 *
 * Original idea is from: http://nwvault.ign.com/View.php?view=NWN2Articles.Detail&id=156#_Writing_Conversations
 *
 * @param int $npc_id the ID of the NPC
 */
	function admin_index($npc_id = null) {
		$this->Conversation->Npc->bindModel(
			array(
				'hasMany' => array(
					'Conversation' => array(
						'conditions' => array(
							'Conversation.parent_id' => 0
						)
					)
				)
			)
		);
		$this->Conversation->Npc->contain('Conversation');
		$Npcs = $this->Conversation->Npc->find('all');
		if(empty($Npcs)) {
			$this->redirect('/admin/npcs');
		}

		$rootConversations = array();
		$prefix = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		foreach($Npcs as $someNpc) {
			foreach($someNpc['Conversation'] as $Conversation) {
				$this->Conversation->contain(array('QuestNeeded', 'ConversationNeeded', 'Quest', 'Npc'));
				$currentConversation = $this->Conversation->find('first', array('conditions' => array('Conversation.id' => $Conversation['id'])));
				$currentConversation['tree_prefix'] = '';
				$this->Conversation->contain(array('QuestNeeded', 'ConversationNeeded', 'Quest'));
				$children = $this->Conversation->children($Conversation['id'], false, null, null, null, 1, 1, $prefix);
				$rootConversations[] = array_merge(array(0 => $currentConversation), $children);
			}
		}
		$this->set('prefix', $prefix);
		$this->set('rootConversations', $rootConversations);
	}

	function admin_add($npc_id = null) {
		if(isset($this->request->data['Conversation']) && !empty($this->request->data['Conversation'])) {
			if($this->Conversation->save($this->data)) {
				$this->redirect('/admin/conversations');
			}
		}
		if(isset($npc_id)) {
			$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
			$this->Conversation->Npc->unbindModelAll();
			$this->data = $this->Conversation->Npc->find('first', array('conditions' => array('Npc.id' => $npc_id)));
			$this->request->data['Conversation']['npc_id'] = $this->request->data['Npc']['id'];
			$this->set('conversations', $this->Conversation->generatetreelist(array('Conversation.npc_id' => $npc_id), null, '{n}.Conversation.question', '&nbsp;&nbsp;&nbsp;'));
			$this->set('quests', $this->Conversation->Quest->find('list'));
		}
		$this->set('npcs', $this->Conversation->Npc->find('list'));
	}

	function admin_edit($id = null) {
		if(isset($this->data) && !empty($this->data)) {
			foreach($this->request->data['ActionsConversation'] as $index => $ActionsConversation) {
				if($ActionsConversation['check'] != '1') {
					unset($this->request->data['ActionsConversation'][$index]);
				}
				else {
					$this->request->data['ActionsConversation'][$index]['conversation_id'] = $this->request->data['Conversation']['id'];
				}
			}
			$this->Conversation->save($this->data);
			$this->Conversation->ActionsConversation->deleteAll(array('conversation_id' => $this->request->data['Conversation']['id']));
			$this->Conversation->ActionsConversation->saveAll($this->request->data['ActionsConversation']);
			$this->redirect('/admin/conversations');
		}
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
		$this->Conversation->recursive = 1;
		$this->data = $this->Conversation->find(
			'first', array(
				'conditions' => array(
					'Conversation.id' => $id
				)
			)
		);
		$this->set('conversations', $this->Conversation->find('list', array('conditions' => array('Conversation.npc_id' => $this->request->data['Conversation']['npc_id']), 'fields' => array('Conversation.id', 'Conversation.question'))));

		// Targets
		$this->set('quests', $this->Conversation->Quest->find('list', array('fields' => array('Quest.id', 'Quest.name'))));
	}

	function admin_delete($id = null) {
		$this->Conversation->delete($id);
		$this->Conversation->ActionsConversation->deleteAll(array('conversation_id' => $id));
		$this->Conversation->bindModel(array('hasMany' => array('Log')));
		$this->Conversation->Log->deleteAll(array('conversation_id' => $id));
		$this->Conversation->bindModel(array('hasMany' => array('ConversationsQuest')));
		$this->Conversation->Log->deleteAll(array('conversation_id' => $id));
		$this->redirect('/admin/conversations');
	}
}
?>