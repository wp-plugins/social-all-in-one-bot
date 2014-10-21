<?php
/******************************
 * filename:    modules/queue/actions/actions.php
 * description: show queue 
 */

class QueueActions extends SkinnyActions 
{
	public $queuetablename;
	public $limit;
	public $start;
	public $targetpage;

	public function __construct()
	{
		$this->queuetablename = WP_SOCIAL_ALL_IN_ONE_BOT_QUEUE_TABLE;
		$this->limit = 15;
		$this->targetpage = 'admin.php?page=social-all-in-one-bot/index.php&__module=queue';
	}

	/**
	 * The actions index method
	 * @param array $request
	 * @return array
	 */
	public function executeIndex($request)
	{
		// return an array of name value pairs to send data to the template
		$data = array(); $where = '';
		global $wpdb;

		$page = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 0;
		if(empty($page) || ($page == 0)) 
			$page = 1;		

		if($page)
			$this->start = ($page - 1) * $this->limit;
		else
			$this->start = 0;

		# generate where condition
		if(isset($request['POST']))
		{
			$fromdate = isset($request['POST']['fromdate']) ? $request['POST']['fromdate'] : '';
			$todate = isset($request['POST']['todate']) ? $request['POST']['todate'] : '';
			$provider_filter = isset($request['POST']['provider_filter']) ? $request['POST']['provider_filter'] : '';
			if(!empty($fromdate) && !empty($todate))
				$where .= "createdtime >= '$fromdate' and createdtime <= '$todate' and";
			else if(!empty($fromdate))
				$where .= "createdtime >= '$fromdate' and";
			else if(!empty($todate))
				$where .= "createdtime <= '$todate' and";

			if(!empty($provider_filter))	
				$where .= " provider = '$provider_filter' and";

			if(!empty($where))	
			{
				$where = "where $where";
				$where = substr($where, 0, -3);
			}
		}

		$getqueuecount   = $wpdb->get_results("select count(*) as count from {$this->queuetablename} {$where}");
		$queuecount      = $getqueuecount[0]->count;

		$data['prev'] = $page - 1;						
		$data['next'] = $page + 1;					
		$data['lastpage'] = ceil($queuecount/$this->limit);
		$data['lpm'] = $data['lastpage'] - 1;	

		$query_to_get_queue = "select * from {$this->queuetablename} {$where} order by createdtime desc limit {$this->start}, {$this->limit}";
		$queuelist = $wpdb->get_results($query_to_get_queue);
		$data['queuecount'] = $queuecount;
		$data['queuelist'] = $queuelist;
		$data['targetpage'] = $this->targetpage;
		$data['page'] = $page;
		$data['filter'] = $this->generatefilter($request['POST']);
		return $data;
	}

	/**
	 * generate filter
	 * @return HTML $filter
	 **/
	public function generatefilter($post)
	{
		$filter = array();
		$fromdate = isset($post['fromdate']) ? $post['fromdate'] : '';
                $todate = isset($post['todate']) ? $post['todate'] : '';
                $provider_filter = isset($post['provider_filter']) ? $post['provider_filter'] : '';

		$provider = array('twitter' => 'Twitter', 'facebook' => 'Facebook');
		$provider_dd = "<select name = 'provider_filter' id = 'provider_filter'>";
		$provider_dd .= "<option value = ''> Select Provider </option>";
		foreach($provider as $keyprovider => $sprovider)
		{
			$selected_provider = '';
			if($provider_filter == $keyprovider)
				$selected_provider = 'selected';

			$provider_dd .= "<option $selected_provider value = '$keyprovider'> $sprovider </option>";
		}
		$provider_dd .= "</select>";
		$status = array('Succeed', 'Failed');
		$status_dd = "<select name = 'status_filter' id = 'status_filter' >";
		$status_dd .= "<option value = ''> Select Status </option>";
		foreach($status as $singlestatus)	
		{
			$status_dd .= "<option value = '$singlestatus'> $singlestatus </option>";
		}
		$status_dd .= "</select>";

		$filter  = "<div> <form name = 'saiob_filter' id = 'saiob_filter' method = 'post' action = '#'>";
		$filter .= "<div class = 'form-group'>";
		$filter .= "<div class = 'col-sm-2'> <input type = 'text' name = 'fromdate' id = 'fromdate' class = 'form-control' placeholder = 'From Date' value = '$fromdate'> </div>";
		$filter .= "<div class = 'col-sm-2'> <input type = 'text' name = 'todate' id = 'todate' class = 'form-control' placeholder = 'To Date' value = '$todate'> </div>";
		$filter .= "<div class = 'col-sm-2 text-center'> $provider_dd </div>";
		$filter .= "<div class = 'col-sm-0'style = 'width:12%';margin-right:10px;> </div>";
		$filter .= "<div class = 'col-sm-1'> <button type = 'button' style='width:32px;height:32px' name = 'deleteform' id = 'delete' onclick ='deleteItem()'  <span class='fa fa-trash-o'> </span></button> </div>";
		$filter .= "<div > <button type = 'button' onclick = 'checkfilter(this.form)' name = 'filter' class='btn btn-primary'> Filter </button> </div>";
		$filter .= "<input type = 'hidden' name = 'status_filter' id = 'status_filter'> </form> </div>";
		# div not closed here
		return $filter;	
	}
}
