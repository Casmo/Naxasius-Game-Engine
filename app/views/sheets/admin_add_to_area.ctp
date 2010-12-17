<?php
/*
 * Created on Aug 16, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php
echo $this->Form->create('Sheet', array('action' => 'admin_add_to_area'));
echo $this->Form->input('Sheet.id', array('options' => $sheets, 'label' => __('Sheet', true)));
echo $this->Form->input('Sheet.area_id', array('type' => 'hidden', 'value' => $area_id));
echo $this->Form->input('Sheet.x', array('type' => 'text', 'value' => '0', 'size' => '3'));
echo $this->Form->input('Sheet.y', array('type' => 'text', 'value' => '0', 'size' => '3'));
echo $this->Form->input('Sheet.z', array('type' => 'text', 'value' => '0', 'size' => '3'));
echo $this->Form->end('save');
?>
<div id="loadAreas" style="display: none;"></div>
<script type="text/javascript">
$('form#SheetAdminAddToAreaForm').ajaxForm(function(data) {
	$('div#loadAreas').html(data);
    hidePopup();
});
</script>