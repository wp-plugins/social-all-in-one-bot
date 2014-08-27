<?
$this->notification = isset($skinnyData['notification']) ? $skinnyData['notification'] : '';
$this->notificationclass = isset($skinnyData['notificationclass']) ? $skinnyData['notificationclass'] : '';
?>
<form name = 'saiob_template_clone' id = 'saiob_template_clone' method = 'POST' action = 'admin.php?page=<?php echo WP_SOCIAL_ALL_IN_ONE_BOT_SLUG; ?>/index.php&__module=templates&__action=clone'>
<div class="form-group" style = 'height:25px;padding-top:15px;'>
 
   <?

           $twit=array();
           $twitter_provider='';
           $facebook_provider='';
           $a='';
           $b='';
           $twit_display='';
           $face_display='';
           $singlebot='';
           $eid='';

           $bulktemplate = get_option('__wp_saiob_bulkcomposer_template'); 
           if(is_array($bulktemplate))
             {
             foreach($bulktemplate as $ser_key => $ser_val)
                  {
                    $eid=mysql_real_escape_string($_GET['id']);
                    if($ser_key==$eid)
                        { 
                    $twit=maybe_unserialize($ser_val['value']); 
                    $twitter_provider=isset($twit['twitter_provider']) ? $twit['twitter_provider'] : '';
                    $facebook_provider=isset($twit['facebook_provider']) ? $twit['twitter_provider'] : '';
                     if(isset($twitter_provider) && $twitter_provider == 'on')
                      {
                        $a = 'checked';
                        $twit_display = 'display:none';
                        $face_display = 'display:none';
                        $singlebot = 'twitterbot';
                        
                      }
                     if(isset($facebook_provider) && $facebook_provider == 'on')
                        {
                        $b = 'checked';
                        $twit_display = 'display:none';
                        $face_display = 'display:none';
                        $singlebot = 'facebookbot';
                        }
                 
                    
        
                 
?>  
	<div class = 'form-group' style = 'padding-left:20px;display:block'>
        	<label> <input onclick = 'saiob_showprovider(this.checked, "facebook")' type = 'checkbox' name = 'facebook_provider' id = 'facebook_provider' <?php echo $b ; ?>> Facebook </label>
                <label> <input  onclick = 'saiob_showprovider(this.checked, "twitter")' type = 'checkbox'  name = 'twitter_provider' id = 'twitter_provider'  <?php echo $a ; ?> > Twitter </label>
        </div>
</div>
<hr>


 
<div class="panel-group" id="accordion" style = "width:98.3%;">
	<div class="panel panel-default" id = 'saiob_facebook_accordion' style = '<?php echo $face_display ;?>'>
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#facebook">
                        <div class="panel-title"> <b> Facebook </b> <span id = 'facebook_h_span' class = 'fa fa-toggle-down pull-right'> </span> </div>
                </div>
                <div id="facebook" class="panel-collapse collapse in">
                        <div class="panel-body">
                                <div class = 'header_settings form-group' style = 'width:100%; padding-top:5px;'>
                                        <div class = 'left_header_settings' style = 'width:100%'>
                                                <div class="form-group">
                                            <?$eid=isset($eid) ? $eid : '' ;?>
                                            <input type="hidden" name="id" <? echo $eid ; ?>>
                                                        <label for="facebookbot_maxchars" class="col-sm-2 control-label"> Maximum Characters </label>
                                                        <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="facebookbot_maxchars" maxlength = '5' name = 'facebookbot_maxchars' placeholder = '60000' value="<?=isset($twit[$singlebot.'_maxchars']) ? $twit[$singlebot.'_maxchars'] : '';?>">
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="facebookbot_calltoactions" class="col-sm-2 control-label"> Call to actions </label>
                                                        <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="facebookbot_calltoactions" name = "facebookbot_calltoactions" placeholder = 'like us' value="<?=isset($twit[$singlebot.'_calltoactions']) ? $twit[$singlebot.'_calltoactions'] : '';?>">
                                                        </div>
                                                        <div class = 'col-sm-1'>
                                                                <label class = "checkbox-inline"> <input type = 'checkbox' id = 'facebookbot_action_rotate' name = 'facebookbot_action_rotate' > Rotate </label>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label"> Frequency </label>
                                                <div class="col-sm-1" style = "width:75px;">
                                                        <?php echo $skinnyData[$singlebot.'_frequency']; ?>
                                                </div>
                                                <div class = "col-sm-1" id = 'facebookbot_period_div'>
                                                        <?php echo $skinnyData[$singlebot.'_period']; ?>
                                                </div>
                                                <div class = "col-sm-1" id = 'facebookbot_Weekly_div' >
                                                        <?php echo $skinnyData[$singlebot.'_weekly']; ?>
                                                </div>
						<div class = "col-sm-3" id = 'facebookbot_Date_div' >
                                                        <div class = "col-sm-2">
                                                                <input type = 'text' name = 'facebookbot_fromdate' id = 'facebookbot_fromdate' class = 'form-control' style = 'width:100px;' value="<?=isset($twit[$singlebot.'_fromdate']) ? $twit[$singlebot.'_fromdate'] : '';?>">
                                                        </div>
                                                        <div class = 'col-sm-1' style = 'margin-left:70px;'> to </div>
                                                        <div class = 'col-sm-2'  >
                                                                <input type = 'text' name = 'facebookbot_todate' id = 'facebookbot_todate' class = 'form-control' style = 'width:100px;' value="<?=isset($twit[$singlebot.'_todate']) ? $twit[$singlebot.'_todate'] : '';?>">
                                                        </div>
                                                </div>
                                                <div class = "col-sm-3" id = 'facebookbot_time_div'>
                                                        <div class = "col-sm-2"> <?php echo $skinnyData[$singlebot.'_hours_from']; ?> </div>
                                                        <div class = 'col-sm-1' style = 'margin-left:30px;'> to </div>
                                                        <div class = 'col-sm-2'> <?php echo $skinnyData[$singlebot.'_hours_to']; ?> </div>
                                                </div>
                                        </div>
                                        <div class="form-group" style="display:none">
                                                <div class="col-sm-offset-2 col-sm-5">
                                                        <button type="button" onclick = "storesmartbotinfo('facebook', this.form)" id = 'facebooksmartbot' name = 'facebooksmartbot' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Scheduling..."> Schedule </button>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
	<div class="panel panel-default" style = '<?php echo $twit_display ; ?>' id = 'saiob_twitter_accordion'>
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#twitter">
                        <div class="panel-title"> <b> Twitter </b> <span id = 'twitter_h_span' class = 'fa fa-toggle-down pull-right'> </span> </div>
                </div>




                    <div id="twitter" class="panel-collapse collapse in">
                        <div class="panel-body">
                                <div class = 'header_settings form-horizontal' style = 'width:100%; padding-top:5px;'>
                                        <div class = 'left_header_settings' style = 'width:100%'>
                                                <div class="form-group">
                                                        <label class="col-sm-2 control-label"> Maximum Characters </label>
                                                        <div class="col-sm-1">
                                                      <? $eid=isset($eid) ? $eid : '' ;?>
                                                        <input type="hidden" name="id" value="<?=$eid ;?>">
                        <?$max=isset($twit[$singlebot.'_maxchars']) ? $twit[$singlebot.'_maxchars'] : ''?>
                                                                <input type="text" class="form-control" id="twitterbot_maxchars" maxlength = '3' name = "twitterbot_maxchars" placeholder = '140' value="<?php echo $max; ?>">
                                                        </div>

                                                </div>
                                                <div class="form-group">
                                                        <label class="col-sm-2 control-label"> Tags # </label>
                                                        <div class="col-sm-5">
                                               
                                                                <input type="text" class="form-control" id="twitterbot_tags" name = "twitterbot_tags" placeholder = 'smackcoders, sachin, sun' value="<?=isset($twit[$singlebot.'_tags']) ? $twit[$singlebot.'_tags'] : '';?>">
                                                        </div>
                                                        <div class = 'col-sm-1'>
                                                                <label class = "checkbox-inline"> <input type = 'checkbox' id = 'twitterbot_tag_rotate' name = 'twitterbot_tag_rotate' checked > Rotate </label>
                                                        </div>
                                                        <div class = "col-sm-2" id = 'twitter_tag_nos_div'>
                                                                <label class = "col-sm-1 control-label" style = 'width:50px;'> Nos </label>  
                        <?$tag_nos=isset($skinnyData[$singlebot.'_tag_nos']) ? $skinnyData[$singlebot.'_tag_nos'] : ''?>
                                                                <div class = "col-sm-1"> <?php echo $tag_nos; ?> </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="twitter_calltoactions" class="col-sm-2 control-label"> Call to actions </label>
                                                        <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="twitterbot_calltoactions" name = "twitterbot_calltoactions" placeholder = "retweet us" value="<?=isset($twit[$singlebot.'_calltoactions']) ? $twit[$singlebot.'_calltoactions'] : '';?>">
                                                        </div>
                                                        <div class = 'col-sm-1'>
                                                                <label class = "checkbox-inline"> <input type = 'checkbox' id = 'twitterbot_action_rotate' name = 'twitterbot_action_rotate'  checked> Rotate </label>
                                                        </div>
							</div>
                                                <div class="form-group">
                                                        <label for="twitter_frequency" class="col-sm-2 control-label"> Frequency </label>
                                                        <div class="col-sm-1" style = "width:75px;">
                                                                <?php echo $skinnyData[$singlebot.'_frequency']; ?>
                                                        </div>
                                                        <div class = "col-sm-1" id = 'twitterbot_period_div'>
                                                                <?php echo $skinnyData[$singlebot.'_period']; ?>
                                                        </div>
                                                        <div class = "col-sm-1" id = 'twitterbot_Weekly_div' >
                                                                <?php echo $skinnyData[$singlebot.'_weekly']; ?>
                                                        </div>
                                                        <div class = "col-sm-3" id = 'twitterbot_Date_div' >
                                                                <div class = "col-sm-2">
                                                                        <input type = 'text' name = 'twitterbot_fromdate' id = 'twitterbot_fromdate' class = 'form-control' style = 'width:100px;'value="<?=isset($twit[$singlebot.'_fromdate']) ? $twit[$singlebot.'_fromdate'] : '';?>">
                                                                </div>
                                                                <div class = 'col-sm-1' style = 'margin-left:70px;'> to </div>
                                                                <div class = 'col-sm-2'> 
                                                                        <input type = 'text' name = 'twitterbot_todate' id = 'twitterbot_todate' class = 'form-control' style = 'width:100px;' value="<?=isset($twit[$singlebot.'_todate']) ? $twit[$singlebot.'_todate'] : '';?>">
                                                                </div>
                                                        </div>
                                                        <div class = "col-sm-3" id = 'twitterbot_time_div' >
                                                                <div class = "col-sm-2"> <?php echo $skinnyData[$singlebot.'_hours_from']; ?> </div>
                                                                <div class = 'col-sm-1' style = 'margin-left:30px;'> to </div>
                                                                <div class = 'col-sm-2' > <?php echo $skinnyData[$singlebot.'_hours_to']; ?> </div>
      
                                               </div>
                                                </div>
                                            
                                        </div>
                             </div>
                        </div>
                </div>
        </div>
</div>
<hr>
<div class = 'form-group'>
        <div class = 'col-sm-10'>
                <div class = 'col-sm-3'> <label> Enter Template Name </label> </div>
                <div class = 'col-sm-4'> <input type = 'text' name = 'templatename' id = 'templatename' class = 'form-control' placeholder = 'Enter Template Name'  > </div>
                <div class = 'col-sm-3'>
                      <button type = 'button' class = 'btn btn-primary' name = 'saiob_clonetemplate_button' id = 'saiob_clonetemplate_button' onclick = 'saiob_clonetemplate(this.form)' data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Cloning Template...">
                                Clone Template
                        </button>
                </div>
        </div>
</div>
 <?
  }
    }
}
?>
</form> 
<script type = 'text/javascript'>

jQuery(document).ready(function() {
    jQuery('#twitterbot_todate').datepicker({
        dateFormat : 'yy-mm-dd'
    });
});

jQuery(document).ready(function() {
    jQuery('#twitterbot_fromdate').datepicker({
        dateFormat : 'yy-mm-dd'
    });
});

jQuery(document).ready(function() {
    jQuery('#facebookbot_todate').datepicker({
        dateFormat : 'yy-mm-dd'
    });
});

jQuery(document).ready(function() {
    jQuery('#facebookbot_fromdate').datepicker({
        dateFormat : 'yy-mm-dd'
    });
});

jQuery(document).ready(function() {
    jQuery('#googlebot_todate').datepicker({
        dateFormat : 'yy-mm-dd'
    });
});

jQuery(document).ready(function() {
    jQuery('#googlebot_fromdate').datepicker({
        dateFormat : 'yy-mm-dd'
    });
});
</script>      
