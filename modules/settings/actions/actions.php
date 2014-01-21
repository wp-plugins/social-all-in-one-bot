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
	    $facebook_appid = $_REQUEST['facebook_appid'];
	    $facebook_secretkey = $_REQUEST['facebook_secretkey'];
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
                    	$data['notificationclass'] = 'alert-success';
	            }
		    else
		    {
			$data['notification'] = "Error getting access token from facebook";
                        $data['notificationclass'] = 'alert-danger';
  		    }
		    $value[2] = $facebook_accesstoken;
		    update_option('__saiob_facebookkeys', $value);

		    $user = $facebook->getUser();
		    if(!$user)      {
			    $loginurl = $facebook->getLoginUrl(array('scope' => 'publish_stream,status_update')); ?>
			    <script> window.location.href = "<?php echo $loginurl; ?>" </script> <?php
			    die;
		    }
	    }
	    return $data;
    }

}
