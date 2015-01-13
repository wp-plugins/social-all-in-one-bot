<?php
/******************************
 * filename:    modules/settings/actions/actions.php
 * description:
 */

class SettingsActions extends SkinnyActions {

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
		// return an array of name value pairs to send data to the template
		$data = array();
		$facebook_appid = isset($_REQUEST['facebook_appid']) ? $_REQUEST['facebook_appid'] : '';
		$facebook_secretkey = isset($_REQUEST['facebook_secretkey']) ? $_REQUEST['facebook_secretkey'] : '';
		$facebook_status = isset($_REQUEST['enablefacebook']) ? $_REQUEST['enablefacebook'] : '';
		$facebook_code = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
		$facebook_url = isset($_REQUEST['redirect_uri']) ? $_REQUEST['redirect_uri'] : '';
		if(!empty($facebook_appid) && !empty($facebook_secretkey))
		{
			$value[0] = $facebook_appid;
			$value[1] = $facebook_secretkey;

			$facebook = new SAIOB_Facebook(array(
						'appId'  => $value[0],
						'secret' => $value[1],
						));

			$facebook_accesstoken = $facebook->getAccessToken();
			if(!empty($facebook_accesstoken))
			{
				$data['notification'] = "Facebook settings stored Successfully.";
				$data['notificationclass'] = 'alert alert-success';
			}
			else
			{
				$data['notification'] = "Error getting access token from facebook";
				$data['notificationclass'] = 'alert alert-danger';
			}
			$value[2] = $facebook_accesstoken;
			$value['status'] = $facebook_status;
                        $value['code'] = $facebook_code;
                        $value['redirect_uri'] = $facebook_url;
			update_option('__saiob_facebookkeys', $value);

			$user = $facebook->getUser();
			if(!$user)      
			{
				# if user is not logged in, redirect the user to facebook inorder to get the accesstoken. get loginurl from getLoginUrl function
				$loginurl = $facebook->getLoginUrl(array('scope' => 'publish_stream,status_update,offline_access,photo_upload')); ?>
					<script> window.location.href = "<?php echo $loginurl; ?>" </script> <?php die;
			}
		}
		else if(!empty($facebook_code))
		{
			$value = get_option('__saiob_facebookkeys');
			$facebook = new SAIOB_Facebook(array(
						'appId'  => $value[0],
						'secret' => $value[1],
						));

			$facebook_accesstoken = $facebook->getAccessToken(); 
			if(!empty($facebook_accesstoken))
			{
				$value[2] = $facebook_accesstoken;
				$data['notification'] = "Facebook settings stored Successfully.";
				$data['notificationclass'] = 'alert alert-success';
			}
			else
			{
				$value = array();
				$data['notification'] = "Error getting access token from facebook";
				$data['notificationclass'] = 'alert alert-danger';

			}
			update_option('__saiob_facebookkeys', $value);
		}


		/*$linkedin_appid = isset($_REQUEST['linkedin_apikey']) ? $_REQUEST['linkedin_apikey'] : '';
                $linkedin_secretkey = isset($_REQUEST['linkedin_secretkey']) ? $_REQUEST['linkedin_secretkey'] : '';
		$linkedin_url = isset($_REQUEST['linkedin_url']) ? $_REQUEST['linkedin_url'] : '';
                $linkedin_status = isset($_REQUEST['enablelinkedin']) ? $_REQUEST['enablelinkedin'] : '';

		if(!empty($linkedin_appid) && !empty($linkedin_secretkey))
                {
			//echo '<pre>';print_r($_REQUEST);die;
			$value = get_option('__saiob_linkedinkeys');
                        $value[0] = $linkedin_appid;
                        $value[1] = $linkedin_secretkey;
			$value[2] = $linkedin_url;

			#$linkedin = new SAIOB_LinkedIn();
                        $linkedin = new SAIOB_LinkedIn(array(
                                                'api_key'  => $value[0],
                                                'api_secret' => $value[1],
						'callback_url' => $value[2],
                                                ));

			$linkedin_loginurl = $linkedin->getLoginUrl(array(
							SAIOB_LinkedIn::SCOPE_BASIC_PROFILE, 
    							SAIOB_LinkedIn::SCOPE_EMAIL_ADDRESS,
							SAIOB_LinkedIn::SCOPE_FULL_PROFILE,
							SAIOB_LinkedIn::SCOPE_NETWORK,
							SAIOB_LinkedIn::SCOPE_CONTACT_INFO,
							SAIOB_LinkedIn::SCOPE_READ_WRTIE_UPDATES,
							SAIOB_LinkedIn::SCOPE_READ_WRITE_GROUPS,
							SAIOB_LinkedIn::SCOPE_WRITE_MESSAGES,
						));
			if(!empty($linkedin_loginurl))
                        {
                                $data['notification'] = "LinkedIn settings stored Successfully.";
                                $data['notificationclass'] = 'alert alert-success';
                        }
                        else
                        {
                                $data['notification'] = "Error getting access token from linkedin";
                                $data['notificationclass'] = 'alert alert-danger';
                        }
			//$linkedin_code = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';echo '<pre>';print_r($linkedin_code);
			$value['status'] = $linkedin_status;
			$value['url'] = $linkedin_loginurl; //echo '<pre>';print_r($value);die('ds');
			update_option('__saiob_linkedinkeys', $value);
			?>
			<script> window.location.href = "<?php echo $linkedin_loginurl; ?>" </script> <?php die;
			//$linkedin_accesstoken = $linkedin->getAccessToken($_REQUEST['code']);
			//$value['code'] = $linkedin_accesstoken;
			#echo '<pre>';print_r($value);die('ds');
			#update_option('__saiob_linkedinkeys', $value);
		}*/


		return $data;
	}

}
