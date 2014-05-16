<?php
/**
 * Interface Component
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
class InterfaceComponent extends Component {

	/*
	 * returns an array with menu items
	 */
	function getAdminMenu($current_controller = null) {
		$items = array(
			0 => array(
				'name' => 'Worlds',
				'link' => '/admin/maps',
				'image' => 'world.png',
				'class' => in_array($current_controller, array('Maps', 'Tiles', 'Obstacles')) ? 'selected' : ''
			),
			1 => array(
				'name' => 'Npcs',
				'link' => '/admin/npcs',
				'image' => 'npc.png',
				'class' => in_array($current_controller, array('Npcs', 'Conversations')) ? 'selected' : ''
			),
			2 => array(
				'name' => 'Mobs',
				'link' => '/admin/mobs',
				'image' => 'mob.png',
				'class' => in_array($current_controller, array('Mobs')) ? 'selected' : ''
			),
			3 => array(
				'name' => 'Quests',
				'link' => '/admin/quests',
				'image' => 'quest.png',
				'class' => in_array($current_controller, array('Quests')) ? 'selected' : ''
			),
			4 => array(
				'name' => 'Items',
				'link' => '/admin/items',
				'image' => 'item.png',
				'class' => in_array($current_controller, array('Items')) ? 'selected' : ''
			),
			5 => array(
				'name' => 'Support',
				'link' => '/admin/users',
				'image' => 'support.png',
				'class' => in_array($current_controller, array('Users', 'Characters')) ? 'selected' : ''
			),
			6 => array(
				'name' => 'Other',
				'link' => '/admin/news',
				'image' => 'other.png',
				'class' => in_array($current_controller, array('News', 'Pages', 'Texts', 'Promotions', 'Screenshots', 'Groups', 'Classes')) ? 'selected' : ''
			),
			7 => array(
				'name' => 'Help',
				'link' => '/files/documents/building-a-game-with-naxasius-game-engine.pdf',
				'image' => 'help.png',
				'class' => ''
			),
			8 => array(
				'name' => 'Logout',
				'link' => '/users/logout',
				'image' => 'logout.png',
				'class' => ''
			)
		);

		return $items;
	}

	/*
	 * returns an array with sub menu items
	 */
	function getAdminSubMenu($name = null) {

		switch($name) {

			case "Npcs":
			case "Conversations":
			$subMenus = array(
				0 => array(
					'name' => 'Npcs',
					'link' => '/admin/npcs',
					'icon' => 'shadowless/user-silhouette.png', // Relative from /img/admin/icons/small/
					'class' => $name == 'Npcs' ? 'selected' : ''
				),
				1 => array(
					'name' => 'Conversations',
					'link' => '/admin/conversations',
					'icon' => 'shadowless/balloon.png',
					'class' => $name == 'Conversations' ? 'selected' : ''
				)
			);
			break;

			case "Quests":
			$subMenus = array(
				0 => array(
					'name' => 'Quests',
					'link' => '/admin/quests',
					'icon' => 'shadowless/book.png',
					'class' => $name == 'Quests' ? 'selected' : ''
				)
			);
			break;

			case "Items":
			$subMenus = array(
				0 => array(
					'name' => 'Items',
					'link' => '/admin/items',
					'icon' => 'shadowless/cookie.png',
					'class' => $name == 'Items' ? 'selected' : ''
				)
			);
			break;

			case "Mobs":
			$subMenus = array(
				0 => array(
					'name' => 'Mobs',
					'link' => '/admin/mobs',
					'icon' => 'shadowless/bug.png',
					'class' => $name == 'Mobs' ? 'selected' : ''
				)
			);
			break;

			case "Groups":
			case "Types":
			case "News":
			case "Pages":
			case "Texts":
			case "Promotions":
			case "Screenshots":
			$subMenus = array(
				0 => array(
					'name' => 'News',
					'link' => '/admin/news',
					'icon' => 'shadowless/newspaper.png',
					'class' => $name == 'News' ? 'selected' : ''
				),
				1 => array(
					'name' => 'Pages',
					'link' => '/admin/pages',
					'icon' => 'shadowless/document-text-image.png',
					'class' => $name == 'Pages' ? 'selected' : ''
				),
				2 => array(
					'name' => 'Texts',
					'link' => '/admin/texts',
					'icon' => 'shadowless/document-text.png',
					'class' => $name == 'Texts' ? 'selected' : ''
				),
				3 => array(
					'name' => 'Promotions',
					'link' => '/admin/promotions',
					'icon' => 'shadowless/image.png',
					'class' => $name == 'Promotions' ? 'selected' : ''
				),
				4 => array(
					'name' => 'Screenshots',
					'link' => '/admin/screenshots',
					'icon' => 'shadowless/camera.png',
					'class' => $name == 'Screenshots' ? 'selected' : ''
				),
				5 => array(
					'name' => 'Groups',
					'link' => '/admin/groups',
					'icon' => 'shadowless/documents.png',
					'class' => $name == 'Groups' ? 'selected' : ''
				),
				6 => array(
					'name' => 'Classes',
					'link' => '/admin/types',
					'icon' => 'shadowless/user-detective-gray.png',
					'class' => $name == 'Classes' ? 'selected' : ''
				)
			);
			break;

			case "Users":
			case "Characters":
			$subMenus = array(
				0 => array(
					'name' => 'Users',
					'link' => '/admin/users',
					'icon' => 'shadowless/users.png',
					'class' => $name == 'Users' ? 'selected' : ''
				),
				1 => array(
					'name' => 'Characters',
					'link' => '/admin/characters',
					'icon' => 'shadowless/users.png',
					'class' => $name == 'Characters' ? 'selected' : ''
				)
			);
			break;

			default:
			$subMenus = array(
				0 => array(
					'name' => 'Maps',
					'link' => '/admin/maps',
					'icon' => 'shadowless/map.png',
					'class' => $name == 'Maps' ? 'selected' : ''
				),
				1 => array(
					'name' => 'Tiles',
					'link' => '/admin/tiles',
					'icon' => 'shadowless/zone.png',
					'class' => $name == 'Tiles' ? 'selected' : ''
				),
				2 => array(
					'name' => 'Obstacles',
					'link' => '/admin/obstacles',
					'icon' => 'shadowless/wooden-box.png',
					'class' => $name == 'Obstacles' ? 'selected' : ''
				),
				3 => array(
					'name' => 'Sheets',
					'link' => '/admin/sheets',
					'icon' => 'shadowless/block.png',
					'class' => $name == 'Sheets' ? 'selected' : ''
				)
			);
		}
		return $subMenus;
	}

	/*
	 * returns a array with pages for the website menu
	 * @todo cache it.
	 */
	function getWebsiteMenus() {
		App::import('Model', 'Page');
		$this->Page = new Page();
		$pages = $this->Page->find('all', array('conditions' => array('Page.menu' => '1'), 'order' => 'Page.order ASC'));
		return $pages;
	}

}
?>