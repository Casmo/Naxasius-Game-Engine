<?php
/**
 * Types (Classes)
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
class TypesController extends AppController {
	var $name = 'Types';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Type.name' => 'asc')
	);

	function admin_index() {
		$types = $this->paginate();
		$this->set('types', $types);
	}

	function admin_add() {
		if(isset($this->data) && !empty($this->data)) {
			$this->Type->save($this->data);
			$this->redirect('/admin/types');
		}
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
	}

	function admin_edit($id = null) {
		if(isset($this->data) && !empty($this->data)) {
			if($this->Type->save($this->data)) {
				foreach($this->data['StatsType'] as $index => $StatsType) {
					if($StatsType['check'] != 1) {
						unset($this->data['StatsType'][$index]);
					}
					else {
						$this->data['StatsType'][$index]['type_id'] = $this->data['Type']['id'];
					}
				}
				$this->Type->StatsType->deleteAll(array('type_id' => $id));
				$this->Type->StatsType->saveAll($this->data['StatsType']);
			}
			$this->redirect('/admin/types');
		}
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
		$this->data = $this->Type->find('first', array('conditions' => array('Type.id' => $id)));
		$this->set('stats', $this->Type->Stat->find('list'));
	}

	function admin_delete($id = null) {
		$this->Type->StatsType->deleteAll(array('StatsType.type_id' => $id));
		$this->Type->delete($id);
		$this->redirect('/admin/types');
	}
}
?>