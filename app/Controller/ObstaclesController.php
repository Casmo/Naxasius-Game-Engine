<?php
/**
 * Obstacles
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
class ObstaclesController extends AppController {
	var $name = 'Obstacles';

	var $paginate = array(
		'limit' => 50,
		'order' => array('Obstacle.id' => 'asc'),
		'contain' => array('Group')
	);

	var $helpers = array('Form');

	/**
	 * (Admin) Get an overview of all the
	 */
	function admin_index() {
		$filters = array();
		if(isset($this->request->data['Group']['id']) && $this->request->data['Group']['id'] != 0) {
			$filters['Group.id'] = $this->request->data['Group']['id'];
		}
		elseif(isset($this->passedArgs['Group.id']) && $this->passedArgs['Group.id'] != 0) {
			$filters['Group.id'] = $this->passedArgs['Group.id'];
		}
		elseif(isset($this->request->data['Group']['id']) && $this->request->data['Group']['id'] == 0) {
			$this->Session->delete('Filters.obstacles');
		}
		else {
			$filters = $this->Session->read('Filters.obstacles');
		}
		if(isset($this->params['named']['page']) && !empty($this->params['named']['page'])) {
			$this->Session->write('Page.obstacles', $this->params['named']['page']);
		}
		elseif(!isset($this->params['named']['page'])) {
			$this->passedArgs['page'] = $this->Session->read('Page.obstacles');
		}
		$obstacles = $this->paginate($filters);

		// Check for doubles
		$obstaclesIds = array();
		foreach($obstacles as $obstacle) {
			$obstaclesIds[] = $obstacle['Obstacle']['id'];
		}
		$doubleObstacles = $this->Obstacle->find('all', array(
				'fields' => array(
					'Obstacle.id',
					'COUNT(Obstacle.sha1) as `doubles`'
				),
				'group' => 'Obstacle.sha1',
				'conditions' => array(
					'Obstacle.id' => $obstaclesIds
				)
			)
		);
		// Set the $mixedObstacles so we can merge it with $obstacles
		$mixedObstacles = array();
		foreach($doubleObstacles as $obstacle) {
			$mixedObstacles[$obstacle['Obstacle']['id']] = $obstacle[0]['doubles'];
		}
		foreach($obstacles as $index => $obstacle) {
			$obstacles[$index]['Obstacle']['doubles'] = isset($mixedObstacles[$obstacle['Obstacle']['id']]) ? $mixedObstacles[$obstacle['Obstacle']['id']] : 0;
		}

		$groups = $this->Obstacle->Group->find('list', array('conditions' => array('type' => 'obstacle')));
		$this->set('groups', $groups);
		$this->set('filters', $filters);
		$this->set('obstacles', $obstacles);
	}

	function admin_search() {
		$obstacles = array();
		if(isset($this->data) && !empty($this->data)) {
			$obstacles = $this->Obstacle->find('all', array('conditions' => array('Group.id' => $this->request->data['Group']['id'])));
		}
		$groups = $this->Obstacle->Group->find('list', array('conditions' => array('type' => 'obstacle')));
		$this->set('groups', $groups);
		$this->set('obstacles', $obstacles);
	}

	/**
	 * (Admin) Add a new NPC
	 */
	function admin_add() {
		$this->set('groups', $this->Obstacle->Group->find('list', array('conditions' => array('Group.type' => 'obstacle'))));
	}

	/**
	 * (Admin) edit a obstacle
	 */
	function admin_edit($id = null) {
		if(!isset($id) || empty($id)) {
			$this->redirect('/admin/obstacles');
			return false;
		}
		$obstacle = $this->Obstacle->find('first', array('conditions' => array('Obstacle.id' => $id)));
		if(empty($obstacle)) {
			$this->redirect('/admin/obstacles');
			return false;
		}

		$this->set('groups', $this->Obstacle->Group->find('list', array('conditions' => array('Group.type' => 'obstacle'))));
		$this->data = $obstacle;
	}

	/**
	 * (Admin) save a (new) obstacle
	 */
	function admin_save($id = null) {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->request->data['Obstacle']['id']) && !empty($this->request->data['Obstacle']['id'])) {
				$obstacle = $this->Obstacle->find('first', array('conditions' => array('Obstacle.id' => $this->request->data['Obstacle']['id'])));
			}
			if(empty($this->request->data['Obstacle']['image']['name'])) {
				unset($this->request->data['Obstacle']['image']);
			}
			else {
				$ext = preg_replace('/(.*)(\.(.*))$/', '\\3', $this->request->data['Obstacle']['image']['name']);
				$imageName = md5(uniqid(mt_rand(), true)) .'.'. $ext;
				move_uploaded_file($this->request->data['Obstacle']['image']['tmp_name'], WWW_ROOT . 'img'. DS .'game'. DS .'obstacles'. DS . $imageName);
				$this->request->data['Obstacle']['image'] = $imageName;
				if(isset($obstacle['Obstacle']['image'])) {
					@unlink(WWW_ROOT . 'img'. DS .'game'. DS .'obstacles'. DS . $obstacle['Obstacle']['image']);
				}
				$this->request->data['Obstacle']['sha1'] = sha1_file(WWW_ROOT . 'img'. DS .'game'. DS .'obstacles'. DS . $imageName);
			}
			$this->Obstacle->save($this->data);
			$this->redirect('/admin/obstacles');
			return true;
		}
		else {
			$this->redirect('/admin/obstacles');
		}
	}

	/**
	 * (Admin) delete an obstacle
	 */
	function admin_delete($id = null) {
		if(isset($id)) {
			$this->deleteAll($id);
		}
		elseif(isset($this->request->data['Obstacle']['id'])) {
			$this->deleteAll($this->request->data['Obstacle']['id']);
		}
		$this->redirect('/admin/obstacles');
	}

	function deleteAll($id = null) {
		if(is_array($id)) {
			foreach($id as $obstacle_id) {
				$this->deleteAll($obstacle_id);
			}
		}
		elseif(!empty($id)) {
			$obstacle = $this->Obstacle->find('first', array('conditions' => array('Obstacle.id' => $id)));
			if(!empty($obstacle['Obstacle']['image'])) {
						@unlink(WWW_ROOT . 'img'. DS .'game'. DS .'obstacles'. DS . $obstacle['Obstacle']['image']);
			}
			$this->Obstacle->delete($id);
		}
	}

	function admin_import() {
		if(isset($this->data) && !empty($this->data)) {
			if(isset($this->request->data['Obstacle']['save']) && $this->request->data['Obstacle']['save'] == '1') {
				$saveData = array();
				foreach($this->request->data['Obstacle']['images'] as $image) {
					if(rename(WWW_ROOT . 'img' . DS . 'admin' . DS . 'tmp' . DS . $image, WWW_ROOT . 'img' . DS . 'game' . DS . 'obstacles' . DS . $image)) {
						$sha1 = sha1_file(WWW_ROOT . 'img'. DS .'game'. DS .'obstacles'. DS . $image);
						$saveData[] = array('name' => '', 'image' => $image, 'group_id' => $this->request->data['Obstacle']['group_id'], 'sha1' => $sha1);
					}
				}
				$this->Obstacle->saveAll($saveData);
				$this->redirect('/admin/obstacles');
			}
			else {
				$tile_width = Configure::read('Game.tile.width');
				$tile_height = Configure::read('Game.tile.height');
				$sizes = getimagesize($this->request->data['Obstacle']['image']['tmp_name']);
				$src_im = imagecreatefrompng($this->request->data['Obstacle']['image']['tmp_name']);
				$x = $sizes[0] / $tile_width;
				$y = $sizes[1] / $tile_height;
				$imagei = 1;
				$images = array();
				for($i = 0; $i < $x; $i++) {
					for($j = 0; $j < $y; $j++) {
						// Create a new image
						$dest_im  = imagecreatetruecolor($tile_width, $tile_height);
						imagealphablending($dest_im, false);
						imagesavealpha($dest_im, true);
						imagecopyresampled($dest_im, $src_im, 0, 0, ($i * $tile_width)  , ($j * $tile_height), $tile_width  , $tile_height, $tile_width  , $tile_height);
						$imageName = md5(uniqid(mt_rand(), true)) .'.png';
						imagepng($dest_im, WWW_ROOT . 'img' . DS . 'admin'. DS .'tmp'. DS . $imageName);
						$images[] = $imageName;
						$imagei++;
		    		}
				}
				$this->set('images', $images);
			}
		}
		$this->set('groups', $this->Obstacle->Group->find('list', array('conditions' => array('Group.type' => 'obstacle'))));
	}

	/*
	 * Merge tiles with the orginal and delete the others...
	 */
	function admin_merge($obstacle_id = null) {
		$originalObstacle = $this->Obstacle->find('first', array('conditions' => array('Obstacle.id' => $obstacle_id)));
		if(!empty($originalObstacle)) {
			App::import('Model', 'AreasObstacle');
			$AreasObstacle = new AreasObstacle();
			// Get the same tiles
			$someObstacles = $this->Obstacle->find('all',
				array(
					'conditions' => array(
						'Obstacle.sha1' => $originalObstacle['Obstacle']['sha1'],
						'Obstacle.id <>' => $originalObstacle['Obstacle']['id']
					)
				)
			);
			$obstacleIds = array();
			foreach($someObstacles as $obstacle) {
				$obstacleIds[] = $obstacle['Obstacle']['id'];
			}

			$AreasObstacle->updateAll(
				array('AreasObstacle.obstacle_id' => $originalObstacle['Obstacle']['id']),
				array('AreasObstacle.obstacle_id' => $obstacleIds)
			);
			$this->deleteAll($obstacleIds);
		}
		$this->redirect('/admin/obstacles');
	}
}
?>