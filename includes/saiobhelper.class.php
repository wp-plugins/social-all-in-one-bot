<?php
class saiob_include_saiobhelper
{
        // // @var string CSV upload directory name
        public $uploadDir = 'saiob_image';
      
        public function getUploadDirectory($check = 'plugin_uploads') {
                $upload_dir = wp_upload_dir();
                  if($check =='default'){
                     return $upload_dir ['basedir'] . "/";
                  }
          
                elseif($check == 'plugin_uploads') {
                     return $upload_dir ['basedir'] . "/" . $this->uploadDir;
                 }
        }
	public function saiob_cloningqueueorlog()
	{
		global $wpdb;
		$mod = $_REQUEST['mod'];
		$id = $_REQUEST['id'];
		$queue_table = WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE;
		$log_table = WP_SOCIAL_ALL_IN_ONE_BOT_LOG_TABLE;
		$sql = '';
		$createdtime = date('Y-m-d H:i:s');
		$response = $wpdb->get_results("select * from wp_social_all_in_one_bot_queue where id = $id");
		$sql = "insert into $queue_table (provider, socialmessage, scheduledtimetorun, period, dateorweek, createdtime) values ('{$response[0]->provider}', '{$response[0]->socialmessage}', '{$response[0]->scheduledtimetorun}', '{$response[0]->period}', '{$response[0]->dateorweek}', '$createdtime')";
		
		$response = $wpdb->query($sql);
		if($response == 1)	
		{
			$result['msg'] = 'Cloned successfully';
                        $result['msgclass'] = 'success';
		}
		else
		{
			$result['msg'] = 'Error occured while cloning';
			$result['msgclass'] = 'danger';
		}
		print_r(wp_send_json($result));die;
	}

	public function saiob_deleteItem()
	{	global $wpdb;
		$checked=$_REQUEST['checked'];$queue_table = WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE;
			foreach($checked as $key => $idno)
				{
  				  $checked[$key] = explode('_', $idno);
				}
			foreach($checked as $key)
				{
				$sql = "delete from $queue_table where id = '{$key[1]}'";
				$response = $wpdb->query($sql);
			//		echo $key[1];
				}
		
print_r("Successfully Deleted");die;
	}	
public static function saiob_deleteItem1()
	{	global $wpdb;
		$checked=$_REQUEST['checked'];
		$log_table = WP_SOCIAL_ALL_IN_ONE_BOT_LOG_TABLE;
			foreach($checked as $key => $idno)
				{
  				  $checked[$key] = explode('_', $idno);
				}
			foreach($checked as $key)
				{
				$sql = "delete from $log_table where logid = '{$key[1]}'";
				$response = $wpdb->query($sql);
		//			echo $key[1];

			}
				
print_r("Successfully Deleted");die;
	}	

	public static $types = array('Post', 'Page');

	public function __construct()
	{

	}

	public static function register_session()
	{
		if( !session_id())
			session_start();
	}

	/**
	 * helps to remove api keys from settings module
	 **/
	public function clearsocialsettings()
	{
		$type = $_REQUEST['type'];
		$result = array(); $msg  = array();
		switch($type)
		{
			case "facebook":
				$facebook = saiob_include_saiobhelper::clearsocialkeys($type);
				update_option('__saiob_facebookkeys', $facebook);
				$msg = 'Cleared Facebook API Keys';
				break;
			case "twitter":
				$twitter = saiob_include_saiobhelper::clearsocialkeys($type);
				update_option('__saiob_twitterkeys', $twitter);
				$msg = 'Cleared Twitter API Keys';
				break;
			case "all":
				$social_service = array('facebook', 'twitter');
				foreach($social_service as $single_service)
				{
					$service_response = array();
					$service_response = saiob_include_saiobhelper::clearsocialkeys($single_service);
					update_option("__saiob_{$single_service}keys", $service_response);
				}
				$msg = 'Cleared All Social API Keys';
				break;
		}
		$result['msg'] = $msg;
		$result['msgclass'] = 'success';
		print_r(wp_send_json($result));die;
	}

	/**
 	 * check whether provider is enabled on settings
	 * @param string $provider
	 **/
	public static function saiob_checkproviderenabled()
	{
		$data = array();
		$provider = $_REQUEST['provider'];
		$data['msg'] = "$provider is not enabled in settings. Please enable it";
		$data['msgclass'] = "danger";
		$provider_keys = get_option('__saiob_'.$provider.'keys');
		if(!empty($provider_keys) && isset($provider_keys['status']) && $provider_keys['status'] == 'on')
		{
			$data['msg'] = "$provider is enabled";
			$data['msgclass'] = 'success';
		}
		print_r(wp_send_json($data));die;
	}

	/**
	 * function will delete template
	 **/
	public function saiob_deletetemplate()
	{
             
                $result = array();
		$id = $_REQUEST['id'];
                
                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
		$result['msg'] = 'Error while deleting template';
                $result['msgclass'] = 'danger';
		foreach($bulktemplate as $templatekey => $singletemplate)
		{
                 if($id == $templatekey)
			{
			        unset($bulktemplate[$templatekey]);
				update_option('__wp_saiob_bulkcomposer_template', $bulktemplate);
				$result['msg'] = 'Deleted the template successfully';
		                $result['msgclass'] = 'success';
				break;
			}
		}
		print_r(wp_send_json($result));die;
	}

	/**
	 * clear social key values for given social service
	 * @param string $name ** social service name for eg) facebook, twitter **
	 **/
	public static function clearsocialkeys($name)
	{
		$old = get_option("__saiob_{$name}keys");
		$enabled = $old['status'];
		$new = array();
		#$new['status'] = $enabled;
		return $new;
	}

	public function saiob_deletequeueorlog()
	{
		global $wpdb;
		$mod = $_REQUEST['mod'];
		$id = $_REQUEST['id'];
		$queue_table = WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE;
		$log_table = WP_SOCIAL_ALL_IN_ONE_BOT_LOG_TABLE;
		$sql = '';
		if($mod == 'queue')
			$sql = "delete from $queue_table where id = '$id'";
		else if($mod == 'log')
			$sql = "delete from $log_table where logid = '$id'";

		$response = $wpdb->query($sql);
		if($response == 1)	
		{
			$result['msg'] = 'Deleted Successfully';
                        $result['msgclass'] = 'success';
		}
		else
		{
			$result['msg'] = 'Error occured while deleting';
			$result['msgclass'] = 'danger';
		}
		print_r(wp_send_json($result));die;
	}

	/**
	 * add social log 
	 * @param array $response ** contains message and class **
	 * @param string $provider
	 * @param string $socialmessage
	 * @param int $queueid
	 **/
	public function addsociallog($response, $provider, $socialmessage, $queueid)
	{
		global $wpdb;
		$socialresponse = mysql_real_escape_string($response['message']);
		$messagestatus = mysql_real_escape_string($response['result']);
		$socialmessage = mysql_real_escape_string($socialmessage);
		$logtable = WP_SOCIAL_ALL_IN_ONE_BOT_LOG_TABLE;
		$addlog_query = "insert into $logtable (provider, socialmessage, socialresponse, result) values ('$provider', '$socialmessage', '$socialresponse', '$messagestatus')";
		$wpdb->query($addlog_query);
		return true;
	}

	/**
         *  store social app keys
         *  @param string $provider (facebook, linkedin, twitter ...)
         *  @param value $value
         **/
        public function saiob_storesocialkeys()
        {
                $provider = $_REQUEST['provider'];
                $value = $_REQUEST['value'];
                if($provider == 'facebook')     
		{
                        update_option('__saiob_facebookkeys', $value);
                        print_r('Facebook keys updated successfully');
                }
                else if($provider == 'twitter')
                {
			# check whether twitter api keys are correct. If so update the keys else dont
			$socialhelper = new saiob_include_socialhelper();
			$config = array(
                                'consumer_key' => $value[0],
                                'consumer_secret' => $value[1],
                                'oauth_token' => $value[2],
                                'oauth_token_secret' => $value[3],
                                'output_format' => 'array'
                               );	

			$response = $socialhelper->validatetwitter($config);
			if(!isset($response['errors']))
			{
				$value['status'] = $value[4]; unset($value[4]);
                        	update_option('__saiob_twitterkeys', $value);
				$result['msg'] = 'Twitter keys updated successfully';
                                $result['msgclass'] = 'success';
			}
			else
			{
				$errormsg = "";
				foreach($response['errors'] as $singleerror)
				{
					$errormsg .= "{$singleerror['message']} - Code: {$singleerror['code']} ";
				}
				$result['msg'] = 'Twitter keys are not updated. Error: '.$errormsg;
				$result['msgclass'] = 'danger';
			}
                }
		print_r(wp_send_json($result));
                die;
        }

        /**
         *  generate tweet/fbstatus and update it on queue
         *  @param string $_REQUEST['provider']
         *  @param array $_REQUEST['value']
         */
        public static function saiob_storesmartbotinfo()
        {       global $wpdb;
                $skinny = new SkinnyController_saiob();
                $metainfo = new saiob_include_getmetainfo();

                $templatename=$_REQUEST['templatename']; 
                $metavalue = $_REQUEST['value'];
                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                # get template
                foreach($bulktemplate as $bulktemplatekey => $bulktemplateval)
                {
                        if($bulktemplateval['templatename'] == $templatename)
                        {
                              $saiob=maybe_unserialize($bulktemplateval['value']);
                              $twitter_provider=isset($saiob['twitter_provider']) ? $saiob['twitter_provider'] : '';
                              $facebook_provider=isset($saiob['facebook_provider']) ? $saiob['facebook_provider'] : '';
                              if(isset($twitter_provider) && $twitter_provider == 'on')
                                {
                                  
                                  $provider = 'twitter' ;
                                }
                              if(isset($facebook_provider) && $facebook_provider == 'on')
                                {
                                 
                                  $provider ='facebook'  ;
                                }
                            if(isset($provider) && $provider == 'twitter')
			      {
                                      $values=array();
				      $values[0] = isset($saiob['twitterbot_maxchars']) ?  $saiob['twitterbot_maxchars'] : '' ;
				      $values[1] = isset($saiob['twitterbot_tags']) ? $saiob['twitterbot_tags'] : '';
				      $values[2] = isset($saiob['twitterbot_tag_rotate']) ? $saiob['twitterbot_tag_rotate'] : '';
				      $values[3] = isset($saiob['twitterbot_tag_nos'])  ?  $saiob['twitterbot_tags'] : '';
				      $values[4] = isset($saiob['twitterbot_calltoactions'])  ? $saiob['twitterbot_tags'] : '';
				      $values[5] = isset($saiob['twitterbot_action_rotate'])  ? $saiob['twitterbot_action_rotate'] : '';
				      $values[6] = isset($saiob['twitterbot_frequency'])  ?  $saiob['twitterbot_frequency'] : '';
				      $values[7] = isset($saiob['twitterbot_period']) ?  $saiob['twitterbot_period'] : '';
				      $values[8] = isset($saiob['twitterbot_hours_from']) ?  $saiob['twitterbot_hours_from'] : '';
				      $values[9] = isset($saiob['twitterbot_hours_to'])  ? $saiob['twitterbot_hours_to'] : '';
				      $values[10] = $templatename;
				      $values[11] = isset($saiob['twitterbot_weekly']) ? $saiob['twitterbot_weekly'] : '';
				      $values[12] = isset($saiob['twitterbot_fromdate']) ?  $saiob['twitterbot_fromdate'] : '';
				      $values[13] = isset($saiob['twitterbot_todate']) ? $saiob['twitterbot_todate'] : '';
                                     // echo '<pre>'; print_r($values[2]); die('coming');
			      
			      }
			       if(isset($provider) && $provider == 'facebook')
			      {
				      $values[0] = isset($saiob['facebookbot_maxchars']) ? $saiob['facebookbot_maxchars'] : '';
				      $values[4] = isset($saiob['facebookbot_calltoactions']) ?  $saiob['facebookbot_calltoactions'] : '';
				      $values[5] = isset($saiob['facebookbot_action_rotate']) ?  $saiob['facebookbot_action_rotate'] :'';
				      $values[6] = isset($saiob['facebookbot_frequency']) ? $saiob['facebookbot_frequency'] : '';
				      $values[7] = isset($saiob['facebookbot_period']) ? $saiob['facebookbot_period'] : '';
				      $values[8] = isset($saiob['facebookbot_hours_from']) ?  $saiob['facebookbot_hours_from'] : '';
				      $values[9] = isset($saiob['facebookbot_hours_to']) ?  $saiob['facebookbot_hours_to'] : '';
				      $values[10] = $templatename;
				      $values[11] = isset($saiob['facebookbot_weekly']) ? $saiob['facebookbot_weekly'] : '';
				      $values[12] = isset($saiob['facebookbot_fromdate']) ?  $saiob['facebookbot_weekly'] : '';
				      $values[13] = isset($saiob['facebookbot_todate']) ?  $saiob['facebookbot_todate'] : '';
			      }

                              # generate query to get all the post / pages
                                $type = $metavalue[12];
                                $where = "where post_type = '$type' ";
                                $stype = $metavalue['0'];
                                if($stype == 'ID')
                                {
                                        $from   = $metavalue['3'];
                                        $to     = $metavalue['4'];
                                        $where .= " and id >= '$from' and id <= '$to' ";
                                }
                                else
                                {
                                        $from   = $metavalue['1'];
                                        $to     = $metavalue['2'];
                                        $where .= " and post_date >= '$from' and post_date <= '$to'";
                                }
                                # only published post/page are allowed
                                $where .= " and post_status = 'publish'";
                                $query = "select * from wp_posts $where";
                                $getposts = $wpdb->get_results($query);
                                $postcount    = count($getposts);
                                if($postcount != 0)
                                        $timeinterval = $metainfo->scheduletime($postcount, $values);

                                $fromtime = $values[8];

                                if($getposts)
                                {
                                        $formattedfromtime = strtotime($fromtime);
                                        foreach($getposts as $singlepost)
                                        {
                                                $formattedfromtime = date("H:i", strtotime("+$timeinterval minutes", $formattedfromtime));
                                                $url             = $metainfo->makeurl($type, $singlepost->ID);
                                                $variation_one   = $metainfo->getvariationone($bulktemplateval, $values, $provider, $singlepost, $url, $formattedfromtime, $singlepost->ID);
                                                $variation_two   = $metainfo->getvariationtwo($bulktemplateval, $values, $provider, $singlepost, $url, $formattedfromtime);
                                                $variation_three = $metainfo->getvariationthree($bulktemplateval, $values, $provider, $singlepost, $url, $formattedfromtime);
                                                $formattedfromtime = strtotime($formattedfromtime);
                                        }
                                }
                        }
                }
                print_r(" smartbot updated successfully");
                die();
        }


	public static function saiob_storesmartbotinfo1()
        {       global $wpdb;
                $skinny = new SkinnyController_saiob();
                $metainfo = new saiob_include_getmetainfo();

                $templatename=$_REQUEST['templatename']; 
                $metavalue = $_REQUEST['value'];
                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                # get template
                foreach($bulktemplate as $bulktemplatekey => $bulktemplateval)
                {
                        if($bulktemplateval['templatename'] == $templatename)
                        {
                              $saiob=maybe_unserialize($bulktemplateval['value']);
                              $twitter_provider=isset($saiob['twitter_provider']) ? $saiob['twitter_provider'] : '';
                              $facebook_provider=isset($saiob['facebook_provider']) ? $saiob['facebook_provider'] : '';
                              if(isset($twitter_provider) && $twitter_provider == 'on')
                                {
                                  
                                  $provider = 'twitter' ;
                                }
                              if(isset($facebook_provider) && $facebook_provider == 'on')
                                {
                                 
                                  $provider ='facebook'  ;
                                }
                            if(isset($provider) && $provider == 'twitter')
			      {
                                      $values=array();
				      $values[0] = isset($saiob['twitterbot_maxchars']) ?  $saiob['twitterbot_maxchars'] : '' ;
				      $values[1] = isset($saiob['twitterbot_tags']) ? $saiob['twitterbot_tags'] : '';
				      $values[2] = isset($saiob['twitterbot_tag_rotate']) ? $saiob['twitterbot_tag_rotate'] : '';
				      $values[3] = isset($saiob['twitterbot_tag_nos'])  ?  $saiob['twitterbot_tags'] : '';
				      $values[4] = isset($saiob['twitterbot_calltoactions'])  ? $saiob['twitterbot_tags'] : '';
				      $values[5] = isset($saiob['twitterbot_action_rotate'])  ? $saiob['twitterbot_action_rotate'] : '';
				      $values[6] = isset($saiob['twitterbot_frequency'])  ?  $saiob['twitterbot_frequency'] : '';
				      $values[7] = isset($saiob['twitterbot_period']) ?  $saiob['twitterbot_period'] : '';
				      $values[8] = isset($saiob['twitterbot_hours_from']) ?  $saiob['twitterbot_hours_from'] : '';
				      $values[9] = isset($saiob['twitterbot_hours_to'])  ? $saiob['twitterbot_hours_to'] : '';
				      $values[10] = $templatename;
				      $values[11] = isset($saiob['twitterbot_weekly']) ? $saiob['twitterbot_weekly'] : '';
				      $values[12] = isset($saiob['twitterbot_fromdate']) ?  $saiob['twitterbot_fromdate'] : '';
				      $values[13] = isset($saiob['twitterbot_todate']) ? $saiob['twitterbot_todate'] : '';
                                     // echo '<pre>'; print_r($values[2]); die('coming');
			      
			      }
			       if(isset($provider) && $provider == 'facebook')
			      {
				      $values[0] = isset($saiob['facebookbot_maxchars']) ? $saiob['facebookbot_maxchars'] : '';
				      $values[4] = isset($saiob['facebookbot_calltoactions']) ?  $saiob['facebookbot_calltoactions'] : '';
				      $values[5] = isset($saiob['facebookbot_action_rotate']) ?  $saiob['facebookbot_action_rotate'] :'';
				      $values[6] = isset($saiob['facebookbot_frequency']) ? $saiob['facebookbot_frequency'] : '';
				      $values[7] = isset($saiob['facebookbot_period']) ? $saiob['facebookbot_period'] : '';
				      $values[8] = isset($saiob['facebookbot_hours_from']) ?  $saiob['facebookbot_hours_from'] : '';
				      $values[9] = isset($saiob['facebookbot_hours_to']) ?  $saiob['facebookbot_hours_to'] : '';
				      $values[10] = $templatename;
				      $values[11] = isset($saiob['facebookbot_weekly']) ? $saiob['facebookbot_weekly'] : '';
				      $values[12] = isset($saiob['facebookbot_fromdate']) ?  $saiob['facebookbot_weekly'] : '';
				      $values[13] = isset($saiob['facebookbot_todate']) ?  $saiob['facebookbot_todate'] : '';
			      }

                              # generate query to get all the post / pages
                                $type = $metavalue[12];
                                $where = "where post_type = '$type' ";
                                $stype = $metavalue['0'];
                                if($stype == 'ID')
                                {
                                        $from   = $metavalue['3'];
                                        $to     = $metavalue['4'];
                                        $where .= " and id >= '$from' and id <= '$to' ";
                                }
                                else
                                {
                                        $from   = $metavalue['1'];
                                        $to     = $metavalue['2'];
                                        $where .= " and post_date >= '$from' and post_date <= '$to'";
                                }
                                # only published post/page are allowed
                                $where .= " and post_status = 'publish'";
                                $query = "select * from wp_posts $where";
                                $getposts = $wpdb->get_results($query);
                                $postcount    = count($getposts);
				$postpage = 3 * $postcount;

				update_option('__wp_saiob_post_id' , '');
				update_option('__wp_saiob_variation' , '');
                                $getpost = $wpdb->get_results("select * from wp_posts $where order by ID");//echo '<pre>';print_r($getpost);die('kavi');
				foreach ( $getpost as $postresult )
				{
					$postcontent = $postresult->post_content;
                                        $postitle = $postresult->post_title;
                                        $postid = $postresult->ID;//echo '<pre>';print_r($postid);die('kavi');
					preg_match_all('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/si', $postcontent, $header);//echo '<pre>';print_r($header);die('sw');
				$htag = count($header[1]);//echo '<pre>';print_r($htag);//die('dc');
				preg_match_all('/<img[^>]+>/i', $postcontent, $image);//echo '<pre>';print_r($image);die('dc');
                               	$img = count($image[0]);//echo '<pre>';print_r($img);die('dc');
				$pct = preg_replace("/<img[^>]+\>/i", "", $postcontent);
                             	$val = preg_replace('#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#', '', $pct);
				if ( $htag >0 && $htag <2 )
				{
					$id = $postid;
					$title = $header[1][0];//echo '<pre>';print_r($title);die('df');
					$stringCut = substr($val, 0, 270);
                                        $content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
					if ($img > 0 )
						$content .= $image[0][0];
					$finalresult = array ( array (
                                        	'ID' => $id,
                                             	'post_title' => $title,
                                                'post_content' => $content )
							
                                        	);
					update_option('__wp_saiob_variation' , $finalresult);
				}
					
				if ( $htag >=2 && $htag <3 )
				{
					$id = $postid;
                                       	$title = $header[1][0];//echo '<pre>';print_r($title);die('df');
                                        $stringCut = substr($val, 0, 270);
                                      	$content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
                                      	if ($img > 0 )
                                 		$content .= $image[0][0];
					$id1 = $postid;
                                     	$title1 = $header[1][1];//echo '<pre>';print_r($title);die('df');
                                      	$stringCut1 = substr($val, 300, 650);
                                  	$content1 = substr($stringCut1, 300, strrpos($stringCut1, ' ')).'...';
                                     	if ($img > 0 && $img <=1 )
                                     		$content1 .= $image[0][1];
					else 
						$content1 .= $image[0][0];
					$finalresult = array ( array (
						'ID' => $id,
                                               	'post_title' => $title,
                                               	'post_content' => $content ),
						array ( 'ID' => $id1,
                                                        'post_title' => $title1,
                                                        'post_content' => $content1 )	
						);
                                                update_option('__wp_saiob_variation' , $finalresult);
				}

				if ( $htag >=3 && $htag <4 )
                             	{
					$id = $postid;
                                  	$title = $header[1][0];//echo '<pre>';print_r($title);die('df');
                                     	$stringCut = substr($val, 0, 270);
                                    	$content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
                                    	if ($img > 0 )
                                     		$content .= $image[0][0];
                                    	$id1 = $postid;
                                       	$title1 = $header[1][1];//echo '<pre>';print_r($title);die('df');
                                        $stringCut1 = substr($val, 300, 650);
                                       	$content1 = substr($stringCut1, 300, strrpos($stringCut1, ' ')).'...';
                                    	if ($img > 0 && $img <=1 )
                                        	$content1 .= $image[0][1];
                                     	else
                                        	$content1 .= $image[0][0];
                                       	$id2 = $postid;
                                       	$title2 = $header[1][2];//echo '<pre>';print_r($title);die('df');
                                    	$stringCut2 = substr($val, 700, 950);
                                      	$content2 = substr($stringCut2, 700, strrpos($stringCut2, ' ')).'...';
                                      	if ($img > 0 && $img <=2 )
                                    		$content2 .= $image[0][1];
					else
						$content2 .= $image[0][0];
					$finalresult = array ( array (
                                       		'ID' => $id,
                                           	'post_title' => $title,
                                              	'post_content' => $content ),
                                             	array ( 'ID' => $id1,
                                              	'post_title' => $title1,
                                          	'post_content' => $content1 ),
						array ( 'ID' => $id2,
                                             	'post_title' => $title2,
                                        	'post_content' => $content2 )   );
                                	update_option('__wp_saiob_variation' , $finalresult);
              			}
				if ( $htag >=4 )
                           	{
					$id = $postid;
                                    	$title = $header[1][0];//echo '<pre>';print_r($title);die('df');
                                   	$stringCut = substr($val, 0, 270);
                                	$content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
                                 	if ($img > 0 )
                                   		$content .= $image[0][0];
                                      	$id1 = $postid;
                                  	$title1 = $header[1][1];//echo '<pre>';print_r($title);die('df');
                                 	$stringCut1 = substr($val, 300, 650);
                                	$content1 = substr($stringCut1, 300, strrpos($stringCut1, ' ')).'...';
                                   	if ($img > 0 && $img <=1 )
                                  		$content1 .= $image[0][1];
                               		else
                                      		$content1 .= $image[0][0];
                                 	$id2 = $postid;
                                    	$title2 = $header[1][2];//echo '<pre>';print_r($title);die('df');
                                   	$stringCut2 = substr($val, 700, 950);
                               		$content2 = substr($stringCut2, 700, strrpos($stringCut2, ' ')).'...';
                                     	if ($img > 0 && $img <=2 )
                                            	$content2 .= $image[0][1];
                                    	else
                                       		$content2 .= $image[0][0];
                                	$finalresult = array ( array (
                                          	'ID' => $id,
                                              	'post_title' => $title,
                                          	'post_content' => $content ),
                                            	array ( 'ID' => $id1,
                                             	'post_title' => $title1,
                                               	'post_content' => $content1 ),
                                           	array ( 'ID' => $id2,
                                              	'post_title' => $title2,
                                           	'post_content' => $content2 )   );
                                 	update_option('__wp_saiob_variation' , $finalresult);
                   		}
				if ( $htag == 0 ) 
				{
					$id3 = $postid;
                                 	$title3 = $postitle;
                                     	$stringCut3 = substr($val, 0, 270);
                                     	$content3 = substr($stringCut3, 0, strrpos($stringCut3, ' ')).'...';
                                  	$content3 .= $image[0][0];
					$finalresult = array ( array (
                                     		'ID' => $id3,
                                            	'post_title' => $title3,
                                            	'post_content' => $content3 )
                                                );
                                  	update_option('__wp_saiob_variation' , $finalresult);
				}
	
				$variation = get_option('__wp_saiob_variation');
                             	$set = count($variation);
				$container = "<input type = 'hidden' id='total_variation' value='$set'>";
				}
                                update_option('__wp_saiob_post_id' , $getpost);

				print_r("Post chosen - ". $postcount."&emsp;&emsp;Post variations - ".$postpage);

				$ans = get_option('__wp_saiob_post_id');
                                
                		foreach($ans as $value1) {
                			$ab1[]=$value1->ID; }
                		$array_val = json_encode($ab1);
                		$v1=count($ab1);
                		$container .= "<input type = 'hidden' id='first' value='$ab1[0]'>";
                		$container .= "<input type = 'hidden' id='next' value='$ab1[1]'>";
                		$container .= "<input type = 'hidden' id='prev' value='$ab1[1]'>";
                		$container .= "<input type = 'hidden' id='count' value='$v1'>";
                		$container .= "<input type = 'hidden' id='array_val' value='$array_val'>";
				$container .=	"<input type = 'hidden' id='curent_variation' value=1>";
                		foreach ($ans as $rep) {
                        		$valid = $rep->ID; }
                		$container .=  "<input type = 'hidden' id='last' value='$valid'>";

				print_r($container);
				die();
			}
		}
        }


	/**
	 * add template on option values
	 * check whether already name exists If so return false else true
	 **/
	public function saiob_checkbulkcomposertemplateandclone()
        {
                $new_templatename = $_REQUEST['newname'];
		$selected_templatename = $_REQUEST['selname'];
		$result = array();
		$result['msg'] = 'Template Name Already Exists';
                $result['msgclass'] = 'danger';

                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
		if(!empty($bulktemplate))
		{
			foreach($bulktemplate as $templatekey => $singletemplate)
			{
				if($singletemplate['templatename'] == $new_templatename)    {
					print_r(wp_send_json($result));die;
				}
			}
		}

		foreach($bulktemplate as $templatekey => $singletemplate)
		{
			if($selected_templatename == $singletemplate['templatename'])
			{
				$copy_singletemplate[] = $singletemplate;
				# change the name of the template alone
				$copy_singletemplate[0]['templatename'] = $new_templatename;
				# merging orignal template array with copy of single template
				$updated_bulktemplate = array_merge($bulktemplate, $copy_singletemplate);
				# updating the template options
				update_option('__wp_saiob_bulkcomposer_template', $updated_bulktemplate);
				$result['msg'] = 'Template cloned successfully';
		                $result['msgclass'] = 'success';
				break;
			}
		}
		print_r(wp_send_json($result));die;
        }


	/**
	 * add template on option values
	 * check whether already name exists If so return false else true
	 **/
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
         *  return container HTML for bulk composer
         *  @param string $templatename
         *  @return HTML $container
         **/
	public function saiob_preview()
	{
		global $wpdb;
		$skinny = new SkinnyController_saiob();
                $metainfo = new saiob_include_getmetainfo();

                $templatename=$_REQUEST['templatename']; 
                $metavalue = $_REQUEST['value'];
                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                # get template
                foreach($bulktemplate as $bulktemplatekey => $bulktemplateval)
                {
                        if($bulktemplateval['templatename'] == $templatename)
                        {
                              $saiob=maybe_unserialize($bulktemplateval['value']);
                              $twitter_provider=isset($saiob['twitter_provider']) ? $saiob['twitter_provider'] : '';
                              $facebook_provider=isset($saiob['facebook_provider']) ? $saiob['facebook_provider'] : '';
                              if(isset($twitter_provider) && $twitter_provider == 'on')
                                {
                                  
                                  $provider = 'twitter' ;
                                }
                              if(isset($facebook_provider) && $facebook_provider == 'on')
                                {
                                 
                                  $provider ='facebook'  ;
                                }
                                # only published post/page are allowed
				$firstid = $_REQUEST['id'];//echo '<pre>';print_r($firstid);die('sx');
				$postresult = $wpdb->get_results("select * from wp_posts where ID = $firstid");
				$postcontent = $postresult[0]->post_content;
                            	$postitle = $postresult[0]->post_title;
                              	$postid = $postresult[0]->ID;

				preg_match_all('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/si', $postcontent, $header);//echo '<pre>';print_r($header);die('sw');
				$htag = count($header[1]);//echo '<pre>';print_r($htag);//die('dc');
				preg_match_all('/<img[^>]+>/i', $postcontent, $image);//echo '<pre>';print_r($image);die('dc');
                               	$img = count($image[0]);//echo '<pre>';print_r($img);die('dc');
				$pct = preg_replace("/<img[^>]+\>/i", "", $postcontent);
                             	$val = preg_replace('#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#', '', $pct);
				if ( $htag >0 && $htag <2 )
				{
					$id = $postid;
					$title = $header[1][0];//echo '<pre>';print_r($title);die('df');
					$stringCut = substr($val, 0, 270);
                                        $content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
					if ($img > 0 )
						$content .= $image[0][0];
					$finalresult = array ( array (
                                        	'ID' => $id,
                                             	'post_title' => $title,
                                                'post_content' => $content )
							
                                        	);
					update_option('__wp_saiob_variation' , $finalresult);
				}
					
				if ( $htag >=2 && $htag <3 )
				{
					$id = $postid;
                                       	$title = $header[1][0];//echo '<pre>';print_r($title);die('df');
                                        $stringCut = substr($val, 0, 270);
                                      	$content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
                                      	if ($img > 0 )
                                 		$content .= $image[0][0];
					$id1 = $postid;
                                     	$title1 = $header[1][1];//echo '<pre>';print_r($title);die('df');
                                      	$stringCut1 = substr($val, 300, 650);
                                  	$content1 = substr($stringCut1, 300, strrpos($stringCut1, ' ')).'...';
                                     	if ($img > 0 && $img <=1 )
                                     		$content1 .= $image[0][1];
					else 
						$content1 .= $image[0][0];
					$finalresult = array ( array (
						'ID' => $id,
                                               	'post_title' => $title,
                                               	'post_content' => $content ),
						array ( 'ID' => $id1,
                                                        'post_title' => $title1,
                                                        'post_content' => $content1 )	
						);
                                                update_option('__wp_saiob_variation' , $finalresult);
				}

				if ( $htag >=3 && $htag <4 )
                             	{
					$id = $postid;
                                  	$title = $header[1][0];//echo '<pre>';print_r($title);die('df');
                                     	$stringCut = substr($val, 0, 270);
                                    	$content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
                                    	if ($img > 0 )
                                     		$content .= $image[0][0];
                                    	$id1 = $postid;
                                       	$title1 = $header[1][1];//echo '<pre>';print_r($title);die('df');
                                        $stringCut1 = substr($val, 300, 650);
                                       	$content1 = substr($stringCut1, 300, strrpos($stringCut1, ' ')).'...';
                                    	if ($img > 0 && $img <=1 )
                                        	$content1 .= $image[0][1];
                                     	else
                                        	$content1 .= $image[0][0];
                                       	$id2 = $postid;
                                       	$title2 = $header[1][2];//echo '<pre>';print_r($title);die('df');
                                    	$stringCut2 = substr($val, 700, 950);
                                      	$content2 = substr($stringCut2, 700, strrpos($stringCut2, ' ')).'...';
                                      	if ($img > 0 && $img <=2 )
                                    		$content2 .= $image[0][1];
					else
						$content2 .= $image[0][0];
					$finalresult = array ( array (
                                       		'ID' => $id,
                                           	'post_title' => $title,
                                              	'post_content' => $content ),
                                             	array ( 'ID' => $id1,
                                              	'post_title' => $title1,
                                          	'post_content' => $content1 ),
						array ( 'ID' => $id2,
                                             	'post_title' => $title2,
                                        	'post_content' => $content2 )   );
                                	update_option('__wp_saiob_variation' , $finalresult);
              			}
				if ( $htag >=4 )
                           	{
					$id = $postid;
                                    	$title = $header[1][0];//echo '<pre>';print_r($title);die('df');
                                   	$stringCut = substr($val, 0, 270);
                                	$content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
                                 	if ($img > 0 )
                                   		$content .= $image[0][0];
                                      	$id1 = $postid;
                                  	$title1 = $header[1][1];//echo '<pre>';print_r($title);die('df');
                                 	$stringCut1 = substr($val, 300, 650);
                                	$content1 = substr($stringCut1, 300, strrpos($stringCut1, ' ')).'...';
                                   	if ($img > 0 && $img <=1 )
                                  		$content1 .= $image[0][1];
                               		else
                                      		$content1 .= $image[0][0];
                                 	$id2 = $postid;
                                    	$title2 = $header[1][2];//echo '<pre>';print_r($title);die('df');
                                   	$stringCut2 = substr($val, 700, 950);
                               		$content2 = substr($stringCut2, 700, strrpos($stringCut2, ' ')).'...';
                                     	if ($img > 0 && $img <=2 )
                                            	$content2 .= $image[0][1];
                                    	else
                                       		$content2 .= $image[0][0];
                                	$finalresult = array ( array (
                                          	'ID' => $id,
                                              	'post_title' => $title,
                                          	'post_content' => $content ),
                                            	array ( 'ID' => $id1,
                                             	'post_title' => $title1,
                                               	'post_content' => $content1 ),
                                           	array ( 'ID' => $id2,
                                              	'post_title' => $title2,
                                           	'post_content' => $content2 )   );
                                 	update_option('__wp_saiob_variation' , $finalresult);
                   		}
				if ( $htag == 0 ) 
				{
					$id3 = $postid;
                                 	$title3 = $postitle;
                                     	$stringCut3 = substr($val, 0, 270);
                                     	$content3 = substr($stringCut3, 0, strrpos($stringCut3, ' ')).'...';
                                  	$content3 .= $image[0][0];
					$finalresult = array ( array (
                                     		'ID' => $id3,
                                            	'post_title' => $title3,
                                            	'post_content' => $content3 )
                                                );
                                  	update_option('__wp_saiob_variation' , $finalresult);
				}
	
				$variation = get_option('__wp_saiob_variation');
                             	$set = count($variation);
                           	//for ( $i = 0; $i < $set; $i++) {
                           	foreach ( $variation as $key => $outputresult ) {
                           	$arrayvalue[$key] = $outputresult;
                            	$finid = $variation[0]['ID'];//echo '<pre>';print_r($finid);die('hel');
                          	$fintitle = $arrayvalue[0]['post_title'];
                           	$fincontent1 = $arrayvalue[0]['post_content'];
                          	$fincontent = preg_replace("/<img[^>]+\>/i", "", $fincontent1);
                            	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $fincontent1, $matches);
                               	$imgcount = count($matches[1]);
                              	$finimage = $matches[1][0]; }
				$res = $fintitle.'_'.$fincontent.'_'.$finimage.'_'.$finid;
                                print_r(json_encode($res));  //}
			}die;
		}	
	}
	
	public function saiob_next()
	{

		$templatename=$_REQUEST['templatename'];
                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                # get template
                foreach($bulktemplate as $bulktemplatekey => $bulktemplateval)
                {
                        if($bulktemplateval['templatename'] == $templatename)
                        {
                              	$saiob=maybe_unserialize($bulktemplateval['value']);
                              	$twitter_provider=isset($saiob['twitter_provider']) ? $saiob['twitter_provider'] : '';
                              	$facebook_provider=isset($saiob['facebook_provider']) ? $saiob['facebook_provider'] : '';
                              	if(isset($twitter_provider) && $twitter_provider == 'on')
                         	{
                                  	$provider = 'twitter' ;
                                }
                              	if(isset($facebook_provider) && $facebook_provider == 'on')
                                {
                                  	$provider ='facebook'  ;
                                }
				global $wpdb;

				$posval = $_REQUEST['id'];
				$query = "select * from wp_posts where ID = $posval";
				$postresult1 = $wpdb->get_results($query);
				$postcontent = $postresult1[0]->post_content;
				$postitle = $postresult1[0]->post_title;
				$postid = $postresult1[0]->ID;
                                $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $postcontent, $matches);
				$imgcount = count($matches[1]);
				if(isset($provider) && $provider == 'facebook')
                              	{
				if ( strlen($postcontent) > 270 )
				{
					$stringCut = substr($postcontent, 0, 270);
					$result1 = substr($stringCut, 0, strpos($stringCut, ' ')).'...'; 
				}
				if ( strlen($postitle) <= 50 )
				{
					$result = $postitle;
				}
				else if ( strlen($postitle) > 51 )
				{
					$result = substr($postitle, 0, 51);
				}
				}
				if(isset($provider) && $provider == 'twitter') {
					if ( strlen($posct1) > 80 ){
                                        $stringCut = substr($postcontent, 0, 80);
                                        $result1 = substr($stringCut, 0, strpos($stringCut, ' ')).'...';
                                	}
				}
				if($imgcount > 0)
					$out = $matches [1] [0];
				else
					$out = 'null';
				$res = $out.'_'.$postid.'_'.$result.'_'.$result1;print_r($res); //} }  
			}
		}
		die;	
	}



	public function saiob_previous() {
		$templatename=$_REQUEST['templatename'];
                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                # get template
                foreach($bulktemplate as $bulktemplatekey => $bulktemplateval)
                {
                        if($bulktemplateval['templatename'] == $templatename)
                        {
                              	$saiob=maybe_unserialize($bulktemplateval['value']);
                              	$twitter_provider=isset($saiob['twitter_provider']) ? $saiob['twitter_provider'] : '';
                              	$facebook_provider=isset($saiob['facebook_provider']) ? $saiob['facebook_provider'] : '';
                              	if(isset($twitter_provider) && $twitter_provider == 'on')
                             	{

                                  	$provider = 'twitter' ;
                                }
                              	if(isset($facebook_provider) && $facebook_provider == 'on')
                                {

                                 	 $provider ='facebook'  ;
                                }
                		global $wpdb;
                                $idval = '';
                		$idval = $_REQUEST['id'];
                		//get_option('__wp_saiob_post_id');

                        	$res = ' ';
                        	$query1 = "select * from wp_posts where ID = $idval";
				$postresult1 = $wpdb->get_results($query1);
                                $posct1 = $postresult1[0]->post_content;
                                $postit1 = $postresult1[0]->post_title;
                                $posidval = $postresult1[0]->ID;
                                $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $posct1, $matches);
                                $imgcount = count($matches[1]);
				if(isset($provider) && $provider == 'facebook')
                                {

                                if ( strlen($posct1) > 270 )
                                {
                                        $stringCut = substr($posct1, 0, 270);
                                        $result1 = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
                                }
                                if ( strlen($postit1) <= 50 )
                                {
                                        $result = $postit1;
                                }
                                else if ( strlen($postit1) > 51 )
                                {
                                        $result = substr($postit1, 0, 51);
                                }
				}
				if(isset($provider) && $provider == 'twitter')
                                {
					 if ( strlen($posct1) > 80 )
                                        {
                                        $stringCut = substr($posct1, 0, 80);
                                        $result1 = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
                                        }
                                }

                                if($imgcount > 0)
                                        $out = $matches [1] [0];
                                else
                                        $out = 'null';
                                $res = $out.'_'.$posidval.'_'.$result.'_'.$result1;print_r($res);
			}
                }die;
        }

        public function saiob_gettemplate($templatename, $callmode = 'normal') {
		global $wpdb;
		$fromdate = ''; $todate = ''; $fromid = ''; $toid = ''; $posttitle = ''; $htag = ''; $variation = ''; 
		$metatitle = ''; $postcontent = ''; $excerptmsg = ''; $metadesc = ''; $images = '';
                # below two check for ajax request
                if(isset($_REQUEST['templatename']) && !empty($_REQUEST['templatename']) && empty($templatename))
                        $templatename = $_REQUEST['templatename'];

                if(isset($_REQUEST['callmode']) && !empty($_REQUEST['callmode']))
                        $callmode = $_REQUEST['callmode'];

                $dropdownlist = saiob_include_saiobhelper::$types;

                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                if(empty($templatename))
                {
			$posttitle = 'checked'; $htag = 'checked'; $variation = 'checked';
	                $metatitle = 'checked'; $postcontent = 'checked'; $excerptmsg = 'checked'; $metadesc = 'checked'; $images = 'checked';

                        $mode = 'create';
                        $datediv_display = 'display:create';
                        $iddiv_display = 'display:none';
                        $tempname = "<label class = 'control-label col-sm-3'> Template Name </label> <div class = 'col-sm-5'> <input type = 'text' name = 'templatename' id = 'templatename' class = 'form-control' placeholder = 'Enter Template Name'> </div>";
                }
                else
                {
                        $mode = 'edit';
                        $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');

                        if($bulktemplate)
                        {
                                foreach($bulktemplate as $templatekey => $singletemplate)
                                {
                                        if($singletemplate['templatename'] == $templatename)    {
                                                $templatevalue = $bulktemplate[$templatekey];
                                                break;
                                        }
                                }
                        }

                       
                        if(isset($templatevalue['settingstype']) && $templatevalue['settingstype'] == 'Date')
                        {
                                $datediv_display = 'display:block';
                                $iddiv_display = 'display:none';
                        }
                        else
                        {
                                $datediv_display = 'display:none';
                                $iddiv_display = 'display:block';
                        }

                        $fromid =isset($templatevalue['fromid']) ? $templatevalue['fromid'] : '';
                        $toid = isset($templatevalue['toid']) ? $templatevalue['toid']  : '' ;
                        $fromdate =isset($templatevalue['fromdate']) ? $templatevalue['fromdate'] : '';
                        $todate = isset($templatevalue['todate']) ? $templatevalue['todate'] : '';
			$type = isset($templatevalue['type']) ? $templatevalue['type'] : '';


                        $templatenametype = 'hidden';
                        $templatename_composer = $templatename;
                        $metatitle = empty($templatevalue['metatitle']) ? '' : 'checked';
                        $posttitle = empty($templatevalue['posttitle']) ? '' : 'checked';
                        $htag = empty($templatevalue['htag']) ? '' : 'checked';

                        $metadesc = empty($templatevalue['metadesc']) ? '' : 'checked';
                        $postcontent = empty($templatevalue['postcontent']) ? '' : 'checked';
                        $excerptmsg = empty($templatevalue['excerptmsg']) ? '' : 'checked';
                        $images = empty($templatevalue['images']) ? '' : 'checked';
                        $video = empty($templatevalue['video']) ? '' : 'checked';

                        $thumbnails = empty($templatevalue['metatitle']) ? '' : 'checked';
                        $variation = empty($templatevalue['variation']) ? '' : $templatevalue['variation'];
                        $keyword_check = empty($templatevalue['keyword_check']) ? '' : 'checked';
                        $keyword = empty($templatevalue['keyword']) ? '' : $templatevalue['keyword'];

                        $charbefore = empty($templatevalue['charbefore']) ? '' : $templatevalue['charbefore'];
                        $charafter = empty($templatevalue['charafter']) ? '' : $templatevalue['charafter'];
                        $tags = empty($templatevalue['tags']) ? '' : $templatevalue['tags'];

			$tempname = "<label class = 'control-label col-sm-3'> </label> <div class = 'col-sm-5'> <input type = '$templatenametype' name = 'templatename' id = 'templatename' value = '$templatename_composer'> </div>";
		}
                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                $select_template="<select id='select_temp' name='select_temp'  >";
                   if(empty($bulktemplate)){
                    $select_template .="<option  value='default'>choose</option>";
                    $select_template .="</select>";
                     }
                 
         if(is_array($bulktemplate))
              {
                foreach($bulktemplate as $temp_key => $temp_val ) {
                    $select_temp=$temp_val['templatename'];
                    $select_template .="<option  value='$select_temp'>$select_temp</option>";

                }
                    $select_template .="</select>";
             }    

                $settingstype_array = array('Date', 'ID');
                $settingstype = "<select name = 'settingstype' id = 'settingstype' onchange = 'changetype(this.value)'>";
                foreach($settingstype_array as $singlesettingstype)     
		{
                        $settings_selected = '';
			if(isset($templatevalue['settingstype']))
			{
                        	if($singlesettingstype == $templatevalue['settingstype'])	{
                                	$settings_selected = "selected = 'selected'";
				}
			}

                        $settingstype .= "<option $settings_selected value = '$singlesettingstype'> $singlesettingstype </option>";
                }
                $settingstype .= "</select>";
                $dropdown = '<select name = "type" class = "form-control" id = "type">';
                $dropdown .= '<option name = ""> Select </option>';
                foreach($dropdownlist as $singledropdownlist)   {
                        $dropdown_selected = '';
			if(isset($templatevalue['settingstype']))
                        {
                        	if($singledropdownlist == $templatevalue['type'])	{
                                	$dropdown_selected = "selected = 'selected'";
				}
			}

                        $dropdown .= "<option {$dropdown_selected} name = '$singledropdownlist'> $singledropdownlist </option>";
                }

                $dropdown .= '</select>';
                $data['dropdown'] = $dropdown;

                $container = "<form class='form-horizontal' method = 'POST' id = 'bulkcomposertemplate' name = 'bulkcomposertemplate' role='form' action = 'admin.php?page=social-all-in-one-bot/index.php&__module=smartbot'>
                                <input type = 'hidden' name = 'mode' id = 'mode' value = '$mode'>
				<input type = 'hidden' name = 'bulkcomposertemplate' id = 'bulkcomposertemplate'>
                                <div class = 'header_settings form-group' style = 'width:100%; margin-top: 20px; margin-left: 20px;'>
               <div class = 'form-group'>
                        <div class='col-sm-10' style='margin-bottom:35px'>
                        <label class= 'col-sm-2'> Select Template </label>
                           <div class='col-sm-2'>{$select_template} </div>
                           
                            
                             </div>
                      <div class='col-sm-10'>
                               <label class = 'text-center col-sm-2'> Source </label>
                                <div class = 'col-sm-2'> {$data['dropdown']} </div>
                                <div class = 'col-sm-1'> {$settingstype} </div>
                       
                                <div class = 'col-sm-7' id = 'date_div' style = '$datediv_display'>
                                        <label class='control-label col-sm-1'> From </label>
                                        <div class = 'col-sm-3'> <input type = 'text' name = 'fromdate' id = 'fromdate' style='width:100px;' placeholder = 'From Date' readonly value = '$fromdate'> </div>
                                        <label class='control-label col-sm-1'> To </label>
                                        <div class = 'col-sm-3' style='padding-left:0px;'> <input type = 'text' style='width:100px;'  name = 'todate' id = 'todate' placeholder = 'To Date' readonly value = '$todate' onchange = 'scheduleinfo1(this.form);'> </div>
                                </div>
                                <div class = 'col-sm-6' id = 'id_div' style = '$iddiv_display'>
                                        <label class='control-label col-sm-1'> From </label>
                                        <div class = 'col-sm-3'> <input type = 'text' name = 'fromid' id = 'fromid' placeholder = 'From Id' value = '$fromid'> </div>
                                        <label class='control-label col-sm-1'> To </label>
                                        <div class = 'col-sm-3'> <input type = 'text' name = 'toid' id = 'toid' placeholder = 'To Id' value = '$toid' onchange = 'scheduleinfo1(this.form);'></div>
                                </div><br><br>
				<div class = 'col-sm-10' id = 'nodisp' style = 'text-align:center;margin-right:25px;'>
				</div>
                        </div>
                </div>
        </div>";

                $container .= "<div class = 'form-group' style='display:none;'> <label class = 'col-sm-2'> </label> <label class = 'col-sm-2'> Variation 1 </label>  <label class = 'col-sm-2'> Variation 2 </label> <label class = 'col-sm-2'> Variation 3 </label> </div>";

                $container .= "<div id = 'template_saiob' style = 'width:100%;'>
                                <div class = 'form-group' style='display:none;'>
                                        <label class='text-center col-sm-2'> Title </label>
                                        <label class='checkbox-inline col-sm-2'> <input style = 'vertical-align:bottom;float:none' type = 'checkbox' name = 'posttitle' id = 'posttitle' $posttitle> Post Title </label>
                                        <label class='checkbox-inline col-sm-2'> <input style = 'vertical-align:bottom;float:none' type = 'checkbox' name = 'htag' id = 'htag' $htag> H1, H2, H3 </label>
                                        <label class='checkbox-inline col-sm-2'> <input style = 'vertical-align:bottom;float:none' type = 'checkbox' name = 'metatitle' id = 'metatitle' $metatitle> Meta Title </label>
                                </div>
                                <div class = 'form-group' style='display:none;'>
                                        <label class = 'text-center col-sm-2'> Message </label>
                                        <label class = 'checkbox-inline col-sm-2'> <input style = 'vertical-align:bottom;float:none' type = 'checkbox' name = 'postcontent' id = 'postcontent' $postcontent> Post Content </label>
                                        <label class = 'checkbox-inline col-sm-2'> <input style = 'vertical-align:bottom;float:none' type = 'checkbox' name = 'excerptmsg' id = 'excerptmsg' $excerptmsg> Excerpt </label>
                                        <label class = 'checkbox-inline col-sm-2'> <input style = 'vertical-align:bottom;float:none' type = 'checkbox' name = 'metadesc' id = 'metadesc' $metadesc> Meta Description </label>
                                </div>
                                <div class = 'form-group' style='display:none;'>
                                        <label class='text-center col-sm-2'> Media </label>
                                        <label class='checkbox-inline col-sm-2'> <input style = 'vertical-align:bottom;float:none' type = 'checkbox' name = 'images' id = 'images' $images> Images </label>
                                </div>";
		$container .= "<div class = 'form-group'>
				<label class='text-center col-sm-2'></label>
                                        <label class='checkbox-inline col-sm-2'> <input style = 'vertical-align:bottom;float:none' type = 'checkbox' name = 'variation' id = 'variation' $variation> Apply Variations </label>
				</div>";

                $container .=  "<div class = 'form-group' style = 'padding-top:10px; '>
                                                                              
                                        <button type='button' style = 'margin-left:350px'  class='btn btn-primary' id = 'schedule' onclick = 'scheduleinfo(this.form)' data-loading-text='<span class = \"fa fa-spinner fa-spin\"></span> Scheduling Template...'>  Schedule </button>&emsp;
					<button type='button' style = 'margin-left:50px'  class='btn btn-primary' id = 'preview' data-toggle='modal' data-target='.bs-example-modal-sm' onclick = 'previewinfo(this.form)'> Preview </button>";

		$container .=  "<div class='modal fade bs-example-modal-sm' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
  						<div class='modal-dialog modal-lg'>
    						<div class='modal-content'>
						<div class = 'model-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
						<div class = 'model-title' id='myModalLabel'>
							
							<img height= '50px;' width = '60px;' style= 'padding-top:20px;margin-left:10px;' name = 'previous' id = 'previousimage' src = '".WP_SOCIAL_ALL_IN_ONE_BOT_DIR."images/previous.png'  alt = 'previous' onclick = 'previous_info(this.form)'/>";

						$container .=  "<img class = 'nextimage' id = 'nextimage' style = 'height:50px;width:60px;padding-top:20px;float:right;margin-right:10px;' name = 'next' src = '".WP_SOCIAL_ALL_IN_ONE_BOT_DIR."images/next.png' alt = 'next' onclick = 'next_info(this.form)'/>";
														
						$container .=  "<div style = 'text-align:center;margin-top:-25px;' id = 'divpost'></div>
						</div>
						</div>
						<div class = 'model-body' style = 'height:150px;'>
							<div class = 'dispimg' id = 'divimg' style='border:none;'>
							</div>
							<div class = 'dispcont' id = 'divcont'>
								<div id = 'divtit' class = 'disptit'></div>
								<div id ='divbod' class = 'dispbod'></div>
							</div>
    						</div>
						<div class = 'modal-footer'>
						</div>
  						</div>
						</div></div>
					
                                </div>
                                </div>
			
                        </div> 
                        </form>
                        <script type = 'text/javascript'>
                        jQuery(document).ready(function() {
                                        jQuery('#todate').datepicker({
                                                dateFormat : 'yy-mm-dd'
                                                });
                                        });

                        jQuery(document).ready(function() {
                                jQuery('#fromdate').datepicker({
                                        dateFormat : 'yy-mm-dd'
                                });
                        });";
                $container .= "</script>";
                if($callmode == 'ajax') {
                        print_r(wp_send_json($container));die;
                }
                else    {
                        return $container;
                }
        }

	/**
         *  add new cron schedule
         *  @param $param
         *  @return array
         **/
        public static function cron_schedules($param) {
                return array('saiob_one_minute_cron'
                                => array(
                                        'interval' => 60, // seconds
                                        'display'  => __('Every 1 minutes')
                                        ));
        }

	/**
         *  plugin activate
         **/
        public static function activate()
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
                        `createdtime` datetime NOT NULL,
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

	public static function front_page()
	{
		require_once(WP_SOCIAL_ALL_IN_ONE_BOT_DIRECTORY.'config/settings.php');
		require_once(WP_SOCIAL_ALL_IN_ONE_BOT_DIRECTORY.'lib/skinnymvc/controller/SkinnyController.php');
		$c= new SkinnyController_saiob();
		$c->main();

	}

	/**
         *  plugin deactivate
         **/
        public static function deactivate()
        {
                global $wpdb;
                # droping table starts here
                $socialqueue_table = WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE;
                $sociallog_table = WP_SOCIAL_ALL_IN_ONE_BOT_LOG_TABLE;
                $socialqueue_sql = "DROP TABLE IF EXISTS $socialqueue_table;";
                $sociallog_sql = "DROP TABLE IF EXISTS $sociallog_table";
                $wpdb->query($socialqueue_sql);
                $wpdb->query($sociallog_sql);
                # droping table ends here
                delete_option('__saiob_facebookkeys');
                delete_option('__saiob_twitterkeys');
                delete_option('__wp_saiob_bulkcomposer_template');
		delete_option('__wp_saiob_post_id');
                # clearing cron
                wp_clear_scheduled_hook('wordpress_social_all_in_one_bot_queue');
                # clearing cron ends here
        }

	/**
	 * get current wordpress datetime
	 * @param string $type 
	 * @param boolean $gmt
	 * @return array $date
	 **/
	public static function get_saiob_wordpress_date($type, $gmt = 0)
	{
		$date = array();
        	$time = current_time($type, $gmt);
		$date['timstamp'] = $time;
		$date['date'] = date('Y-m-d', strtotime($time));
		$date['time'] = date('H:i', strtotime($time));
		$date['day'] = date('l', strtotime($time));
		return $date;
	}

	/**
	 *  run all the queues
	 **/
        public static function runcron()
        {
                global $wpdb;
                $queuetablename = WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE;
		$wp_date = saiob_include_saiobhelper::get_saiob_wordpress_date('mysql', 0);
                $day  = $wp_date['day'];
                $date = $wp_date['date'];
                $time = $wp_date['time'];

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
       
        public function saiob_createinstantpost() {
          $status['title']       = $_POST['postdata']['posttitle'];
          $status['description'] = $_POST['postdata']['postcontent'];
          $status['image']       = $_POST['postdata']['imageurl'];
          $status['link_post']   = $_POST['postdata']['saiob_link'];
          $status['text_post']   = $_POST['postdata']['saiob_text'];
          $status['image_post']  = $_POST['postdata']['saiob_url'];
          $status['link_url']    = $_POST['postdata']['link_post'];
          $facebook              = $_POST['postdata']['facebook_provider']; 
          $twitter               = $_POST['postdata']['twitter_provider']; 
          $data = array();         
          if(isset($status['image_post'])) {
          $saiobhelper = new saiob_include_saiobhelper();
          $img_path =  $saiobhelper->saiob_imageupload($status['image']);
          }
          $status['img_path']    = $img_path;
          $socialhelper          = new saiob_include_socialhelper();
          if(isset($facebook) && $facebook == 'true') {
          $res     = $socialhelper->fbstatus($status); 
          $provider="facebook"; 
          $saiobhelper->addsociallog($res, $provider, $status['description'],$id);
          $data['facebook'] = $res['result'];
           
          }
          if(isset($twitter) && $twitter == 'true') {
          $twt = $socialhelper->tweet($status);
                  $provider="twitter";
                  $saiobhelper->addsociallog($twt, $provider, $status['description'],$id);
          $data['twitter'] = $twt['result'];
            
          }
                if((trim($res['result'])=="Succeed") && (trim($twt['result'])=="Succeed")){
                  $data['msg']="The post is successfully posted in facebook and twitter";
                  $data['war']="success";

                  }
                 elseif((trim($res['result'])=="Failed") && (trim($twt['result'])=="Succeed")){
                  $data['msg']="The post is sucessfully posted in twitter and failed in facebook";
                  $data['war']="warning";
                     }
              elseif(trim($res['result'])=="Succeed"){
                 $data['msg']="The post is successfully posted in facebook";
                 $data['war']="success";
                 }
              elseif(trim($res['result'])=="Failed"){
                $data['msg']="The post is already posted in facebook";
                $data['war']="danger";
                }
              elseif(trim($twt['result'])=="Succeed"){
                 $data['msg']="The post is successfully posted in Twitter";
                 $data['war']="success";
                }
              echo json_encode($data);die;
        }
       public function saiob_imageupload($url) {
        $saiobhelper = new saiob_include_saiobhelper();
        $uploadDir = $saiobhelper->getUploadDirectory('plugin_uploads');
        if(!is_dir($uploadDir)) {
        wp_mkdir_p($uploadDir);
        } 
        $get_path = explode('/',$url);
        $c = count($get_path);
        $temp_dir_name = explode('.',$get_path[$c - 1]);

        $local_dir = $uploadDir . '/' . $temp_dir_name[0].'.jpg';

        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $rawdata=curl_exec($ch);
        curl_close ($ch);
         if(file_exists($local_dir)){
             unlink($local_dir);
       } 
       $fp = fopen($local_dir,'w');
       fwrite($fp, $rawdata);
       fclose($fp);
       return $local_dir;

       }
       
} 

