<?php
/**
 * Chat system
 *
 * Chatting and logging system for the game.
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
class ChatsController extends AppController {
	var $name = 'Chats';

	// List the last messages of the character last logged in date
	function game_index($type = 'general') {
		$conditions = array();
		$conditions['and']['Chat.character_id_from'] = array(0, $this->characterInfo['id']);
		$conditions['and']['Chat.character_id_to'] = array(0, $this->characterInfo['id']);
		switch($type) {
			case 'trade':
			$conditions['Chat.type'] = array('system','trade', 'private');
			break;
			case 'combat':
			$conditions['Chat.type'] = array('system','combat', 'private');
			break;
			case 'map':
			$conditions['Chat.type'] = array('system','map', 'private');
			break;
			case 'private':
			$conditions['Chat.type'] = array('system', 'private');
			$conditions['Chat.character_id_to'] = $this->characterInfo['id'];
			break;
			default:
			$conditions['Chat.type'] = array('system', 'general', 'private');
			$type = 'general';
			break;
		}
		$last_id = $this->Session->read('Chat.last_id');
		if(!isset($last_id) || empty($last_id)) {
			$conditions['Chat.created >='] = $this->characterInfo['loggedin'];
		}
		else {
			$conditions['Chat.id >'] = $last_id;
		}
		$this->Chat->CharacterFrom->unbindModelAll();
		$this->Chat->CharacterTo->unbindModelAll();
		$chats = $this->Chat->find('all', array('conditions' => $conditions, 'order' => array('Chat.created DESC', 'Chat.id DESC'), 'limit' => '50'));
		if(isset($chats[0]['Chat']['id'])) {
			$this->Session->write('Chat.last_id', $chats[0]['Chat']['id']);
		}
		$chats = array_reverse($chats);
		$updateChats = array();
		$messages = array(); // Messaged to display on top of the map
		foreach($chats as $chat) {
			if($chat['Chat']['display'] == 'yes') {
				$chat['Chat']['display'] = 'no';
				$updateChats[] = $chat['Chat'];
				$messages[] = $chat['Chat']['message'];
			}
		}
		if(!empty($updateChats)) {
			$this->Chat->saveAll($updateChats);
		}
		$this->set('chats', $chats);
		$this->set('messages', $messages);
		$this->set('type', $type);
	}

	function game_talk($type = null) {
		$this->render(false);
		if(isset($this->data['Chat']['message']) && !empty($this->data['Chat']['message'])) {
			$message = $this->data['Chat']['message'];
			$message = str_replace('code.dot', '.', $message);
			$message = str_replace('code.question', '?', $message);
			$message = str_replace('code.colon', ':', $message);
			$message = str_replace('code.slash', '/', $message);
			if($type == 'general' || $type == 'trade' || $type == 'map' || $type == 'private') {
				$ChatData = array();
				$ChatData['type'] = $type;
				$ChatData['character_id_to'] = 0;
				// Kijken of deze character bestaat
				if(eregi('^(@([a-z0-9]+))(.*)?', $message, $parts)) {
					$name = $parts[2];
					App::import('Model', 'Character');
					$Character = new Character();
					$someCharacter = $Character->find('first', array('conditions' => array('Character.name' => $name)));
					if(!empty($someCharacter)) {
						$ChatData['character_id_to'] = $someCharacter['Character']['id'];
						$message = eregi_replace('^(@([a-z0-9]+))', '', $message);
						$ChatData['type'] = 'private';
					}
					else {
						$message = __('Nobody could hear you...', true);
						$ChatData['type'] = 'private';
						$ChatData['character_id_to'] = $this->characterInfo['id'];
					}
				}
				$ChatData['id'] = null;
				$ChatData['character_id_from'] = $this->characterInfo['id'];
				$ChatData['message'] = urldecode($message);
				$ChatData['display'] = 'no';
				$this->Chat->save($ChatData);
			}
		}
	}
}
?>