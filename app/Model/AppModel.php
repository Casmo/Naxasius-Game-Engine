<?php
/**
 * Global model.
 *
 * This file allows models to unbind all their related Models.
 * @todo Remove unbindModelAll() since we're using ContainBehavior for Models.
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
App::uses('Model', 'Model');
class AppModel extends Model {
	function unbindModelAll()
	{
		$unbind = array();
		foreach ($this->belongsTo as $model=>$info)
		{
			$unbind['belongsTo'][] = $model;
		}
		foreach ($this->hasOne as $model=>$info)
		{
			$unbind['hasOne'][] = $model;
		}
		foreach ($this->hasMany as $model=>$info)
		{
			$unbind['hasMany'][] = $model;
		}
		foreach ($this->hasAndBelongsToMany as $model=>$info)
		{
			$unbind['hasAndBelongsToMany'][] = $model;
    	}
		parent::unbindModel($unbind);
	}
}
?>