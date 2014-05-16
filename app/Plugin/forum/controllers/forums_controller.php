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
class ForumsController extends AppController {
	var $name = 'Forums';

	function beforeFilter() {
		parent::beforeFilter();
		$this->crumbs[] = array('name' => __('Forum', true), 'link' => '/forum');
		$this->styles[] = '/css/forum';
		$this->Auth->allow('index', 'view');
	}

	function index() {
		$this->Forum->contain();
		$forums = $this->Forum->find('all', array('order' => array('Forum.order' => 'asc')));
		$pages = $this->Interface->getWebsiteMenus();
		$this->set('pages', $pages);
		$this->set('forums', $forums);
	}
}
?>