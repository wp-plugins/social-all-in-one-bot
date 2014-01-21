<!-- settings page of social-all-in-one-bot -->
<?php $facebook = get_option('__saiob_facebookkeys'); $twitter = get_option('__saiob_twitterkeys'); 
# for notification
$this->notification = isset($skinnyData['notification']) ? $skinnyData['notification'] : '';
$this->notificationclass = isset($skinnyData['notificationclass']) ? $skinnyData['notificationclass'] : '';
?>
<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#facebook"> facebook </a>
			</h4>
		</div>
		<div id="facebook" class="panel-collapse collapse in">
			<div class="panel-body">
				<form class="form-horizontal" role="form" method = 'POST' id = 'facebook_settings' name = 'facebook_settings'>
			 		<div class="form-group">
    						<label class="col-sm-2 control-label"> app id </label>
	    					<div class="col-sm-8">
      							<input type="text" class="form-control" id="facebook_appid" name = 'facebook_appid' value = '<?php echo $facebook[0]; ?>'>
    						</div>
  					</div>
  					<div class="form-group">
    						<label class="col-sm-2 control-label"> app secret </label>
    						<div class="col-sm-8">
      							<input type="text" class = "form-control" id = "facebook_secretkey" name = 'facebook_secretkey' value = '<?php echo $facebook[1] ?>'>
    						</div>
  					</div>
  					<div class="form-group">
   						<div class="col-sm-offset-2 col-sm-1">
      							<button type="button" onclick = "savesocialkeys('facebook', this.form)" id = 'facebooksettingssync' name = 'facebooksettingssync' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Saving..."> Save </button>
						</div>
  					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#twitter"> Twitter </a>
			</h4>
		</div>
		<div id="twitter" class="panel-collapse collapse">
			<div class="panel-body">
				<form class="form-horizontal" role="form" method = 'POST' id = 'twitter_settings' name = 'twitter_settings'>
			 		<div class="form-group">
    						<label class="col-sm-2 control-label"> consumer key </label>
	    					<div class="col-sm-8">
      							<input type="text" class="form-control" id="twitter_consumerkey" name = 'twitter_consumerkey' value = '<?php echo $twitter[0]; ?>'>
    						</div>
  					</div>
  					<div class="form-group">
    						<label class="col-sm-2 control-label"> consumer secret </label>
    						<div class="col-sm-8">
      							<input type="text" class = "form-control" id = "twitter_consumersecret" name = 'twitter_consumersecret' value = '<?php echo $twitter[1] ?>'>
    						</div>
  					</div>
					<div class="form-group">
                                                <label class="col-sm-2 control-label"> access key </label>
                                                <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="twitter_accesskey" name = 'twitter_accesskey' value = '<?php echo $twitter[2]; ?>'>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label"> access token secret </label>
                                                <div class="col-sm-8">
                                                        <input type="text" class = "form-control" id = "twitter_tokensecret" name = 'twitter_tokensecret' value = '<?php echo $twitter[3] ?>'>
                                                </div>
                                        </div>
  					<div class="form-group">
   						<div class="col-sm-offset-2 col-sm-1">
      							<button id = 'twittersettingssync' name = 'twittersettingssync' type="button" onclick = "savesocialkeys('twitter', this.form)" class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Saving..." > Save </button>
						</div>
  					</div>
				</form>
			</div>
		</div>
	</div>
</div>
