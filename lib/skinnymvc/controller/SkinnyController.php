<?php
/******************************
 * filename:    SkinnyController.php
 * description: The main application controller. Every request goes through here.
 */

require_once('base/SkinnyBaseController.php');

class SkinnyController extends SkinnyBaseController 
{
	public $types = array('Page', 'Post');

	public function __construct()
	{

	}

	public function run()
	{
		// Put code here to rewrite the routing rules, or whatever.
		//
		// To make this happen, set the following fields to change the routing (and then call parent::run() )...
		//
		//     $this->module
		//     $this->action
		//     $this->param
		//
		//
		// For example, to make it so URLs like...
		//
		//     http://example.com/book/1234
		//     http://example.com/book/51238
		//     http://example.com/book/7
		//
		// ... work as if they were the URLs...
		//
		//     http://example.com/knowledgebase/item?ID=1234
		//     http://example.com/knowledgebase/item?ID=51238
		//     http://example.com/knowledgebase/item?ID=7
		//
		// ... we use the following code...
		//
		//     if (  'book' == $module  ) {
		//
		//         $ID = $this->action;
		//
		//         $this->param['GET']['ID'] = $ID;
		//         $this->module = 'knowledgebase';
		//         $this->action = 'item';
		//     }
		//
		//
		// Or for a more complex example, to make it so URLs like...
		//
		//     http://example.com/joe
		//     http://example.com/john
		//     http://example.com/jen
		//
		// ... work as if they were the URLs...
		//
		//     http://example.com/user/defaul?username=joe
		//     http://example.com/user/defaul?username=john
		//     http://example.com/user/defaul?username=jen
		//
		// ... EXCEPT in cases where there is actually a module for that, like...
		//
		//     http://example.com/settings
		//     http://example.com/about
		//     http://example.com/contact
		//
		// ... we use code like...
		//
		//     if (  ! $this->moduleExists($this->module)  ) {
		//         $this->module = 'user';
		//         $this->action = 'default';
		//         $this->param['GET']['username'] = $this->module;
		//     }
		//



		// This MUST stay here!
		parent::run();
	}

	/**
	 *  add new cron schedule
	 *  @param $param
	 *  @return array
	 **/
	public function cron_schedules($param) {
		return array('saiob_one_minute_cron' 
				=> array(
					'interval' => 60, // seconds
					'display'  => __('Every 1 minutes')
					));
	}

	public function saiob_checkbulkcomposertemplate()
	{	
		$templatename = $_REQUEST['type'];
		$mode = $_REQUEST['mode'];
		
		if($mode == 'create')	
		{
			$bulktemplate = get_option('__wp_saiob_bulkcomposer_template');	
			if(!empty($bulktemplate))
                        {
				foreach($bulktemplate as $templatekey => $singletemplate)
				{
					if($singletemplate['templatename'] == $templatename)    {
						print_r(false);die;
					}
				}
			}
		}
		print_r(true);die;
	}

	/**
	 *  plugin activate
	 **/
	function activate()
	{
		global $wpdb;
		# creating table for queue
		$socialqueue_table = WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE;
		$sociallog_table = WP_SOCIAL_ALL_IN_ONE_BOT_LOG_TABLE;
		$socialqueue_sql = "CREATE TABLE `$socialqueue_table` (
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`provider` varchar(100) DEFAULT NULL,
			`socialmessage` blob,
			`socialresponse` blob,
			`scheduledtimetorun` varchar(50) DEFAULT NULL,
			`isrun` int(1) DEFAULT '0',
			`updatedtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			`period` varchar(100) DEFAULT NULL,
			`dateorweek` varchar(100) DEFAULT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1";

		$sociallog_sql = "CREATE TABLE `$sociallog_table` (
			`logid` int(10) NOT NULL AUTO_INCREMENT,
			`provider` varchar(100) NOT NULL,
			`socialmessage` blob,
			`socialresponse` blob,
			`result` varchar(10) NOT NULL,
			`createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`logid`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($socialqueue_sql);
		dbDelta($sociallog_sql);
		# creating table ends here

		# cron to run vtiger
        	wp_schedule_event(time(), 'saiob_one_minute_cron', 'wordpress_social_all_in_one_bot_queue');
	}

	/**
	 *  plugin deactivate
	 **/
	function deactivate()
	{
		global $wpdb;
		# droping table starts here
		$socialqueue_table = WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE;
		$sociallog_table = WP_SOCIAL_ALL_IN_ONE_BOT_LOG_TABLE;
		$socialqueue_sql = "DROP TABLE IF EXISTS $socialqueue_table;";
		$sociallog_sql = "DRIP TABLE IF EXISTS $sociallog_table";
		$wpdb->query($socialqueue_sql);
		$wpdb->query($sociallog_sql);
		# droping table ends here
		delete_option('__saiob_facebookkeys');
		delete_option('__saiob_twitterkeys');
		delete_option('__wp_saiob_bulkcomposer_template');
		# clearing cron 
		wp_clear_scheduled_hook('wordpress_social_all_in_one_bot_queue');
		# clearing cron ends here
	}

	public function runcron()
	{
		global $wpdb;
		$queuetablename = WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE;
		$day  = date('l');
		$date = date('Y-d-m');
		$time = date('H:i');

		$query = "select * from $queuetablename where isrun = 0 and ((period = 'Daily') or (period = 'Weekly' and dateorweek = '$day') or (period = 'Date' and dateorweek = '$date')) and scheduledtimetorun <= '$time' and date(updatedtime) != curdate()";
		$getqueue = $wpdb->get_results($query);

		if($getqueue)
		{
			$socialhelper = new saiob_include_socialhelper();
			$saiobhelper = new saiob_include_saiobhelper();
			foreach($getqueue as $singlequeue)
			{
				$id = $singlequeue->id;
				$provider = $singlequeue->provider;
				$socialmessage = maybe_unserialize($singlequeue->socialmessage);
				if($provider == 'twitter')
				{
					$tweet = $socialmessage;
					$response = $socialhelper->tweet($tweet);
				}
				else if($provider == 'facebook')
				{
					$status = $socialmessage;
					$response = $socialhelper->fbstatus($status);	
				}

				$saiobhelper->addsociallog($response, $provider, $singlequeue->socialmessage, $id);	
				if($response['result'] == 'Succeed' && $singlequeue->period != 'Daily')	
				{
					# delete the queue when response is success and period is not daily. If period is daily we need to use again
					$wpdb->query("delete from $queuetablename where id = $id");
				}
				else
				{
					$message = mysql_real_escape_string($response['message']);
					$wpdb->query("update $queuetablename set socialresponse = '$message' where id = $id");	
				}
			}
		}
	}
} // class SkinnyController


