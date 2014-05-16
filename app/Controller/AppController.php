<?php
/**
 * Game indentifier.
 *
 * This files collects the User- and Characterinfo and generates the correct view for the request.
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
class AppController extends Controller {
    public $helpers = array('Html', 'Form', 'Ubb');

    public $components = array('Auth' => array(
        'authenticate' => array(
            'Form' => array(
                'passwordHasher' => array(
                    'className' => 'Simple',
                    'hashType' => 'sha256'
                )
            )
        )
    ), 'Session', 'RequestHandler', 'Interface');

/**
 * Information about the current User
 *
 * @var array all `user` related info
 * @see this::beforeFilter();
 */
	var $userInfo = array();

/**
 * Information about the current Character
 *
 * @var array all `character` related info
 * @see this::beforeFilter()
 * @see this::updateGame()
 */
 	var $characterInfo = array();

/**
 * Addition CSS files
 *
 * @var array urls to the stylesheet
 */
	var $styles = array();

/**
 * Additional Javascript files
 *
 * @var array urls to the javascripts
 */
	var $javascripts = array();

/**
 * Interface structure paths for website and admin
 *
 * This contains a list of items who are displayed in the layout.
 * It contains a name and link for each parent function.
 *
 * Example:
 * $this->crumbs[] = array('name' => 'News', 'link' => '/news');
 * $this->crumbs[] = array('name' => 'Add', 'link' => '/news/add');
 *
 * @var array
 */
	var $crumbs = array();

	var $title_for_layout = 'Naxasius: a free browser MMORPG';

	var $description_for_layout = 'Naxasius is a free browser MMORPG where you can play with thousands of other players in a fantasy world.';

	var $layout = 'default';

/**
 * Initial the user, layout and rights for the request.
 *
 * @see beforeRender() for handeling specific AJAX requests
 */
	function beforeFilter() {
		$this->Auth->deny('*');

		if($this->Auth->User('id')) {
			$authUser = $this->Auth->User();
			$this->userInfo = $authUser;
		}
		$this->characterInfo = $this->Session->read('Game.Character');

		if($this->Auth->User('role') == 'admin' &&
		isset($this->params['prefix']) &&
		$this->params['prefix'] == 'admin') {
			$this->layout = 'admin';
			$this->Auth->allow($this->params['action']);
			$this->set('headMenus', $this->Interface->getAdminMenu($this->name));
			$this->set('subMenus', $this->Interface->getAdminSubMenu($this->name));
		}
		elseif(!empty($this->characterInfo) &&
			isset($this->params['prefix']) &&
			$this->params['prefix'] == 'game') {
			$this->layout = 'game';
			$this->Auth->allow($this->params['action']);
		}
		$this->crumbs[] = array('name' => __('Home', true), 'link' => '/');
        parent::beforeFilter();
	}

/**
 * Set special view for AJAX requests and add the user-, character-, script-
 * style- and crumbinformation to the View
 *
 * Loads a different view (ajax_<action>) if exists
 */
	function beforeRender() {
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
			$filePath = $this->viewPath . DS . 'ajax_' . $this->action . $this->ext;
			if(file_exists($filePath)) {
				$this->action = 'ajax_'. $this->action;
			}
		}

		$this->set('userInfo', $this->userInfo);
		$this->set('styles', $this->styles);
		$this->set('javascripts', $this->javascripts);
		$this->set('gameInfo', $this->Session->read('Game'));
		$this->set('crumbs', $this->crumbs);
		$this->set('title_for_layout', $this->title_for_layout);
		$this->set('description_for_layout', $this->description_for_layout);
        parent::beforeRender();
	}

	function isAuthorized() {

	}

/**
 * Sets the latest information about the game in the Session.
 *
 * @param array $models List of elements to update
 * @return void
 */
	function updateGame($models = array()) {
		foreach($models as $model) {
			switch($model) {
				case 'Character':
				$this->loadModel('Character');
				$this->Character->contain();
				$someCharacter = $this->Character->find('first', array('conditions' => array('Character.id' => $this->characterInfo['id'])));
				$this->Session->write('Game.Character', $someCharacter['Character']);
				$this->characterInfo = $someCharacter['Character'];
				break;

				case 'Map':
				$this->loadModel('Map');
				$this->loadModel('Area');
				$this->Map->contain();
				$this->Area->contain();
				$someArea = $this->Area->find('first', array('fields' => array('Area.map_id'), 'conditions' => array('Area.id' => $this->characterInfo['area_id'])));
				$map_id = $someArea['Area']['map_id'];
				$map = $this->Map->find('first', array('conditions' => array('Map.id' => $map_id)));
				$this->Session->write('Game.Map', $map['Map']);
				break;

				case 'Type':
				$this->loadModel('Type');
				$someType = $this->Type->find('first', array('conditions' => array('Type.id' => $this->characterInfo['type_id'])));
				$this->Session->write('Game.Type', $someType['Type']);
				break;

				case 'Avatar':
				$this->loadModel('Avatar');
				$someAvatar = $this->Avatar->find('first', array('conditions' => array('Avatar.id' => $this->characterInfo['avatar_id'])));
				$this->Session->write('Game.Avatar', $someAvatar['Avatar']);
				break;

				case 'Stat':
				$this->loadModel('Character');
				$this->Character->contain(array('Stat', 'Inventory' => array('Item' => array('Stat'))));
				$oldLevel = $this->Session->read('Game.Stat.level');
				$someCharacter = $this->Character->find('first', array('conditions' => array('Character.id' => $this->characterInfo['id'])));
				$equipment = $this->Character->Inventory->getEquipedItems($this->characterInfo['id'], true);
				$someCharacter['Stat'] = $this->Character->makeStats($someCharacter['Stat'], $equipment);
				$newLevel = $someCharacter['Stat']['level'];
				$this->Session->write('Game.Stat', $someCharacter['Stat']);
				if(isset($oldLevel) && $oldLevel < $newLevel) {
					$this->Character->ding($this->characterInfo['id']);
					$this->updateGame(array('Stat'));
				}
				break;
			}
		}
	}
}
?>