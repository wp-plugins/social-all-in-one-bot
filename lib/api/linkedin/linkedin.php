<?php
require_once("OAuth.php");

class LinkedIn {
	public $base_url = "http://api.linkedin.com";
	public $secure_base_url = "https://api.linkedin.com";
	public $oauth_callback = "oob";
	public $consumer;
	public $request_token;
	public $access_token;
	public $oauth_verifier;
	public $signature_method;
	public $request_token_path;
	public $access_token_path;
	public $authorize_path;

	function __construct($consumer_key, $consumer_secret, $oauth_callback = NULL)
	{

		if($oauth_callback) {
			$this->oauth_callback = $oauth_callback;
		}

		$this->consumer = new OAuthConsumer($consumer_key, $consumer_secret, $this->oauth_callback);
		$this->signature_method = new OAuthSignatureMethod_HMAC_SHA1();
		$this->request_token_path = $this->secure_base_url . "/uas/oauth/requestToken";
		$this->access_token_path = $this->secure_base_url . "/uas/oauth/accessToken";
		$this->authorize_path = $this->secure_base_url . "/uas/oauth/authorize";
	}

	function getRequestToken()
	{
		$consumer = $this->consumer;
		$request = OAuthRequest::from_consumer_and_token($consumer, NULL, "GET", $this->request_token_path);
		$request->set_parameter("oauth_callback", $this->oauth_callback);
		$request->sign_request($this->signature_method, $consumer, NULL);
		$headers = Array();
		$url = $request->to_url();
		$response = $this->httpRequest($url, $headers, "GET");
		parse_str($response, $response_params);
		$this->request_token = new OAuthConsumer($response_params['oauth_token'], $response_params['oauth_token_secret'], 1);
	}

	function generateAuthorizeUrl()
	{
		$consumer = $this->consumer;
		$request_token = $this->request_token;
		return $this->authorize_path . "?oauth_token=" . $request_token->key;
	}

	function getAccessToken($oauth_verifier)
	{
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->request_token, "GET", $this->access_token_path);
		$request->set_parameter("oauth_verifier", $oauth_verifier);
		$request->sign_request($this->signature_method, $this->consumer, $this->request_token);
		$headers = Array();
		$url = $request->to_url();
		$response = $this->httpRequest($url, $headers, "GET");
		parse_str($response, $response_params);
		$this->access_token = new OAuthConsumer($response_params['oauth_token'], $response_params['oauth_token_secret'], 1);
	}

	function getProfile($resource = "~")
	{
		$profile_url = $this->base_url . "/v1/people/" . $resource;
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "GET", $profile_url);
		$request->sign_request($this->signature_method, $this->consumer, $this->access_token);
		$auth_header = $request->to_header("https://api.linkedin.com"); # this is the realm
		# This PHP library doesn't generate the header correctly when a realm is not specified.
		# Make sure there is a space and not a comma after OAuth
		// $auth_header = preg_replace("/Authorization\: OAuth\,/", "Authorization: OAuth ", $auth_header);
		// # Make sure there is a space between OAuth attribute
		// $auth_header = preg_replace('/\"\,/', '", ', $auth_header);

		// $response will now hold the XML document
		$response = $this->httpRequest($profile_url, $auth_header, "GET");
		return $response;
	}


	function postShare($msg, $title, $url, $imgURL='', $dsc) { $status_url = $this->base_url . "/v1/people/~/shares";
        //$status_url = $this->base_url . "/v1/people/~/network/updates?scope=self";
    #$dsc =  $this->nxs_decodeEntitiesFull(strip_tags($dsc));  $msg = strip_tags($this->nxs_decodeEntitiesFull($msg));  $title =  $this->nxs_decodeEntitiesFull(strip_tags($title));
    //$dsc =  $dsc;  $msg = $msg;  $title =  $title;
    $xml = '<?xml version="1.0" encoding="UTF-8"?><share><comment>'.htmlspecialchars($msg, ENT_NOQUOTES, "UTF-8").'</comment>'.
    ($url!=''?'<content><title>'.htmlspecialchars($title, ENT_NOQUOTES, "UTF-8").'</title><submitted-url>'.$url.'</submitted-url><submitted-image-url>'.$imgURL.'</submitted-image-url><description>'.htmlspecialchars($dsc, ENT_NOQUOTES, "UTF-8").'</description></content>':'').
    '<visibility><code>anyone</code></visibility></share>';//echo '<pre>';print_r($xml);
    $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "POST", $status_url);//echo '<pre>';print_r($request);
    $request->sign_request($this->signature_method, $this->consumer, $this->access_token);
    $auth_header = $request->to_header("https://api.linkedin.com");//echo '<pre>';print_r($auth_header);die;
    //if ($debug) echo $auth_header . "\n"; 
    $response = $this->httpRequest($status_url, $auth_header, "POST", $xml);
    return $response;
  }

	/*function postShare($tkn, $msg, $title='', $url='', $imgURL='', $dsc='') { $nURL = 'https://api.linkedin.com/v1/people/~/shares?format=json&oauth2_access_token='.$tkn;  
      #$dsc =  nxs_decodeEntitiesFull(strip_tags($dsc));  $msg = strip_tags(nxs_decodeEntitiesFull($msg));  $title =  nxs_decodeEntitiesFull(strip_tags($title));
	$dsc =  $dsc;  $msg = $msg;  $title =  $title;
      $xml = '<?xml version="1.0" encoding="UTF-8"?><share><comment>'.htmlspecialchars($msg, ENT_NOQUOTES, "UTF-8").'</comment>'.
      ($url!=''?'<content><title>'.htmlspecialchars($title, ENT_NOQUOTES, "UTF-8").'</title><submitted-url>'.$url.'</submitted-url><submitted-image-url>'.$imgURL.'</submitted-image-url><description>'.htmlspecialchars($dsc, ENT_NOQUOTES, "UTF-8").'</description></content>':'').
        '<visibility><code>anyone</code></visibility></share>'; $hdrsArr = array();  $hdrsArr['Content-Type']='application/xml';      
      $wprg = array( 'method' => 'POST', 'headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'body' => $xml);  $wprg['sslverify'] = false;      
      $response  = wp_remote_post($nURL, $wprg); if (is_wp_error($response) || empty($response['body'])) return "ERROR: ".print_r($response, true);      
      $post = json_decode($response['body'], true); return $post; 
    }*/


	function setStatus($status)
	{
		$profile_url = $this->base_url . "/v1/people/~";
		$status_url = $this->base_url . "/v1/people/~/current-status";
		echo "Setting status...\n";
		$xml = "<current-status>" . htmlspecialchars($status, ENT_NOQUOTES, "UTF-8") . "</current-status>";
		echo $xml . "\n";
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "PUT", $status_url);
		$request->sign_request($this->signature_method, $this->consumer, $this->access_token);
		$auth_header = $request->to_header("https://api.linkedin.com");

		$response = $this->httpRequest($profile_url, $auth_header, "GET");
		return $response;
	}

	# Parameters should be a query string starting with "?"
	# Example search("?count=10&start=10&company=LinkedIn");
	function search($parameters)
	{
		$search_url = $this->base_url . "/v1/people-search:(people:(id,first-name,last-name,picture-url,site-standard-profile-request,headline),num-results)" . $parameters;
		//$search_url = $this->base_url . "/v1/people-search?keywords=facebook";

		echo "Performing search for: " . $parameters . "<br />";
		echo "Search URL: $search_url <br />";
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "GET", $search_url);
		$request->sign_request($this->signature_method, $this->consumer, $this->access_token);
		$auth_header = $request->to_header("https://api.linkedin.com");
		$response = $this->httpRequest($search_url, $auth_header, "GET");
		return $response;
	}

	function httpRequest($url, $auth_header, $method, $body = NULL)
	{
		//echo '<pre>';print_r($url.','.$auth_header.', hello '. $method);die;
		if (!$method) {
			$method = "GET";
		};
		//echo '<pre>';print_r($url.','.$auth_header.','. $method);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header)); // Set the headers.
		//echo '<pre>';print_r(curl_exec($curl));die;
		if ($body) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header, "Content-Type: text/xml;charset=utf-8"));
			//curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header));
			//echo '<pre>';print_r(curl_exec($curl));die;
		}

		$data = curl_exec($curl);
		curl_close($curl);
		return $data;
	}
	/*function httpRequest($url, $auth_header, $method, $body = NULL) { // $this->debug = true; //if (!is_array($auth_header)) $auth_header = array($auth_header);
    if (!is_array($auth_header)) $auth_header = array($auth_header); 
    if (!$method) $method = "GET"; $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $auth_header); // Set the headers.

    if ($body) { $auth_header[] = "Content-Type: text/xml;charset=utf-8";
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $auth_header);   
    }
    global $nxs_skipSSLCheck; if ($nxs_skipSSLCheck===true) curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($curl); $errmsg = curl_error($curl); //prr($data);// die();
    
    //## NextScripts Fix
    if (curl_errno($curl) == 60 || stripos($errmsg, 'SSL')!==false) {  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); $data = curl_exec($curl);}
    if (curl_errno($curl) > 0) { $err = curl_errno($curl); $errmsg = curl_error($curl); prr($errmsg); prr($err);}    
    //## /NextScripts Fix    
    $header = curl_getinfo($curl); curl_close($curl);// prr($header);

    if ($this->debug) echo $data . "\n";    
        if (trim($data)=='' && ($header['http_code']=='201' || $header['http_code']=='200' || $header['http_code']=='202')) $data = '201';
    return $data; 
  }*/

}
