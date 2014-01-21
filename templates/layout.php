<?php
$mod = $_REQUEST['__module'];
$composer_menu = ''; $bulk_composer_menu = '';$smartbot_menu = ''; $queue_menu = 'queue'; $settings_menu = 'settings';
if($mod == 'smartbot')
	$smartbot_menu = 'active';
else if($mod == 'settings')
	$settings_menu = 'active';
else if($mod == 'queue')
	$queue_menu = 'active';
else
	$smartbot_menu = 'active';

?>
<!-- header starts -->
<div class = "breadcrumb" style = 'padding:5px;'> <b style = "padding-left:10px;font-size: 14px;"> <img src = "<?php echo WP_SOCIAL_ALL_IN_ONE_BOT_DIR; ?>images/icon.png" alt = "icon"> <?php echo WP_SOCIAL_ALL_IN_ONE_BOT_NAME; ?> Settings </b> </div>
<div id = "notification_saio" class = "<?php echo $this->notificationclass; ?>">
	<?php if(isset($this->notification) && !empty($this->notification)) { echo $this->notification; } ?>
</div>
<!-- nav menu starts -->
<div style = "height:10px;padding-top:10px;"> </div>
<ul class="nav nav-pills">
	<ul class="nav nav-tabs">
		<li class = "<?php echo $smartbot_menu; ?>"> <a href="admin.php?page=social-all-in-one-bot/saiob.php&__module=smartbot" class = "saio_nav_smartbot"> Smart BOT</a> </li>
		<li class = "<?php echo $queue_menu; ?>"> <a href="admin.php?page=social-all-in-one-bot/saiob.php&__module=queue" class = "saio_nav_queue"> Queue </a> </li>
		<li class = "<?php echo $settings_menu; ?>"> <a href="admin.php?page=social-all-in-one-bot/saiob.php&__module=settings" class = "saio_nav_settings"> Settings</a> </li>
	</ul>
</ul>
<!-- menu ends -->
<div style = "height:10px;padding-top:10px;"> </div>
<!-- header ends -->
<?php echo $skinny_content ?>


