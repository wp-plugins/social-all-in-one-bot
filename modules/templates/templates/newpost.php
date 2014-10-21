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
                        <label  class="col-sm-3"> Select The Provider </label> 
                        <label> <input onclick = 'saiob_showprovider(this.checked, "facebook")' type = 'checkbox' name = 'facebook_provider' id = 'facebook_provider'> Facebook </label>
                        <label> <input onclick = 'saiob_showprovider(this.checked, "twitter")' type = 'checkbox' name = 'twitter_provider' id = 'twitter_provider'> Twitter </label>
			<label> <input onclick = 'saiob_showprovider(this.checked, "twittercards")' type = 'checkbox' name = 'twittercard_provider' id = 'twittercard_provider'> Twitter Cards </label>
                        </div>
                            <div class = 'row' style = 'margin-top:25px;'>
                                                        <label  class="col-sm-3"> Enter The Post Title </label>
                                                                <input type="text" class="col-sm-5" id="saiob_posttitle" name = "saiob_posttitle" / > 
                            </div>
                            <div class= 'row' style = 'margin-top:25px;'>
                                                        <label class="col-sm-3 "> Enter The Post Content </label>
                                                        <textarea class="col-sm-5" id="saiob_postcontent" name = "saiob_postcontent" > </textarea>
                            </div>
                             <div class="row" style='margin-top:25px;'>
                                                     <label class="col-sm-3">Post Type</label>
                                                  </div>
                             <div class="row" style="margin-top:25px;">
                                                     <label class="col-sm-3">Text Post</label>
                                                     <input type="radio" id="saiob_text_post"  name = "saiob_post_type" data-toggle="tooltip"
data-original-title="Share a text message"/>
                             </div>
                             <div class="row" style="margin-top:25px;">
                                                     <label class="col-sm-3">Link Post</label>
                                                     <input type="radio" id="saiob_link_post" name = "saiob_post_type" data-toggle="tooltip"
data-original-title="Share a link message"/>
                             </div>
                            <div class= 'row' style = 'margin-top:25px;'>
                                                        <label class="col-sm-3 ">Enter The Link Post Url </label>
                                                        <input type = "text" class="col-sm-5" id="saiob_url" name = 'saiob_url' data-toggle="tooltip"
data-original-title="Enter the link post image url(http://example.com/image.png)" />
                            </div>
                            <div class="row" style="margin-top:25px;">
                                                     <label class="col-sm-3">Image Post</label>
                                                     <input type="radio" id="saiob_image_post" name = "saiob_post_type" data-toggle="tooltip"
data-original-title="Share a image message"/>
                             </div>
                            <div class= 'row' style = 'margin-top:25px;'>
                                                        <label class="col-sm-3 "> Enter The Image Url </label>
                                                        <input type = "text" class="col-sm-5" id="saiob_imageurl" name = 'saiob_imageurl' data-toggle="tooltip" data-original-title="Enter the image post image url(http://example.com/image.png)"/>
                            </div>

                            <div class= 'row' style = 'margin-top:25px;'>
                                                        <label class="col-sm-3 ">  </label>
                                                        <button type="button" onclick = "createnewpost(this.id)" id = 'saiob_compose' name = 'saiob_compose' class="btn btn-primary" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span> Composing..."> Compose </button>
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
