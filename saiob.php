<?php
require_once(WP_SOCIAL_ALL_IN_ONE_BOT_DIRECTORY.'config/settings.php');
require_once(WP_SOCIAL_ALL_IN_ONE_BOT_DIRECTORY.'lib/skinnymvc/controller/SkinnyController.php');

$c = new SkinnyController;
$c->main();

