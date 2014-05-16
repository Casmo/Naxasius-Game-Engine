<?php
/**
 * Text
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
class TextsController extends AppController {
	var $name = 'Texts';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Text.name' => 'asc'),
		'contain' => array('Page')
	);

	function beforeFilter() {
		parent::beforeFilter();
	}

	function admin_index() {
		$texts = $this->paginate();
		$this->set('texts', $texts);
	}

	function admin_add() {
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
		$this->set('pages', $this->Text->Page->find('list'));
	}

	function admin_edit($id = null) {
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
		$this->data = $this->Text->find('first', array('conditions' => array('Text.id' => $id)));
		$this->set('pages', $this->Text->Page->find('list'));
	}

	function admin_save() {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->request->data['Text']['id'])) {
				$text = $this->Text->find('first', array('conditions' => array('Text.id' => $this->request->data['Text']['id'])));
			}
			// resize
			App::import('Vendor', 'Image', array('file' => 'image.php'));
			$Image = new Image();
			if(empty($this->request->data['Text']['image']['name'])) {
				unset($this->request->data['Text']['image']);
			}
			else {
				$ext = preg_replace('/(.*)(\.(.*))$/', '\\3', $this->request->data['Text']['image']['name']);
				$imageName = md5(uniqid(mt_rand(), true)) .'.'. $ext;
				move_uploaded_file($this->request->data['Text']['image']['tmp_name'], WWW_ROOT . 'img'. DS .'website'. DS .'texts'. DS . $imageName);
				$Image->resize(WWW_ROOT . 'img'. DS .'website'. DS .'texts'. DS . $imageName, WWW_ROOT . 'img'. DS .'website'. DS .'texts'. DS . $imageName, 100, 100);
				$this->request->data['Text']['image'] = $imageName;
				if(isset($text['Text']['image']) && !empty($text['Text']['image'])) {
					@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'texts'. DS . $text['Text']['image']);
				}
			}
			$this->Text->save($this->data);
			$this->redirect('/admin/texts');
		}
		else {
			$this->redirect('/admin/texts');
		}
	}
}
?>