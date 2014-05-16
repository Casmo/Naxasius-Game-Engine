<?php
/**
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

	var $paginate = array(
		'limit' => 20,
		'order' => array('Reply.created ASC'),
		'contain' => array('User')
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->crumbs[] = array('name' => __('Forum', true), 'link' => '/forum');
		$this->styles[] = '/css/forum';
		$this->Auth->allow('index');
		if($this->Auth->User('id')) {
			$this->Auth->allow('add');
		}
		$pages = $this->Interface->getWebsiteMenus();
		$this->set('pages', $pages);
	}

	function index($topic_id = null) {
		$this->Reply->bindModel(array('belongsTo' => array('Topic' => array('className' => 'Topic', 'foreignKey' => 'target_id'))), false);
		$this->Reply->Topic->bindModel(array('belongsTo' => array('Forum')), false);
		$this->Reply->contain(array('Topic' => array('Forum')));
		$someTopic = $this->Reply->Topic->find('first', array('conditions' => array('Topic.id' => $topic_id)));
		if(empty($someTopic)) {
			$this->redirect('/forum');
		}
		$replies = $this->paginate();
		$this->crumbs[] = array('name' => $someTopic['Forum']['name'], 'link' => '/forum/view/'. $someTopic['Forum']['id']);
		$this->crumbs[] = array('name' => $someTopic['Topic']['title'], 'link' => '/forum/topics/view/'. $someTopic['Topic']['id']);
		$this->set('topic', $someTopic);
		$this->set('replies', $replies);
	}

	function add() {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->data['Reply']['topic_id'])) {
				$someTopic = $this->Reply->Topic->find('first', array('conditions' => array('Topic.id' => $this->data['Reply']['topic_id'])));
				if(empty($someTopic)) {
					$this->redirect('/forum');
				}
				else {
					$redirect = 'forum/topics';
					$this->data['Reply']['type'] = 'topic';
					$this->data['Reply']['target_id'] = $this->data['Reply']['topic_id'];
					unset($this->data['Reply']['topic_id']);
				}
			}
			if(!empty($this->data['Reply']['message'])) {
				// Kijken of het nieuws bestaat...
				$this->data['Reply']['user_id'] = $this->userInfo['id'];
				$this->Reply->save($this->data);
				$this->redirect('/'. $redirect .'/view/'. $this->data['Reply']['target_id']);
			}
		}
		$this->redirect('/');
	}
}
?>