<?php
/**
 * Replies
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
class RepliesController extends AppController {
	var $name = 'Replies';

	function beforeFilter() {
		parent::beforeFilter();
		if($this->Auth->user('role') == 'player') {
			$this->Auth->allow('add');
		}
	}

	function add() {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->request->data['Reply']['news_id'])) {
				$someNews = $this->Reply->News->find('first', array('conditions' => array('News.id' => $this->request->data['Reply']['news_id'])));
				if(empty($someNews)) {
					$this->redirect('/news');
				}
				else {
					$redirect = 'news';
					$this->request->data['Reply']['type'] = 'news';
					$this->request->data['Reply']['target_id'] = $this->request->data['Reply']['news_id'];
					unset($this->request->data['Reply']['news_id']);
				}
			}
			if(isset($this->request->data['Reply']['topic_id'])) {
				$someTopic = $this->Reply->Forum->find('first', array('conditions' => array('Topic.id' => $this->request->data['Reply']['topic_id'])));
				if(empty($someTopic)) {
					$this->redirect('/forum');
				}
				else {
					$redirect = 'forum/topics';
					$this->request->data['Reply']['type'] = 'topic';
					$this->request->data['Reply']['target_id'] = $this->request->data['Reply']['topic_id'];
					unset($this->request->data['Reply']['topic_id']);
				}
			}
			if(!empty($this->request->data['Reply']['message'])) {
				// Kijken of het nieuws bestaat...
				$this->request->data['Reply']['user_id'] = $this->userInfo['id'];
				$this->Reply->save($this->data);
				$this->redirect('/'. $redirect .'/view/'. $this->request->data['Reply']['target_id']);
			}
		}
		$this->redirect('/');
	}

	function admin_delete($id = null) {
		$this->Reply->unbindModelAll();
		$someReply = $this->Reply->find('first', array('conditions' => array('Reply.id' => $id)));
		if(empty($someReply)) {
			$this->redirect('/admin/news');
		}
		else {
			$this->Reply->delete($id);
			$this->redirect('/admin/news/edit/'. $someReply['Reply']['news_id']);
		}
	}
}
?>