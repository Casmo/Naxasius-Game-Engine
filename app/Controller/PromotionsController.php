<?php
/**
 * Promotions
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
class PromotionsController extends AppController {
	var $name = 'Promotions';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Promotion.title' => 'asc')
	);

	function beforeFilter() {
		parent::beforeFilter();
	}

	function admin_index() {
		$promotions = $this->paginate();
		$this->set('promotions', $promotions);
	}

	function admin_add() {
	}

	function admin_edit($id = null) {
		$this->data = $this->Promotion->find('first', array('conditions' => array('Promotion.id' => $id)));
	}

	function admin_save() {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->request->data['Promotion']['id'])) {
				$promotion = $this->Promotion->find('first', array('conditions' => array('Promotion.id' => $this->request->data['Promotion']['id'])));
			}
			// resize
			App::import('Vendor', 'Image', array('file' => 'image.php'));
			$Image = new Image();
			if(empty($this->request->data['Promotion']['image']['name'])) {
				unset($this->request->data['Promotion']['image']);
			}
			else {
				$ext = preg_replace('/(.*)(\.(.*))$/', '\\3', $this->request->data['Promotion']['image']['name']);
				$imageName = md5(uniqid(mt_rand(), true)) .'.'. $ext;
				move_uploaded_file($this->request->data['Promotion']['image']['tmp_name'], WWW_ROOT . 'img'. DS .'website'. DS .'promotions'. DS . $imageName);
				$Image->resize(WWW_ROOT . 'img'. DS .'website'. DS .'promotions'. DS . $imageName, WWW_ROOT . 'img'. DS .'website'. DS .'promotions'. DS . $imageName, 320, 160);
				$this->request->data['Promotion']['image'] = $imageName;
				if(isset($text['Promotion']['image']) && !empty($text['Promotion']['image'])) {
					@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'promotions'. DS . $text['Promotion']['image']);
				}
			}
			$this->Promotion->save($this->data);
		}
		$this->redirect('/admin/promotions');
	}
}

?>