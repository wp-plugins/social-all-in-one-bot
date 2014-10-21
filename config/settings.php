<?php
/******************************
 * filename:    settings.php
 * description: Project settings. 
 */
global $wpdb;
DEFINE('WP_DBNAME_SOCIAL', $wpdb->dbname);
DEFINE('WP_DBHOST_SOCIAL', $wpdb->dbhost);
DEFINE('WP_DBUSER_SOCIAL', $wpdb->dbuser);
DEFINE('WP_DBPASSWORD_SOCIAL', $wpdb->dbpassword);

class SkinnySettings_saiob 
{ 
	public static $CONFIG = array(
		"project name"    => WP_SOCIAL_ALL_IN_ONE_BOT_NAME,
		"debug"           => false,
		"preload model"   => true,  # true = all model classes will be loaded with each request;
		# false = model classes will be loaded only if explicitly required (use require_once)

		"session persistency" => false, //tmp in your project dir must be writeable by the server!
		"session timeout" => 1800, //in seconds!

		"unauthenticated default module" => "bulkcomposer", //set this to where you want unauthenticated users redirected.
		"unauthenticated default action" => "index",

		"dbdriver"        => "mysql",
		"dbname"	  => WP_DBNAME_SOCIAL,	
		"dbhost" 	  => WP_DBHOST_SOCIAL,
		"dbuser"	  => WP_DBUSER_SOCIAL,
		"dbpassword"	  => WP_DBPASSWORD_SOCIAL,
      );
}

