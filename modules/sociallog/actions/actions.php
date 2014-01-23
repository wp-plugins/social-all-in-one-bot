<?php
/**
 * filename:    modules/sociallog/actions/actions.php
 * description: show social logs
 **/
class SociallogActions extends SkinnyActions 
{
	public $queuetablename;
        public $limit;
        public $start;
        public $targetpage;

	public function __construct()
	{
		$this->queuetablename = WP_SOCIAL_ALL_IN_ONE_BOT_LOG_TABLE;
                $this->limit = 15;
                $this->targetpage = 'admin.php?page=social-all-in-one-bot/saiob.php&__module=sociallog';
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
		global $wpdb;
		$page = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 0;
                if(empty($page) || ($page == 0))
                        $page = 1;

                if($page)
                        $this->start = ($page - 1) * $this->limit;
                else
                        $this->start = 0;

                $getqueuecount   = $wpdb->get_results("select count(*) as count from {$this->queuetablename}");
                $queuecount      = $getqueuecount[0]->count;

                $data['prev'] = $page - 1;
                $data['next'] = $page + 1;
                $data['lastpage'] = ceil($queuecount/$this->limit);
                $data['lpm'] = $data['lastpage'] - 1;

                $query_to_get_queue = "select * from {$this->queuetablename} limit {$this->start}, {$this->limit}";
                $queuelist = $wpdb->get_results($query_to_get_queue);
                $data['logcount'] = $queuecount;
                $data['socialloglist'] = $queuelist;
                $data['targetpage'] = $this->targetpage;
                $data['page'] = $page;
		return $data;
	}

}
