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
		return $data;
	}

}
