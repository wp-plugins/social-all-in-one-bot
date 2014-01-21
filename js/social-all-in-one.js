function fetchtemplate(templatename)
{
        jQuery('#fetchtemplategif').show();
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'   : 'saiob_gettemplate',
                    'type'     : templatename,
                },
                success:function(data) {
                        jQuery("#social-all-in-one-settings-bulkcomposer").html(data);
                        jQuery('#fetchtemplategif').hide();
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function storesmartbotinfo(provider, form)
{
	var value = new Array()
	var buttonid = provider+'smartbot';	
	var templatename = jQuery.trim(document.getElementById('bulkcomposer_template').value);
	if(templatename == '')
	{
		msg = "Select Template";
		shownotification(msg, 'warning');
		return false;
	}

	jQuery('#'+buttonid).button('loading');

	if(provider == 'twitter')
	{
		value[0] = form.twitterbot_maxchars.value;
		value[1] = form.twitterbot_tags.value;
		value[2] = form.twitterbot_tag_rotate.value;
		value[3] = form.twitterbot_tag_nos.value;
		value[4] = form.twitterbot_calltoactions.value;
		value[5] = form.twitterbot_action_rotate.value;
		value[6] = form.twitterbot_frequency.value;
		value[7] = form.twitterbot_period.value;
		value[8] = form.twitterbot_hours_from.value;
		value[9] = form.twitterbot_hours_to.value;
		value[10] = templatename;
		value[11] = form.twitterbot_weekly.value;
		value[12] = form.twitterbot_fromdate.value;
		value[13] = form.twitterbot_todate.value;
	}
	else if(provider == 'facebook')
	{
		value[0] = form.facebookbot_maxchars.value;
                value[4] = form.facebookbot_calltoactions.value;
                value[5] = form.facebookbot_action_rotate.value;
                value[6] = form.facebookbot_frequency.value;
                value[7] = form.facebookbot_period.value;
                value[8] = form.facebookbot_hours_from.value;
                value[9] = form.facebookbot_hours_to.value;
                value[10] = templatename;
		value[11] = form.facebookbot_weekly.value;
		value[12] = form.facebookbot_fromdate.value;
		value[13] = form.facebookbot_todate.value;
	}

	jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       : 'saiob_storesmartbotinfo',
                    'provider'     : provider,
                    'value'        : value,
                },
                success:function(data) {
			shownotification(data, 'success');
                        jQuery('#'+buttonid).button('reset');
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function savesocialkeys(provider, form)
{
	var value = new Array();
	var buttonid = provider+'settingssync';
	jQuery('#'+buttonid).button('loading');

	if(provider == 'facebook')
	{
		value[0] = form.facebook_appid.value;
		value[1] = form.facebook_secretkey.value;
		jQuery( "#facebook_settings" ).submit();
		return false;
	}
	else if(provider == 'twitter')
	{	
		value[0] = form.twitter_consumerkey.value; 
		value[1] = form.twitter_consumersecret.value;
		value[2] = form.twitter_accesskey.value;
		value[3] = form.twitter_tokensecret.value;
	}

	jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       : 'saiob_storesocialkeys',
                    'provider'     : provider,
		    'value'	   : value,
                },
                success:function(data) {
			if(data.loginurl)	{
				window.location.href = data.loginurl;
			}
			shownotification(data.msg, data.msgclass);
			jQuery('#'+buttonid).button('reset');
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function shownos(value, checked)
{
	var display = 'none';
	if(checked == true)
		display = 'block';
		
	if(value == 'googlebot_tag_rotate' && checked == true)
		document.getElementById(value+'_div').style.display = display;
}

function showdatediv(value, provider)
{
	if(value == 'Date')	
	{
		document.getElementById(provider+'_Date_div').style.display = 'block';
		document.getElementById(provider+'_Weekly_div').style.display = 'none';
	}
	else if(value == 'Weekly')	
	{
		document.getElementById(provider+'_Weekly_div').style.display = 'block';
		document.getElementById(provider+'_Date_div').style.display = 'none';
	}
	else
	{
		document.getElementById(provider+'_Weekly_div').style.display = 'none';
		document.getElementById(provider+'_Date_div').style.display = 'none';
	}
}

function savebulkcomposertemplate(form)
{
	var templatename = jQuery.trim(form.templatename.value);
	var mode = form.mode.value;
	// validation for bulk composer starts here
	var source = form.type.value;
	var settingstype = form.settingstype.value;
	var fromdate = form.fromdate.value;
	var todate = form.todate.value;
	var fromid = jQuery.trim(form.fromid.value);
	var toid = jQuery.trim(form.toid.value);
	var msg = '';
	if(mode == 'create' && templatename == '')
		msg = 'Enter Template Name';
	
	if(source == 'Select' && msg == '')	
		msg = 'Select Source';

	if(settingstype == 'Date' && msg == '')
	{
		if(!todate || !fromdate)
			msg = 'Select Date';
		else if(fromdate > todate)
			msg = 'From date should be greater than To Date';

	}	
	else if(settingstype == 'ID' && msg == '')
	{
		var reg=/^-?[0-9]+$/;
		if(!toid || !fromid)	
                        msg = 'Select Id';
		else if(!reg.test(fromid) || !reg.test(toid))
			msg = 'ID sould be integer';
 	        else if(fromid > toid)	
                        msg = 'From ID should be greater than To ID';

	}

	if(msg != '')
	{
		shownotification(msg, 'danger');
		return false;
	}
	// validation ends here

	jQuery('#savetemplate').button('loading');
	jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'   : 'saiob_checkbulkcomposertemplate',
                    'type'     : templatename,
		    'mode'     : mode,
                },

                success:function(data) 
		{
			if(data == 1)	
			{
				jQuery("#bulkcomposertemplate").submit();	
			}
			else	
			{
				msg = "Template name exist. Please use another name";
				shownotification(msg, 'danger');	
			}
			jQuery('#savetemplate').button('reset');	
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function changetemplate(templatename)
{
	jQuery('#changetemplategif').show();
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'   		: 'saiob_gettemplate',
                    'templatename'      : templatename,
                    'callmode'     	: 'ajax',
                },
                success:function(data)
                {	
			jQuery("#bulkcomposer").html(data);
			jQuery('#changetemplategif').hide();
			
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function shownotification(msg, alerts)
{
	var newclass;
	var divid = "notification_saio";

	if(alerts == 'success')
		newclass = "alert alert-success";
	else if(alerts == 'danger')
		newclass = "alert alert-danger";
	else if(alerts == 'warning')
		newclass = "alert alert-warning";
	else
		newclass = "alert alert-info";

	jQuery('#'+divid).removeClass()
	jQuery('#'+divid).html(msg);
        jQuery('#'+divid).addClass(newclass);
	// Scroll
    	jQuery('html,body').animate({
        	scrollTop: jQuery("#"+divid).offset().top},
        'slow');
}

function getmetainformation(type, id)
{	
	if((type == 'Select') || (id.trim().length == 0)) 
	{
		msg = "Both Type and Id are Mandatory";
		shownotification(msg, 'warning');
		return false;
	}

	jQuery('#metainformationgif').show();
	jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'   : 'generatemetainformation',
                    'type'     : type,
                    'id'       : id,
                },
                success:function(data) {
			jQuery("#metainformation_saio").html(data);
			jQuery('#metainformationgif').hide();
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });	
}

function changetype(value)
{
	if(value == 'Date')
	{
		jQuery('#id_div').hide();
                jQuery('#date_div').show();
	}
	else if(value == 'ID')
	{
		jQuery('#id_div').show();
		jQuery('#date_div').hide();
	}
}
