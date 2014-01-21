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
if(empty($facebook))
	$facebook_show = "display:none";

if(empty($twitter))
	$twitter_show = "display:none";

$this->notification = isset($skinnyData['notification']) ? $skinnyData['notification'] : '';
$this->notificationclass = isset($skinnyData['notificationclass']) ? $skinnyData['notificationclass'] : '';
?>
<div style = 'height:50px;padding-left:15px;padding-top:10px;' class="form-group"> <?php echo $skinnyData['bulkcomposer_template']; ?> </div>
<div class="panel-group" id="accordion">
  <div class = 'panel panel-default'>
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#bulkcomposer">
          Bulk Composer
        </a>
      </h4>
    </div>
    <div id = 'bulkcomposer' class = "panel-collapse collapse in">
		<?php echo $skinnyData['bulkcomposer']; ?>
    </div>
  </div>
  <div class="panel panel-default" style = '<?php echo $facebook_show; ?>'>
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#facebook">
          facebook
        </a>
      </h4>
    </div>
    <div id="facebook" class="panel-collapse collapse">
      <div class="panel-body">
      <form class='form-horizontal' method = 'POST' id = 'smartbot_facebook' name = 'smartbot_facebook' role='form' action = 'admin.php?page=social-all-in-one-bot/saiob.php&__module=smartbot'>
      	<div class = 'header_settings form-group' style = 'width:100%; padding-top:5px;'>
      		<div class = 'left_header_settings' style = 'width:100%'>
      			<div class="form-group">
      				<label for="facebookbot_maxchars" class="col-sm-2 control-label"> Maximum Characters </label>
			      	<div class="col-sm-1">
      					<input type="text" class="form-control" id="facebookbot_maxchars" maxlength = '5' name = 'facebookbot_maxchars' placeholder = '60000+'>
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
	      			<div class = "col-sm-2">
			      		<?php echo $skinnyData['facebookbot_hours_from']; ?>
				</div>
        			<div class = 'col-sm-1' style = 'margin-left:30px;'> to </div>
      					<div class = 'col-sm-2'>
      						<?php echo $skinnyData['facebookbot_hours_to']; ?>
	      				</div>
      				</div>
      			</div>
			<div class="form-group"> 
				<div class="col-sm-offset-2 col-sm-5">
					<button type="button" onclick = "storesmartbotinfo('facebook', this.form)" id = 'facebooksmartbot' name = 'facebooksmartbot' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Scheduling..."> Schedule </button>
				</div>
			</div>
	      	</div>
      	</div>
      </form>
      </div>
    </div>
  </div>
  <div class="panel panel-default" style = '<?php echo $twitter_show; ?>'>
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#twitter">
          Twitter
        </a>
      </h4>
    </div>
    <div id="twitter" class="panel-collapse collapse">
      <div class="panel-body">
      <form class='form-horizontal' method = 'POST' id = 'smartbot_twitter' name = 'smartbot_twitter' role='form' action = 'admin.php?page=social-all-in-one-bot/saiob.php&__module=smartbot'>
      	<div class = 'header_settings form-group' style = 'width:100%; padding-top:5px;'>
      		<div class = 'left_header_settings' style = 'width:100%'>
      			<div class="form-group">
      				<label class="col-sm-2 control-label"> Maximum Characters </label>
			      	<div class="col-sm-1">
      					<input type="email" class="form-control" id="twitterbot_maxchars" maxlength = '3' name = "twitterbot_maxchars" placeholder = '140'>
				</div>
      			</div>
      			<div class="form-group">
	      			<label class="col-sm-2 control-label"> Tags # </label>
      				<div class="col-sm-5">
      					<input type="text" class="form-control" id="twitterbot_tags" name = "twitterbot_tags" placeholder = '#smackcoders, #sachin, #sun'>
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
      			<div class = "col-sm-2">
		      		<?php echo $skinnyData['twitterbot_hours_from']; ?>
			</div>
        		<div class = 'col-sm-1' style = 'margin-left:30px;'> to </div>
      				<div class = 'col-sm-2' style = ''>
      					<?php echo $skinnyData['twitterbot_hours_to']; ?>
      				</div>
      			</div>
      		</div>
		<div class="form-group"> 
			<div class="col-sm-offset-2 col-sm-5">
				<button type="button" onclick = "storesmartbotinfo('twitter', this.form)" id = 'twittersmartbot' name = 'twittersmartbot' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Scheduling..."> Schedule </button>
			</div>
		</div>
      	</div>
      </div>
      </form>
      </div>
    </div>
  </div>

</div>
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
