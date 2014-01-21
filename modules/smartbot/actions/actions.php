<?php
/******************************
 * filename:    modules/smartbot/actions/actions.php
 * description: SmartBOT
 */
class SmartbotActions extends SkinnyActions 
{
	public static $types = array('Post', 'Page');

	public function __construct()
	{

	}

        /**
         *  return container HTML for bulk composer
         *  @param string $templatename
         *  @return HTML $container
         **/
        public function saiob_gettemplate($templatename)
        {
                $skinnycontroller = new SkinnyController();
                $dropdownlist = $skinnycontroller->types;

		$bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
		$gettemplate  = "<select name = 'bulkcomposertemplate' id = 'bulkcomposertemplate'>";
                $gettemplate .= "<option value = ''> Create New Template </option>";
                if($bulktemplate)
                {
                        foreach($bulktemplate as $singletemplate)
                        {
                                $gettemplate .= "<option value = '{$singletemplate['templatename']}'> {$singletemplate['templatename']} </option>";
                        }
                }
                $gettemplate .= "</select>";

                if(empty($templatename))        
		{
                        $mode = 'create';
                        $datediv_display = 'display:create';
                        $iddiv_display = 'display:none';
                        $templatenametype = 'text';
                        $tempname = "<label class = 'control-label col-sm-3'> Template Name </label> <div class = 'col-sm-8'> <input type = '$templatenametype' name = 'templatename' id = 'templatename' value = '$templatename_composer' class = 'form-control'> </div>";
                }
                else
                {
                        $mode = 'edit';
                        $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                        foreach($bulktemplate as $templatekey => $singletemplate)
                        {
                                if($singletemplate['templatename'] == $templatename)    {
                                        $templatevalue = $bulktemplate[$templatekey];
                                        break;
                                }
                        }

                        if($templatevalue['settingstype'] == 'Date')
                        {
                                $datediv_display = 'display:block';
                                $iddiv_display = 'display:none';
                        }
                        else
                        {
                                $datediv_display = 'display:none';
                                $iddiv_display = 'display:block';
                        }

                        $fromid = $templatevalue['fromid'];
                        $toid = $templatevalue['toid'];
                        $fromdate = $templatevalue['fromdate'];
                        $todate = $templatevalue['todate'];

                        $templatenametype = 'hidden';
                        $templatename_composer = $templatename;
                        $metatitle = empty($templatevalue['metatitle']) ? '' : 'checked';
                        $posttitle = empty($templatevalue['posttitle']) ? '' : 'checked';
                        $htag = empty($templatevalue['htag']) ? '' : 'checked';

                        $metadescription = empty($templatevalue['metadescription']) ? '' : 'checked';
                        $postcontent = empty($templatevalue['postcontent']) ? '' : 'checked';
                        $excerptmsg = empty($templatevalue['excerptmsg']) ? '' : 'checked';
                        $images = empty($templatevalue['images']) ? '' : 'checked';
                        $video = empty($templatevalue['video']) ? '' : 'checked';

                        $thumbnails = empty($templatevalue['metatitle']) ? '' : 'checked';
                        $variation = $templatevalue['variation'];
                        $keyword_check = empty($templatevalue['keyword_check']) ? '' : 'checked';
                        $keyword = $templatevalue['keyword'];

                        $charbefore = $templatevalue['charbefore'];
                        $charafter = $templatevalue['charafter'];
                        $tags = $templatevalue['tags'];

                        $tempname = "<span style = 'float:left;width:100px;'> </span> <span style = 'padding-left:10px;width:350px;float:left;'>  <input type = '$templatenametype' name = 'templatename' id = 'templatename' value = '$templatename_composer' class = 'form-control'> </span>";
                }

                $settingstype_array = array('Date', 'ID');
                $settingstype = "<select name = 'settingstype' id = 'settingstype' onchange = 'changetype(this.value)'>";
                foreach($settingstype_array as $singlesettingstype)     {
                        $settings_selected = '';
                        if($singlesettingstype == $templatevalue['settingstype'])
                                $settings_selected = "selected = 'selected'";

                        $settingstype .= "<option $settings_selected value = '$singlesettingstype'> $singlesettingstype </option>";
                }
                $settingstype .= "</select>";

                $dropdown = '<select name = "type" class = "form-control" style = "padding:5px;" id = "type">';
                $dropdown .= '<option name = ""> Select </option>';
                foreach($dropdownlist as $singledropdownlist)   {
                        $dropdown_selected = '';
                        if($singledropdownlist == $templatevalue['type'])
                                $dropdown_selected = "selected = 'selected'";

                        $dropdown .= "<option {$dropdown_selected} name = '$singledropdownlist'> $singledropdownlist </option>";
                }

                $dropdown .= '</select>';
                $data['dropdown'] = $dropdown;

                $container = "
        <form class='form-horizontal' method = 'POST' id = 'bulkcomposertemplate' name = 'bulkcomposertemplate' role='form' action = 'admin.php?page=social-all-in-one-bot/saiob.php&__module=bulkcomposer'>
        <input type = 'hidden' name = 'mode' id = 'mode' value = '$mode'>
        <div class = 'header_settings form-group' style = 'width:100%; margin-top: 20px; margin-left: 20px;'>
		<div class = 'form-group'> 
			<label class = 'col-sm-2 text-right'> Select Template </label>
			<div class = 'col-sm-4'> $gettemplate </div>
		</div>
                <div class = 'form-group'>
                        <label class = 'control-label col-sm-2'> Select Source </label>
                        <div class = 'col-sm-10'>
                                <div class = 'col-sm-2'> {$data['dropdown']} </div>
                                <div class = 'col-sm-2'> {$settingstype} </div>
                                <div id = 'date_div' style = '$datediv_display'>
                                        <span style = 'float:left;padding-left:10px;'> <label class='control-label' style='float:left;padding:10px;'> From </label> </span> <span style = 'float:left;padding-left:10px;'> <input type = 'text' name = 'fromdate' id = 'fromdate' class='form-control' placeholder = 'From Date' readonly value = '$fromdate'> </span>
                                        <div style = 'float:left;padding-left:10px;'> <label class='control-label' style='float:left;padding:10px;'> To </label> </span> <span style = 'float:left;padding-left:10px;'> <input type = 'text' name = 'todate' id = 'todate' class='form-control' placeholder = 'To Date' readonly value = '$todate'> </div>
                                </div>
                                <span id = 'id_div' style = '$iddiv_display'>
                                        <span style = 'float:left;padding-left:10px;'> <label class='control-label' style='float:left;padding:10px;'> From </label> </span> <span style = 'float:left;padding-left:10px;'> <input type = 'text' name = 'fromid' id = 'fromid' class='form-control' placeholder = 'From Id' value = '$fromid'> </span>
                                        <span style = 'float:left;padding-left:10px;'> <label class='control-label' style='float:left;padding:10px;'> To </label> </span> <span style = 'float:left;padding-left:10px;'> <input type = 'text' name = 'toid' id = 'toid' class='form-control' placeholder = 'To Id' value = '$toid'> </span>
                                </span>
                        </div>
                </div>
        </div>";

                $container .= "<div style = 'padding-top:20px;'> </div>";
                $container .= "<div class = 'form-group'> <label class = 'col-sm-1'> </label> <label class = 'col-sm-2'> Variation 1 </label>  <label class = 'col-sm-2'> Variation 2 </label> </div>";

                $container .= "<div id = 'template_saiob' style = 'width:100%'>
                                <div class = 'form-group'>
                                        <label class='control-label col-sm-1'> Title </label>
                                        <label class='checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'posttitle' id = 'posttitle' $posttitle> Post Title </label>
                                        <label class='checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'htag' id = 'htag' $htag> H1, H2, H3 </label>
                                </div>
                                <div class = 'form-group'>
                                        <label class = 'control-label col-sm-1'> Message </label>
                                        <label class = 'checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'postcontent' id = 'postcontent' $postcontent> Post Content </label>
                                        <label class='checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'excerptmsg' id = 'excerptmsg' $excerptmsg> Excerpt </label>
                                </div>
                                <div class = 'form-group'>
                                        <label class='control-label col-sm-1'> Media </label>
                                        <label class='checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'images' id = 'images' $images> Images </label>
                                </div>";
		$container .=  "<div class = 'form-group' style = 'padding-top:20px;'>
			<div class = 'col-sm-5'> $tempname </div>
			<div class = 'col-sm-5'>
			<button type='button' class='btn btn-primary' onclick = 'savebulkcomposertemplate(this.form)'> Save Template </button>
			</div>
			<span id = 'metainformationgif' style = 'display:none'> <img src = '".WP_SOCIAL_ALL_IN_ONE_BOT_DIR."images/loading.gif' alt = 'loading'> </span>
			</div> </div>
			</form>

			<div class = 'footer_settings'>

			</div>
			<script type = 'text/javascript'>
			jQuery(document).ready(function() {
					jQuery('#todate').datepicker({
						dateFormat : 'yy-mm-dd'
						});
					});

			jQuery(document).ready(function() {
				jQuery('#fromdate').datepicker({
					dateFormat : 'yy-mm-dd'
				});
			});
		</script>";
                return $container;
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
		# storing template information starts here
		if($request['POST']['mode'] && !empty($request['POST']['mode']))
                {
                        $mode = $request['POST']['mode'];
			$alreadypresent = false;
			$templatename = $request['POST']['templatename'];
                        $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                        if(empty($bulktemplate))
                                $bulktemplate = array();

                        unset($request['POST']['mode']);
                        $data['notification'] = "Template Added Successfully.";
			$data['notificationclass'] = 'alert-success';

                        if($mode == 'create' && empty($request['POST']['bulkcomposertemplate']))
                        {
				# check whether template already added. If so dont save the template. Show error
				foreach($bulktemplate as $singletemplate)
				{
					if($singletemplate['templatename'] == $templatename)	{
						$alreadypresent = true;
						$data['notification'] = "Template Name already present.";
                        			$data['notificationclass'] = 'alert-warning';
					}
				}

				if(!$alreadypresent)	{
                               		$updated_bulktemplate = array_merge($bulktemplate, array($request['POST']));
				}
                        }
                        else
                        {
                                foreach($bulktemplate as $templatekey => $singletemplate)
                                {
                                        if($singletemplate['templatename'] == $templatename)    {
                                                break;
                                        }
                                }
                                $bulktemplate[$templatekey] = $request['POST'];
                                $updated_bulktemplate = $bulktemplate;
				$data['notification'] = "Template Updated Successfully.";
               			$data['notificationclass'] = 'alert alert-success';
                        }
                        update_option('__wp_saiob_bulkcomposer_template', $updated_bulktemplate);
                }
		# storing template information ends here

		$saiobhelper = new saiob_include_saiobhelper();
		$data['bulkcomposer'] = $saiobhelper->saiob_gettemplate($request['POST']['templatename']);
		$bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                $gettemplate  = "<select name = 'bulkcomposer_template' id = 'bulkcomposer_template'>";
		$gettemplate .= "<option value = ''> Select Template </option>";
                if($bulktemplate)
                {
                        foreach($bulktemplate as $singletemplate)
                        {
                                $gettemplate .= "<option value = '{$singletemplate['templatename']}'> {$singletemplate['templatename']} </option>";
                        }
                }
                $gettemplate .= "</select>";
                $data['bulkcomposer_template'] = $gettemplate;

		$botarray = array('googlebot', 'facebookbot', 'twitterbot');
		foreach($botarray as $singlebot)
		{
			$frequency_array =  array('1', '2', '3');
			$frequency  = "<select name = '".$singlebot."_frequency' id = '".$singlebot."_frequency'>";
			foreach($frequency_array as $singleFrequency)   {
				$frequency .= "<option value = '$singleFrequency'> $singleFrequency </option>";
			}
			$frequency .= "</select>";
			$data[$singlebot.'_frequency'] = $frequency;

			$period_array = array('Daily', 'Weekly', 'Date');
			$period = "<select name = '".$singlebot."_period' id = '".$singlebot."_period' onchange = 'showdatediv(this.value, \"$singlebot\" )'>";
			foreach($period_array as $singlePeriod) {
				$period .= "<option value = '$singlePeriod'> $singlePeriod </option>";
			}
			$period .= "</select>";
			$data[$singlebot.'_period'] = $period;

			$weekly_array = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
			$weekly = "<select name = '".$singlebot."_weekly' id = '".$singlebot."_weekly'>";
			foreach($weekly_array as $singleWeek)   {
				$weekly .= "<option value = '$singleWeek'> $singleWeek </option>";
			}
			$weekly .= "</select>";
			$data[$singlebot.'_weekly'] = $weekly;

			$googlbot_hours_from = "<select name = '".$singlebot."_hours_from' id = '".$singlebot."_hours_from'>";
			for($hours = 0; $hours < 24; $hours ++)
			{
				for($mins=0; $mins<60; $mins+=30)
				{
					$datetime = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
					$googlbot_hours_from .= "<option value = '$datetime'> $datetime </option>";
				}
			}
			$googlbot_hours_from .= "</select>";
			$data[$singlebot.'_hours_from'] = $googlbot_hours_from;

			$googlbot_hours_to = "<select name = '".$singlebot."_hours_to' id = '".$singlebot."_hours_to'>";
			for($hours = 0;$hours < 24;$hours ++)
			{
				for($mins = 0; $mins < 60; $mins += 30)
				{
					$datetime = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
					$googlbot_hours_to .= "<option value = '$datetime'> $datetime </option>";
				}
			}
			$googlbot_hours_to .= "</select>";
			$data[$singlebot.'_hours_to'] = $googlbot_hours_to;

			$googlebot_tag_nos = "<select name = '".$singlebot."_tag_nos' id = '".$singlebot."_tag_nos' >";
			for($i = 1; $i <= 5; $i ++)
				$googlebot_tag_nos .= "<option value = '$i'> $i </option>";

			$googlebot_tag_nos .= "</select>";
			$data[$singlebot.'_tag_nos'] = $googlebot_tag_nos;
		}
		return $data;
	}

}
