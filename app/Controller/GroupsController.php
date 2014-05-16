<?php
/**
 * Group system
 *
 * Obstacles, Tiles and Items can be placed into Groups in order to keep managing them (Amdin only)
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
class GroupsController extends AppController {
	var $name = 'Groups';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Group.name' => 'asc')
	);

	function admin_index() {
		$this->paginate['contain'] = array();
		$groups = $this->paginate();
		$this->set('groups', $groups);
	}

	function admin_add() {
		if(isset($this->data) && !empty($this->data)) {
			$this->Group->save($this->data);
			$this->redirect('/admin/groups');
		}
	}

	function admin_edit($id = null) {
		if(isset($this->data) && !empty($this->data)) {
			$this->Group->save($this->data);
			$this->redirect('/admin/groups');
		}
		else {
			$this->data = $this->Group->find('first', array('conditions' => array('Group.id' => $id)));
		}
	}
}
?>