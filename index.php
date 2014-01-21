<?php
/******************************
  Plugin Name: Social All in One Bot
  Description: A plugin that helps to share data to various social media.
  Version: 1.0.0 Beta
  Author: smackcoders.com
  Plugin URI: http://www.smackcoders.com/social-all-in-one-bot.html
  Author URI: http://www.smackcoders.com/social-all-in-one-bot.html
*/
global $wpdb;
define('WP_SOCIAL_ALL_IN_ONE_BOT_URL', 'http://www.smackcoders.com/wp-social-all-in-one-bot.html');
define('WP_SOCIAL_ALL_IN_ONE_BOT_NAME', 'Social All in One Bot');
define('WP_SOCIAL_ALL_IN_ONE_BOT_SLUG', 'social-all-in-one-bot');
define('WP_SOCIAL_ALL_IN_ONE_BOT_SETTINGS', 'Social All in One Bot');
define('WP_SOCIAL_ALL_IN_ONE_BOT_VERSION', '1.0.0');
define('WP_SOCIAL_ALL_IN_ONE_BOT_DIR', WP_PLUGIN_URL . '/' . WP_SOCIAL_ALL_IN_ONE_BOT_SLUG . '/');
define('WP_SOCIAL_ALL_IN_ONE_BOT_DIRECTORY', plugin_dir_path( __FILE__ ));
define('WP_PLUGIN_BASE', WP_SOCIAL_ALL_IN_ONE_BOT_DIRECTORY);
define('WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE', $wpdb->prefix . "social_all_in_one_bot_queue");

require_once('config/settings.php');
require_once('lib/skinnymvc/controller/SkinnyController.php');
require_once('includes/getmetainfo.class.php');
require_once('includes/saiobhelper.class.php');
require_once('lib/api/facebook/facebook.php');
require_once('lib/api/TwitterOAuth/TwitterOAuth.php');
require_once('includes/socialhelper.class.php');

# Activation & Deactivation 
register_activation_hook(__FILE__, array('SkinnyController', 'activate') );
register_deactivation_hook(__FILE__, array('SkinnyController', 'deactivate') );

function action_admin_menu()
{
	add_menu_page(WP_SOCIAL_ALL_IN_ONE_BOT_SETTINGS, WP_SOCIAL_ALL_IN_ONE_BOT_NAME, 'manage_options', WP_SOCIAL_ALL_IN_ONE_BOT_SLUG.'/saiob.php', '', WP_SOCIAL_ALL_IN_ONE_BOT_DIR . "/images/icon.png");
}
add_action ( "admin_menu", "action_admin_menu" );

function action_admin_init()
{
	# adding js
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', plugins_url('css/jquery-ui.css', __FILE__));
	wp_register_script('saiob-collapse', plugins_url('js/collapse.js', __FILE__));
	wp_enqueue_script('saiob-collapse');
	wp_register_script('saiob-button', plugins_url('js/buttons.js', __FILE__));
        wp_enqueue_script('saiob-button');
	wp_register_script('social-all-in-one-js', plugins_url('js/social-all-in-one.js', __FILE__));
	wp_enqueue_script('social-all-in-one-js');
	# adding css
	wp_enqueue_style('jquery-style', plugins_url('css/jquery-ui.css', __FILE__));
	wp_enqueue_style('social-all-in-one-css', plugins_url('css/social-all-in-one.css', __FILE__));
	wp_enqueue_style('social_all_in_one_bot_font_awesome', plugins_url('css/font-awesome.css', __FILE__));
}
add_action('admin_init', 'action_admin_init');

# ajax
add_action('wp_ajax_generatemetainformation', array('SkinnyController', 'generatemetainformation'));
add_action('wp_ajax_saiob_gettemplate', array('saiob_include_saiobhelper','saiob_gettemplate'));
add_action('wp_ajax_saiob_checkbulkcomposertemplate', array('SkinnyController', 'saiob_checkbulkcomposertemplate'));
add_action('wp_ajax_saiob_storesocialkeys', array('SkinnyController', 'saiob_storesocialkeys'));
add_action('wp_ajax_saiob_storesmartbotinfo', array('saiob_include_saiobhelper', 'saiob_storesmartbotinfo'));

# cron schedule
add_filter('cron_schedules', array('SkinnyController', 'cron_schedules'));
add_action('wordpress_social_all_in_one_bot_queue', array('SkinnyController', 'runcron'));