<!-- SmartBOT page for social-all-in-one -->
<!-- Fix for div shown up at the footer of the wordpress-->
<style> #ui-datepicker-div { display:none } </style>
<?php
$facebookbot_weekly_div_style = 'display:none';
$facebookbot_date_div_style = 'display:none';
$facebookbot_tag_nos_div = 'display:none';

$twitterbot_weekly_div_style = 'display:none';
$twitterbot_date_div_style = 'display:none';
$twitterbot_tag_nos_div = 'display:none';

$facebook = get_option('__saiob_facebookkeys'); $twitter = get_option('__saiob_twitterkeys');
$facebook_show = 'display:block';
$twitter_show = 'display:block';
#if(empty($facebook) || !isset($facebook['status']) || $facebook['status'] != 'on')
	$facebook_show = "display:none";

#if(empty($twitter) || !isset($twitter['status']) || $twitter['status'] != 'on')
	$twitter_show = "display:none";

$this->notification = isset($skinnyData['notification']) ? $skinnyData['notification'] : '';
$this->notificationclass = isset($skinnyData['notificationclass']) ? $skinnyData['notificationclass'] : '';
?>
<form name = 'smartbotform' id = 'smartbotform' action = "#" method = 'POST'>
        <div class="panel-group" id="accordion">
	     <div class = 'panel panel-default' style='display:none'>   	
                	<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#templates" style = 'border-bottom:1px solid #dedede'>
      			        <div class="panel-title"> <b> Templates </b> <span id = 'templates_h_span' class = 'fa fa-toggle-up pull-right'> </span> </div>
   </div>
    		<div id = 'templates' class = "panel-collapse collapse in" style = 'height:110px;'>
			<div class="form-group" style = 'height:45px;padding-top:15px;'> 
				<div class = 'form-group' style = 'padding-left:20px;'> 
					<label> <input onclick = 'saiob_showprovider(this.checked, "facebook")' type = 'checkbox' name = 'facebook_provider' id = 'facebook_provider'> Facebook </label>
					<label>	<input onclick = 'saiob_showprovider(this.checked, "twitter")' type = 'checkbox' name = 'twitter_provider' id = 'twitter_provider' > Twitter </label>
				</div>
				<div class = 'col-sm-2'> <?php echo $skinnyData['bulkcomposer_template']; ?> </div>
				<div class = 'col-sm-2'> 
					<i class = 'fa fa-plus-square fa-2x' onclick = 'return saiob_changetemplate("new");'></i> 
					<i class = 'fa fa-edit fa-2x' onclick = 'return saiob_changetemplate("edit");'></i> 
					<i class = 'fa fa-copy fa-2x' onclick = 'saiob_showdiv("newtemplatediv")'></i> 
					<i class = 'fa fa fa-trash-o fa-2x' onclick = 'return saiob_deletetemplate()'></i> 
					<i><span id = 'changetemplategif' style = 'display:none'> <img src = '<?php echo WP_SOCIAL_ALL_IN_ONE_BOT_DIR; ?>images/loading.gif' alt = 'loading'> </span></i>
				</div>
				<div class = 'form-group' style = 'display:none' id = 'newtemplatediv'>
					<div class = 'col-sm-2'>
						<div> <input type = 'text' name = 'newtemplatename' id = 'newtemplatename' placeholder = 'Enter Template Name' class = 'form-control'> </div>
					</div>
					<div class = 'col-sm-2'>
						<div style = 'col-sm-2'> <button class = 'btn btn-primary' id = 'saiob_clonetemplate' class = 'saiob_clonetemplate' data-loading-text='<span class = "fa fa-spinner fa-spin"></span> Cloning...' onclick = 'return saiob_clonetemplate();'> Clone Template </button> </div>
					</div>
				</div>
			</div>
			<div class = 'form-group'>
                                <div class = 'col-sm-7'>
					<label class = 'control-label col-sm-3'> Template Name </label> <div class = 'col-sm-5'> <input type = 'text' name = 'templatename' id = 'templatename' class = 'form-control' placeholder = 'Enter Template Name'> </div>
                                        <button type='button' class='btn btn-primary' id = 'savetemplate' onclick = 'savebulkcomposertemplate(this.form)' data-loading-text='<span class = \"fa fa-spinner fa-spin\"></span> Saving Template...'> Save Template </button>
                                </div>
			</div>
    		</div>
	</div>
    	<div class="panel panel-default" id = 'saiob_facebook_accordion' style = 'display:none'>
    		<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#facebook">
      			<div class="panel-title"> <b> Facebook </b> <span id = 'facebook_h_span' class = 'fa fa-toggle-down pull-right'> </span> </div>
	    	</div>
    		<div id="facebook" class="panel-collapse collapse">
	      		<div class="panel-body">
      				<div class = 'header_settings form-group' style = 'width:100%; padding-top:5px;'>
			      		<div class = 'left_header_settings' style = 'width:100%'>
      						<div class="form-group">
		      					<label for="facebookbot_maxchars" class="col-sm-2 control-label"> Maximum Characters </label>
						      	<div class="col-sm-1">
      								<input type="text" class="form-control" id="facebookbot_maxchars" maxlength = '5' name = 'facebookbot_maxchars' placeholder = '60000<'>
							</div>
	      					</div>
      						<div class="form-group">
			      				<label for="facebookbot_calltoactions" class="col-sm-2 control-label"> Call to actions </label>
      							<div class="col-sm-5">
      								<input type="text" class="form-control" id="facebookbot_calltoactions" name = "facebookbot_calltoactions" placeholder = 'like us'>
			      				</div>
      							<div class = 'col-sm-1'>
      								<label class = "checkbox-inline"> <input type = 'checkbox' id = 'facebookbot_action_rotate' name = 'facebookbot_action_rotate' > Rotate </label>
	      						</div>
						</div>
      					</div>
      					<div class="form-group">
      						<label class="col-sm-2 control-label"> Frequency </label>
	      					<div class="col-sm-1" style = "width:75px;">
      							<?php echo $skinnyData['facebookbot_frequency']; ?>
	      					</div>
     		 				<div class = "col-sm-1" id = 'facebookbot_period_div'> 
      							<?php echo $skinnyData['facebookbot_period']; ?>
      						</div>
      						<div class = "col-sm-1" id = 'facebookbot_Weekly_div' style = '<?php echo $facebookbot_weekly_div_style; ?>'>
      							<?php echo $skinnyData['facebookbot_weekly']; ?>
		      				</div> 
      						<div class = "col-sm-3" id = 'facebookbot_Date_div' style = '<?php echo $facebookbot_date_div_style ?>'>
      							<div class = "col-sm-2">
      								<input type = 'text' name = 'facebookbot_fromdate' id = 'facebookbot_fromdate' class = 'form-control' style = 'width:100px;'>	
			      				</div>
      							<div class = 'col-sm-1' style = 'margin-left:70px;'> to </div>
      							<div class = 'col-sm-2' style = ''>
			      					<input type = 'text' name = 'facebookbot_todate' id = 'facebookbot_todate' class = 'form-control' style = 'width:100px;' >
      							</div>
				     		</div>
      						<div class = "col-sm-3" id = 'facebookbot_time_div'>
				      			<div class = "col-sm-2"> <?php echo $skinnyData['facebookbot_hours_from']; ?> </div>
	        					<div class = 'col-sm-1' style = 'margin-left:30px;'> to </div>
      							<div class = 'col-sm-2'> <?php echo $skinnyData['facebookbot_hours_to']; ?> </div>
      						</div>
		      			</div>
					<div class="form-group"> 
						<div class="col-sm-offset-2 col-sm-5">
							<button type="button" onclick = "storesmartbotinfo('facebook', this.form)" id = 'facebooksmartbot' name = 'facebooksmartbot' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Scheduling..."> Schedule </button>
						</div>
					</div>
			      	</div>
	      		</div>
	      	</div>
	</div>
  	<div class="panel panel-default" style = 'display:none' id = 'saiob_twitter_accordion'>
    		<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#twitter">
      			<div class="panel-title"> <b> Twitter </b> <span id = 'twitter_h_span' class = 'fa fa-toggle-down pull-right'> </span> </div>
    		</div>
    		<div id="twitter" class="panel-collapse collapse">
      			<div class="panel-body">
      				<div class = 'header_settings form-horizontal' style = 'width:100%; padding-top:5px;'>
      					<div class = 'left_header_settings' style = 'width:100%'>
      						<div class="form-group">
			      				<label class="col-sm-2 control-label"> Maximum Characters </label>
						      	<div class="col-sm-1">
			      					<input type="text" class="form-control" id="twitterbot_maxchars" maxlength = '3' name = "twitterbot_maxchars" placeholder = '140'>
							</div>
			      			</div>
	      					<div class="form-group">
				      			<label class="col-sm-2 control-label"> Tags # </label>
      							<div class="col-sm-5">
      								<input type="text" class="form-control" id="twitterbot_tags" name = "twitterbot_tags" placeholder = 'smackcoders, sachin, sun'>
		      					</div>
      							<div class = 'col-sm-1'> 
      								<label class = "checkbox-inline"> <input type = 'checkbox' id = 'twitterbot_tag_rotate' name = 'twitterbot_tag_rotate' onclick = "shownos(this.name, this.checked)" > Rotate </label>
			      				</div>
     		 					<div class = "col-sm-2" id = 'twitter_tag_nos_div'>
      								<label class = "col-sm-1 control-label" style = 'width:50px;'> Nos </label>
		     		 				<div class = "col-sm-1"> <?php echo $skinnyData['twitterbot_tag_nos']; ?> </div> 
      							</div>
		      				</div>
	      					<div class="form-group">
      							<label for="twitter_calltoactions" class="col-sm-2 control-label"> Call to actions </label>
				      			<div class="col-sm-5">
      								<input type="text" class="form-control" id="twitterbot_calltoactions" name = "twitterbot_calltoactions" placeholder = "retweet us">
      							</div>
		      					<div class = 'col-sm-1'>
	      							<label class = "checkbox-inline"> <input type = 'checkbox' id = 'twitterbot_action_rotate' name = 'twitterbot_action_rotate' > Rotate </label>
      							</div>
		      				</div>
      						<div class="form-group">
      							<label for="twitter_frequency" class="col-sm-2 control-label"> Frequency </label>
				      			<div class="col-sm-1" style = "width:75px;">
      								<?php echo $skinnyData['twitterbot_frequency']; ?>			
							</div>
      							<div class = "col-sm-1" id = 'twitterbot_period_div'> 
      								<?php echo $skinnyData['twitterbot_period']; ?>
			      				</div>
		      					<div class = "col-sm-1" id = 'twitterbot_Weekly_div' style = '<?php echo $twitterbot_weekly_div_style; ?>'>
      								<?php echo $skinnyData['twitterbot_weekly']; ?>
      							</div> 
		      					<div class = "col-sm-3" id = 'twitterbot_Date_div' style = '<?php echo $twitterbot_date_div_style ?>'>
	      							<div class = "col-sm-2">
      									<input type = 'text' name = 'twitterbot_fromdate' id = 'twitterbot_fromdate' class = 'form-control' style = 'width:100px;'>	
			      					</div>
      								<div class = 'col-sm-1' style = 'margin-left:70px;'> to </div>
			      					<div class = 'col-sm-2' style = ''>
      									<input type = 'text' name = 'twitterbot_todate' id = 'twitterbot_todate' class = 'form-control' style = 'width:100px;' >
				      				</div>
     							</div>
			      				<div class = "col-sm-3" id = 'twitterbot_time_div' >
      								<div class = "col-sm-2"> <?php echo $skinnyData['twitterbot_hours_from']; ?> </div>
					        		<div class = 'col-sm-1' style = 'margin-left:30px;'> to </div>
      								<div class = 'col-sm-2' style = ''> <?php echo $skinnyData['twitterbot_hours_to']; ?> </div>
				      			</div>
      						</div>
						<div class="form-group"> 
							<div class="col-sm-offset-2 col-sm-5">
								<button type="button" onclick = "storesmartbotinfo('twitter', this.form)" id = 'twittersmartbot' name = 'twittersmartbot' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Scheduling..."> Schedule </button>
							</div>
						</div>
      					</div>
			      	</div>
			</div>
		</div>
	</div>
 </div>

	<div class = 'panel panel-default' style = 'width:98.3%;'>
    		<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#bulkcomposer" style = 'border-bottom:1px solid #dedede'>
      			<div class="panel-title"> <b> Bulk Composer </b> <span id = 'bulkcomposer_h_span' class = 'fa fa-toggle-up pull-right'> </span> </div>
        	</div>	<div id = 'bulkcomposer' class = "panel-collapse collapse in form-horizontal" style='height:auto; width:95%;'>
			<?php echo $skinnyData['bulkcomposer']; ?>
                        
    		</div>
  	</div>


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

jQuery(document).ready(function()
{
        jQuery('#facebook').on('hidden.bs.collapse', function ()
        {
                jQuery("#facebook_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });

        jQuery('#facebook').on('show.bs.collapse', function ()
        {
                jQuery("#facebook_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });

        jQuery('#twitter').on('hidden.bs.collapse', function ()
        {
                jQuery("#twitter_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });

        jQuery('#twitter').on('show.bs.collapse', function ()
        {
                jQuery("#twitter_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });

        jQuery('#bulkcomposer').on('hidden.bs.collapse', function ()
        {
                jQuery("#bulkcomposer_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });

        jQuery('#bulkcomposer').on('show.bs.collapse', function ()
        {
                jQuery("#bulkcomposer_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });

});
</script>
