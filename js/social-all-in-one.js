jQuery(document).ready(function(){

                        jQuery("#wpfooter").css("position","relative");
});
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

function selectAll(all)
{
var checked = all.checked;
var chkBoxes = document.getElementsByTagName("input");
for (var counter=0;counter<chkBoxes.length;counter++) {
chkBoxes[counter].checked= checked;
}
}

function deleteItem(){
    if (confirm("Are you sure you want to delete?")){               
        var notChecked = [], checked = [];
        jQuery(":checkbox").each(function() {
            if(this.checked){
                checked.push(this.id);
            } else {
                notChecked.push(this.id);
            }
        });
        
    }
jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       : 'saiob_deleteItem',
                    
                    'checked'        :  checked,
                },
                success:function(data) {
			shownotification(data, 'success');
 //                       jQuery('#'+buttonid).button('reset');
                       location.reload();
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}



function deleteItem1(){
    if (confirm("Are you sure you want to delete?")){               
        var notChecked = [], checked = [];
        jQuery(":checkbox").each(function() {
            if(this.checked){
                checked.push(this.id);
            } else {
                notChecked.push(this.id);
            }
        });
        
    }
jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       : 'saiob_deleteItem1',
                    
                    'checked'        :  checked,
                },
                success:function(data) {
			shownotification(data, 'success');
                        location.reload();
                       // jQuery('#'+buttonid).button('reset');
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}
function debug_option()
{
	var debug_name = document.getElementById('debug_mode').checked;
        var postdata = new Array();
        var postdata = debug_name;
                jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                'action'   : 'debug_option',
                'postdata' : postdata,
                },
                success:function(data) {
                },
                error: function(errorThrown){
                console.log(errorThrown);
                       }
                });


}

function saiob_deletetemplate(id,buttonthis)
{
    
      
     var res = confirm('Are you sure you want to delete this ?');
     if(!res) return false;
              
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'            : 'saiob_deletetemplate',
                    'id'      : id,
                },
                success:function(data)
                {       jQuery('#delete_templatename'+id).button('reset');
                        if(data.msgclass='success')
                         {  
                           var tr=jQuery(buttonthis).closest('tr');
                           tr.css("background-color","#FF3700");
                           tr.fadeOut(400,function(){
                             tr.remove();
                            });
                             return false;
                          }

                       
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function saiob_createtemplate(form)
{
         
	var facebook_check = jQuery('#facebook_provider').is(":checked");
	var twitter_check  = jQuery('#twitter_provider').is(":checked");
	var linkedin_check  = jQuery('#linkedin_provider').is(":checked");
	var templatename   = jQuery.trim(form.templatename.value);
	var mode = 'create';
	// if no provider selected. Show error
	if(facebook_check == false && twitter_check == false && linkedin_check == false)
	{
		var msg = 'Please select any provider to save template';
		saiob_shownotification(msg, 'danger');
		return false;
	}

	// if templatname is null
	if(!templatename)
	{
		var msg = 'Please enter template name';
                saiob_shownotification(msg, 'danger');
                return false;
	}

	jQuery('#saiob_createtemplate_button').button('loading');
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
                                jQuery("#saiob_template_create").submit();
                        }
                        else
                        {
                                msg = "Template name exist. Please enter another name";
                                shownotification(msg, 'danger');
	    			jQuery('#saiob_createtemplate_button').button('reset');
                        }
                },
                error: function(errorThrown) {
                        console.log(errorThrown);
                }
        });	
}
// update template 
   function saiob_updatetemplate(form)
{
       
	var facebook_check = jQuery('#facebook_provider').is(":checked");
	var twitter_check  = jQuery('#twitter_provider').is(":checked");
	var templatename   = jQuery.trim(form.templatename.value);
	var mode = 'update';
	// if no provider selected. Show error
	if(facebook_check == false && twitter_check == false)
	{
		var msg = 'Please select any provider to save template';
		saiob_shownotification(msg, 'danger');
		return false;
	}

	// if templatname is null
	if(!templatename)
	{
		var msg = 'Please enter template name';
                saiob_shownotification(msg, 'danger');
                return false;
	}

	jQuery('#saiob_updatetemplate_button').button('loading');
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
                                jQuery("#saiob_template_update").submit();
                                 var msg = ' Template  Updated Successfully';
                                 saiob_shownotification(msg, 'success');
                                 return false;
                        }
                                        },
                error: function(errorThrown) {
                        console.log(errorThrown);
                }
        });	
}

function saiob_showprovider(checked, provider)
{
	if(checked == true)
	{
		// check whether module is enabled
		jQuery.ajax({
        	        type  : 'POST',
			async : false,
                	url   : ajaxurl,
	                data: {
        	            'action'       : 'saiob_checkproviderenabled',
                	    'provider'     : provider,
	                },
        	        success:function(data) {
				if(data.msgclass == 'danger')
				{
					shownotification(data.msg, data.msgclass);
					jQuery("#"+provider+"_provider").prop('checked', false);
					return false;
				}
				else
				{
					jQuery("#saiob_"+provider+'_accordion').show();
				}
	                },
        	        error: function(errorThrown){
                	        console.log(errorThrown);
	                }
	        });
	}
	else
	{
		jQuery("#saiob_"+provider+'_accordion').hide();
	}
}

function performcloningaction(mod, id, buttonthis)
{
        var res = confirm('Are you sure you want to clone this ?');
        if(!res) return false;

	jQuery('#clone_'+id).button('loading');
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'   : 'saiob_cloningqueueorlog',
                    'mod'      : mod,
		    'id'       : id,
                },
                success:function(data) {
			jQuery('#clone_'+id).button('reset');
			if(data.msgclass == 'success')
			{
				var tr = jQuery(buttonthis).closest('tr');
			}
			shownotification(data.msg, data.msgclass)
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}



function performdeleteaction(mod, id, buttonthis)
{
       
     var res = confirm('Are you sure you want to delete this ?');
        if(!res) return false;

	jQuery('#delete_'+id).button('loading');
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'   : 'saiob_deletequeueorlog',
                    'mod'      : mod,
		    'id'       : id,
                },
                success:function(data) {
			jQuery('#delete_'+id).button('reset');
			if(data.msgclass == 'success')
			{
				var tr = jQuery(buttonthis).closest('tr');
                                        tr.css("background-color","#FF3700");

                                tr.fadeOut(400, function(){
                                	tr.remove();
                                });
				return false;
			}
			shownotification(data.msg, data.msgclass)
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function saiob_clearfieldvalues(type)
{
	if(type == 'twitter')
	{
		jQuery('#twitter_consumerkey').val('');
		jQuery('#twitter_accesskey').val('');
		jQuery('#twitter_consumersecret').val('');
		jQuery('#twitter_tokensecret').val('');
		jQuery('#enabletwitter').prop('checked', false);
	}
	else if(type == 'facebook')
	{
		jQuery('#facebook_appid').val('');
		jQuery('#facebook_secretkey').val('');
		jQuery('#enablefacebook').prop('checked', false);
	}
	else if(type == 'twittercards')
        {
                jQuery('#twittercards_username').val('');
                jQuery('#enabletwittercards').prop('checked', false);
        }
	else if(type == 'linkedin')
        {
                jQuery('#linkedin_apikey').val('');
                jQuery('#linkedin_secretkey').val('');
		jQuery('#linkedin_url').val('');
                jQuery('#enablelinkedin').prop('checked', false);
        }
	else if(type == 'all')
	{
		jQuery('#twitter_consumerkey').val('');
                jQuery('#twitter_accesskey').val('');
                jQuery('#twitter_consumersecret').val('');
                jQuery('#twitter_tokensecret').val('');
                jQuery('#enabletwitter').prop('checked', false);

		jQuery('#facebook_appid').val('');
                jQuery('#facebook_secretkey').val('');
                jQuery('#enablefacebook').prop('checked', false);
	}
}

function saiob_clearsocialsettings(type)
{
	var res = confirm('Are you sure you want to clear '+type+' settings ?');
        if(!res) return false;

	var classid = 'clear'+type+'settings';
	jQuery('#'+classid).button('loading');
	jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data:	{
                    'action'       : 'saiob_clearsocialsettings',
                    'type'         : type,
                },
                success:function(data) 
		{
                        shownotification(data.msg, data.msgclass);
			if(data.msgclass == 'success')
			{
				saiob_clearfieldvalues(type);
			}
                        jQuery('#'+classid).button('reset');
                },
                error: function(errorThrown)	
		{
                        console.log(errorThrown);
                }
        });
}

function storesmartbotinfo(provider, form)
{       
    	var value = new Array()
	var buttonid = provider+'smartbot';	
	var templatename = jQuery.trim(document.getElementById('templatename').value);
	if(templatename == '')
	{
		msg = "Select Template";
		shownotification(msg, 'warning');
		return false;
	}

	jQuery('#twittersmartbot').button('loading');

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
	else if(provider == 'linkedin')
	{
		value[0] = form.linkedinbot_maxchars.value;
                value[4] = form.linkedinbot_calltoactions.value;
                value[5] = form.linkedinbot_action_rotate.value;
                value[6] = form.linkedinbot_frequency.value;
                value[7] = form.linkedinbot_period.value;
                value[8] = form.linkedinbot_hours_from.value;
                value[9] = form.linkedinbot_hours_to.value;
                value[10] = templatename;
		value[11] = form.linkedinbot_weekly.value;
		value[12] = form.linkedinbot_fromdate.value;
		value[13] = form.linkedinbot_todate.value;
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
                        jQuery('#saiob_template_update').button('reset');
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}
function scheduleinfo(form)
 {
       
    	var value = new Array();
	var buttonid = 'schedule';	
	var templatename = jQuery.trim(document.getElementById('select_temp').value);
       	if(templatename == '')
	{
		msg = "Select Template";
		shownotification(msg, 'warning');
		return false;
	}
       
		value[0] = jQuery.trim(document.getElementById('settingstype').value); 
		value[1] = form.fromdate.value;
		value[2] = form.todate.value;
		value[3] = form.fromid.value;
		value[4] = form.toid.value;
		value[5] = form.posttitle.value;
		value[6] = form.htag.value;
		value[7] = form.metatitle.value;
		value[8] = form.postcontent.value;
		value[9] = form.excerptmsg.value;
		value[10] =form.metadesc.value; 
	        value[11] =form.images.value;
                value[12] =form.type.value;
	jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       : 'saiob_storesmartbotinfo',
                    'value'        : value,
                   'templatename'  : templatename,
                },
                success:function(data) {
                        
			shownotification(data, 'success');
                        jQuery('#saiob_template_update').button('reset');
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });

}

function scheduleinfo1(form)
 {
       
    	var value = new Array();
	var templatename = jQuery.trim(document.getElementById('select_temp').value);
       	if(templatename == '')
	{
		msg = "Select Template";
		shownotification(msg, 'warning');
		return false;
	}
       
		value[0] = jQuery.trim(document.getElementById('settingstype').value); 
		value[1] = form.fromdate.value;
		value[2] = form.todate.value;
		value[3] = form.fromid.value;
		value[4] = form.toid.value;
		value[5] = form.posttitle.value;
		value[6] = form.htag.value;
		value[7] = form.metatitle.value;
		value[8] = form.postcontent.value;
		value[9] = form.excerptmsg.value;
		value[10] =form.metadesc.value; 
	        value[11] =form.images.value;
                value[12] =form.type.value;
	jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       : 'saiob_storesmartbotinfo1',
                    'value'        : value,
                   'templatename'  : templatename,
                },
                success:function(data) {
			shownotify(data, 'info');
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });

}
function shownotify(msg, alerts)
{
	var newclass;
	var divid = "nodisp";

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
}

function previewinfo(form) 
{
	var value = new Array();
        var templatename = jQuery.trim(document.getElementById('select_temp').value);
	var source = document.getElementById('type').value
        if(templatename == 'default')
        {
                msg = "Select Template";
                shownotification(msg, 'warning');
                return false;
        }
	if(source == 'Select')
        {
                msg = "Select Source as Post / Page";
                shownotification(msg, 'warning');
                return false;
        }
		value[0] = jQuery.trim(document.getElementById('settingstype').value);
		value[1] = form.fromdate.value;
		value[2] = form.todate.value;
		value[3] = form.fromid.value;
		value[4] = form.toid.value;
		value[5] = form.posttitle.value;
		value[6] = form.htag.value;
		value[7] = form.metatitle.value;
		value[8] = form.postcontent.value;
		value[9] = form.excerptmsg.value;
		value[10] =form.metadesc.value; 
	        value[11] =form.images.value;
                value[12] =form.type.value;
	if(value[0] == 'Date' && (value[1] == '' || value[2] == ''))
        {
                msg = "Select From / To Date";
                shownotification(msg, 'warning');
                return false;
        }
	if(value[0] == 'ID' && (value[3] == '' || value[4] == ''))
        {
                msg = "Specify From / To ID";
                shownotification(msg, 'warning');
                return false;
        }
	var id = document.getElementById('first').value;
	jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       : 'saiob_preview',
		    'value'        : value,
                    'templatename' : templatename,
			'id' : id,
		     
                },
	 success:function(data) {
			var x = data.split('_');
			if( x[2] == 'null') {
				document.getElementById('divimg').innerHTML = "<div>Image Not Found!</div>";
			}
			else {
				document.getElementById('divimg').innerHTML = "<img src = "+x[2]+" height='150px' width='150px'>";
			}
			document.getElementById('divpost').innerHTML = "<center>Post Id: "+x[3]+"</center>";
			document.getElementById('divtit').innerHTML = x[0];
			document.getElementById('divbod').innerHTML = x[1];
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function next_info(form)
{
	var templatename = jQuery.trim(document.getElementById('select_temp').value);
        if(templatename == '')
        {
                msg = "Select Template";
                shownotification(msg, 'warning');
                return false;
        }
	var count = document.getElementById('count').value;
	var lastid = document.getElementById('last').value;
	var array_val = document.getElementById('array_val').value;
	var decode_array = jQuery.parseJSON(array_val);
	var id = document.getElementById('next').value;
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       : 'saiob_next',
                    'id'           : id,
		    'templatename' : templatename,
                },
        	success:function(data) {
                        var x = '';
                        x = data.split('_');
                        if( x[0] == 'null') {
                        	document.getElementById('divimg').innerHTML = "<div>Image Not Found!</div>";
                        }
                        else {
                        	document.getElementById('divimg').innerHTML = "<img src = "+x[0]+" height='150px' width='150px'>";
                        }  
                        document.getElementById('divpost').innerHTML = "<center>Post Id: "+x[1]+"</center>";
                        document.getElementById('divtit').innerHTML = x[2];
                        document.getElementById('divbod').innerHTML = x[3];
			if ( parseInt(id) == parseInt(lastid) ) {
				jQuery('.nextimage').attr('disabled', 'disabled');
			} else  {
                        // changing next image id
                        arrayKey = decode_array.indexOf(id);
                        arrayKey = arrayKey + 1;
                        lastKey  = arrayKey - 1;
                        document.getElementById('next').value = decode_array[arrayKey];
                        document.getElementById('prev').value = decode_array[lastKey];
                       }
                   },
	               error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function previous_info(form)
{
	var templatename = jQuery.trim(document.getElementById('select_temp').value);
        if(templatename == '')
        {
                msg = "Select Template";
                shownotification(msg, 'warning');
                return false;
        }
        var count = document.getElementById('count').value;
	var firstid = document.getElementById('first').value;
	var lastid = document.getElementById('last').value;
        var value = document.getElementById('array_val').value;
        var decode = jQuery.parseJSON(value);
	var id = document.getElementById('prev').value;

                 data='';
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       : 'saiob_previous',
                    'id'           : id,
		    'templatename' : templatename,

                },

                success:function(data) {
                        var x = '';
                        x = data.split('_');
                        if( x[0] == 'null') {
                        	document.getElementById('divimg').innerHTML = "<div>Image Not Found!</div>";
                        }
                        else{
                        	document.getElementById('divimg').innerHTML = "<img src = "+x[0]+" height='150px' width='150px'>";
                        }
                        document.getElementById('divpost').innerHTML = "<center>Post Id: "+x[1]+"</center>";
                        document.getElementById('divtit').innerHTML = x[2];
                        document.getElementById('divbod').innerHTML = x[3];
                        if ( parseInt(id) == parseInt(firstid) ) {
                                jQuery('.previousimage').attr('disabled', 'disabled');
                        }
			else  {
                 	id1 = decode.indexOf(id);
        		id_next = id1 + 1;
                        id_prev = id1 - 1;
			document.getElementById('next').value =  decode[id_next];
                        document.getElementById('prev').value = decode[id_prev];

			}
                 },

                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function checkfilter(form)
{
	var msg = '';
	var fromdate = form.fromdate.value;
	var todate = form.todate.value;
	var provider = form.provider_filter.value;
	var status_filter = form.status_filter.value;
	// check from date greater than to date
	if(fromdate && todate && (fromdate > todate))
        	msg = 'From date should be greater than To Date';

	if(msg != '')
        {
                shownotification(msg, 'danger');
                return false;
        }
	jQuery("#saiob_filter").submit();	
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
		value[4] = form.enabletwitter.value;
	}
	else if(provider == 'linkedin')
	{
                value[0] = form.linkedin_apikey.value;
                value[1] = form.linkedin_secretkey.value;
		value[2] = form.linkedin_url.value;
		jQuery( "#linkedin_settings" ).submit();
                return false;
        }
	else if(provider == 'twittercards')
	{
		value[0] = form.twittercard_consumerkey.value;
                value[1] = form.twittercard_consumersecret.value;
                value[2] = form.twittercard_accesskey.value;
                value[3] = form.twittercard_tokensecret.value;
		value[4] = form.twittercard_username.value;
                value[5] = form.enabletwittercard.value;
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
	var selectedtemplate = jQuery('#bulkcomposer_template').val();
	jQuery('#bulkcomposertemplate').val(selectedtemplate);
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

function saiob_clonetemplate(form)
{
        
	var facebook_check = jQuery('#facebook_provider').is(":checked");
	var twitter_check  = jQuery('#twitter_provider').is(":checked");
	var linkedin_check  = jQuery('#linkedin_provider').is(":checked");
	var templatename   = jQuery.trim(form.templatename.value);
	var mode = 'create';
	// if no provider selected. Show error
	if(facebook_check == false && twitter_check == false && linkedin_check == false)
	{
		var msg = 'Please select any provider to save template';
		saiob_shownotification(msg, 'danger');
		return false;
	}

	// if templatname is null
	if(!templatename)
	{
		var msg = 'Please enter template name';
                saiob_shownotification(msg, 'danger');
                return false;
	}

	jQuery('#saiob_clonetemplate_button').button('loading');
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
                                jQuery("#saiob_template_clone").submit();
                        }
                        else
                        {
                                msg = "Template name exist. Please enter another name";
                                shownotification(msg, 'danger');
                                jQuery('#saiob_clonetemplate_button').button('reset');
                        }
                },
                        error: function(errorThrown) {
                        console.log(errorThrown);
                }
        });	
}
function saiob_showdiv(divid)
{
	jQuery('#'+divid).show();
}


function saiob_changetemplate(templatename)
{
	var value = new Array();
	var templatename;
		value[0] = jQuery.trim(document.getElementById('settingstype').value);
		value[1] = form.fromdate.value;
		value[2] = form.todate.value;
		value[3] = form.fromid.value;
		value[4] = form.toid.value;
		value[5] = form.posttitle.value;
		value[6] = form.htag.value;
		value[7] = form.metatitle.value;
		value[8] = form.postcontent.value;
		value[9] = form.excerptmsg.value;
		value[10] =form.metadesc.value; 
	        value[11] =form.images.value;
                value[12] =form.type.value;
	if(mode == 'new')
	{
		templatename = '';
               
	}
	else
	{
		templatename = jQuery('#select_temp').val();
		if(templatename == '')
		{
			msg = 'Select Template';
			shownotification(msg, 'danger');
			return false;
		}
	}

	jQuery('#changetemplategif').show();
        jQuery.ajax({
                type: 'POST',
              
                url: ajaxurl,
                data: {
                    'action'   		: 'saiob_gettemplate',
                    'templatename'      : templatename,
		    'value'        	: value,
                    'callmode'     	: 'ajax',
                },
                success:function(data)
                {	
			//jQuery("#bulkcomposer").html(data);
			//jQuery('#changetemplategif').hide();
			
                },
                error: function(errorThrown){
                        console.log(errorThrown);
                }
        });
}

function saiob_shownotification(msg, alerts)
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
function createnewpost(id) {

var saiob_posttitle   = document.getElementById('saiob_posttitle').value;
var saiob_postcontent = document.getElementById('saiob_postcontent').value;
var saiob_imageurl    = document.getElementById('saiob_imageurl').value;
var saiob_text        = document.getElementById('saiob_text_post').checked;
var saiob_link        = document.getElementById('saiob_link_post').checked;
var saiob_url         = document.getElementById('saiob_image_post').checked;
var link_post         = document.getElementById('saiob_url').value;
var facebook_provider = document.getElementById('facebook_provider').checked;
var twitter_provider = document.getElementById('twitter_provider').checked;
var twittercard_provider = document.getElementById('twittercard_provider').checked;
var postdata          = new Array();
postdata = {'posttitle': saiob_posttitle, 'postcontent': saiob_postcontent, 'imageurl': saiob_imageurl , 'saiob_text': saiob_text , 'saiob_link' : saiob_link , 'saiob_url' : saiob_url , 'link_post' : link_post , 'facebook_provider' : facebook_provider , 'twitter_provider' : twitter_provider, 'twittercard_provider' : twittercard_provider } 
 jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'   : 'saiob_createinstantpost',
                    'postdata'     : postdata,
                },
                success:function(data) {
              var dat=JSON.parse(data);
                 shownotification(dat.msg,dat.war);
                },
                error: function(errorThrown){
                      console.log(errorThrown);
                }
        });
}
