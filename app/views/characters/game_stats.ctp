<?php
/*
 * Created on Apr 17, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<script type="text/javascript">
<?php
foreach($stats as $stat => $value) {
	?>
	var stat_<?php echo $stat; ?> = '<?php echo $value; ?>';
	<?php
}
?>
</script>