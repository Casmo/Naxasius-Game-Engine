<?php
/*
 * Created on Nov 16, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
class UbbHelper extends AppHelper {

	var $helpers = array('html', 'Session');

    function output($message = null, $allowHtml = false, $addslashes = false) {

    	$message = preg_replace('/\%name\%/', $this->Session->read('Game.Character.name'), $message);
    	$message = preg_replace('/\%class\%/', $this->Session->read('Game.Type.name'), $message);
    	$message = preg_replace('/\%hisher\%/', 'his', $message);
    	if($allowHtml != true) {
    		$message = htmlspecialchars($message);
    	}
    	/* Items */
    	preg_match_all('/\[item\](.*?)\[\/item\]/', $message, $items);
    	if(isset($items[1]) && !empty($items[1])) {
    		// Laat de makers het niet zien...
    		App::import('Model', 'Item');
    		$Item = new Item();
    		$Item->contain();
    		$items = $Item->find('all', array('fields' => array('Item.id', 'Item.name', 'Item.quality'), 'conditions' => array('Item.name' => $items[1])));
    		foreach($items as $item) {
    			$message = str_replace('[item]'. $item['Item']['name'] .'[/item]', '<span class="item_'. $item['Item']['quality'] .'" onmouseover="showMouseInfo(url + \'items/view/'. addslashes($item['Item']['name']) .'\');" onmouseout="hideMouseInfo();">['. addslashes($item['Item']['name']) .']</span>', $message);
    		}
    	}
    	// Quests
    	preg_match_all('/\[quest\](.*?)\[\/quest\]/', $message, $quests);
    	if(isset($quests[1]) && !empty($quests[1])) {
			foreach($quests[1] as $quest) {
				$message = str_replace('[quest]'. $quest .'[/quest]', '<span class="quest" onmouseover="showMouseInfo(url + \'quests/view/'. $quest .'\');" onmouseout="hideMouseInfo();">'. htmlspecialchars($quest) .'</span>', $message);
			}
    	}
    	if($addslashes === true) {
    		$message = addslashes($message);
    	}
    	return $message;
    }
}
?>