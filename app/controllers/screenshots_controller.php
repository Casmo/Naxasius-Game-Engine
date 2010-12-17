<?php
/**
 * Screenshots
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
class ScreenshotsController extends AppController {
	var $name = 'Screenshots';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Screenshot.title' => 'asc')
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view');
	}

	function index() {
		$this->paginate['order'] = array('Screenshot.created' => 'desc');
		$this->crumbs[] = array('name' => 'Screenshots', 'link' => '/screenshots');
		$screenshots = $this->paginate();

		$pages = $this->Interface->getWebsiteMenus();

		$this->javascripts[] = '/js/fancybox/jquery.fancybox-1.3.1.pack.js';
		$this->styles[] = 'jquery.fancybox-1.3.1.css';
		$this->title_for_layout = 'Naxasius.com: screenshots';
		$this->description_for_layout = 'Check out the latest screenshots!';

		$this->set('screenshots', $screenshots);
		$this->set('pages', $pages);
	}

	function admin_index() {
		$screenshots = $this->paginate();
		$this->set('screenshots', $screenshots);
	}

	function admin_add() {
	}

	function admin_edit($id = null) {
		$this->data = $this->Screenshot->find('first', array('conditions' => array('Screenshot.id' => $id)));
	}

	function admin_save() {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->data['Text']['id'])) {
				$screenshot = $this->Screenshot->find('first', array('conditions' => array('Screenshot.id' => $this->data['Screenshot']['id'])));
			}
			// resize
			App::import('Vendor', 'Image', array('file' => 'image.php'));
			$Image = new Image();
			if(empty($this->data['Screenshot']['image']['name'])) {
				unset($this->data['Screenshot']['image']);
			}
			else {
				$ext = preg_replace('/(.*)(\.(.*))$/', '\\3', $this->data['Screenshot']['image']['name']);
				$imageName = md5(uniqid(mt_rand(), true)) .'.'. $ext;
				move_uploaded_file($this->data['Screenshot']['image']['tmp_name'], WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'original'. DS . $imageName);
				$Image->resize(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'original' . DS . $imageName, WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'big' . DS . $imageName, 640, 480);
				$Image->resize(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'original' . DS . $imageName, WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'medium' . DS . $imageName, 350, 350);
				$Image->resize(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'original' . DS . $imageName, WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'small' . DS . $imageName, 100, 100);
				$this->data['Screenshot']['image'] = $imageName;
				if(isset($screenshot['Screenshot']['image']) && !empty($screenshot['Screenshot']['image'])) {
					@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'original' . DS . $screenshot['Screenshot']['image']);
					@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'small' . DS . $screenshot['Screenshot']['image']);
					@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'medium' . DS . $screenshot['Screenshot']['image']);
					@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'big' . DS . $screenshot['Screenshot']['image']);
				}
			}
			$this->Screenshot->save($this->data);
			$this->redirect('/admin/screenshots');
		}
		else {
			$this->redirect('/admin/screenshots');
		}
	}

	function admin_delete($id = null) {
		$someScreenshot = $this->Screenshot->find('first', array('Screenshot.id' => $id));
		if(!empty($someScreenshot)) {
			if(isset($screenshot['Screenshot']['image']) && !empty($screenshot['Screenshot']['image'])) {
				@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'original' . DS . $screenshot['Screenshot']['image']);
				@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'small' . DS . $screenshot['Screenshot']['image']);
				@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'medium' . DS . $screenshot['Screenshot']['image']);
				@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'screenshots'. DS . 'big' . DS . $screenshot['Screenshot']['image']);
			}
			$this->Screenshot->delete($someScreenshot['Screenshot']['id']);
		}
		$this->redirect('/admin/screenshots');
	}
}
?>