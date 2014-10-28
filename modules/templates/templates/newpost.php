<?php
$this->notification = isset($skinnyData['notification']) ? $skinnyData['notification'] : '';
$this->notificationclass = isset($skinnyData['notificationclass']) ? $skinnyData['notificationclass'] : '';
?>
<div class="panel-group" id="accordion">
	<div class="panel panel-default" id = 'saiob_fb_accordion' style = 'display:block;width:98.3%;'>
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#facebook">
                        <div class="panel-title"> <b> Compose New Post </b> <span id = 'facebook_h_span' class = 'fa fa-toggle-down pull-right'> </span> </div>
                </div>
                

                 
                <div id="fbook" class="panel-collapse collapse in">
                        <div class="panel-body">
                        <div class='row'>
                        <label  class="col-sm-3 composeoptions"> Select The Provider </label> 
                        <span id='circlecheck'> <input onclick = 'saiob_showprovider(this.checked, "facebook")' type = 'checkbox' name = 'facebook_provider' class="circlecheckbox" id = 'facebook_provider'><label id="enableoption" class="circle-label" for="facebook_provider"> Facebook </label>
                        <span id='circlecheck' style="margin-left:15px;"> <input onclick = 'saiob_showprovider(this.checked, "twitter")' type = 'checkbox' name = 'twitter_provider' class="circlecheckbox" id = 'twitter_provider'><label id="enableoption" class="circle-label" for="twitter_provider"> Twitter </label>
			<span id='circlecheck' style="margin-left:15px;"> <input onclick = 'saiob_showprovider(this.checked, "twittercards")' type = 'checkbox' name = 'twittercard_provider' class="circlecheckbox"  id = 'twittercard_provider'><label id="enableoption" class="circle-label" for="twittercard_provider"> Twitter Cards </label>
                        </div>
                            <div class = 'row' style = 'margin-top:25px;'>
                                                        <label  class="col-sm-3 composeoptions"> Enter The Post Title </label>
                                                                <input type="text" class="col-sm-5" id="saiob_posttitle" name = "saiob_posttitle" / > 
                            </div>
                            <div class= 'row' style = 'margin-top:25px;'>
                                                        <label class="col-sm-3 composeoptions"> Enter The Post Content </label>
                                                        <textarea class="col-sm-5" id="saiob_postcontent" name = "saiob_postcontent" > </textarea>
                            </div>
                             <div class="row" style='margin-top:25px;'>
                                                     <label class="col-sm-3 composeoptions">Post Type</label>
                                                  </div>
                             <div class="row" style="margin-top:25px;">
                                                     <input type="radio" id="saiob_text_post"  name = "saiob_post_type" data-toggle="tooltip"
data-original-title="Share a text message" style="float:left;margin-left:25px"/>
						     <label class="col-sm-3 enableoption" style="margin-top:-3px;">Text Post</label>
                             </div>
                             <div class="row" style="margin-top:25px;">
                                                     <input type="radio" id="saiob_link_post" name = "saiob_post_type" data-toggle="tooltip"
data-original-title="Share a link message" style="float:left;margin-left:25px"/>
						     <label class="col-sm-3 enableoption" style="margin-top:-3px;">Link Post</label>
<!--                                                     <label class="col-sm-3 enableoption">Enter The Link Post Url </label>-->
                                                     <input type = "text" class="col-sm-5" id="saiob_url" name = 'saiob_url' style="margin-left:-45px;margin-top:-6px;" data-toggle="tooltip" data-original-title="Enter the link post image url(http://example.com/image.png)" placeholder="Enter The Link Post Url"/>
                            </div>
                            <div class="row" style="margin-top:25px;">
                                                     <input type="radio" id="saiob_image_post" name = "saiob_post_type" data-toggle="tooltip"
data-original-title="Share a image message" style="float:left;margin-left:25px"/>
						     <label class="col-sm-3 enableoption" style="margin-top:-3px;">Image Post</label>
<!--                                                     <label class="col-sm-3 enableoption"> Enter The Image Url </label>-->
                                                     <input type = "text" class="col-sm-5" id="saiob_imageurl" name = 'saiob_imageurl' data-toggle="tooltip" style="margin-left:-45px;margin-top:-6px;" data-original-title="Enter the image post image url(http://example.com/image.png)" placeholder="Enter The Image Url"/>
                            </div>

                            <div class= 'row' style = 'margin-top:25px;'>
                                                        <label class="col-sm-3 ">  </label>
                                                        <button type="button" onclick = "createnewpost(this.id)" id = 'saiob_compose' name = 'saiob_compose' style="margin:15px 0px 20px 190px"class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Composing..."> Compose </button>
                            </div>

                                </div>


<script>
jQuery(document).ready(function (){
     jQuery(":input").mouseover(function (){
              var id=this.id;           
jQuery("#"+id).tooltip({placement: 'right'});
              });
});
</script>



















                        </div>
                </div>
        </div>
