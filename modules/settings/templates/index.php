<!-- settings page of social-all-in-one-bot -->
<?php $facebook = get_option('__saiob_facebookkeys'); $twitter = get_option('__saiob_twitterkeys'); $linkedin = get_option('__saiob_linkedinkeys');$twittercards = get_option('__saiob_twittercardskeys');
$facebook_enabled = (isset($facebook['status']) && $facebook['status'] == 'on') ? 'checked' : '';
$twitter_enabled  = (isset($twitter['status']) && $twitter['status'] == 'on') ? 'checked' : '';
$linkedin_enabled = (isset($linkedin['status']) && $linkedin['status'] == 'on') ? 'checked' : '';
$twittercards_enabled = (isset($twittercards['5']) && $twittercards['5'] == 'on') ? 'checked' : '';
# for notification
$this->notification = isset($skinnyData['notification']) ? $skinnyData['notification'] : '';
$this->notificationclass = isset($skinnyData['notificationclass']) ? $skinnyData['notificationclass'] : '';
	 $impCE=new saiob_include_saiobhelper();
?>
<div class="panel-group" id="accordion" style = "width:98.3%;">
	<div class="panel panel-default" >
                <div class="warning" id="warning" name="warning" style="display:none"></div>

             <?php if(is_dir($impCE->getUploadDirectory($check='default'))){ ?>
                <input type='hidden' id='is_uploadfound' name='is_uploadfound' value='found' />
        <?php } else { ?>
                <input type='hidden' id='is_uploadfound' name='is_uploadfound' value='notfound' />
        <?php } ?>

<script>
  jQuery(document).ready(function($) {
 var check_upload_dir = document.getElementById('is_uploadfound').value;  
        if(check_upload_dir == 'notfound'){
                var msg="Sorry. There is no uploads directory Please create it with write permission";
               saiob_shownotification(msg, 'danger');
                                      }
      });
          </script>
		<div class="panel-heading" data-toggle="collapse" data-target="#facebook" data-parent="#accordion">
			<div class="panel-title"> <b> Facebook </b> <span class = 'fa fa-toggle-up pull-right'id = 'facebook_h_span'> </span> </div>
		</div>
		<div id="facebook" class="panel-collapse collapse in">
			<div class="panel-body">
				<form class="form-horizontal" role="form" method = 'POST' id = 'facebook_settings' name = 'facebook_settings'>
					<div class = "col-sm-offset-2 text-right" style="height:38px"> <i><a class = "label label-info" style = 'padding:5px;' href = "https://developers.facebook.com/apps" target = '_blank'> click here to create facebook app </a></i> </div>
			 		<div class="form-group">
    						<label class="col-sm-2 control-label optionstext"> App Id </label>
	    					<div class="col-sm-8">
      							<input type="text" class="form-control" id="facebook_appid" name = 'facebook_appid' value = '<?php echo isset($facebook[0]) ? $facebook[0] : ''; ?>'>
    						</div>
  					</div>
  					<div class="form-group">
    						<label class="col-sm-2 control-label optionstext"> App Secret </label>
    						<div class="col-sm-8">
      							<input type="text" class = "form-control" id = "facebook_secretkey" name = 'facebook_secretkey' value = '<?php echo isset($facebook[1]) ? $facebook[1] : ''; ?>'>
    						</div>
  					</div>
					<div class="form-group" style="margin-left:183px;">
						<div id='circlecheck'>
							 <input type = 'checkbox' <?php echo isset($facebook_enabled) ? $facebook_enabled :''; ?> name = 'enablefacebook' class="circlecheckbox" id = 'enablefacebook' style = 'margin:0px;'><label id="enableoption" class="circle-label" for="enablefacebook"> Enable Facebook </label>
						</div>
					</div>
  					<div class="form-group">
   						<div class="col-sm-offset-2 col-sm-1">
      							<button type="button" onclick = "savesocialkeys('facebook', this.form)" id = 'facebooksettingssync' name = 'facebooksettingssync' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Saving..."> Save </button>
						</div>
						<div class = "col-sm-2">
                                                        <button id = 'clearfacebooksettings' name = 'clearfacebooksettings' type="button" onclick = "saiob_clearsocialsettings('facebook')" class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Clearing..." > Clear Facebook Settings </button>
                                                </div>
<!--						<div class = "col-sm-offset-2 col-sm-3 text-right"> <i><a class = "label label-info" style = 'padding:5px;' href = "https://developers.facebook.com/apps" target = '_blank'> click here to create facebook app </a></i> </div>-->
  					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target = "#twitter">
			<div class="panel-title"> <b> Twitter </b> <span id = 'twitter_h_span' class = 'fa fa-toggle-down pull-right'> </span> </div>
		</div>
		<div id="twitter" class="panel-collapse collapse">
			<div class="panel-body">
				<form class="form-horizontal" role="form" method = 'POST' id = 'twitter_settings' name = 'twitter_settings'>
					<div class = "col-sm-3 text-right" style="width:100%;height:38px;"> <i> <a class = "label label-info" style = 'padding:5px;' href = "https://dev.twitter.com/apps/new" target = '_blank'> click here to create twitter app </a></i> </div>
			 		<div class="form-group">
    						<label class="col-sm-2 control-label optionstext"> Consumer Key </label>
	    					<div class="col-sm-8">
      							<input type="text" class="form-control" id="twitter_consumerkey" name = 'twitter_consumerkey' value = '<?php echo isset($twitter[0]) ? $twitter[0] : ''; ?>'>
    						</div>
  					</div>
  					<div class="form-group">
    						<label class="col-sm-2 control-label optionstext"> Consumer Secret </label>
    						<div class="col-sm-8">
      							<input type="text" class = "form-control" id = "twitter_consumersecret" name = 'twitter_consumersecret' value = '<?php echo isset($twitter[1]) ? $twitter[1] : ''; ?>'>
    						</div>
  					</div>
					<div class="form-group">
                                                <label class="col-sm-2 control-label optionstext"> Access Key </label>
                                                <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="twitter_accesskey" name = 'twitter_accesskey' value = '<?php echo isset($twitter[2]) ? $twitter[2] : ''; ?>'>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label optionstext"> Access Token Secret </label>
                                                <div class="col-sm-8">
                                                        <input type="text" class = "form-control" id = "twitter_tokensecret" name = 'twitter_tokensecret' value = '<?php echo isset($twitter[3]) ? $twitter[3] : '' ?>'>
                                                </div>
                                        </div>

					<div class = "form-group" style="margin-left:183px;">
						<div id='circlecheck'>
                                                        <input type = 'checkbox' <?php echo $twitter_enabled; ?> name = 'enabletwitter' class="circlecheckbox" id = 'enabletwitter' style = 'margin:0px;'><label id="enableoption" class="circle-label" for="enabletwitter"> Enable Twitter </label>
                                                </div>
					</div>
  					<div class="form-group">
   						<div class="col-sm-offset-2 col-sm-1">
      							<button id = 'twittersettingssync' name = 'twittersettingssync' type="button" onclick = "savesocialkeys('twitter', this.form)" class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Saving..." > Save </button>
						</div>
						<div class = "col-sm-2"> 
							<button id = 'cleartwittersettings' name = 'cleartwittersettings' type="button" onclick = "saiob_clearsocialsettings('twitter')" class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Clearing..." > Clear Twitter Settings </button>
						</div>
<!--						<div class = "col-sm-3 text-right"> <i> <a class = "label label-info" style = 'padding:5px;' href = "https://dev.twitter.com/apps/new" target = '_blank'> click here to create twitter app </a></i> </div> -->
  					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
	<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target = "#twittercards">
			<div class="panel-title"> <b> Twitter Cards </b> <span id = 'twittercards_h_span' class = 'fa fa-toggle-down pull-right'> </span> </div>
		</div>
		<div id="twittercards" class="panel-collapse collapse">
			<div class="panel-body">
				<form class="form-horizontal" role="form" method = 'POST' id = 'twittercards_settings' name = 'twittercards_settings'>
					<div class="form-group">
    						<label class="col-sm-2 control-label optionstext"> Consumer Key </label>
	    					<div class="col-sm-8">
      							<input type="text" class="form-control" id="twittercard_consumerkey" name = 'twitter_consumerkey' value = '<?php echo isset($twittercards[0]) ? $twittercards[0] : ''; ?>'>
    						</div>
  					</div>
  					<div class="form-group">
    						<label class="col-sm-2 control-label optionstext"> Consumer Secret </label>
    						<div class="col-sm-8">
      							<input type="text" class = "form-control" id = "twittercard_consumersecret" name = 'twittercard_consumersecret' value = '<?php echo isset($twittercards[1]) ? $twittercards[1] : ''; ?>'>
    						</div>
  					</div>
					<div class="form-group">
                                                <label class="col-sm-2 control-label optionstext"> Access Key </label>
                                                <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="twittercard_accesskey" name = 'twittercard_accesskey' value = '<?php echo isset($twittercards[2]) ? $twittercards[2] : ''; ?>'>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label optionstext"> Access Token Secret </label>
                                                <div class="col-sm-8">
                                                        <input type="text" class = "form-control" id = "twittercard_tokensecret" name = 'twittercard_tokensecret' value = '<?php echo isset($twittercards[3]) ? $twittercards[3] : '' ?>'>
                                                </div>
                                        </div>
					<div class="form-group">
    						<label class="col-sm-2 control-label optionstext"> Twitter User Name </label>
	    					<div class="col-sm-8">
      							<input type="text" class="form-control" id="twittercard_username" name = 'twittercard_username' value = '<?php echo isset($twittercards[4]) ? $twittercards[4] : ''; ?>'>
    						</div>
  					</div>
					<div class = "form-group" style="margin-left:183px;">
                                                <div id='circlecheck'>
                                                        <input type = 'checkbox' <?php echo $twittercards_enabled; ?> name = 'enabletwittercard' class="circlecheckbox" id = 'enabletwittercard' style = 'margin:0px;'><label id="enableoption" class="circle-label" for="enabletwittercard"> Enable Twitter </label>
                                                </div>
                                        </div>
  					<div class="form-group">
   						<div class="col-sm-offset-2 col-sm-1">
      							<button id = 'twittercardssettingssync' name = 'twittercardssettingssync' type="button" onclick = "savesocialkeys('twittercards', this.form)" class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Saving..." > Save </button>
						</div>
						<div class = "col-sm-2"> 
							<button id = 'cleartwittercardssettings' name = 'cleartwittercardssettings' type="button" onclick = "saiob_clearsocialsettings('twittercards')" class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Clearing..." > Clear twittercard Settings </button>
						</div>
				</form>
			</div>
		</div>
	</div>
</div>
<br>
<div class = 'form-group clearfix'>
	<div class = "col-sm-2">
        	<button id = 'cleartwittersettings' name = 'cleartwittersettings' type="button" onclick = "saiob_clearsocialsettings('all')" class="btn btn-danger" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Clearing..." > Clear All Settings </button>
       </div>
</div>
<script type = 'text/javascript'>
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

	jQuery('#linkedin').on('hidden.bs.collapse', function ()
    	{
		jQuery("#linkedin_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
	});

	jQuery('#linkedin').on('show.bs.collapse', function ()
        {
		jQuery("#linkedin_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });

	jQuery('#twittercards').on('hidden.bs.collapse', function ()
    	{
		jQuery("#twittercards_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
	});

	jQuery('#twittercards').on('show.bs.collapse', function ()
        {
		jQuery("#twittercards_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });

});
</script>
