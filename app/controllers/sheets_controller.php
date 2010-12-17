<?php
/**
 * Sheets
 *
 * An predifined sheet of Obstacles.
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
class SheetsController extends AppController {
	var $name = 'Sheets';

	var $paginate = array(
		'limit' => 50,
		'order' => array('Sheet.id' => 'asc')
	);

	var $helpers = array('World');

	function admin_add_to_area($area_id = null) {
		if(isset($this->data) && !empty($this->data)) {
			$this->render(false);
			if(isset($this->data['Sheet']['id'])) {
				$someSheet = $this->Sheet->find('first', array('conditions' => array('Sheet.id' => $this->data['Sheet']['id'])));
				if(empty($someSheet)) {
					return false;
				}
				$obstaclesPosition = array(); // List of [x][y] obstacles
				$saveObstacles = array(); // The data to be saved
				// topleft opzoeken
				$min_x = 0;
				$max_x = 0;
				$min_y = 0;
				$max_y = 0;
				foreach($someSheet['Obstacle'] as $obstacle) {
					$obstaclesPosition[$obstacle['ObstaclesSheet']['position_x']][$obstacle['ObstaclesSheet']['position_y']][] = $obstacle;
					if($min_x > $obstacle['ObstaclesSheet']['position_x']) {
						$min_x = $obstacle['ObstaclesSheet']['position_x'];
					}
					if($min_y > $obstacle['ObstaclesSheet']['position_y']) {
						$min_y = $obstacle['ObstaclesSheet']['position_x'];
					}
					if($max_x < $obstacle['ObstaclesSheet']['position_x']) {
						$max_x = $obstacle['ObstaclesSheet']['position_x'];
					}
					if($max_y < $obstacle['ObstaclesSheet']['position_y']) {
						$max_y = $obstacle['ObstaclesSheet']['position_y'];
					}
				}
				// Correctie inbouwen (in het geval we -1 x of -2 y hebben)
				$addX = 0;
				if($min_x < 0) {
					$addX = ($min_x - $min_x - $min_x);
				}
				$addY = 0;
				if($min_y < 0) {
					$addY = ($min_y - $min_y - $min_y);
				}
				$this->loadModel('Area');
				$this->Area->contain();
				$topLeftArea = $this->Area->find('first', array('conditions' => array('Area.id' => $this->data['Sheet']['area_id'])));
				for($x = $min_x; $x <= $max_x; $x++) {
					for($y = $min_y; $y <= $max_y; $y++) {
						if(isset($obstaclesPosition[$x][$y])) {
							// Vraag de ID van de area op
							$conditions = array();
							$conditions['Area.map_id'] = $topLeftArea['Area']['map_id'];
							$conditions['Area.x'] = $topLeftArea['Area']['x'] + $x + $addX;
							$conditions['Area.y'] = $topLeftArea['Area']['y'] + $y + $addY;
							$currentArea = $this->Area->find('first', array('conditions' => $conditions));
							if(!empty($currentArea)) {
								foreach($obstaclesPosition[$x][$y] as $obstacle) {
									$saveObstacles[] = array(
										'area_id' => $currentArea['Area']['id'],
										'obstacle_id' => $obstacle['id'],
										'x' => $this->data['Sheet']['x'],
										'y' => $this->data['Sheet']['y'],
										'z' => $this->data['Sheet']['z']
									);
								}
							}
						}
					}
				}
				$output = '<script type="text/javascript">';
				$this->loadModel('AreasObstacle');
				$this->AreasObstacle->saveAll($saveObstacles);
				foreach($saveObstacles as $obstacle) {
					$output .= '$(\'div#area_'. $obstacle['area_id'] .'\').load(\''. Router::url('/', true) .'/admin/areas/view/'. $obstacle['area_id'] .'\');';
				}
				$output .= '</script>';
				echo $output;
				exit;
			}
		}
		else {
			$this->set('sheets', $this->Sheet->find('list'));
			$this->set('area_id', $area_id);
		}
	}

	/**
	 * (Admin) Get an overview of all the
	 */
	function admin_index() {
		$sheets = $this->paginate();
		$this->set('sheets', $sheets);
	}

	function admin_add() {
		$this->Sheet->Obstacle->contain();
		$this->set('obstacles', $this->Sheet->Obstacle->find('all'));
	}

	function admin_edit($sheet_id = null) {
		$this->Sheet->Obstacle->contain();
		$someSheet = $this->Sheet->find('first', array('conditions' => array('Sheet.id' => $sheet_id)));
		if(empty($someSheet)) {
			$this->redirect('/admin/sheets');
		}
		$this->data = $someSheet;
		$this->set('obstacles', $this->Sheet->Obstacle->find('all'));
	}

	function admin_save() {
		if(isset($this->data) && !empty($this->data)) {
			if($this->Sheet->save($this->data)) {
				if(isset($this->data['ObstaclesSheet'])) {
					foreach($this->data['ObstaclesSheet'] as $index => $obstacle) {
						if(!isset($obstacle['obstacle_id'])) {
							unset($this->data['ObstaclesSheet'][$index]);
						}
						else {
							$this->data['ObstaclesSheet'][$index]['sheet_id'] = $this->Sheet->id;
						}
					}
					$this->Sheet->ObstaclesSheet->deleteAll(array('ObstaclesSheet.sheet_id' => $this->Sheet->id));
					$this->Sheet->ObstaclesSheet->saveAll($this->data['ObstaclesSheet']);
				}
			}
		}
		$this->redirect('/admin/sheets');
	}

	function admin_delete($id = null) {
		if(isset($id)) {
			$this->deleteAll($id);
		}
		elseif(isset($this->data['Sheet']['id'])) {
			$this->deleteAll($this->data['Sheet']['id']);
		}
		$this->redirect('/admin/sheets');
	}

	function deleteAll($id = null) {
		if(is_array($id)) {
			foreach($id as $sheet_id) {
				$this->deleteAll($sheet_id);
			}
		}
		elseif(!empty($id)) {
			$this->Sheet->delete($id);
			$this->Sheet->ObstaclesSheet->deleteAll(array('ObstaclesSheet.sheet_id' => $id));
		}
	}
}
?>