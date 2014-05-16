<?php
/**
 * Quests
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
class QuestsController extends AppController {
	var $name = 'Quests';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Quest.name' => 'asc')
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('view');
	}

	function view($name = null) {
		$name = str_replace('[', '', $name);
		$name = str_replace(']', '', $name);
		$this->Quest->contain(array('Item', 'Mob'));
		$someQuest = $this->Quest->find('first', array('conditions' => array('Quest.name' => $name)));
		if(empty($someQuest)) {
			$this->render('/pages/view/notfound');
		}
		else {
			// Nieuwe array maken met needed/required (for layout)
			$someQuest['Rewards'] = array();
			$someQuest['RequirementsItem'] = array();
			$someQuest['RequirementsMob'] = array();
			foreach($someQuest['Item'] as $Item) {
				if($Item['ItemsQuest']['type'] == 'needed') {
					$someQuest['RequirementsItem'][] = $Item;
				}
				else {
					$someQuest['Rewards'][] = $Item;
				}
			}
			foreach($someQuest['Mob'] as $Mob) {
				$someQuest['RequirementsMob'][] = $Mob;
			}
			$this->set('quest', $someQuest);
		}
	}

	function game_index($type = 'active') {
		if($type == 'active') {
			$this->Quest->bindModel(array('hasOne' => array('CharactersQuest' => array('conditions' => array('CharactersQuest.character_id' => $this->Session->read('Game.Character.id'))))));
			$quests = $this->Quest->find('all', array('conditions' => array('CharactersQuest.completed' => array('yes','no'))));
		}
		else {
			$this->Quest->bindModel(array('hasOne' => array('CharactersQuest' => array('conditions' => array('CharactersQuest.character_id' => $this->Session->read('Game.Character.id'))))));
			$quests = $this->Quest->find('all', array('conditions' => array('CharactersQuest.completed' => 'finished'), 'order' => 'CharactersQuest.modified DESC'));
		}
		$this->set('type', $type);
		$this->set('quests', $quests);
	}

	function game_view($id = null) {

		// Alleen quests laten zien die deze gebruiker in zijn/haar log heeft...
		$this->Quest->bindModel(array('hasOne' => array('CharactersQuest' => array('conditions' => array('CharactersQuest.character_id' => $this->Session->read('Game.Character.id'))))));
		$someQuest = $this->Quest->find('first', array('conditions' => array('Quest.id' => $id)));
		if(empty($someQuest)) {
			$this->redirect('/game/quests');
		}
		else {
			// Nieuwe array maken met needed/required (for layout)
			$someQuest['Rewards'] = array();
			$someQuest['RequirementsItem'] = array();
			$someQuest['RequirementsMob'] = array();
			foreach($someQuest['Item'] as $Item) {
				if($Item['ItemsQuest']['type'] == 'needed') {
					$someQuest['RequirementsItem'][] = $Item;
				}
				else {
					$someQuest['Rewards'][] = $Item;
				}
			}
			foreach($someQuest['Mob'] as $Mob) {
				$someQuest['RequirementsMob'][] = $Mob;
			}
			$this->set('quest', $someQuest);
		}
	}

	/*
	 * @description Verwijderne van een quest van een bepaalde user...
	 * @param $id (int) id of the quest
	 */
	function game_abandon($id = null) {
		App::import('Model', 'CharactersQuest');
		$CharactersQuest = new CharactersQuest();
		$CharactersQuest->deleteAll(array('quest_id' => $id, 'character_id' => $this->Session->read('Game.Character.id'), 'completed' => array('yes','no')));
		$this->redirect('/game/quests');
	}

	// This will display the action frame with the quest
	function game_action($quest_id = null, $type='completequest') {
		if($this->Quest->canView($this->Session->read('Game.Character.id'), $quest_id, $type)) {
			$quest = $this->Quest->find('first', array('conditions' => array('Quest.id' => $quest_id)));
			$this->set('quest', $quest);
			$this->set('type', $type);
		}
		else {
			$this->render('/pages/view/notfound');
		}
	}

	function game_do_action($quest_id = null, $type='completequest') {
		$this->render(false);
		if($this->Quest->canView($this->Session->read('Game.Character.id'), $quest_id, $type)) {
			switch($type) {
				case "getquest":
				$this->Quest->bindModel(array('hasMany' => array('CharactersQuest')));
				$this->Quest->CharactersQuest->save(array('id' => null, 'quest_id' => $quest_id, 'character_id' => $this->Session->read('Game.Character.id'), 'completed' => 'no'));
				// Maybe this user has already the quest done, so try to update it...
				$this->Quest->update($quest_id, $this->Session->read('Game.Character.id'));
				break;
				case "completequest":
				$this->Quest->update($quest_id, $this->Session->read('Game.Character.id'), true);
				break;
				default:
				echo '0';
				exit;
			}
			$this->updateGame(array('Character'));
			echo '1';
			exit;
		}
		else {
			echo '0';
			exit;
		}
	}

	function admin_index() {
		$quests = $this->paginate();
		$this->set('quests', $quests);
	}

	function admin_add() {
		if(isset($this->data) && !empty($this->data)) {
			if($this->Quest->save($this->data)) {
				$this->redirect('/admin/quests');
			}
		}
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
	}

	function admin_edit($id = null) {
		if(isset($this->data) && !empty($this->data)) {
			if($this->Quest->save($this->data)) {
				foreach($this->request->data['ItemsQuest'] as $index => $ItemsQuest) {
					if($ItemsQuest['check'] != 1) {
						unset($this->request->data['ItemsQuest'][$index]);
					}
					else {
						$this->request->data['ItemsQuest'][$index]['quest_id'] = $id;
					}
				}
				$this->Quest->ItemsQuest->deleteAll(array('quest_id' => $id));
				$this->Quest->ItemsQuest->saveAll($this->request->data['ItemsQuest']);

				foreach($this->request->data['QuestsStat'] as $index => $QuestsStat) {
					if($QuestsStat['check'] != 1) {
						unset($this->request->data['QuestsStat'][$index]);
					}
					else {
						$this->request->data['QuestsStat'][$index]['quest_id'] = $id;
					}
				}
				$this->Quest->QuestsStat->deleteAll(array('quest_id' => $id));
				$this->Quest->QuestsStat->saveAll($this->request->data['QuestsStat']);

				foreach($this->request->data['MobsQuest'] as $index => $MobsQuest) {
					if($MobsQuest['check'] != 1) {
						unset($this->request->data['MobsQuest'][$index]);
					}
					else {
						$this->request->data['MobsQuest'][$index]['quest_id'] = $id;
					}
				}
				$this->Quest->MobsQuest->deleteAll(array('quest_id' => $id));
				$this->Quest->MobsQuest->saveAll($this->request->data['MobsQuest']);
				$this->redirect('/admin/quests');
			}
		}
		else {
			$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
			$this->data = $this->Quest->find('first', array('conditions' => array('Quest.id' => $id)));
			$this->set('items', $this->Quest->Item->find('list'));
			$this->set('mobs', $this->Quest->Mob->find('list'));
			$this->set('stats', $this->Quest->Stat->find('list'));
		}
	}

	function admin_delete($id = null) {
		$this->Quest->bindModel(array('hasMany' => array('ConversationsQuest', 'CharactersQuest')));
		$this->Quest->delete($id);
		$this->Quest->ConversationsQuest->deleteAll(array('quest_id' => $id));
		$this->Quest->CharactersQuest->deleteAll(array('quest_id' => $id));
		$this->Quest->ItemsQuest->deleteAll(array('quest_id' => $id));
		$this->redirect('/admin/quests');
	}

}
?>