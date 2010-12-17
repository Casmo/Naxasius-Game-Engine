<?php
/* SVN FILE: $Id$ */
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class PagesController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';

	var $paginate = array(
		'limit' => 20,
		'order' => array('Page.order' => 'asc')
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('display', 'view', 'browsergamehub');
		if($this->Auth->user('role') == 'player' && $this->Auth->user('activation_code') == '' && !empty($this->characterInfo)) {
			$this->Auth->allow('game');
		}
	}

	function view($id = null) {
		$page = $this->Page->find('first', array('conditions' => array('Page.id' => $id)));
		if(empty($page)) {
			$this->redirect('/');
		}

		$pages = $this->Interface->getWebsiteMenus();

		$this->crumbs[] = array('name' => $page['Page']['title'], 'link' => '/pages/view/'. $page['Page']['id']);
		$this->title_for_layout = 'Naxasius.com: '. $page['Page']['title'];
		$this->description_for_layout = strip_tags($page['Page']['message']);
		$this->set('page', $page);
		$this->set('pages', $pages);
	}

	function browsergamehub() {
		$this->layout = 'xml';
		$this->loadModel('Screenshot');
		$screenshots = $this->Screenshot->find('all');
		$this->set('screenshots', $screenshots);
	}

/**
 * This is the function where a player gets redirected after selecting a character,
 * or after going to /game.
 */
	function game() {
		$this->layout = 'game';
		$this->render(false); // Rendering goes through ajax calls
	}

	function admin_index() {
		$pages = $this->paginate();
		$this->set('pages', $pages);
	}

	function admin_add() {
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
	}

	function admin_edit($id = null) {
		$this->javascripts[] = '/js/tiny_mce/jquery.tinymce.js';
		$this->data = $this->Page->find('first', array('conditions' => array('Page.id' => $id)));
	}

	function admin_save() {
		if(isset($this->data) && !empty($this->data)) {
			$this->Page->save($this->data);
		}
		$this->redirect('/admin/pages');
	}
}

?>