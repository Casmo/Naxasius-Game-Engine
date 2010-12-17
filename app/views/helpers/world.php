<?php
/*
 * Created on Nov 16, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
class WorldHelper extends AppHelper {

	var $helpers = array('Html', 'Session');

	 // Tijdens het laden van de map worden hier de objecten, npcs, mobs, etc in deze array gezet.
	 // Vervolgens kunnen we deze gegevens gebruiken om netjes onder de map te plaatsen...
	var $actions = array();

    function show($areas = array(), $map = array(), $options = array()) {

		// Default option values
		if(!isset($options['showTitle'])) {
			$options['showTitle'] = true;
		}
		if(!isset($options['inGame'])) {
			$options['inGame'] = true; // We can use other links and stuff with this variabele
		}
		if(!isset($options['objectsClickable'])) {
			$options['objectsClickable'] = false;
		}
		if(!isset($options['playerPosition'])) {
			$area_id = $this->Session->read('Game.Character.area_id');
			if(isset($area_id) && !empty($area_id)){
				$options['playerPosition'] = $area_id;
			}
			else {
				$options['playerPosition'] = null;
			}
		}
		$html = '';
		// Calculate width and rows
		$aLengths = $this->getSizes($areas);
		#debug($aLengths);
		$map_width = $aLengths['x'] * Configure::read('Game.tile.width');
		$map_height = $aLengths['y'] * Configure::read('Game.tile.height');
		#$html .= '<div class="map-container" id="map">';
		if(isset($map) && !empty($map) && $options['showTitle'] == true) {
			$html .= '<h1>'. $map['Map']['name'];
			if(isset($map['Area']['x']) && !empty($map['Area']['y'])) {
				$html .= ' '. $map['Area']['x'] .', '. $map['Area']['y'];
			}
			$html .= '</h1>';
		}
		$html .= '<div style="width: '. $map_width .'px; height: '. $map_height .'px;" id="theMap">';

		$index = 0;
		for($i = 1; $i <= $aLengths['y']; $i++) {
			for($j = 1; $j <= $aLengths['x']; $j++) {

				// Set background for this area
				$style = '';
				if(isset($areas[$index])) {
					$style .= 'style="background-image: url('. $this->Html->url('/img/game/tiles/'. $areas[$index]['Tile']['image']) .')"';
				}
				// If there are some attributes for each area, add them here
				$attributes = '';
				if(isset($options['onclick'])) {
					// Onclick attribute
				}
				if(isset($areas[$index])) {
					$attributes .= ' id="area_'. $areas[$index]['Area']['id'] .'"';
				}
				$html .= '<div'. $attributes . $style .' class="area">';
				if(isset($areas[$index]['Npc']) && !empty($areas[$index]['Npc'])) {
					foreach($areas[$index]['Npc'] as $npc) {
						$style = 'cursor: default; position: absolute; left: '. $npc['AreasNpc']['x'] .'px; top: '. $npc['AreasNpc']['y'] .'px; z-index: '. $npc['AreasNpc']['z'] .';';
						$onclick = '';
#						if($options['inGame'] == true) {
#							// Only clickable when we are at the same position
							if($options['playerPosition'] == $areas[$index]['Area']['id']) {
								$this->actions[] = array('type' => 'npc', 'image' => '/img/game/npcs/'. $npc['icon'], 'target_id' => $npc['id']);
#								$style .= 'cursor: pointer;';
#								$onclick = 'popup("'. $this->html->url('/npcs/view/'. $npc['id']) .'");';
							}
#						}
						$html  .= $this->Html->image('/img/game/npcs/map/'. $npc['AreasNpc']['image'], array('title' => $npc['name'], 'style' => $style, 'onclick' => $onclick));
					}
				}
				if(isset($areas[$index]['Obstacle']) && !empty($areas[$index]['Obstacle'])) {
					foreach($areas[$index]['Obstacle'] as $obstacle) {
						$style = 'cursor: default; position: absolute; left: '. $obstacle['AreasObstacle']['x'] .'px; top: '. $obstacle['AreasObstacle']['y'] .'px; z-index: '. $obstacle['AreasObstacle']['z'] .';';
						$onclick = '';
#						if($options['inGame'] == true) {
							// Only clickable when we are at the same position
							if($options['playerPosition'] == $areas[$index]['Area']['id']) {
								$this->actions[] = array('type' => 'obstacle', 'image' => '', 'area_index' => $index, 'target_id' => $obstacle['AreasObstacle']['id']);
#								$style .= 'cursor: pointer;';
#								$onclick = 'popup("'. $this->html->url('/areas_obstacles/view/'. $obstacle['AreasObstacle']['id']) .'");';
							}
#						}
						$html  .= $this->Html->image('/img/game/obstacles/'. $obstacle['image'], array('style' => $style, 'class' => 'area_object', 'onclick' => $onclick));
					}
				}
				if(isset($options['playerPosition']) && $options['playerPosition'] == $areas[$index]['Area']['id']) {
					$html .= $this->Html->image('/img/game/avatars/'. $this->Session->read('Game.Avatar.image_map') .'/'. $this->Session->read('Game.Character.last_move') .'.png', array('alt' => __('You', true), 'title' => __('You', true), 'style' => 'z-index: 50;position: absolute; top: 3px; left: 8px;'));
				}
				$html .= '</div>';
				$index++;
			}
			#$html .= '</tr>';
		}
		$html .= '</div>';
    	return $this->output($html);
    }

    /**
     * Display the actions for the current area
     */
	function actions() {
		$html = '';
		if(isset($this->actions) && !empty($this->actions)) {
			foreach($this->actions as $index => $action) {
				$html .= '<div class="action borders" id="action_'. $index .'">';
				if(isset($action['image']) && !empty($action['image'])) {
					$html .= $this->Html->image($action['image']);
				}
				$html .= '</div>';
			}
		}
		return $this->output($html);
	}

	/**
	 * Show just one area (probably the current location of the player)
	 */
    function showArea($area = array(), $options=array()) {
		if(!isset($options['showDiv'])) {
			$options['showDiv'] = true;
		}
		$html = '';
		// Calculate width and rows
		if($options['showDiv']) {
			$style = 'background-image: url('. $this->Html->url('/img/game/tiles/'. $area['Tile']['image']) .');';
			if(isset($options['style'])) {
				$style .= $options['style'] .';';
			}
			$html .= '<div style="'. $style .' width: '. Configure::read('Game.tile.width') .'px; height: '. Configure::read('Game.tile.height') .'px; overflow: hidden; position: relative; border: 1px solid black;">';
		}

		if(isset($area['Npc']) && !empty($area['Npc'])) {
			foreach($area['Npc'] as $npc) {
				$style = 'position: absolute; left: '. $npc['AreasNpc']['x'] .'px; top: '. $npc['AreasNpc']['y'] .'px; z-index: '. $npc['AreasNpc']['z'] .';';
#				$style .= 'cursor: pointer;';
#				$onclick = 'popup("'. $this->Html->url('/npcs/view/'. $npc['id']) .'");';
				$html  .= $this->Html->image('/img/game/npcs/map/'. $npc['AreasNpc']['image'], array('title' => $npc['name'], 'style' => $style));
			}

		}
		if(isset($area['Obstacle']) && !empty($area['Obstacle'])) {
			foreach($area['Obstacle'] as $obstacle) {
				$style = 'position: absolute; left: '. $obstacle['AreasObstacle']['x'] .'px; top: '. $obstacle['AreasObstacle']['y'] .'px; z-index: '. $obstacle['AreasObstacle']['z'] .';';
			//	$style .= 'cursor: pointer;';
			//	$onclick = 'popup("'. $this->Html->url('/drops/view/'. $obstacle['id']) .'");';

				$html  .= $this->Html->image('/img/game/obstacles/'. $obstacle['image'], array('style' => $style));
			}

		}
		if($options['showDiv']) {
			$html .= '</div>';
		}

		return $this->output($html);
	}

	function buildSheet($obstacles = array()) {
		// Loop through the obstacles and devine the width/height of the preview
		$min_x = 0;
		$max_x = 0;
		$min_y = 0;
		$max_y = 0;
		$tile_width = Configure::read('Game.tile.width');
		$tile_height = Configure::read('Game.tile.height');
		foreach($obstacles as $obstacle) {
			if($min_x > $obstacle['ObstaclesSheet']['position_x']) {
				$min_x = $obstacle['ObstaclesSheet']['position_x'];
			}
			if($max_x < $obstacle['ObstaclesSheet']['position_x']) {
				$max_x = $obstacle['ObstaclesSheet']['position_x'];
			}
			if($min_y > $obstacle['ObstaclesSheet']['position_y']) {
				$min_y = $obstacle['ObstaclesSheet']['position_y'];
			}
			if($max_y < $obstacle['ObstaclesSheet']['position_y']) {
				$max_y = $obstacle['ObstaclesSheet']['position_y'];
			}
		}
		$divWidth = (($max_x - $min_x) + 1) * $tile_width;
		$divHeight = (($max_y - $min_y) + 1) * $tile_height;
		// In case of negative values, we have to correct those here.
		$addLeft = 0;
		$addTop = 0;
		if($min_x < 0) {
			$addLeft = ($min_x - $min_x - $min_x) * $tile_width;
		}
		if($min_y < 0) {
			$addTop = ($min_y - $min_y - $min_y) * $tile_height;
		}
		$html = '<div style="position: relative; width: '. $divWidth .'px; height: '. $divHeight .'px; border: 1px solid #000;">';
		foreach($obstacles as $obstacle) {
			$left = ($obstacle['ObstaclesSheet']['position_x'] * $tile_width) + $addLeft;
			$top = ($obstacle['ObstaclesSheet']['position_y'] * $tile_height) + $addTop;
			$html .= $this->Html->image('/img/game/obstacles/'. $obstacle['image'], array('style' => 'position: absolute; left: '. $left .'px; top: '. $top .'px;'));
		}
		$html .= '</div>';
		return $html;
	}

    /**
     * Private function to calculate the heighest x and heighest y
     * @return array('x' => INT, 'y' => INT)
     */
    function getSizes($areas = array()) {
    	$x = 0;
    	$y = 0;
    	$heighest_x = 0;
    	$heighest_y = 0;
		foreach($areas as $area) {
			if($area['Area']['x'] > $heighest_x) {
				$x++;
				$heighest_x = $area['Area']['x'];
			}
			if($area['Area']['y'] > $heighest_y) {
				$y++;
				$heighest_y = $area['Area']['y'];
			}
		}
		return array('x' => $x, 'y' => $y);
    }
}
?>