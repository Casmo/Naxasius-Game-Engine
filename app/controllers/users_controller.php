<?php
/**
 * Users
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
class UsersController extends AppController {
	var $name = 'Users';

	var $paginate = array(
		'limit' => 20,
		'order' => array('User.username' => 'asc')
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->loginRedirect = array('controller' => 'news', 'action' => 'index');
		$this->Auth->allow('login','logout','register','lostpw');
		if($this->Auth->user('role') == 'player') {
			$this->Auth->allow('activate');
		}
	}

	function login() {
		if($this->Auth->user('id')) {
			$this->redirect('/');
		}

		$this->title_for_layout = 'Naxasius.com: Login';
		$this->crumbs[] = array('name' => __('Login', true), 'link' => '/users/login');

		$pages = $this->Interface->getWebsiteMenus();

		$this->set('pages', $pages);
	}

	function logout() {
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}

	function register() {
		if(!empty($this->data)) {
			$this->data['User']['activation_code'] = uniqid();
			if($this->User->save($this->data)) {
				$this->redirect('/pages/view/5');
			}
		}

		$this->title_for_layout = 'Naxasius.com: Register for a free account';
		$this->crumbs[] = array('name' => __('Register', true), 'link' => '/users/register');

		$pages = $this->Interface->getWebsiteMenus();

		$this->set('pages', $pages);
	}

	function lostpw() {

	}

	function activate() {
		if(isset($this->data) && !empty($this->data)) {
			if($this->data['User']['activation_code'] == $this->Auth->user('activation_code')) {
				$userData['User']['id'] = $this->Auth->user('id');
				$userData['User']['activation_code'] = '';
				$this->User->save($userData, array('validate' => false));
				$this->Session->write('Auth.User.activation_code', '');
				$this->redirect('/characters');
			}
		}

	}

	function admin_index() {
		$users = $this->paginate();
		$this->set('users', $users);
	}

	function admin_add() {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->data['User']['password']) && !empty($this->data['User']['password'])) {
				$this->data['User']['password'] = $this->Auth->password($this->data['User']['password']);
			}
			if($this->User->save($this->data)) {
				$this->redirect('/admin/users');
			}
		}
	}

	function admin_edit($id = null) {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->data['User']['password']) && !empty($this->data['User']['password'])) {
				$this->data['User']['password'] = $this->Auth->password($this->data['User']['password']);
			}
			$this->User->save($this->data, array('validate' => false));
			$this->redirect('/admin/users');
		}
		$this->data = $this->User->find('first', array('conditions' => array('User.id' => $id)));
	}

	function admin_delete($id = null) {
		$someUser = $this->User->find('first',
			array('conditions' => array(
				'User.id' => $id
			)
		));
		if(!empty($someUser)) {
			// Delete it's characters
			$this->loadModel('Character');
			$someCharacters = $this->Character->find('all',
				array('conditions' => array('Character.user_id' => $someUser['User']['id']))
			);
			if(!empty($someCharacters)) {
				$this->loadModel('Bag');
				$this->loadModel('CharactersQuest');
				$this->loadModel('CharactersStat');
				$this->loadModel('Chat');
				$this->loadModel('Drop');
				$this->loadModel('Inventory');
				$this->loadModel('Item');
				$this->loadModel('Log');

				foreach($someCharacters as $someCharacter) {
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
			}

			$this->loadModel('Reply');

			$this->Reply->deleteAll(array('Reply.user_id' => $someUser['User']['id']));
			$this->User->delete($someUser['User']['id']);
		}

		$this->redirect('/admin/users');
	}
}
?>