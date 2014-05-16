<?php
/*
 * Created on Nov 15, 2009
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?php echo $title_for_layout; ?></title>
<script type="text/javascript">var url = '<?php echo $this->Html->url('/', true); ?>';</script>
<?php
echo $this->Html->script(array('j.js', '/js/admin/popup.js', '/js/admin/j.tool.js', '/js/admin/map.js', '/js/admin/admin.js', '/js/tiny_mce/jquery.tinymce.js', '/js/j.form.js'));
echo $this->Html->css(array('reset.css', 'admin.css'));
?>
</head>
<body>
<div class="container">
	<div class="topmenu_container">
		<div class="item_container">
			<?php
			foreach($headMenus as $item) {
			?>
				<span class="item <?php echo $item['class']; ?>">
				<?php echo $this->Html->link($item['name'] .'<span class="img">'. $this->Html->image('/img/admin/icons/menu/'. $item['image']) .'</span>', $item['link'], array('escape' => false)); ?>
				</span>
			<?php
			}
			?>
		</div>
	</div>
	<div class="submenu_container">
		<?php
		foreach($subMenus as $subMenu) {
			echo $this->Html->link($this->Html->image('/img/admin/icons/small/'. $subMenu['icon']) .' '. $subMenu['name'], $subMenu['link'], array('escape' => false, 'class' => $subMenu['class']));
		}
		?>
	</div>
	<div class="content_container">
		<div class="content" id="content">
		<?php echo $content_for_layout; ?>
		</div>
	</div>
</div>
<div id="popup_container">
</div>
<div id="popup"></div>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>