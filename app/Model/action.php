<?php
/**
 * Action
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
class Action extends AppModel {
	var $name = 'Action';

	var $belongsTo = array('Quest' => array(
		'foreignKey' => 'Action.target_id',
		'conditions' => array(
			'Action.type' => array('getquest', 'completequest')
		)
	));

	var $actsAs = array('Containable');

	// After a player has talked, maybe some actions are required. Fill the db with those actions...
	// @TODO types
	// @TODO, REMOVE. See the models for the actions (e.g. Conversation model...)
	function perform($action_id = null, $character_id = null) {
		$someAction = $this->find('first', array('conditions' => array('Action.id' => $action_id)));
		if(!empty($someAction)) {
			switch($someAction['Action']['type']) {
				case "getquest":
				$this->Quest->bindModel(array('hasMany' => array('CharactersQuest')));
				$this->Quest->CharactersQuest->save(array('id' => null, 'quest_id' => $someAction['Action']['target_id'], 'character_id' => $character_id, 'completed' => 'no'));
				// Maybe this user has already the quest done, so try to update it...
				$this->Quest->update($someAction['Action']['target_id'], $character_id);
				break;
				case "completequest":
				$this->Quest->update($someAction['Action']['target_id'], $character_id, true);
				/*
				$this->Quest->bindModel(array('hasMany' => array('CharactersQuest')));
				$someCharactersQuest = $this->Quest->CharactersQuest->find('first', array('conditions' => array('CharactersQuest.quest_id' => $someAction['Action']['target_id'], 'CharactersQuest.character_id' => $character_id)));
				if(!empty($someCharactersQuest)) {
					$this->Quest->CharactersQuest->save(array('id' => $someCharactersQuest['CharactersQuest']['id'], 'completed' => 'finished'));
				}
				break;
				*/
			}
		}
		return true;
	}
}
?>