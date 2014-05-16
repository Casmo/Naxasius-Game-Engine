<?php
/**
 * Character Controller
 *
 * Creating, deleting, list and play a Character.
 * @todo A lot
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
class CharactersController extends AppController {
	var $name = 'Characters';

	var $helpers = array('Form');

	var $paginate = array(
		'limit' => 20,
		'order' => array('User.username' => 'asc'),
		'contain' => array('User', 'Type')
	);

	function beforeFilter() {
		parent::beforeFilter();
		if($this->Auth->user('role') == 'player' && $this->Auth->user('activation_code') == '') {
			$this->Auth->allow('index', 'add', 'play', 'view');
		}
	}

	function index() {
		$conditions = array('Character.user_id' => $this->Auth->user('id'));
		$this->Character->contain('Type', 'Avatar', 'Stat');
		$characters = $this->Character->find('all', array('conditions' => $conditions));
		foreach($characters as $index => $character) {
			$characters[$index]['Stat'] = $this->Character->makeStats($characters[$index]['Stat']);
		}

		$pages = $this->Interface->getWebsiteMenus();

		$this->crumbs[] = array('name' => __('Characters', true), 'link' => '/characters');

		$this->styles[] = 'character.css';
		$this->title_for_layout = 'Naxasius: Select character';

		$this->set('characters', $characters);
		$this->set('pages', $pages);
	}

	function game_stats() {
		$this->updateGame(array('Character', 'Stat'));
		$this->set('stats', $this->Session->read('Game.Stat'));
	}

	function add() {
		if(isset($this->data) && !empty($this->data)) {
			$this->request->data['Character']['user_id'] = $this->Auth->user('id');
			$this->request->data['Character']['area_id'] = '74';
			if($this->Character->save($this->data)) {
				// Save a default bag for this character
				App::import('Model', 'Bag');
				$Bag = new Bag();
				$Bag->save(array('Bag' => array('item_id' => '421', 'character_id' => $this->Character->id, 'index' => '1')));

				// Stats @
				App::import('Model', 'CharactersStat');
				$CharactersStat = new CharactersStat();
				$basicStats = array();
				$basisStats[] = array('character_id' => $this->Character->id, 'stat_id' => '1', 'amount' => '80'); // Health
				$basisStats[] = array('character_id' => $this->Character->id, 'stat_id' => '2', 'amount' => '100'); // Mana
				$basisStats[] = array('character_id' => $this->Character->id, 'stat_id' => '5', 'amount' => '1'); // Min damage
				$basisStats[] = array('character_id' => $this->Character->id, 'stat_id' => '6', 'amount' => '3'); // Max damage
				$basisStats[] = array('character_id' => $this->Character->id, 'stat_id' => '8', 'amount' => '0'); // Experience
				$basisStats[] = array('character_id' => $this->Character->id, 'stat_id' => '9', 'amount' => '5000'); // Charisma
				$CharactersStat->saveAll($basisStats);

				$this->redirect('/characters');
			}
		}

		$this->crumbs[] = array('name' => __('Characters', true), 'link' => '/characters');
		$this->crumbs[] = array('name' => __('Create', true), 'link' => '/characters/add');

		$pages = $this->Interface->getWebsiteMenus();
		$this->Character->contain('Type', 'Avatar');
		$types = $this->Character->Type->find('list');
		$avatars = $this->Character->Avatar->find('all');

		$this->title_for_layout = 'Naxasius: Create character';

		$this->set('types', $types);
		$this->set('avatars', $avatars);
		$this->set('pages', $pages);
	}

	/**
	 * This function allows a player to play one of it's characters.
	 * we put this information in the session so we know on every request wich character is active.
	 * There can be only one character active at the same time.
	 */
	function play($id = null) {
		if(!isset($id) || empty($id)) {
			$this->redirect('/characters');
		} else {
			$conditions = array(
				'Character.user_id' => $this->userInfo['id'],
				'Character.id' => $id
			);
			/* Those basic information is needed in the layout */
			$this->Character->contain();
			$character = $this->Character->find('first', array('conditions' => $conditions));
			if(!empty($character)) {
				// Put it in the session
				$character['Character']['loggedin'] = date('Y-m-d H:i:s');
				$this->Character->save($character['Character']);
				$this->Session->write('Game.Character', $character['Character']);
				$this->characterInfo = $character['Character'];
				$this->updateGame(array('Character', 'Type', 'Avatar', 'Stat', 'Map'));
				$this->redirect('/game');
			}
			else {
				$this->redirect('/characters');
			}
		}
	}

	// Functie die de laatste data van de database in de sessie zet...
	function update() {
		if(isset($this->characterInfo['Character']['id'])) {
			$conditions = array('Character.id' => $this->characterInfo['Character']['id']);

			App::import('Model', 'Character');
			$Character = new Character();

			$Character->recursive = 2;
			$Character->unbindModelAll();
			$Character->bindModel(array('belongsTo' => array('Area', 'Type', 'Avatar')));
			$Character->bindModel(array('hasAndBelongsToMany' => array('Stat')));
			$someCharacter = $Character->find('first', array('conditions' => $conditions));
			if(!empty($someCharacter)) {
				// Put it in the session
				$this->characterInfo = $someCharacter;
				$this->Session->write('character', $someCharacter);
			}
		}
	}

/**
 * Equip an item to a slot in your character view and returns 0 or 1 if succeed.
 *
 * @param int $item_id the ID of the item
 * @param string $equip the name of the slot (head,neck,leg,feet,etc);
 */
	function game_equip($item_id = null, $equip = null) {
		$this->render(false);
		// Item owned by user?
		$conditions['Inventory.character_id'] = $this->characterInfo['id'];
		$conditions['Inventory.item_id'] = $item_id;
		$conditions['Inventory.equiped'] = 'none';
		$this->Character->Inventory->contain(array('Item'));
		$currentItem = $this->Character->Inventory->find('first', array('conditions' => $conditions));
		if(empty($currentItem)) {
			echo '0';
			exit;
		}
		// @todo twohand...
		if($currentItem['Item']['slot'] == $equip || ($currentItem['Item']['slot'] == 'onehand' && ($equip == 'offhand' || $equip == 'mainhand'))) {
			// Controleren of er al een item in het slot zit, zo ja: vervangen
			$conditions = array();
			$conditions['Inventory.character_id'] = $this->characterInfo['id'];
			$conditions['Inventory.item_id'] = $item_id;
			$conditions['Inventory.equiped'] = $equip;
			$this->Character->Inventory->contain();
			$someItem = $this->Character->Inventory->find('first', array('conditions' => $conditions));
			if(!empty($someItem)) {
				$someItem['Inventory']['bag_id'] = $currentItem['Inventory']['bag_id'];
				$someItem['Inventory']['index'] = $currentItem['Inventory']['index'];
				$this->Character->Inventory->save($someItem);
			}
			$currentItem['Inventory']['bag_id'] = 0;
			$currentItem['Inventory']['index'] = 0;
			$currentItem['Inventory']['equiped'] = $equip;
			$this->Character->Inventory->save($currentItem);
			$this->updateGame(array('Stat', 'Character'));
			echo '1';
			exit;
		}
		echo '0';
		exit;
	}

	function game_view() {
		$this->Character->contain(array('Inventory' => array('Item')));
		$conditions['Inventory.character_id'] = $this->characterInfo['id'];
		$conditions['Inventory.equiped'] = 'none';
		$conditions['Item.slot <>'] = 'none';
		$available_items = $this->Character->Inventory->find('all', array('conditions' => array($conditions)));
		$this->set('equiped_items', $this->Character->Inventory->getEquipedItems($this->characterInfo['id']));
		$this->set('available_items', $available_items);
	}

	function admin_index() {
		$characters = $this->paginate();
		$this->set('characters', $characters);
	}

	function admin_edit($id = null) {
		if(isset($this->data) && !empty($this->data)) {
			$this->Character->save($this->data, array('validate' => false));
			$this->redirect('/admin/characters');
		}
		$this->Character->contain('Type');
		$this->data = $this->Character->find('first', array('conditions' => array('Character.id' => $id)));
		$this->set('types', $this->Character->Type->find('list'));
	}

	function admin_delete($id = null) {
		$someCharacter = $this->Character->find('first',
			array('conditions' => array('Character.id' => $id))
		);
		if(!empty($someCharacter)) {
			$this->loadModel('Bag');
			$this->loadModel('CharactersQuest');
			$this->loadModel('CharactersStat');
			$this->loadModel('Chat');
			$this->loadModel('Drop');
			$this->loadModel('Inventory');
			$this->loadModel('Item');
			$this->loadModel('Log');

			$this->Bag->deleteAll(array('Bag.character_id' => $someCharacter['Character']['id']));
			$this->CharactersQuest->deleteAll(array('CharactersQuest.character_id' => $someCharacter['Character']['id']));
			$this->CharactersStat->deleteAll(array('CharactersStat.character_id' => $someCharacter['Character']['id']));
			$this->Chat->deleteAll(array('Chat.character_id_from' => $someCharacter['Character']['id']));
			$this->Chat->deleteAll(array('Chat.character_id_to' => $someCharacter['Character']['id']));
			$this->Drop->deleteAll(array('Drop.character_id' => $someCharacter['Character']['id']));
			$this->Inventory->deleteAll(array('Inventory.character_id' => $someCharacter['Character']['id']));
			$this->Item->updateAll(array('Item.character_id' => '0'), array('Item.character_id' => $someCharacter['Character']['id']));
			$this->Log->deleteAll(array('Log.character_id' => $someCharacter['Character']['id']));
			$this->Character->delete($someCharacter['Character']['id']);
			if(!empty($someCharacter['Character']['image']) &&
				file_exists(WWW_ROOT . DS . 'img' . DS . 'game' . DS . 'avatars' . DS . 'characters' . DS . $someCharacter['Character']['image'])) {
				unlink(WWW_ROOT . DS . 'img' . DS . 'game' . DS . 'avatars' . DS . 'characters' . DS . $someCharacter['Character']['image']);
			}
		}

		$this->redirect('/admin/characters');
	}
}
?>