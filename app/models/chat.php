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
class Chat extends AppModel {
	var $name = 'Chat';
	var $belongsTo = array(
		'CharacterFrom' => array('name' => 'CharacterFrom', 'className' => 'Character', 'foreignKey' => 'character_id_from'),
		'CharacterTo' => array('name' => 'CharacterTo', 'className' => 'Character', 'foreignKey' => 'character_id_to')
	);

	var $actsAs = array('Containable');
}
?>