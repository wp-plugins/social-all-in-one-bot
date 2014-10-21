<?php
$this->notification = isset($skinnyData['notification']) ? $skinnyData['notification'] : '';
$this->notificationclass = isset($skinnyData['notificationclass']) ? $skinnyData['notificationclass'] : '';
?>
<form name = 'saiob_template_create' id = 'saiob_template_create' method = 'POST' action = 'admin.php?page=<?php echo WP_SOCIAL_ALL_IN_ONE_BOT_SLUG; ?>/index.php&__module=templates&__action=save'>
<div class="form-group" style = 'height:25px;padding-top:15px;'>
	<div class = 'form-group' style = 'padding-left:20px;'>
        	<label> <input onclick = 'saiob_showprovider(this.checked, "facebook")' type = 'checkbox' name = 'facebook_provider' id = 'facebook_provider'> Facebook </label>
                <label> <input onclick = 'saiob_showprovider(this.checked, "twitter")' type = 'checkbox' name = 'twitter_provider' id = 'twitter_provider'> Twitter </label>
		 <label> <input onclick = 'saiob_showprovider(this.checked, "linkedin")' type = 'checkbox' name = 'linkedin_provider' id = 'linkedin_provider'> LinkedIn </label>
        </div>
</div>
<hr>
<div class="panel-group" id="accordion">
	<div class="panel panel-default" id = 'saiob_facebook_accordion' style = 'display:none;width:98.3%'>
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#facebook">
                        <div class="panel-title"> <b> Facebook </b> <span id = 'facebook_h_span' class = 'fa fa-toggle-down pull-right'> </span> </div>
                </div>
                <div id="facebook" class="panel-collapse collapse in">
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
                                                <div class = "col-sm-1" id = 'facebookbot_Weekly_div' >
                                                        <?php echo $skinnyData['facebookbot_weekly']; ?>
                                                </div>
						<div class = "col-sm-3" id = 'facebookbot_Date_div' >
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
                                        <div class="form-group" style="display:none;">
                                                <div class="col-sm-offset-2 col-sm-5">
                                                        <button type="button" onclick = "storesmartbotinfo('facebook', this.form)" id = 'facebooksmartbot' name = 'facebooksmartbot' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Scheduling..."> Schedule </button>
                                                </div> 
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
	<div class="panel panel-default" style = 'display:none;width:98.3%;' id = 'saiob_twitter_accordion'>
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
                                                        <div class = "col-sm-1" id = 'twitterbot_Weekly_div' >
                                                                <?php echo $skinnyData['twitterbot_weekly']; ?>
                                                        </div>
                                                        <div class = "col-sm-3" id = 'twitterbot_Date_div' >
                                                                <div class = "col-sm-2">
                                                                        <input type = 'text' name = 'twitterbot_fromdate' id = 'twitterbot_fromdate' class = 'form-control' style = 'width:100px;'>
                                                                </div>
                                                                <div class = 'col-sm-1' style = 'margin-left:70px;'> to </div>
                                                                <div class = 'col-sm-2' style = ''>
                                                                        <input type = 'text' name = 'twitterbot_todate' id = 'twitterbot_todate' class = 'form-control' style = 'width:100px;' >
                                                                </div>
                                                        </div>
                                                        <div class = "col-sm-3" id = 'twitterbot_time_div' >
                                                                <div class = "col-sm-2"> <?php echo $skinnyData['twitterbot_hours_from']; ?>  </div>
                                                                <div class = 'col-sm-1' style = 'margin-left:30px;'> to </div>
                                                                <div class = 'col-sm-2' style = ''> <?php echo $skinnyData['twitterbot_hours_to']; ?> </div>
                                                        </div>
                                                </div>
                                                <div class="form-group" style="display:none">
                                                        <div class="col-sm-offset-2 col-sm-5">
                                                                <button type="button" onclick = "storesmartbotinfo('twitter', this.form)" id = 'twittersmartbot' name = 'twittersmartbot' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Scheduling..."> Schedule </button>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
	
	<div class="panel panel-default" id = 'saiob_linkedin_accordion' style = 'display:none;width:98.3%'>
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#linkedin">
                        <div class="panel-title"> <b> LinkedIn </b> <span id = 'linkedin_h_span' class = 'fa fa-toggle-down pull-right'> </span> </div>
                </div>
                <div id="linkedin" class="panel-collapse collapse in">
                        <div class="panel-body">
                                <div class = 'header_settings form-group' style = 'width:100%; padding-top:5px;'>
                                        <div class = 'left_header_settings' style = 'width:100%'>
                                                <div class="form-group">
                                                        <label for="linkedinbot_maxchars" class="col-sm-2 control-label"> Maximum Characters </label>
                                                        <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="linkedinbot_maxchars" maxlength = '5' name = 'linkedinbot_maxchars' placeholder = '700'>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="linkedinbot_calltoactions" class="col-sm-2 control-label"> Call to actions </label>
                                                        <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="linkedinbot_calltoactions" name = "linkedinbot_calltoactions" placeholder = 'like us'>
                                                        </div>
                                                        <div class = 'col-sm-1'>
                                                                <label class = "checkbox-inline"> <input type = 'checkbox' id = 'linkedinbot_action_rotate' name = 'linkedinbot_action_rotate' > Rotate </label>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label"> Frequency </label>
                                                <div class="col-sm-1" style = "width:75px;">
                                                        <?php echo $skinnyData['linkedinbot_frequency']; ?>
                                                </div>
                                                <div class = "col-sm-1" id = 'linkedinbot_period_div'>
                                                        <?php echo $skinnyData['linkedinbot_period']; ?>
                                                </div>
                                                <div class = "col-sm-1" id = 'linkedinbot_Weekly_div' >
                                                        <?php echo $skinnyData['linkedinbot_weekly']; ?>
                                                </div>
						<div class = "col-sm-3" id = 'linkedinbot_Date_div' >
                                                        <div class = "col-sm-2">
                                                                <input type = 'text' name = 'linkedinbot_fromdate' id = 'linkedinbot_fromdate' class = 'form-control' style = 'width:100px;'>
                                                        </div>
                                                        <div class = 'col-sm-1' style = 'margin-left:70px;'> to </div>
                                                        <div class = 'col-sm-2' style = ''>
                                                                <input type = 'text' name = 'linkedinbot_todate' id = 'linkedinbot_todate' class = 'form-control' style = 'width:100px;' >
                                                        </div>
                                                </div>
                                                <div class = "col-sm-3" id = 'linkedinbot_time_div'>
                                                        <div class = "col-sm-2"> <?php echo $skinnyData['linkedinbot_hours_from']; ?> </div>
                                                        <div class = 'col-sm-1' style = 'margin-left:30px;'> to </div>
                                                        <div class = 'col-sm-2'> <?php echo $skinnyData['linkedinbot_hours_to']; ?> </div>
                                                </div>
                                        </div>
                                        <div class="form-group" style="display:none;">
                                                <div class="col-sm-offset-2 col-sm-5">
                                                        <button type="button" onclick = "storesmartbotinfo('linkedin', this.form)" id = 'linkedinsmartbot' name = 'linkedinsmartbot' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Scheduling..."> Schedule </button>
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
		<div class = 'col-sm-4'> <input type = 'text' name = 'templatename' id = 'templatename' class = 'form-control' placeholder = 'Enter Template Name'> </div> 
		<div class = 'col-sm-3'> 
			<button type = 'button' class = 'btn btn-primary' name = 'saiob_createtemplate_button' id = 'saiob_createtemplate_button' onclick = 'saiob_createtemplate(this.form)' data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Creating Template..."> 
				Create Template 
			</button> 
		</div>
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
    jQuery('#linkedinbot_todate').datepicker({
        dateFormat : 'yy-mm-dd'
    });
});

jQuery(document).ready(function() {
    jQuery('#linkedinbot_fromdate').datepicker({
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

