<?php
class saiob_include_socialhelper
{
	public function __construct()
	{

	}

	public function fbstatus($status)
	{
		$facebook_key = get_option('__saiob_facebookkeys');
		$facebook = new SAIOB_Facebook(array('appId'  => $facebook_key[0], 'secret' => $facebook_key[1]));

		if(!isset($status['title']))
			$status['title'] = '';

		if(!isset($status['description']))
			$status['description'] = '';

		if(!isset($status['image']))
			$status['image'] = '';

		if(isset($status['image']) && !empty($status['image']))
		{	# if we have image url, we can pass here. fb will take care eventhough we dont have description and title
			$status_array = array('name' => $status['title'], 'link' => $status['link'], 'description' => $status['description'], 'picture' => $status['image']);
		}
		else if(isset($status['description']) && !empty($status['description']) && isset($status['description']) && !empty($status['description']))
		{	# if we have title and description then we can generate bs
			$status_array = array('name' => $status['title'], 'link' => $status['link'], 'description' => $status['description']);
		}
		else
		{	# we cant generate bs using title alone. so posting message only
			$status_array = array('message' => $status['title']);
		}

		# unset link if host is localhost. if not, it will return error.
		$parse_url = parse_url($status['link']);
		if($parse_url['host'] == 'localhost')
			unset($status_array['link']);

		$facebook->setAccessToken($facebook_key[2]);
		try 
		{
			$response = $facebook->api('/me/feed', 'POST', $status_array);
			$msg['message'] = "Status updated on facebook. Id - {$response['id']}";
			$msg['result'] = 'Succeed';
		}
		catch(SAIOB_FacebookApiException $e) 
		{
			$msg['message'] = $e->result['error']['message'];
			$msg['result'] = 'Failed';
		}
		return $msg;
	}

	/**
	 *  check whether twitter api key is correct
	 *  @param array $config ** twitter keys **
	 *  @return array $response
	 **/
	public function validatetwitter($config)
	{
		$twitterobj = new TwitterOAuth_SAIO($config);
		$response = $twitterobj->get('account/verify_credentials');	
		return $response;
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
		{
			$msg['message'] = "Message: ".$response['errors'][0]['message']." code: ".$response['errors'][0]['code'];
			$msg['result'] = 'Failed';
		}
		else
		{
			$msg['message'] = "Tweeted successfully";
			$msg['result'] = 'Succeed';
		}
		return $msg;
	}
}
