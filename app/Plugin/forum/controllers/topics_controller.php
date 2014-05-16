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
class TopicsController extends AppController {
	var $name = 'Topics';

	var $paginate = array(
		'limit' => 20,
		'order' => array('LastReply.created DESC'),
		'contain' => array('LastReply', 'FirstReply', 'Reply', 'User')
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->crumbs[] = array('name' => __('Forum', true), 'link' => '/forum');
		$this->styles[] = '/css/forum';
		$this->Auth->allow('index', 'view');
		if($this->Auth->User('id')) {
			$this->Auth->allow('add');
		}
		$pages = $this->Interface->getWebsiteMenus();
		$this->set('pages', $pages);
	}

	function index($forum_id = null) {
		$someForum = $this->Topic->Forum->find('first', array('conditions' => array('Forum.id' => $forum_id)));
		if(empty($someForum)) {
			$this->redirect('/forum');
		}
		$this->paginate['contain'] = array(
			'LastReply' => array('User'),
			'FirstReply' => array('User'),
			'Reply'
		);
		$this->paginate['group'] = array('Topic.id');
		$this->paginate['conditions'] = array('Topic.forum_id' => $forum_id);
		$topics = $this->paginate('Topic');
		$this->crumbs[] = array('name' => $someForum['Forum']['name'], 'link' => '/forum/view/'. $someForum['Forum']['id']);
		$this->set('forum', $someForum);
		$this->set('topics', $topics);
	}

	function add($forum_id = null) {
		if(isset($this->data) && !empty($this->data)) {
			$forum_id = $this->data['Topic']['forum_id'];
		}
		$someForum = $this->Topic->Forum->find('first', array('conditions' => array('Forum.id' => $forum_id)));
		if(empty($someForum)) {
			$this->redirect('/forum');
		}
		if(isset($this->data) && !empty($this->data)) {
			$this->data['Reply'][0]['type'] = 'topic';
			$this->data['Reply'][0]['user_id'] = $this->Auth->User('id');
			$this->data['Topic']['forum_id'] = $forum_id;
			if($this->Topic->saveAll($this->data)) {
				$this->redirect('/forum/topics/view/'. $this->Topic->id);
			}
		}
		$this->crumbs[] = array('name' => $someForum['Forum']['name'], 'link' => '/forum/view/'. $someForum['Forum']['id']);
		$this->crumbs[] = array('name' => 'New topic', 'link' => '/forum/add/'. $someForum['Forum']['id']);
		$this->data['Topic']['forum_id'] = $forum_id;
	}
}
?>