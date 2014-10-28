<?php
/******************************
  Plugin Name: Social All in One Bot
  Description: A plugin that helps to share data to various social media.
  Version: 1.2.1
  Author: smackcoders.com
  Plugin URI: http://www.smackcoders.com/social-all-in-one-bot.html
  Author URI: http://www.smackcoders.com/social-all-in-one-bot.html
*/
global $wpdb;
define('WP_SOCIAL_ALL_IN_ONE_BOT_URL', 'http://www.smackcoders.com/social-all-in-one-bot.html');
define('WP_SOCIAL_ALL_IN_ONE_BOT_NAME', 'Social All in One Bot');
define('WP_SOCIAL_ALL_IN_ONE_BOT_SLUG', 'social-all-in-one-bot');
define('WP_SOCIAL_ALL_IN_ONE_BOT_SETTINGS', 'Social All in One Bot');
define('WP_SOCIAL_ALL_IN_ONE_BOT_VERSION', '1.0.0');
define('WP_SOCIAL_ALL_IN_ONE_BOT_DIR', WP_PLUGIN_URL . '/' . WP_SOCIAL_ALL_IN_ONE_BOT_SLUG . '/');
define('WP_SOCIAL_ALL_IN_ONE_BOT_DIRECTORY', plugin_dir_path( __FILE__ ));
define('WP_PLUGIN_BASE_SAIOB', WP_SOCIAL_ALL_IN_ONE_BOT_DIRECTORY);
define('WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE', $wpdb->prefix . "social_all_in_one_bot_queue");
define('WP_SOCIAL_ALL_IN_ONE_BOT_LOG_TABLE', $wpdb->prefix . "social_all_in_one_bot_log");

require_once('config/settings.php');
require_once('lib/skinnymvc/controller/SkinnyController.php');
require_once('includes/getmetainfo.class.php');
require_once('includes/saiobhelper.class.php');
require_once('lib/api/facebook/facebook.php');
require_once('lib/api/TwitterOAuth/TwitterOAuth.php');
require_once('lib/api/TwitterOAuth/OAuth_SAIO.php');
require_once('lib/api/twittercards/create_meta_box.php');
require_once('lib/api/twittercards/schema_for_twitter_card.php');
require_once('includes/socialhelper.class.php');

# Activation & Deactivation 
register_activation_hook(__FILE__, array('saiob_include_saiobhelper', 'activate') );
register_deactivation_hook(__FILE__, array('saiob_include_saiobhelper', 'deactivate') );

function saiob_action_admin_menu()
{       
	add_menu_page(WP_SOCIAL_ALL_IN_ONE_BOT_SETTINGS, WP_SOCIAL_ALL_IN_ONE_BOT_NAME, 'manage_options', __FILE__,array('saiob_include_saiobhelper','front_page') , WP_SOCIAL_ALL_IN_ONE_BOT_DIR . "/images/icon.png");
}
add_action ( "admin_menu", "saiob_action_admin_menu" );

function saiob_action_admin_init()
{
	# adding js
	if(isset ($_REQUEST['page']) && $_REQUEST['page'] == 'social-all-in-one-bot/index.php')
	{
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', plugins_url('css/jquery-ui.css', __FILE__));
	wp_register_script('saiob-collapse', plugins_url('js/bootstrap.js', __FILE__));
	wp_enqueue_script('saiob-collapse');
	wp_register_script('saiob-button', plugins_url('js/bootstrap.min.js', __FILE__));
        wp_enqueue_script('saiob-button');
	wp_register_script('social-all-in-one-js', plugins_url('js/social-all-in-one.js', __FILE__));
	wp_enqueue_script('social-all-in-one-js');
	# adding css
	wp_enqueue_style('jquery-style', plugins_url('css/jquery-ui.css', __FILE__));
	wp_enqueue_style('social-all-in-one-css', plugins_url('css/social-all-in-one.css', __FILE__));
	wp_enqueue_style('social_all_in_one_bot_font_awesome', plugins_url('css/font-awesome.css', __FILE__));
	}
}
add_action('admin_init', 'saiob_action_admin_init');
add_action('init', array('saiob_include_saiobhelper', 'register_session'));

# ajax
add_action('wp_ajax_generatemetainformation', array('saiob_include_getmetainfo', 'generatemetainformation'));
add_action('wp_ajax_saiob_gettemplate', array('saiob_include_saiobhelper','saiob_gettemplate'));
add_action('wp_ajax_saiob_deletetemplate', array('saiob_include_saiobhelper','saiob_deletetemplate'));
add_action('wp_ajax_saiob_checkbulkcomposertemplate', array('saiob_include_saiobhelper', 'saiob_checkbulkcomposertemplate'));
add_action('wp_ajax_saiob_updatebulkcomposertemplate',array('saiob_include_saiobhelper','saiob_updatebulkcomposertemplate'));
add_action('wp_ajax_saiob_storesocialkeys', array('saiob_include_saiobhelper', 'saiob_storesocialkeys'));
add_action('wp_ajax_saiob_storesmartbotinfo', array('saiob_include_saiobhelper', 'saiob_storesmartbotinfo'));
add_action('wp_ajax_saiob_storesmartbotinfo1', array('saiob_include_saiobhelper', 'saiob_storesmartbotinfo1'));
add_action('wp_ajax_saiob_deletequeueorlog', array('saiob_include_saiobhelper', 'saiob_deletequeueorlog'));
add_action('wp_ajax_saiob_clearsocialsettings', array('saiob_include_saiobhelper', 'clearsocialsettings'));
add_action('wp_ajax_saiob_deletetemplate', array('saiob_include_saiobhelper', 'deletetemplate'));
add_action('wp_ajax_saiob_checkbulkcomposertemplateandclone', array('saiob_include_saiobhelper', 'saiob_checkbulkcomposertemplateandclone'));
add_action('wp_ajax_saiob_checkproviderenabled', array('saiob_include_saiobhelper', 'saiob_checkproviderenabled'));
add_action('wp_ajax_saiob_cloningqueueorlog', array('saiob_include_saiobhelper', 'saiob_cloningqueueorlog'));
//add_action('wp_ajax_saiob_deletequeueorlog', array('saiob_include_saiobhelper', 'saiob_deletequeueorlog'));
add_action('wp_ajax_saiob_deleteItem', array('saiob_include_saiobhelper', 'saiob_deleteItem'));
add_action('wp_ajax_saiob_deleteItem1', array('saiob_include_saiobhelper', 'saiob_deleteItem1'));
add_action('wp_ajax_saiob_preview', array('saiob_include_saiobhelper', 'saiob_preview'));
add_action('wp_ajax_saiob_next', array('saiob_include_saiobhelper', 'saiob_next'));
add_action('wp_ajax_saiob_previous', array('saiob_include_saiobhelper', 'saiob_previous'));
add_action('wp_ajax_saiob_getvariation', array('saiob_include_saiobhelper', 'saiob_getvariation'));
add_action('wp_ajax_saiob_createinstantpost', array('saiob_include_saiobhelper', 'saiob_createinstantpost'));
 

# cron schedule
add_filter('cron_schedules', array('saiob_include_saiobhelper', 'cron_schedules'));
add_action('wordpress_social_all_in_one_bot_queue', array('saiob_include_saiobhelper', 'runcron'));


