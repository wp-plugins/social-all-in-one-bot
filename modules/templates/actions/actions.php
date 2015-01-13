<?php
class TemplatesActions extends SkinnyActions 
{
	public function __construct()
	{

	}

	/**
	 * The actions index method
	 * @param array $request
	 * @return array
	 */
	public function executeIndex($request)
	{
		$data = array();
		# for notification message
		$notification_code = (isset($request['GET']['msg']) && empty($request['GET']['msg'])) ? $request['GET']['msg'] : '';
		if(!empty($notification_code))
		{
			if($notification_code == 5)
			{
				$data['notification'] = "Template Created Successfully.";
	                        $data['notificationclass'] = 'alert alert-success';
			}
		}
		$bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
		$data['templateslist'] = $bulktemplate;
		$data['templates_count'] = count($bulktemplate);
		return $data;
	}
        
        public function executeNewpost($request) {

  
        }       
	/**
	 * action create method
	 * @param array $request
  	 * @return array
	 **/
	public function executeCreate($request)
	{
		$data = array();
		$botarray = array('googlebot', 'facebookbot', 'twitterbot', 'linkedinbot');
                foreach($botarray as $singlebot)
                {
                        $frequency_array =  array('1', '2', '3');
                        $frequency  = "<select name = '".$singlebot."_frequency' id = '".$singlebot."_frequency'>";
                        foreach($frequency_array as $singleFrequency)   {
                                $frequency .= "<option value = '$singleFrequency'> $singleFrequency </option>";
                        }
                        $frequency .= "</select>";
                        $data[$singlebot.'_frequency'] = $frequency;

                        $period_array = array('Daily', 'Weekly', 'Date');
                        $period = "<select name = '".$singlebot."_period' id = '".$singlebot."_period' onchange = 'showdatediv(this.value, \"$singlebot\" )'>";
                        foreach($period_array as $singlePeriod) {
                                $period .= "<option value = '$singlePeriod'> $singlePeriod </option>";
                        }
                        $period .= "</select>";
                        $data[$singlebot.'_period'] = $period;

                        $weekly_array = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                        $weekly = "<select name = '".$singlebot."_weekly' id = '".$singlebot."_weekly'>";
                        foreach($weekly_array as $singleWeek)   {
                                $weekly .= "<option value = '$singleWeek'> $singleWeek </option>";
                        }
                        $weekly .= "</select>";
                        $data[$singlebot.'_weekly'] = $weekly;

                        $googlbot_hours_from = "<select name = '".$singlebot."_hours_from' id = '".$singlebot."_hours_from'>";
                        for($hours = 0; $hours < 24; $hours ++)
                        {
                                for($mins=0; $mins<60; $mins+=30)
                                {
                                        $datetime = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                                        $googlbot_hours_from .= "<option value = '$datetime'> $datetime </option>";
                                }
                        }
			$googlbot_hours_from .= "</select>";
                        $data[$singlebot.'_hours_from'] = $googlbot_hours_from;

                        $googlbot_hours_to = "<select name = '".$singlebot."_hours_to' id = '".$singlebot."_hours_to'>";
                        for($hours = 0;$hours < 24;$hours ++)
                        {
                                for($mins = 0; $mins < 60; $mins += 30)
                                {
                                        $datetime = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                                        $googlbot_hours_to .= "<option value = '$datetime'> $datetime </option>";
                                        
                                }
                        }
                        $googlbot_hours_to .= "</select>";
                        $data[$singlebot.'_hours_to'] = $googlbot_hours_to;

                        $googlebot_tag_nos = "<select name = '".$singlebot."_tag_nos' id = '".$singlebot."_tag_nos' >";
                        for($i = 1; $i <= 5; $i ++)
                                $googlebot_tag_nos .= "<option value = '$i'> $i </option>";

                        $googlebot_tag_nos .= "</select>";
                        $data[$singlebot.'_tag_nos'] = $googlebot_tag_nos;
                }
		return $data;
	}
     

/* EDIT FUNCTION START HERE */
        public function executeedit($request)
	{
		$data= array();
                $twit= array();
                $val_tag=array();
		$choosen_bot= '';
                $singlebot='';
                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template'); 
            if(is_array($bulktemplate))
               {  
               foreach($bulktemplate as $ser_key => $ser_val)
                  {
                    $eid=mysql_real_escape_string($_GET['id']);
                    if($ser_key==$eid)
                        { 

                    $twit=maybe_unserialize($ser_val['value']);
                    $twitter_provider= '' ;
                 
                    $twitter_provider=isset($twit['twitter_provider']) ? $twit['twitter_provider'] : '';
                    $facebook_provider= '' ;
                   $facebook_provider=isset($twit['facebook_provider']) ? $twit['facebook_provider'] : '';
		    $linkedin_provider= '' ;
                   $linkedin_provider=isset($twit['linkedin_provider']) ? $twit['linkedin_provider'] : '';
                   
                     if(isset($twitter_provider) && $twitter_provider == 'on' )
                       {
                       
                        $choosen_bot = 'twitterbot';
                       }
                    if(isset($facebook_provider ) && $facebook_provider == 'on')
                        {
                        $choosen_bot = 'facebookbot';
                         }
		    if(isset($linkedin_provider ) && $linkedin_provider == 'on')
                        {
                        $choosen_bot = 'linkedinbot';
                         }
               } 
                   
                $botarray = array('googlebot', 'facebookbot', 'twitterbot', 'linkedinbot');
                foreach($botarray as $singlebot)
                {
                    if(isset($singlebot) && $singlebot == $choosen_bot)
                       {
                        $frequency_array =  array('1', '2', '3');
                        $frequency  = "<select name = '".$singlebot."_frequency' id = '".$singlebot."_frequency'>";
                        $val_freq=array();  
                        $val_freq=isset($twit[$singlebot.'_frequency']) ? $twit[$singlebot.'_frequency'] : '' ;
                        $frequency .= "<option value = '$val_freq'> $val_freq </option>";
                        foreach($frequency_array as $singleFrequency)  
                          {
                        $frequency .= "<option value = '$singleFrequency'> $singleFrequency </option>";
                           }
                        $frequency .= "</select>";
                        $data[$singlebot.'_frequency'] = $frequency;
                        $period_array = array('Daily', 'Weekly', 'Date');
                        $period = "<select name = '".$singlebot."_period' id = '".$singlebot."_period' onchange = 'showdatediv(this.value, \"$singlebot\" )'>";        $val_period=array();
                        $val_period=isset($twit[$singlebot.'_period']) ? $twit[$singlebot.'_period'] : '';
                        $period .= "<option value = '$val_period'> $val_period </option>";
                        foreach($period_array as $singlePeriod)
                          {
                        $period .= "<option value = '$singlePeriod'> $singlePeriod </option>";
                          }
                        $period .= "</select>";
                        $data[$singlebot.'_period'] = $period;
                        $weekly_array = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                        $weekly = "<select name = '".$singlebot."_weekly' id = '".$singlebot."_weekly'>";
                        $val_week=array();
                        $val_week=isset($twit[$singlebot.'_weekly']) ? $twit[$singlebot.'_weekly'] : '';
                        $weekly .= "<option value = '$val_week'> $val_week </option>";
                        foreach($weekly_array as $singleWeek)   
                          {
                        $weekly .= "<option value = '$singleWeek'> $singleWeek </option>";
                          }
                        $weekly .= "</select>";
                        $data[$singlebot.'_weekly'] = $weekly;
                        $datefrom=isset($twit[$singlebot.'_fromdate']) ? $twit[$singlebot.'_fromdate'] : '';
                        $data[$singlebot.'_fromdate']= $datefrom;
                        $dateto=isset($twit[$singlebot.'_todate']) ? $twit[$singlebot.'_todate'] : '';
                        $data[$singlebot.'_todate']=$dateto;
                        $googlbot_hours_from = "<select name = '".$singlebot."_hours_from' id = '".$singlebot."_hours_from'>";
                        $val_from=array();
                        $val_from=isset($twit[$singlebot.'_hours_from']) ? $twit[$singlebot.'_hours_from'] : '';
                        $googlbot_hours_from .= "<option value = '$val_from'> $val_from </option>";
                        for($hours = 0; $hours < 24; $hours ++)
                        {
                        for($mins=0; $mins<60; $mins+=30)
                                {
                                        $datetime = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                                        $googlbot_hours_from .= "<option value = '$datetime'> $datetime </option>";
                                }
                        }
			$googlbot_hours_from .= "</select>";
                        $data[$singlebot.'_hours_from'] = $googlbot_hours_from;
                        $googlbot_hours_to = "<select name = '".$singlebot."_hours_to' id = '".$singlebot."_hours_to'>";
                        $val_to=array();
                        $val_to=isset($twit[$singlebot.'_hours_to']) ? $twit[$singlebot.'_hours_to'] : '' ;
                        $googlbot_hours_to .= "<option value = '$val_to'> $val_to </option>";
                        for($hours = 0;$hours < 24;$hours ++)
                        {
                                for($mins = 0; $mins < 60; $mins += 30)
                                {
                                        $datetime = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                                         
                                        $googlbot_hours_to .= "<option value = '$datetime'> $datetime </option>";
                                }
                        }
                        $googlbot_hours_to .= "</select>";
                        $data[$singlebot.'_hours_to'] = $googlbot_hours_to;
                        $googlebot_tag_nos = "<select name = '".$singlebot."_tag_nos' id = '".$singlebot."_tag_nos' >";
                        $val_tag=isset($twit[$singlebot.'_tag_nos']) ? $twit[$singlebot.'_tag_nos'] : '';
                        $googlebot_tag_nos .= "<option value = '$val_tag'>   $val_tag </option>";
                        for($i = 1; $i <= 5; $i ++)
                            {
                        $googlebot_tag_nos .= "<option value = '$i'> $i </option>";
                                }
                        $googlebot_tag_nos .= "</select>";
                        $data[$singlebot.'_tag_nos'] = $googlebot_tag_nos;
         
    }
   
 }

}// for check array	
}
 	return $data;
         
	}

// save function star here
	public function executeSave($request)
	{
		$data = array();
               	$post = $request['POST'];
		$templatename = $post['templatename'];
               
		$provider_array = array('twitter', 'facebook', 'linkedin');

		$twitter      = isset($post['twitter_provider']) ? $post['twitter_provider'] : '';
		$facebook     = isset($post['facebook_provider']) ? $post['facebook_provider'] : '';
		$linkedin     = isset($post['linkedin_provider']) ? $post['linkedin_provider'] : '';

		$data['templatename'] = $templatename;
		# unsetting templatename
		unset($post['templatename']);
		foreach($provider_array as $single_provider)
		{
			if(empty($$single_provider))
			{
				foreach($post as $singlepost_key => $singlepost)
                        	{
                                	$split_key = array(); $current_provider = $single_provider."bot";
	                                $split_key = explode('_', $singlepost_key);
        	                        if($split_key[0] == $current_provider)
					{
						unset($post[$singlepost_key]);
					}
                	        }
			}
		}
		$currenttime = date('Y-m-d H:i:s');
		$data['value'] = maybe_serialize($post);
              
		$data['createdtime'] = $currenttime;
		$data['modifiedtime'] = $currenttime;
 
		$bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
		if(empty($bulktemplate))
			$bulktemplate = array();

		$template_count = count($bulktemplate) + 1;
		$bulktemplate[$template_count] = $data;	
		update_option('__wp_saiob_bulkcomposer_template', $bulktemplate);
                  ?>   <script language="javascript" type="text/javascript">
	             window.location.href = ' <?php echo home_url()?>/wp-admin/admin.php?page=<?php echo WP_SOCIAL_ALL_IN_ONE_BOT_SLUG?>/index.php&__module=templates&msg=5';
                </script>
	
 <?php exit;	}
           

    //UPDATE FUNCTION START HERE
          public function executeupdate($request)
	{
		$data = array();
		$post = $request['POST'];
               
		$templatename = $post['templatename']; 
                $uid=$post['id'];
                
		
		$provider_array = array('twitter', 'facebook', 'linkedin');

		$twitter      = isset($post['twitter_provider']) ? $post['twitter_provider'] : '';
		$facebook     = isset($post['facebook_provider']) ? $post['facebook_provider'] : '';
		$linkedin     = isset($post['linkedin_provider']) ? $post['linkedin_provider'] : '';
                foreach($provider_array as $single_provider)
		{
			if(empty($$single_provider))
			{
				foreach($post as $singlepost_key => $singlepost)
                        	{
                                	$split_key = array(); $current_provider = $single_provider."bot";
	                                $split_key = explode('_', $singlepost_key);
        	                        if($split_key[0] == $current_provider)
					{
						unset($post[$singlepost_key]);
					}
                	        }
			}
		}
		$currenttime = date('Y-m-d H:i:s');
		$data['value'] = maybe_serialize($post);
		$data['createdtime'] = $currenttime;
		$data['modifiedtime'] = $currenttime;

        	$bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                foreach($bulktemplate as $ser_key => $ser_val)
                  {
                    if($ser_key==$uid)
                        {
                         $ser_val['value']=maybe_serialize($post);
                         $ser_val['createdtime']=$currenttime;
                         $ser_val['modifiedtime']=$currenttime;
                         $ser_val['templatename']=$post['templatename'];
                         $bulktemplate[$uid]=$ser_val;
                         update_option('__wp_saiob_bulkcomposer_template',$bulktemplate);
              ?>
                   <script language="javascript" type="text/javascript">
	            window.location.href = ' <?php echo home_url()?>/wp-admin/admin.php?page=<?php echo WP_SOCIAL_ALL_IN_ONE_BOT_SLUG?>/index.php&__module=templates&msg=5';
                
                     </script><?php  exit;}

                }	

                        }

// get the template value
       public function executetemp($request)
	{
		$data= array();
                $twit=array();
                $twitter_provider = ' ';
                $facebook_provider = ' ';
                $choosen_bot = ' ';
                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template'); 
              if(is_array($bulktemplate))
                  {
               foreach($bulktemplate as $ser_key => $ser_val)
                  {
                    $eid=mysql_real_escape_string($_GET['id']);
                    if($ser_key==$eid)
                        { 
                    $twit=maybe_unserialize($ser_val['value']);
                    $twitter_provider=isset($twit['twitter_provider']) ? $twit['twitter_provider'] : '';
                    $facebook_provider=isset($twit['facebook_provider']) ? $twit['facebook_provider'] : '' ;
		    $linkedin_provider=isset($twit['linkedin_provider']) ? $twit['linkedin_provider'] : '' ;
                     if(isset($twitter_provider) && $twitter_provider == 'on')
                       {
                        $choosen_bot = 'twitterbot';
                       }
                    if(isset($facebook_provider) && $facebook_provider == 'on')
                        {
                        $choosen_bot = 'facebookbot';
                         }
		    if(isset($linkedin_provider) && $linkedin_provider == 'on')
                        {
                        $choosen_bot = 'linkedinbot';
                         }
                } 
                $botarray = array('googlebot', 'facebookbot', 'twitterbot', 'linkedinbot');
                foreach($botarray as $singlebot)
                {
                    if($singlebot == $choosen_bot )
                       {
                        $frequency_array =  array('1', '2', '3');
                        $frequency  = "<select name = '".$singlebot."_frequency' id = '".$singlebot."_frequency'>";
                        $val_freq=array();
                        $val_freq=isset($twit[$singlebot.'_frequency']) ? $twit[$singlebot.'_frequency'] : '';
                        $frequency .= "<option value = '$val_freq'> $val_freq </option>";
                        foreach($frequency_array as $singleFrequency)  
                          {
                        $frequency .= "<option value = '$singleFrequency'> $singleFrequency </option>";
                           }
                        $frequency .= "</select>";
                        $data[$singlebot.'_frequency'] = $frequency;
                        $period_array = array('Daily', 'Weekly', 'Date');
                        $period = "<select name = '".$singlebot."_period' id = '".$singlebot."_period' onchange = 'showdatediv(this.value, \"$singlebot\" )'>";
                        $val_period=array();
                        $val_period=isset($twit[$singlebot.'_period']) ? $twit[$singlebot.'_period'] : '';
                        $period .= "<option value = '$val_period'> $val_period </option>";
                        foreach($period_array as $singlePeriod)
                          {
                        $period .= "<option value = '$singlePeriod'> $singlePeriod </option>";
                          }
                        $period .= "</select>";
                        $data[$singlebot.'_period'] = $period;
                        $weekly_array = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                        $weekly = "<select name = '".$singlebot."_weekly' id = '".$singlebot."_weekly'>";
                        $val_week=array();
                        $val_week=isset($twit[$singlebot.'_weekly']) ? $twit[$singlebot.'_weekly'] : '';
                        $weekly .= "<option value = '$val_week'> $val_week </option>";
                        foreach($weekly_array as $singleWeek)   
                          {
                        $weekly .= "<option value = '$singleWeek'> $singleWeek </option>";
                          }
                        $weekly .= "</select>";
                        $data[$singlebot.'_weekly'] = $weekly;
                        $datefrom=isset($twit[$singlebot.'_fromdate']) ? $twit[$singlebot.'_fromdate'] : '';
                        $data[$singlebot.'_fromdate']= $datefrom;
                        $dateto=isset($twit[$singlebot.'_todate']) ? $twit[$singlebot.'_todate'] : '';
                        $data[$singlebot.'_todate']=$dateto;
                        $googlbot_hours_from = "<select name = '".$singlebot."_hours_from' id = '".$singlebot."_hours_from'>";
                        $val_from=array();
                        $val_from=isset($twit[$singlebot.'_hours_from']) ? $twit[$singlebot.'_hours_from'] : '';
                        $googlbot_hours_from .= "<option value = '$val_from'> $val_from </option>";
                        for($hours = 0; $hours < 24; $hours ++)
                        {
                        for($mins=0; $mins<60; $mins+=30)
                                {
                                        $datetime = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                                        $googlbot_hours_from .= "<option value = '$datetime'> $datetime </option>";
                                }
                        }
			$googlbot_hours_from .= "</select>";
                        $data[$singlebot.'_hours_from'] = $googlbot_hours_from;
                        $googlbot_hours_to = "<select name = '".$singlebot."_hours_to' id = '".$singlebot."_hours_to'>";
                       $val_to=array();
                        $val_to=isset($twit[$singlebot.'_hours_to']) ? $twit[$singlebot.'_hours_to'] : '';
                        $googlbot_hours_to .= "<option value = '$val_to'> $val_to </option>";
                        for($hours = 0;$hours < 24;$hours ++)
                        {
                                for($mins = 0; $mins < 60; $mins += 30)
                                {
                                        $datetime = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                                         
                                        $googlbot_hours_to .= "<option value = '$datetime'> $datetime </option>";
                                }
                        }
                        $googlbot_hours_to .= "</select>";
                        $data[$singlebot.'_hours_to'] = $googlbot_hours_to;
                        $googlebot_tag_nos = "<select name = '".$singlebot."_tag_nos' id = '".$singlebot."_tag_nos' >";
                        $val_tag=array();   
                        $val_tag=isset($twit[$singlebot.'_tag_nos']) ? $twit[$singlebot.'_tag_nos'] : '';
                        $googlebot_tag_nos .= "<option value = 'val_tag'> $val_tag </option>";
                        for($i = 1; $i <= 5; $i ++)
                            {
                        $googlebot_tag_nos .= "<option value = '$i'> $i </option>";
                                }
                        $googlebot_tag_nos .= "</select>";
                        $data[$singlebot.'_tag_nos'] = $googlebot_tag_nos;
        }//for if   
    }

 
 }
}  //check array
		return $data;
	}
  // clone function start here
     public function executeclone($request)
	{
		$data = array();
               	$post = $request['POST'];
		$templatename = $post['templatename'];
                $provider_array = array('twitter', 'facebook');
                $twitter      = isset($post['twitter_provider']) ? $post['twitter_provider'] : '';
		$facebook     = isset($post['facebook_provider']) ? $post['facebook_provider'] : '';
		$linkedin     = isset($post['linkedin_provider']) ? $post['linkedin_provider'] : '';
                $data['templatename'] = $templatename;
		# unsetting templatename
		unset($post['templatename']);
		foreach($provider_array as $single_provider)
		{
			if(empty($$single_provider))
			{
				foreach($post as $singlepost_key => $singlepost)
                        	{
                                	$split_key = array(); $current_provider = $single_provider."bot";
	                                $split_key = explode('_', $singlepost_key);
        	                        if($split_key[0] == $current_provider)
					{
						unset($post[$singlepost_key]);
					}
                	        }
			}
		}
		$currenttime = date('Y-m-d H:i:s');
		$data['value'] = maybe_serialize($post);
		$data['createdtime'] = $currenttime;
		$data['modifiedtime'] = $currenttime;
                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
		if(empty($bulktemplate))
			$bulktemplate = array();

		$template_count = count($bulktemplate) + 1;
		$bulktemplate[$template_count] = $data;	
		update_option('__wp_saiob_bulkcomposer_template', $bulktemplate);
	   ?>	<script language="javascript" type="text/javascript">
               window.location.href = ' <?php echo home_url()?>/wp-admin/admin.php?page=<?php echo WP_SOCIAL_ALL_IN_ONE_BOT_SLUG?>/index.php&__module=templates&msg=5';
	</script>
           <?php exit;
	}
           

           



           
}
