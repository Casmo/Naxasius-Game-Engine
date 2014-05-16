<?php
/**
 * Items
 *
 * This file is used to edit and add items.
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
class ItemsController extends AppController {
	var $name = 'Items';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Item.name' => 'asc'),
		'contain' => array('Group')
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view');
	}

	function index() {
		$this->crumbs[] = array('name' => 'Item database', 'link' => '/items');
		$lastItem = $this->Item->find('first', array('conditions' => array('Item.character_id <>' => '0'), 'order' => array('Item.discovered DESC')));
		$this->paginate['conditions'] = array('Item.character_id <>' => 0);
		$this->paginate['contain'] = array('Group', 'Character');
		$items = $this->paginate();
		$pages = $this->Interface->getWebsiteMenus();
		$this->set('items', $items);
		$this->set('lastItem', $lastItem);
		$this->set('pages', $pages);
	}

	/* This function is also allowed for guests */
	function view($name = '') {
		$name = str_replace('[', '', $name);
		$name = str_replace(']', '', $name);
		$this->Item->contain(array('Character', 'Stat'));
		$item = $this->Item->find('first', array('conditions' => array('Item.name' => $name)));
		if(empty($item)) {
			$this->redirect('/pages/view/notfound');
		}
		else {
			$this->set('item', $item);
		}
	}

	function admin_index() {
		$items = $this->paginate();
		$this->set('items', $items);
	}

	function admin_edit($id = null) {
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
		if(isset($this->data) && !empty($this->data)) {
			$oldItem = $this->Item->find('first', array('conditions' => array('Item.id' => $id)));
			if(isset($this->request->data['Item']['image']['name']) && !empty($this->request->data['Item']['image']['name'])) {
				// Oude verwijderen en nieuwe toevoegen...
				@unlink(WWW_ROOT . 'img' . DS . 'game' . DS . 'items' . DS . $oldItem['Item']['image']);
				eregi('((.)([A-Z]+))$', $this->request->data['Item']['image']['name'], $parts);
				$extentie = $parts[3];
				$file_name = uniqid(mt_rand(), true) .'.'. $extentie;
				move_uploaded_file($this->request->data['Item']['image']['tmp_name'], WWW_ROOT . 'img' . DS . 'game' . DS . 'items' . DS . $file_name);
				$this->request->data['Item']['image'] = $file_name;
				$this->request->data['Item']['icon'] = $file_name;
			}
			else {
				// Behoud de oude
				unset($this->request->data['Item']['image']);
			}
			if($this->Item->save($this->data)) {

				foreach($this->request->data['ItemsStat'] as $index => $ItemsStat) {
					if($ItemsStat['check'] != 1) {
						unset($this->request->data['ItemsStat'][$index]);
					}
					else {
						$this->request->data['ItemsStat'][$index]['item_id'] = $id;
					}
				}
				$this->Item->ItemsStat->deleteAll(array('item_id' => $id));
				$this->Item->ItemsStat->saveAll($this->request->data['ItemsStat']);
				$this->redirect('/admin/items');
			}
			$this->set('stats', $this->Item->Stat->find('list'));
			$this->set('groups', $this->Item->Group->find('list', array('conditions' => array('Group.type' => 'item'))));
		}
		else {
			$this->data = $this->Item->find('first', array('conditions' => array('Item.id' => $id)));
			$this->set('stats', $this->Item->Stat->find('list'));
			$this->set('groups', $this->Item->Group->find('list', array('conditions' => array('Group.type' => 'item'))));
		}
	}

	function admin_add() {
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->request->data['Item']['image']['name']) && !empty($this->request->data['Item']['image']['name'])) {
				// Oude verwijderen en nieuwe toevoegen...
				eregi('((.)([A-Z]+))$', $this->request->data['Item']['image']['name'], $parts);
				$extentie = $parts[3];
				$file_name = uniqid(mt_rand(), true) .'.'. $extentie;
				move_uploaded_file($this->request->data['Item']['image']['tmp_name'], WWW_ROOT . 'img' . DS . 'game' . DS . 'items' . DS . $file_name);
				$this->request->data['Item']['image'] = $file_name;
				$this->request->data['Item']['icon'] = $file_name;
			}
			else {
				unset($this->request->data['Item']['image']);
			}
			if($this->Item->save($this->data)) {
				$this->redirect('/admin/items');
			}
			$this->set('stats', $this->Item->Stat->find('list'));
			$this->set('groups', $this->Item->Group->find('list', array('conditions' => array('Group.type' => 'item'))));
		}
		else {
			$this->set('stats', $this->Item->Stat->find('list'));
			$this->set('groups', $this->Item->Group->find('list', array('conditions' => array('Group.type' => 'item'))));
		}
	}
}
?>