<?php
/**
 * News
 *
 * Allowing admins to create news
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
class NewsController extends AppController {
	var $name = 'News';

	var $paginate = array(
		'limit' => 20,
		'order' => array('News.created' => 'desc')
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->crumbs[] = array('name' => __('News', true), 'link' => '/news');
		$this->Auth->allow('index', 'view', 'rss');
	}

	function index() {

		$this->paginate['limit'] = 5;
		$news = $this->paginate();

		$this->loadModel('Promotion');
		$promotions = $this->Promotion->find('all', array('conditions' => array('Promotion.show' => '1'), 'order' => 'Promotion.id DESC'));

		$pages = $this->Interface->getWebsiteMenus();

		$this->set('promotions', $promotions);
		$this->set('news', $news);
		$this->set('pages', $pages);
	}

	function view($id = null) {

		$this->News->contain(array('Reply' => 'User'));
		$news = $this->News->find('first', array('conditions' => array('News.id' => $id)));
		if(empty($news)) {
			$this->redirect('/');
		}

		$this->crumbs[] = array('name' => $news['News']['title'], 'link' => '/news/view/'. $news['News']['id']);

		$pages = $this->Interface->getWebsiteMenus();

		$this->title_for_layout = 'Naxasius.com: '. $news['News']['title'];
		$this->description_for_layout = strip_tags($news['News']['summary']);

		$this->set('item', $news);
		$this->set('pages', $pages);
	}

	function rss() {
		$this->layout = 'xml';
		$this->set('news', $this->News->find('all', array('order' => array('News.created DESC'), 'limit' => '10')));
	}

	function admin_index() {
		$news = $this->paginate();
		$this->set('news', $news);
	}

	function admin_add() {
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
	}

	function admin_edit($id = null) {
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
		$this->News->recursive = 2;
		$this->data = $this->News->find('first', array('conditions' => array('News.id' => $id)));
	}

	function admin_save() {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->request->data['News']['id'])) {
				$news = $this->News->find('first', array('conditions' => array('News.id' => $this->request->data['News']['id'])));
			}
			else {
				$this->request->data['News']['user_id'] = $this->userInfo['id'];
			}
			// resize
			App::import('Vendor', 'Image', array('file' => 'image.php'));
			$Image = new Image();
			if(empty($this->request->data['News']['image']['name'])) {
				unset($this->request->data['News']['image']);
			}
			else {
				$ext = preg_replace('/(.*)(\.(.*))$/', '\\3', $this->request->data['News']['image']['name']);
				$imageName = md5(uniqid(mt_rand(), true)) .'.'. $ext;
				move_uploaded_file($this->request->data['News']['image']['tmp_name'], WWW_ROOT . 'img'. DS .'website'. DS .'news'. DS . $imageName);
				$Image->resize(WWW_ROOT . 'img'. DS .'website'. DS .'news'. DS . $imageName, WWW_ROOT . 'img'. DS .'website'. DS .'news'. DS . $imageName, 64, 64);
				$this->request->data['News']['image'] = $imageName;
				if(isset($news['News']['image'])) {
					@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'news'. DS . $news['News']['image']);
				}
			}
			$this->News->save($this->data);
			$this->redirect('/admin/news');
		}
		else {
			$this->redirect('/admin/news');
		}
	}

	function admin_delete($id = null) {
		$news = $this->News->find('first', array('conditions' => array('News.id' => $id)));
		if(empty($news)) {
			$this->redirect('/admin/news');
		}
		if(isset($news['News']['image']) && !empty($news['News']['image'])) {
			@unlink(WWW_ROOT . 'img'. DS .'website'. DS .'news'. DS . $news['News']['image']);
		}
		$this->News->delete($id);
		$this->redirect('/admin/news');
	}
}
?>