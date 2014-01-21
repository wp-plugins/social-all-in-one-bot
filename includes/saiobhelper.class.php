<?php
class saiob_include_saiobhelper
{
	public function __construct()
	{

	}

        /**
         *  generate tweet/fbstatus and update it on queue
         *  @param string $_REQUEST['provider']
         *  @param array $_REQUEST['value']
         */
        public function saiob_storesmartbotinfo()
        {
                global $wpdb;
                $skinny = new SkinnyController();
                $metainfo = new saiob_include_getmetainfo();

                $provider = $_REQUEST['provider'];
                $values = $_REQUEST['value'];

                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                # get template
                foreach($bulktemplate as $bulktemplatekey => $bulktemplateval)
                {
                        if($bulktemplateval['templatename'] == $values[10])
                        {
                                # generate query to get all the post / pages
                                $type = $bulktemplateval['type'];
                                $where = "where post_type = '$type' ";
                                $stype = $bulktemplateval['settingstype'];
                                if($stype == 'ID')
                                {
                                        $from   = $bulktemplateval['fromid'];
                                        $to     = $bulktemplateval['toid'];
                                        $where .= " and id >= '$from' and id <= '$to' ";
                                }
                                else
                                {
                                        $from   = $bulktemplateval['fromdate'];
                                        $to     = $bulktemplateval['todate'];
                                        $where .= " and post_date >= '$from' and post_date <= '$to'";
                                }
                                # only published post/page are allowed
                                $where .= " and post_status = 'publish'";

                                $query = "select * from wp_posts $where";
                                $getposts = $wpdb->get_results($query);

                                $postcount    = count($getposts);
                                if($postcount != 0)
                                        $timeinterval = $metainfo->scheduletime($postcount, $values);

                                $fromtime = $values[8];

                                if($getposts)
                                {
                                        $formattedfromtime = strtotime($fromtime);
                                        foreach($getposts as $singlepost)
                                        {
                                                $formattedfromtime = date("H:i", strtotime("+$timeinterval minutes", $formattedfromtime));
                                                $url             = $metainfo->makeurl($type, $singlepost->ID);
                                                $variation_one   = $metainfo->getvariationone($bulktemplateval, $values, $provider, $singlepost, $url, $formattedfromtime, $singlepost->ID);
                                                $variation_two   = $metainfo->getvariationtwo($bulktemplateval, $values, $provider, $singlepost, $url, $formattedfromtime);
                                                $variation_three = $metainfo->getvariationthree($bulktemplateval, $values, $provider, $singlepost, $url, $formattedfromtime);
                                                $formattedfromtime = strtotime($formattedfromtime);
                                        }
                                }
                        }
                }
                print_r("$provider smartbot updated successfully");
                die();
        }

	/**
         *  return container HTML for bulk composer
         *  @param string $templatename
         *  @return HTML $container
         **/
        public function saiob_gettemplate($templatename, $callmode = 'normal')
        {
                # below two check for ajax request
                if(isset($_REQUEST['templatename']) && !empty($_REQUEST['templatename']) && empty($templatename))
                        $templatename = $_REQUEST['templatename'];

                if(isset($_REQUEST['callmode']) && !empty($_REQUEST['callmode']))
                        $callmode = $_REQUEST['callmode'];

                $skinnycontroller = new SkinnyController();
                $dropdownlist = SmartbotActions::$types;

                $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');
                $gettemplate  = "<select name = 'bulkcomposertemplate' id = 'bulkcomposertemplate' onchange = 'changetemplate(this.value)'>";
                $gettemplate .= "<option value = ''> Create New Template </option>";
                if($bulktemplate)
                {
                        foreach($bulktemplate as $singletemplate)
                        {
                                $selected = '';
                                if($templatename == $singletemplate['templatename'])
                                        $selected = 'selected';


                                $gettemplate .= "<option $selected value = '{$singletemplate['templatename']}'> {$singletemplate['templatename']} </option>";
                        }
                }
                $gettemplate .= "</select>";

                if(empty($templatename))
                {
                        $mode = 'create';
                        $datediv_display = 'display:create';
                        $iddiv_display = 'display:none';
                        $templatenametype = 'text';
                        $tempname = "<label class = 'control-label col-sm-3'> Template Name </label> <div class = 'col-sm-5'> <input type = '$templatenametype' name = 'templatename' id = 'templatename' value = '$templatename_composer' class = 'form-control'> </div>";
                }
                else
                {
                        $mode = 'edit';
                        $bulktemplate = get_option('__wp_saiob_bulkcomposer_template');

                        if($bulktemplate)
                        {
                                foreach($bulktemplate as $templatekey => $singletemplate)
                                {
                                        if($singletemplate['templatename'] == $templatename)    {
                                                $templatevalue = $bulktemplate[$templatekey];
                                                break;
                                        }
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

                        $metadesc = empty($templatevalue['metadesc']) ? '' : 'checked';
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

			$tempname = "<label class = 'control-label col-sm-3'> </label> <div class = 'col-sm-5'> <input type = '$templatenametype' name = 'templatename' id = 'templatename' value = '$templatename_composer'> </div>";
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

                $container = "<form class='form-horizontal' method = 'POST' id = 'bulkcomposertemplate' name = 'bulkcomposertemplate' role='form' action = 'admin.php?page=social-all-in-one-bot/saiob.php&__module=smartbot'>
                                <input type = 'hidden' name = 'mode' id = 'mode' value = '$mode'>
                                <div class = 'header_settings form-group' style = 'width:100%; margin-top: 20px; margin-left: 20px;'>
                <div class = 'form-group'>
                        <label class = 'col-sm-2 text-right'> Select Template </label>
                        <div class = 'col-sm-4'> $gettemplate <span id = 'changetemplategif' style = 'display:none;'> <img src = '".WP_SOCIAL_ALL_IN_ONE_BOT_DIR."/images/loading.gif' alt = 'loading'> </span> </div>
                </div>
                <div class = 'form-group'>
                        <label class = 'control-label col-sm-2'> Select Source </label>
                        <div class = 'col-sm-10'>
                                <div class = 'col-sm-2'> {$data['dropdown']} </div>
                                <div class = 'col-sm-1'> {$settingstype} </div>
                                <div class = 'col-sm-8' id = 'date_div' style = '$datediv_display'>
                                        <label class='control-label col-sm-1'> From </label>
                                        <div class = 'col-sm-3'> <input type = 'text' name = 'fromdate' id = 'fromdate' placeholder = 'From Date' readonly value = '$fromdate'> </div>
                                        <label class='control-label col-sm-1'> To </label>
                                        <div class = 'col-sm-3'> <input type = 'text' name = 'todate' id = 'todate' placeholder = 'To Date' readonly value = '$todate'> </div>
                                </div>
                                <div class = 'col-sm-8' id = 'id_div' style = '$iddiv_display'>
                                        <label class='control-label col-sm-1'> From </label>
                                        <div class = 'col-sm-3'> <input type = 'text' name = 'fromid' id = 'fromid' placeholder = 'From Id' value = '$fromid'> </div>
                                        <label class='control-label col-sm-1'> To </label>
                                        <div class = 'col-sm-3'> <input type = 'text' name = 'toid' id = 'toid' placeholder = 'To Id' value = '$toid'> </div>
                                </div>
                        </div>
                </div>
        </div>";

                $container .= "<div class = 'form-group'> <label class = 'col-sm-2'> </label> <label class = 'col-sm-2'> Variation 1 </label>  <label class = 'col-sm-2'> Variation 2 </label> <label class = 'col-sm-2'> Variation 3 </label> </div>";

                $container .= "<div id = 'template_saiob' style = 'width:100%'>
                                <div class = 'form-group'>
                                        <label class='control-label col-sm-2'> Title </label>
                                        <label class='checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'posttitle' id = 'posttitle' $posttitle> Post Title </label>
                                        <label class='checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'htag' id = 'htag' $htag> H1, H2, H3 </label>
                                        <label class='checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'metatitle' id = 'metatitle' $metatitle> Meta Title </label>
                                </div>
                                <div class = 'form-group'>
                                        <label class = 'control-label col-sm-2'> Message </label>
                                        <label class = 'checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'postcontent' id = 'postcontent' $postcontent> Post Content </label>
                                        <label class = 'checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'excerptmsg' id = 'excerptmsg' $excerptmsg> Excerpt </label>
                                        <label class = 'checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'metadesc' id = 'metadesc' $metadesc> Meta Description </label>
                                </div>
                                <div class = 'form-group'>
                                        <label class='control-label col-sm-2'> Media </label>
                                        <label class='checkbox-inline col-sm-2'> <input type = 'checkbox' name = 'images' id = 'images' $images> Images </label>
                                </div>";
                $container .=  "<div class = 'form-group' style = 'padding-top:10px;'>
                                <div class = 'col-sm-7'> $tempname
                                        <button type='button' class='btn btn-primary' id = 'savetemplate' onclick = 'savebulkcomposertemplate(this.form)' data-loading-text='<span class = \"fa fa-spinner fa-spin\"></span> Saving Template...'> Save Template </button>
                                </div>
                                </div>
                        </div>
                        </form>

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
                if($callmode == 'ajax') {
                        print_r(wp_send_json($container));die;
                }
                else    {
                        return $container;
                }
        }
} 
