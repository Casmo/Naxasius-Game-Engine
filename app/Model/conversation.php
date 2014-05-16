<?php
/**
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
class Conversation extends AppModel {
	var $name = 'Conversation';

	var $actsAs = array('Tree', 'Containable');

	var $belongsTo = array(
		'Npc',
		'QuestNeeded' => array(
			'className' => 'Quest',
			'foreignKey' => 'quest_id'
		),
		'ConversationNeeded' => array(
			'className' => 'Conversation',
			'foreignKey' => 'conversation_id'
		)
	);

	var $hasMany = array('Log');

	// @TODO, hasAndBelongsToMany stats, items, etc
	var $hasAndBelongsToMany = array(
		'Quest' => array(
			'joinTable' => 'actions_conversations',
			'foreignKey' => 'conversation_id',
			'associationForeignKey' => 'target_id',
			'conditions' => array(
				'ActionsConversation.type' => array('getquest','completequest')
			)
		)
	);

	var $actionHappen = false;

	/**
	 * Talk to an NPC (if possible)
	 * @return boolean
	 */
	function talk($npc_id = null, $conversation_id = null, $character_id = null) {
		if(!isset($conversation_id) || empty($conversation_id) || !isset($npc_id) || empty($npc_id) || !isset($character_id) || empty($character_id)) {
			return false;
		}
		// Laatste conversatie opvragen
		$this->contain('Log');
		$this->Log->contain('Conversation');
		$last_log = $this->Log->find('first', array('conditions' => array('Log.npc_id' => $npc_id, 'Log.character_id' => $character_id), 'order' => 'Log.created DESC'));
		if(!empty($last_log)) {
			// Get the conversation
			$conditions = array();
			if($last_log['Conversation']['conversation_goto'] != 0) {
				$conditions['Conversation.parent_id'] = $last_log['Conversation']['conversation_goto'];
			}
			else {
				$conditions['Conversation.parent_id'] = $last_log['Conversation']['id'];
			}
			$available_conversations = $this->find('all', array('conditions' => $conditions));

			// In het geval dat er we naar een conversation moeten gaan, pakken we daar ook de laat gesproken antwoord van
			if($last_log['Conversation']['conversation_goto'] != 0) {
				$last_log = $this->find('first', array('conditions' => array('Conversation.id' => $last_log['Conversation']['conversation_goto'])));
			}

			// Kijken of we mogen praten
			// @TODO kijken of we de betreffende stats en quest hebben...
			$someConversation = $this->find('first', array('conditions' => array('Conversation.id' => $conversation_id, 'Conversation.parent_id' => $last_log['Conversation']['id'])));
			if(empty($someConversation)) {
				return false;
			}
			else {
				// Opslaan
				$this->data['Log']['conversation_id'] = $conversation_id;
				$this->data['Log']['character_id'] = $character_id;
				$this->data['Log']['npc_id'] = $npc_id;
				if($this->Log->save($this->data['Log'])) {
					$this->doActions($conversation_id, $character_id);
					return true;
				}
				else {
					return false;
				}
			}
		}
		else {
			$last_log = $this->find('first', array('conditions' => array('Conversation.npc_id' => $npc_id, 'Conversation.parent_id' => '0')));
			// Kijken of we mogen praten
			$someConversation = $this->find('first', array('conditions' => array('Conversation.id' => $conversation_id, 'Conversation.parent_id' => $last_log['Conversation']['id'])));
			if(empty($someConversation)) {
				return false;
			}
			else {
				// Opslaan
				$this->data['Log']['conversation_id'] = $conversation_id;
				$this->data['Log']['character_id'] = $character_id;
				$this->data['Log']['npc_id'] = $npc_id;
				if($this->Log->save($this->data)) {
					$this->doActions($conversation_id, $character_id);
					return true;
				}
				else {
					return false;
				}
			}
		}
	}

	/**
	 * Get the avaible options of npc/character conversation
	 * @return array
	 */
	function getOptions($npc_id = null, $character_id = null) {
		if(!isset($npc_id) || empty($npc_id) || !isset($character_id) || empty($character_id)) {
			return array();
		}
		$this->bindModel(array('hasMany' => array('Log')));
		$this->Log->bindModel(array('belongsTo' => array('Conversation')));
		$last_log = $this->Log->find('first', array('conditions' => array('Log.npc_id' => $npc_id, 'Log.character_id' => $character_id), 'order' => 'Log.created DESC'));
		if(!empty($last_log)) {
			// Get the conversation
			$conditions = array();
			if($last_log['Conversation']['conversation_goto'] != 0) {
				$conditions['Conversation.parent_id'] = $last_log['Conversation']['conversation_goto'];
			}
			else {
				$conditions['Conversation.parent_id'] = $last_log['Conversation']['id'];
			}

			$this->unbindModel(array('hasMany' => array('Log')));
			$available_conversations = $this->find('all', array('conditions' => $conditions));

			// In het geval dat er we naar een conversation moeten gaan, pakken we daar ook de laat gesproken antwoord van
			if($last_log['Conversation']['conversation_goto'] != 0) {
				$this->unbindModel(array('hasMany' => array('Log')));
				$last_log = $this->find('first', array('conditions' => array('Conversation.id' => $last_log['Conversation']['conversation_goto'])));
			}
		}
		else {
			$this->unbindModel(array('hasMany' => array('Log')));
			$last_log = $this->find('first', array('conditions' => array('Conversation.npc_id' => $npc_id, 'Conversation.parent_id' => '0')));
			$this->unbindModel(array('hasMany' => array('Log')));
			$available_conversations = $this->find('all', array('conditions' => array('Conversation.parent_id' => $last_log['Conversation']['id'])));
		}
		// Voor sommige quests moeten bepaalde quest behaald zijn (of mee bezig zijn). Kijken of dat bij deze quests het geval is...
		App::import('Model', 'ConversationsQuest');
		$ConversationsQuest = new ConversationsQuest();
		App::import('Model', 'CharactersQuest');
		$CharactersQuest = new CharactersQuest();

/*
		$ConversationsQuest->bindModel(array('hasOne' =>
			array(
				'CharactersQuest' => array(
					#'foreignKey' => false,
					#'foreignKey' => 'ConversationsQuest.quest_id = CharactersQuest.quest_id',
					'conditions' => array(
						'CharactersQuest.character_id' => $character_id
					)
				)
			)
		));
*/
		$conversations_ids = array();
		foreach($available_conversations as $index => $conversation) {
			if($conversation['Conversation']['quest_id'] != '0') {
				// Er moet een quest zijn voor deze conversation
				$someQuest = $CharactersQuest->find('first', array('conditions' => array(
						'CharactersQuest.quest_id' => $conversation['Conversation']['quest_id'],
						'CharactersQuest.character_id' => $character_id,
						'CharactersQuest.completed' => 'finished'
					)
				));
				if(empty($someQuest)) {
					unset($available_conversations[$index]);
				}
			}
			// Let op! Dit zijn acties...
			if(!empty($conversation['Quest'])) {
				// Kijken of er een quest completed moet zijn...
				foreach($conversation['Quest'] as $ActionsQuest) {
					// @TODO. Check it in Quest->canView()
					if($ActionsQuest['ActionsConversation']['type'] == 'completequest') {
						// Dan moet deze quest ook wel klaar zijn om in te leveren zijn...
						$someQuest = $CharactersQuest->find('first', array('conditions' => array(
								'CharactersQuest.quest_id' => $ActionsQuest['ActionsConversation']['target_id'],
								'CharactersQuest.character_id' => $character_id,
								'CharactersQuest.completed' => 'yes'
							)
						));
						if(empty($someQuest) && isset($available_conversations[$index])) {
							unset($available_conversations[$index]);
						}
					}
					elseif($ActionsQuest['ActionsConversation']['type'] == 'getquest') {
						// Ervoor zorgen dat je niet 2x dezelfde quest kan krijgen...
						// Dan moet deze quest ook wel klaar zijn om in te leveren zijn...
						// @TODO kijken of je hier niet een quest hebt wat 'repeatable' is...
						$someQuest = $CharactersQuest->find('first', array('conditions' => array(
								'CharactersQuest.quest_id' => $ActionsQuest['ActionsConversation']['target_id'],
								'CharactersQuest.character_id' => $character_id
							)
						));
						if(!empty($someQuest) && isset($available_conversations[$index])) {
							unset($available_conversations[$index]);
						}
					}
				}
			}
			if(isset($available_conversations[$index])) {
				$conversations_ids[$conversation['Conversation']['id']] = $conversation['Conversation']['id'];
			}
		}

		$ConversationsQuests = $ConversationsQuest->find('all', array('conditions' => array('ConversationsQuest.conversation_id' => $conversations_ids)));
		foreach($ConversationsQuests as $ConversationsQuest) {
			// Controleren of de character deze conversation wel mag zien...
			// Compleet en moet deze compleet zijn?
			// De bijhorende quest opvragen...
			$CharactersQuestData = $CharactersQuest->find('first', array(
				'conditions' => array(
					'CharactersQuest.quest_id' => $ConversationsQuest['ConversationsQuest']['quest_id'],
					'CharactersQuest.character_id' => $character_id
				)
			));
			if($ConversationsQuest['ConversationsQuest']['completed'] == 'yes') {
				// De conversation mag alleen zichtbaar zijn als de gebruiker deze ook compleet heeft.
				if($CharactersQuestData['CharactersQuest']['completed'] != 'yes') {
					unset($conversations_ids[$ConversationsQuest['ConversationsQuest']['conversation_id']]);
				}
			}
			elseif($ConversationsQuest['ConversationsQuest']['completed'] == 'no') {
				// De conversation mag alleen zichtbaar zijn als de gebruiker deze niet compleet heeft.
				if($CharactersQuestData['CharactersQuest']['completed'] != 'no') {
					unset($conversations_ids[$ConversationsQuest['ConversationsQuest']['conversation_id']]);
				}
			}
			elseif($ConversationsQuest['ConversationsQuest']['completed'] == 'finished') {
				// De conversation mag alleen zichtbaar zijn als de gebruiker deze niet compleet heeft.
				if($CharactersQuestData['CharactersQuest']['completed'] != 'finished') {
					unset($conversations_ids[$ConversationsQuest['ConversationsQuest']['conversation_id']]);
				}
			}
			// Het kan ook zijn dat deze optie niet beschikbaar mag zijn als hij bezig is met deze quest. In dit geval is het yes OR no
			elseif($ConversationsQuest['ConversationsQuest']['completed'] == 'all') {
				// De conversation mag alleen zichtbaar zijn als de gebruiker deze niet compleet heeft.
				if($CharactersQuestData['CharactersQuest']['completed'] != '') { // Bij geen resultaat is de gebruiker niet aan deze quest bezig
					unset($conversations_ids[$ConversationsQuest['ConversationsQuest']['conversation_id']]);
				}
			}
		}
		if(!empty($conversations_ids)) {
			$available = $this->find('all', array('conditions' => array('Conversation.id' => $conversations_ids)));
		}
		else {
			$available = array();
		}
		return array('available' => $available, 'last_log' => $last_log);
	}

	// After a player has talked, we may have to perform some actions...
	// We do that here.
	// @param $conversation_id int the last talked conversation
	function doActions($conversation_id = null, $character_id = null) {

		$conversation = $this->find('first', array('conditions' => array('Conversation.id'=> $conversation_id)));
		if(!empty($conversation['Quest'])) {
			App::import('Model','Chat');
			$Chat = new Chat();
			foreach($conversation['Quest'] as $quest) {
				switch($quest['ActionsConversation']['type']) {
					case "getquest":
					$this->Quest->bindModel(array('hasMany' => array('CharactersQuest')));
					$this->Quest->CharactersQuest->save(array('id' => null, 'quest_id' => $quest['id'], 'character_id' => $character_id, 'completed' => 'no'));
					// Maybe this user has already the quest done, so try to update it...
					$this->Quest->update($quest['id'], $character_id);
					$ChatData = array();
					$ChatData['id'] = null;
					$ChatData['type'] = 'system';
					$ChatData['character_id_from'] = 0;
					$ChatData['character_id_to'] = $character_id;
					$ChatData['message'] = sprintf(__('Quest %s accepted.', true), '[quest]'. $quest['name'] .'[/quest]');
					$ChatData['display'] = 'yes';
					$Chat->create();
					$Chat->save($ChatData);
					$this->actionHappen = true;
					break;
					case "completequest":
					$this->Quest->update($quest['id'], $character_id, true);
					$ChatData['id'] = null;
					$ChatData['type'] = 'system';
					$ChatData['character_id_from'] = 0;
					$ChatData['character_id_to'] = $character_id;
					$ChatData['message'] = sprintf(__('Quest %s completed.', true), '[quest]'. $quest['name'] .'[/quest]');
					$ChatData['display'] = 'yes';
					$Chat->create();
					$Chat->save($ChatData);
					$this->actionHappen = true;
					break;
				}
			}
		}
		/*
		$this->bindModel(array('hasMany' => array('ActionsConversation')));
		$someActions = $this->ActionsConversation->find('all', array('conditions' => array('ActionsConversation.conversation_id' => $conversation_id)));
		if(!empty($someActions)) {
			App::import('Model', 'Action');
			$Action = new Action();
			foreach($someActions as $action) {
				$Action->perform($action['ActionsConversation']['action_id'], $character_id);
			}
		}
		*/
	}
}
?>