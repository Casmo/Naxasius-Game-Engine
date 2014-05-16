<?php
/**
 * Npc
 *
 * Talking to NPCs
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
class NpcsController extends AppController {
	var $name = 'Npcs';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Npc.name' => 'asc')
	);

	/**
	 * Have a conversation with a NPC. Every time you say
	 * something it's added in the log tables. With the information
	 * in the log table we know exacly what the NPC said the
	 * last time the player said and what his response is.
	 *
	 * @param int The ID of the NPC
	 * @param int The ID of the conversation
	 *
	 * @access public
	 */
	function game_talk($id = null, $conversation_id = null) {

		// If there isn't a npc or conversation, redirect the player to the pages/notfound view.
		if(!isset($id) || empty($id) || !isset($conversation_id) || empty($conversation_id)) {
			$this->redirect('/pages/view/notfound');
		}
		$this->Npc->contain();
		$this->Npc->bindModel(array('hasOne' => array('AreasNpc' => array('type' => 'INNER', 'conditions' => array('AreasNpc.area_id' => $this->Session->read('Game.Character.area_id'))))));
		$npc = $this->Npc->find('first', array('conditions' => array('Npc.id' => $id)));

		// When a user tries to talk to an NPC wich isn't at his location or doesn't exists at all
		// redirect it to the pages/notfound view. This will be shown in the ajax layout.
		if(empty($npc)) {
			$this->redirect('/pages/view/notfound');
		}

		// Get the last conversation
		$this->Npc->bindModel(array('hasMany' => array('Conversation')));
		if($conversations = $this->Npc->Conversation->talk($id, $conversation_id, $this->Session->read('Game.Character.id'))) {
			if($this->Npc->Conversation->actionHappen == true) {
				$this->updateGame(array('Character', 'Stat'));
				$this->redirect('/game/npcs/view/'. $id .'/1');
			}
			else {
				$this->redirect('/game/npcs/view/'. $id);
			}
			return true;
		}
		else {
			$this->redirect('/pages/view/notfound');
			return false;
		}
	}

	function game_view($id = null, $refreshCharacter = false) {
		if(!isset($id) || empty($id)) {
			$this->redirect('/pages/view/notfound');
		}
		$this->Npc->contain();
		$this->Npc->bindModel(array('hasOne' => array('AreasNpc' => array('type' => 'INNER', 'conditions' => array('AreasNpc.area_id' => $this->Session->read('Game.Character.area_id'))))));
		$npc = $this->Npc->find('first', array('conditions' => array('Npc.id' => $id)));
		if(!empty($npc)) {

			// Get the last conversation
			$this->Npc->contain('Conversation');
			$conversations = $this->Npc->Conversation->getOptions($id, $this->Session->read('Game.Character.id'));
			$this->set('conversations', $conversations);
			$this->set('npc', $npc);
			if($refreshCharacter == true) {
				$this->set('javascriptsActions', 'updateCharacterInfo();');
			}
			else {
				$this->set('javascriptsActions', '');
			}
		}
		else {
			$this->redirect('/pages/view/notfound');
		}
	}

	// This will display the action frame with the quest
	function game_action($npc_id = null) {
		$this->Npc->bindModel(array('hasOne' => array('AreasNpc' => array('type' => 'INNER', 'conditions' => array('AreasNpc.area_id' => $this->Session->read('Game.Character.area_id'))))));
		$npc = $this->Npc->find('first', array('conditions' => array('Npc.id' => $npc_id)));
		if(!empty($npc)) {
			$this->set('npc', $npc);
		}
		else {
			$this->render('/errors/actionnotfound');
		}
	}

	/**
	 * (Admin) Get an overview of all the
	 */
	function admin_index() {
		$npcs = $this->paginate();
		$this->set('npcs', $npcs);
	}

	/**
	 * (Admin) Add a new NPC
	 */
	function admin_add() {
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
	}

	/**
	 * (Admin) edit a npc
	 */
	function admin_edit($id = null) {
		if(!isset($id) || empty($id)) {
			$this->redirect('/admin/npcs');
			return false;
		}
		$npc = $this->Npc->find('first', array('conditions' => array('Npc.id' => $id)));
		if(empty($npc)) {
			$this->redirect('/admin/npcs');
			return false;
		}
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
		/*
		// Get all conversations in order to edit
		$this->Npc->bindModel(array('hasMany' => array('Conversation')));
		$conversations = $this->Npc->Conversation->find('all', array('conditions' => array('Conversation.npc_id' => $id)));

		// Get a list of conversations of this NPC (used to select a parent)
		$this->Npc->bindModel(array('hasMany' => array('Conversation')));
		$conversations_parents = $this->Npc->Conversation->generatetreelist(array('Conversation.npc_id' => $id), null, '{n}.Conversation.question', '&nbsp;&nbsp;&nbsp;'); // find('all', array('Conversation.npc_id' => $id));
		$conversations_parent = array();
		foreach($conversations_parents as $conversation_id => $conv) {
			$conversations_parent[$conversation_id] = $conv; // $conv['Conversation']['question'] .' - '. $conv['Conversation']['answer'];
		}
		// Select all conversations in the game. This can be use for the required question
		$this->Npc->bindModel(array('hasMany' => array('Conversation')));
		$this->set('conversations_parent', $conversations_parent);
		$this->set('conversations', $conversations);
		$this->set('conversations_needed', $conversations_parent);
		*/
		$this->data = $npc;
	}

	/**
	 * (Admin) delete an npc
	 */
	function admin_delete($id = null) {
		if(!isset($id) || empty($id)) {
			$this->redirect('/admin/npcs');
			return false;
		}
		$npc = $this->Npc->find('first', array('conditions' => array('Npc.id' => $id)));
		if(empty($npc)) {
			$this->redirect('/admin/npcs');
			return false;
		}
		if(!empty($npc['Npc']['image'])) {
					@unlink(WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS . $npc['Npc']['image']);
		}
		$this->Npc->delete($id);
		$this->redirect('/admin/npcs');
	}

	/**
	 * (Admin) save a (new) npc
	 */
	function admin_save($id = null) {
		if(isset($id) && !empty($id)) {
			$npc = $this->Npc->find('first', array('conditions' => array('Npc.id' => $id)));
		}
		if(isset($this->data) && !empty($this->data)) {
			// resize
			App::import('Vendor', 'Image', array('file' => 'image.php'));
			$Image = new Image();
			if(empty($this->request->data['Npc']['image']['name'])) {
				unset($this->request->data['Npc']['image']);
			}
			else {
				$ext = preg_replace('/(.*)(\.(.*))$/', '\\3', $this->request->data['Npc']['image']['name']);
				$imageName = md5(uniqid(mt_rand(), true)) .'.'. $ext;
				move_uploaded_file($this->request->data['Npc']['image']['tmp_name'], WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS . $imageName);
				$Image->resize(WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS . $imageName, WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS . $imageName, 64, 64);
				$this->request->data['Npc']['image'] = $imageName;
				if(isset($npc['Npc']['image'])) {
					@unlink(WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS . $npc['Npc']['image']);
				}
			}
			if(empty($this->request->data['Npc']['icon']['name'])) {
				unset($this->request->data['Npc']['icon']);
			}
			else {
				$ext = preg_replace('/(.*)(\.(.*))$/', '\\3', $this->request->data['Npc']['icon']['name']);
				$imageName = md5(uniqid(mt_rand(), true)) .'.'. $ext;
				move_uploaded_file($this->request->data['Npc']['icon']['tmp_name'], WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS . $imageName);

				$Image->resize(WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS . $imageName, WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS . $imageName, 32, 32);
				$this->request->data['Npc']['icon'] = $imageName;
				if(isset($npc['Npc']['icon'])) {
					@unlink(WWW_ROOT . 'img'. DS .'game'. DS .'npcs'. DS . $npc['Npc']['icon']);
				}
			}
			$this->Npc->save($this->data);
			$this->redirect('/admin/npcs');
			return true;
		}
		else {
			$this->redirect('/admin/npcs');
		}
	}
}
?>