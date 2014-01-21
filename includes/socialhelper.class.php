<?php
class saiob_include_socialhelper
{
	public function __construct()
	{

	}

	public function fbstatus($status)
	{
		$facebook_key = get_option('__saiob_facebookkeys');
		$facebook = new SAIOB_Facebook(array(
					'appId'  => $facebook_key[0],
					'secret' => $facebook_key[1],
					));

		$parse_url = parse_url($status['link']);
		/** 'message' => '[Status message]',
		    'name' => '[Post title]',
 		    'link' => '[Post image & title link]',
 		    'description' => '[Post description]',
 		    'picture'=> '[Post Thumbnail Location]' */
		$status_array = array('name' => $status['title'], 'link' => $status['link'], 'description' => $status['description'], 'picture' => $status['image']);
		# unset link if host is localhost. 
		if($parse_url['host'] == 'localhost')
			unset($status_array['link']);

		$facebook->setAccessToken($facebook_key[2]);
		$user = $facebook->getUser();
		if($user) 
		{
			try 
			{
				$response = $facebook->api('/me/feed', 'POST', $status_array);
				$msg = "Status updated on facebook. Id - {$response['id']}";
			}
			catch(SAIOB_FacebookApiException $e) 
			{
				$msg = $e->result['error']['message'];
				$user = null;
			}
		}
		else
		{
			$msg = 'User not loggedin to facebook';
		}
		return $msg;
	}

	/**
	 *  tweet using the keys given in settings
	 *  @param string $tweet 
	 *  @return string $msg 
	 **/
	public function tweet($tweet)
	{
		$twitter = get_option('__saiob_twitterkeys');
		$config = array(
				'consumer_key' => $twitter[0],
				'consumer_secret' => $twitter[1],
				'oauth_token' => $twitter[2],
				'oauth_token_secret' => $twitter[3],
				'output_format' => 'array'
			       );

		$obj = new TwitterOAuth_SAIO($config);
		$response = $obj->post('statuses/update', array('status' => $tweet,'include_entities' => true));

		if(isset($response['errors'][0]))
			$msg = "Message: ".$response['errors'][0]['message']." code: ".$response->errors[0]['code'];
		else
			$msg = "Tweeted successfully";
	
		return $msg;
	}
}
