<?php
/*
 * Created on Nov 14, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<h1><?php echo __('Add character'); ?></h1>
<?php
echo $this->Form->create('Character', array('action' => 'add'));
echo $this->Form->input('Character.type_id', array('label' => __('Class', true)));
echo $this->Form->input('Character.name');
echo '<div class="input text"><label>Avatar</label></div>';
foreach($avatars as $i => $avatar) {
	$checked = isset($this->data['Character']['avatar_id']) && $this->data['Character']['avatar_id'] == $avatar['Avatar']['id'] ? 'checked' : '';
	echo '<label for="inputAvatar'. $i .'">'. $this->Html->image('/img/game/avatars/'. $avatar['Avatar']['image_map'] .'/big.png') .'</label>';
	echo '<input type="radio" name="data[Character][avatar_id]" id="inputAvatar'. $i .'" value="'. $avatar['Avatar']['id'] .'" '. $checked .'>';
}
if(isset($this->validationErrors['Character']['avatar_id'])) {
	echo '<div class="error-message">'. $this->validationErrors['Character']['avatar_id'] .'</div>';
}
echo $this->Form->end('create', array('label' => __('Create', true)));
?>