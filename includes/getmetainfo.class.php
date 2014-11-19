<?php
/**
 *  class created html for twitter / facebook etc.
 *  also deal with page to fetch the tag information
 **/
class saiob_include_getmetainfo
{
	public function __construct()
	{

	}

	/**
         *  make metahtml
         *  @param array $metainfo
         *  @return html $html
         **/
        public static function makemetahtml($metainfo, $provider = null, $call, $smartbotvalues, $url, $timetorun)
        {
		global $wpdb;
		$default_maxchars = 100;
		$calltoaction = $smartbotvalues[4];
		$period = $smartbotvalues[7];
		$queuetablename = WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE;
		$dateorweek = '';

		if($period == 'Weekly')
		{
			$dateorweek = $smartbotvalues[11];
		}
		else if($period == 'Date')
		{
			$dateorweek = $smartbotvalues[12];
		}

		if($provider == 'facebook')
		{
			$imagein = false;
			$parse_url = parse_url($url);

			$html['image'] = isset($metainfo['image']) ? $metainfo['image'] : '';
			$html['title'] = isset($metainfo['title']) ? $metainfo['title'] : '';
			$html['link'] = $url;

			$maxchars = !empty($smartbotvalues[0]) && $smartbotvalues != 0 ? $smartbotvalues[0] : $default_maxchars;
			$metainfo['description'] = isset($metainfo['description']) ? $metainfo['description'] : '';
                        if(strlen($metainfo['description']) >= $maxchars)
                                $metainfo['description'] = substr($metainfo['description'], 0 ,$maxchars).'...';

			# check if title and description is empty. If so return immediately. No need to insert into table.
			if(empty($metainfo['title']) && empty($metainfo['description']))
			{
                        	if($call == 'ajax')     {
                	                print_r($html);die;
        	                }
	                        else {
                                	return $html;
                        	}
			}
                        # check ends here

			if($smartbotvalues[5] == 'on' && !empty($metainfo['description']))
                                $metainfo['description'] = $metainfo['description'].' '.$calltoaction;
	
		}
		else if($provider == 'twitter')
		{
			$rand = array();$html = array();
			$metainfo['title'] = isset($metainfo['title']) ? $metainfo['title'] : '';
			$metainfo['description'] = isset($metainfo['description']) ? $metainfo['description'] : '';
			$html['text'] = $metainfo['title'].' '.$metainfo['description'];
			$splited_tag = explode(',', $smartbotvalues[1]);
			$tagnos = $smartbotvalues[3];

			$maxchars = !empty($smartbotvalues[0]) && $smartbotvalues != 0 ? $smartbotvalues[0] : $default_maxchars;

			$html['text'] = trim($html['text']);
			# check if text is empty. If so return immediately, no need to insert into table.
			if(empty($html['text']))
			{
                        	if($call == 'ajax')     {
                	                print_r($html);die;
        	                }
	                        else {
                                	return $html;
                        	}
			}
                        # check ends here

			$checkcount = 0;
			for($i = 0; $i < $tagnos; )
			{
				if($checkcount >= 10)
					break;

				$randno = rand(0, $tagnos);
				if(!in_array($randno, $rand))	{
					$rand[] = $randno;
					$i = $i + 1;
				}
				$checkcount = $checkcount + 1;
			}

			$tag = null;
			foreach($rand as $singlerand)
			{
				if(isset($splited_tag[$singlerand]))
					$splittedtag = trim($splited_tag[$singlerand]);

				if(!empty($splittedtag))
					$tag .= " #{$splittedtag}";
			}

			if($smartbotvalues[2] == 'on' && !empty($html['text']))
				$html['hashtags'] = $tag;

			if($smartbotvalues[5] == 'on' && !empty($html['text']))
				$html['text'] = $html['text'].' '.$calltoaction;

			# adding html at the end of the tweet
			$html['url'] = $url;
			
			# no need to pass array. generate tweet here and pass the generated tweet
			# check hashtag count
                       
			$hashlength = strlen($html['hashtags']);
			$urllength  = strlen($html['url']);
			if($maxchars >= ($hashlength + $urllength))	
			{
				$remaining  = $maxchars - ($hashlength + $urllength);
				if(strlen($html['text']) >= $remaining - 2)
					$html['text'] = substr($html['text'], 0 ,$remaining - 2).' ';

				$html = $html['text'].$html['hashtags'].' '.$html['url'];
			}
			else
			{
				if($maxchars >= $hashlength)
				{
					$remaining  = $maxchars - $hashlength;
	                                if(strlen($html['text']) >= $remaining - 2)
					{
        	                                $html['text'] = substr($html['text'], 0 ,$remaining - 2).' ';
					}
					$html = $html['text'].$html['hashtags'];
				}
				else
				{
					if(strlen($html['text']) >= $maxchars)	
					{
	                                        $html = substr($html['text'], 0 ,$maxchars);
					}
					else
					{
						$html = $html['text'];
					}
				}
			}
		}

		# adding entry to queue table
		$scheduledtime = date("Y-m-d H:i:s");
		$serializedhtml = maybe_serialize($html);
		if($period == 'Date')
		{
			$fromdate = $smartbotvalues[12];
			$todate   = $smartbotvalues[13];

			$dateorweek = $fromdate;

			$datetime1 = new DateTime($fromdate);
			$datetime2 = new DateTime($todate);
			$interval  = $datetime1->diff($datetime2);
			$days_interval = $interval->d + 1;

			for($i = 1; $i <= $days_interval; $i ++)
			{
				$smartbotvalues[7] = mysql_real_escape_string($smartbotvalues[7]);
				$serializedhtml = mysql_real_escape_string($serializedhtml);
				$wpdb->query("insert into $queuetablename (provider, period, socialmessage, scheduledtimetorun, dateorweek) value ('$provider', '{$smartbotvalues[7]}', '$serializedhtml', '$timetorun', '$dateorweek')");
				$dateorweek = date('Y-m-d', strtotime($dateorweek . ' + 1 day'));
			}
		}
		else
		{
			$smartbotvalues[7] = mysql_real_escape_string($smartbotvalues[7]);
			$serializedhtml = mysql_real_escape_string($serializedhtml);
			$wpdb->query("insert into $queuetablename (provider, period, socialmessage, scheduledtimetorun, dateorweek) value ('$provider', '{$smartbotvalues[7]}', '$serializedhtml', '$timetorun', '$dateorweek')");
		}

                if($call == 'ajax')     {
                        print_r($html);die;
                }
                else {
                        return $html;
                }
        }

	/**
	 *  schedule time for post 
	 *  @param int $count
  	 *  @param array $values
   	 *  @return array $time
	 **/
	public function scheduletime($count, $values)
	{
		$period   = $values[7];
		$fromtime = date('Y-m-d').' '.$values[8].':00';
		$totime   = date('Y-m-d').' '.$values[9].':00';

		$timestamp_start = strtotime($fromtime);
		$timestamp_end   = strtotime($totime);

		$timedifference  = $timestamp_end - $timestamp_start;
		$time = $timedifference/$count;

		# convert seconds into minutes
		$timeinterval = $time/60;
		$timeinterval = floor($timeinterval);
		return $timeinterval; # $timeinterval post per minute
	}

	/**
	 *  make url from given type and id
	 *  @param string $type ** post/page **
	 *  @param int $id ** post/page id **
	 *  @return url $url
	 **/
	public static function makeurl($type, $id)
	{
		if($type == 'Page')
			$url = "/?page_id=".$id;
		else if($type == 'Post')
			$url = "/?p=".$id;

		$site_url = site_url();
		$url = $site_url.$url;
		return $url;
	}

	/**
	 *  return given tagname's content
	 *  @param object $dom_document
	 *  @param char $tagname
	 *  @return array $tagcontent
	 **/
	public static function getmetainformation($dom_document, $tagname)
	{
		$tagcontent = array();
		$dom_xpath = new DOMXpath($dom_document);
		$elements = $dom_document->getElementsByTagName($tagname);
		if(!is_null($elements))
		{
			$i = 0;
			foreach ($elements as $element)
			{
				if($tagname == 'img')
					$nodes = $element->attributes;
				else
					$nodes = $element->childNodes;

				foreach ($nodes as $node)
				{
					$nodevalue = trim($node->nodeValue);
					if($tagname == 'img')
					{
						$nodename = trim($node->nodeName);
						if(isset($nodename) && !empty($nodename) && $nodename != NULL && $nodename == 'src')
						{
							$tagcontent[$tagname][$i] = $nodevalue;
							$i ++;
						}
					}
					else
					{
						if(isset($nodevalue) && !empty($nodevalue) && $nodevalue != NULL)
						{
							$tagcontent[$tagname][$i] =  $nodevalue;
							{
								$tagcontent[$tagname][$i] =  $nodevalue;
								$i ++;
							}
						}
					}
				}
			}
			return $tagcontent;
		}
	}

	/**
	 *  return seo plugin key value for title and description
	 *  @return array $seo
	 **/
	public function getseopluginkeyvalue()
	{
		$seo = array();
		$seo['yoast']  = array('title' => '_yoast_wpseo_title', 'metadesc' => '_yoast_wpseo_metadesc');
		$seo['aioseo'] = array('title' => '_aioseop_title', 'metadesc' => '_aioseop_description');
		return $seo;
	}

	public function getvariationone($templatevalues, $smartbotvalues, $provider, $postvalues, $url, $timetorun, $postid)
	{
		$metainformation = array();
		$seokeys = $this->getseopluginkeyvalue();
		$selectedseo = isset($smartbotvalues['saiob_seoplugin']) ? $smartbotvalues['saiob_seoplugin'] : '';

		$postmeta = get_post_meta($postid);
		# fetching meta description 
		if(isset($templatevalues['metadesc']) && $templatevalues['metadesc'] == 'on' && isset($selectedseo['title']))
		{
			$metainformation['description'] = $postmeta[$selectedseo['title']];
		}
		# fetching meta description ends here

		# fetching meta title
		if(isset($templatevalues['metatitle']) && $templatevalues['metatitle'] == 'on' && isset($selectedseo['metadesc'])) 
		{
			$metainformation['title'] = $postmeta[$selectedseo['metadesc']];
		}
		# fetching title ends here
		$html = saiob_include_getmetainfo::makemetahtml($metainformation, $provider, 'normal', $smartbotvalues, $url, $timetorun);
		return $metainformation;
	}

	public function getvariationtwo($templatevalues, $smartbotvalues  , $provider, $postvalues, $url, $timetorun)
	{
		$metainformation = array();
		# fetch post/page title
		$metainformation['title'] = $postvalues->post_title;
		# fetch post/page title ends here

		# fetch post/page description
		$postcontent = $postvalues->post_content;
		$dom = new DOMDocument();
    		$dom->loadHTML($postcontent);

		# adding p content which contains highest chars
		$ptags   = saiob_include_getmetainfo::getmetainformation($dom, 'p');
		usort($ptags['p'],'saiob_include_getmetainfo::array_sort');
		$selected_p_tag = $ptags['p'][0];

		$metainformation['description'] = $selected_p_tag;
		$metainformation['image'] = saiob_include_getmetainfo::getimagefromdom($dom);

		$html = saiob_include_getmetainfo::makemetahtml($metainformation, $provider, 'normal', $smartbotvalues, $url, $timetorun);
		return array($html);	
	}

	function array_sort($a, $b)	{
    		return strlen($b)-strlen($a);
	}

	public function getvariationthree($templatevalues, $smartbotvalues  , $provider, $postvalues, $url, $timetorun)
	{
		$metainformation = array();
		# fetch post/page description
		$postcontent = $postvalues->post_content;
		$dom = new DOMDocument();
    		$dom->loadHTML($postcontent);
		if(isset($templatevalues['htag']) && $templatevalues['htag'] == 'on')
		{
			$metainfo = array();
                        $list = array('h1', 'h2', 'h3');
			foreach($list as $singleList)
			{
				$result   = saiob_include_getmetainfo::getmetainformation($dom, $singleList);
				$metainfo = array_merge($metainfo, $result);
			}

			if(!empty($metainfo['h1']))
				$metainformation['title'] = $metainfo['h1'][0];
			else if(!empty($metainfo['h2']))
				$metainformation['title'] = $metainfo['h2'][0];
			else if(!empty($metainfo['h3']))
				$metainformation['title'] = $metainfo['h3'][0];
		}
		$metainformation['description'] = $postvalues->post_excerpt;
                $metainformation['image'] = saiob_include_getmetainfo::getimagefromdom($dom);

		# fetch post/page description ends here
		$html = saiob_include_getmetainfo::makemetahtml($metainformation, $provider, 'normal', $smartbotvalues, $url, $timetorun);	
		return array($html);	
	}

	/**
	 *  get all images from the page/post. return 1st image
	 *  @param obj $dom
	 *  @response string $selectedimage (imageurl)
	 **/
	public static function getimagefromdom($dom)
	{
		$images = saiob_include_getmetainfo::getmetainformation($dom, 'img');
                $selectedimage = isset($images['img'][0]) ? $images['img'][0] : '';
		return $selectedimage;
	}
}
