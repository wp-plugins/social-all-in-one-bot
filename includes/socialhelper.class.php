<?php
class saiob_include_socialhelper
{
	public function __construct()
	{

	}

	public function fbstatus($status)
	{
		$facebook_key = get_option('__saiob_facebookkeys');
		$facebook = new SAIOB_Facebook(array('appId'  => $facebook_key[0], 'secret' => $facebook_key[1] ,'fileUpload' => true,'cookie' => true));
                $facebook->setFileUploadSupport(true);

		if(!isset($status['title']))
			$status['title'] = '';

		if(!isset($status['description']))
			$status['description'] = '';

		if(!isset($status['image']))
			$status['image'] = '';

                if(!isset($status['img_path'])) 
                        $status['img_path'] = '';
               
                if(!isset($status['link_url'])) 
                        $status['link_url'] = '';
 
		if(isset($status['link_post']) && $status['link_post'] == 'true')
		{	# if we have image url, we can pass here. fb will take care eventhough we dont have description and title
                        
			$status_array = array('name' => $status['title'], 'link' => $status['link_url'], 'description' => $status['description']);
		}
		else if(isset($status['image_post']) && $status['image_post'] == 'true')
		{	# we cant generate bs using title alone. so posting message only
                         $user                    = $facebook->getUser();
                         $status_array['message'] = $status['description'];
                         $file                    = $status['img_path']; //Example image file
                         $status_array['source']  = '@' . $file;
                       
		}
                else 
                {       # we cant generate bs using title alone. so posting message only
                        $status_array = array('message' => $status['description']);
                }

                       # unset link if host is localhost. if not, it will return error.
		$parse_url = parse_url($status['link']);
		if($parse_url['host'] == 'localhost')
			unset($status_array['link']);
		$facebook->setAccessToken($facebook_key[2]);
		try 
		{
		      if(isset($status['image_post']) && $status['image_post'] == 'true') { $response = $facebook->api('/me/photos', 'POST', $status_array); }
                      else { $response = $facebook->api('/me/feed', 'POST', $status_array); }
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
		$twitterobj = new OAuth_SAIO($config);
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
		$config =  array(
				'consumer_key' => $twitter[0],
				'consumer_secret' => $twitter[1],
				'token' => $twitter[2],
				'secret' => $twitter[3],
				'output_format' => 'array'
			       );
                 if(!isset($tweet['title']))
                        $tweet['title'] = '';

                if(!isset($tweet['description']))
                        $tweet['description'] = '';

                if(!isset($tweet['image']))
                        $tweet['image'] = '';

                if(!isset($tweet['img_path']))
                        $tweet['img_path'] = '';

                if(!isset($tweet['link_url']))
                        $tweet['link_url'] = '';

               $obj = new TwitterOAuth_SAIO($config);
               if((isset($tweet['link_post']) && $tweet['link_post'] == 'true') || (isset($tweet['image_post']) && $tweet['image_post'] == 'true' ) ) { 
               $response = $obj->request('POST', 'https://api.twitter.com/1.1/statuses/update_with_media.json', array( 'media[]' => "@{$tweet['img_path']}", 'status' => $tweet['description']), true, true);
                     }
               else {
		$response = $obj->request('POST', $obj->url('1.1/statuses/update'), array('status' =>$tweet['description']));
                 }

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

	public function tweetcard($tweetcard)
        {
                $twitter = get_option('__saiob_twittercardskeys');
                $config =  array(
                                'consumer_key' => $twitter[0],
                                'consumer_secret' => $twitter[1],
                                'token' => $twitter[2],
                                'secret' => $twitter[3],
                                'output_format' => 'array'
                               );
               	if(!isset($tweetcard['title']))
                        $tweetcard['title'] = '';

                if(!isset($tweetcard['description']))
                        $tweetcard['description'] = '';

                if(!isset($tweetcard['link_url']))
                        $tweetcard['link_url'] = '';

		$obj = new TwitterOAuth_SAIO($config);
		if((isset($tweet['link_post']) && $tweet['link_post'] == 'true')) {
			$response = $obj->request('POST', 'https://api.twitter.com/1.1/statuses/update_with_media.json', array( 'media[]' => "@{$tweetcard['link_post']}",'status' => $tweetcard['description']), true, true);
		}
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
