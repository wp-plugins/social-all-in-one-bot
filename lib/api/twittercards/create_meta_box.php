<?php
class Twitter_Box {
	protected $meta_box;
	//Create meta box based on given data
	function __construct( $meta_box )
	{
		$this->_meta_box = $meta_box;

		add_action( 'add_meta_boxes', array( &$this, 'add' ) ); 
		add_action( 'save_post', array( &$this, 'save' ) );
	}
	//Add meta box for multiple post types
	function add()
	{
		global $wpdb;
                //$post_var=get_option('post_check');//echo '<pre>';print_r($post_var);
                //foreach( $post_var as $page =>$value )
                   //{   
			add_meta_box(
					$this->_meta_box['id'],
					$this->_meta_box['title'],
					array( &$this, 'show' ),
					'post',
					$this->_meta_box['context'],
					$this->_meta_box['priority']
				    );
		//}
	}
	function save($post_id){ //echo '<pre>';print_r($post_id);die('qs');
		global $wpdb;
		$twitter=$this->_meta_box['twitter_fields'];
                foreach($twitter as $twitter_field) {
                $key = $twitter_field['id'];
		update_post_meta($post_id,$key,$_POST[$key]);
                 }
	}

	function show()
	{
		global $post;
                $title = '';
                $id = ''; 
                global $wpdb;
                $post_values = array('post/product-title','post/product-image','product_category','product_description');
                $custom_fields = get_post_custom_keys($post->ID);
                $custom_field_keys = array_merge($custom_fields,$post_values);
            //    print_r($custom_field_keys);die;
                // foreach ( $custom_field_keys as $key => $value ) {
                // $valuet = trim($value);
                // if(!in_array($value, $google ,True))
                // echo $key . " => " . $value . "<br />";
                // }
             ?> <div class= "music">
                      <table class="form-table">
                       <!--<h4 class="heading"><?php _e( 'Music'); ?></h4>-->
                         <?php
		        foreach($this->_meta_box['twitter_fields'] as $twitter_field){
                        $twitter_title=$twitter_field['name'];
			$twitter_id=$twitter_field['id'];
			$twitter_type=$twitter_field['type'];
			$twitter_value=get_post_meta($post->ID,$twitter_id,true);
                         ?>
                        <tr> <th> 
                         <label for="google_seo_meta_title"><?php  _e( $twitter_title );  ?></label>
                          </th>
                          <td>
				
				<?php if ( $twitter_type == 'twitter_card_type' ) { ?>
					<input type="radio" id="<?php echo $twitter_id; ?>" name="<?php echo $twitter_id; ?>" value="summary" /><label for="<?php echo $twitter_id; ?>">Summary Card</label>
					<input type="radio" id="<?php echo $twitter_id; ?>" name="<?php echo $twitter_id; ?>" value="large_image_summary" /><label for="<?php echo $twitter_id; ?>">Large Image Summary Card</label>
					<input type="radio" id="<?php echo $twitter_id; ?>" name="<?php echo $twitter_id; ?>" value="photo" /><label for="<?php echo $twitter_id; ?>">Photo Card</label>
					<input type="radio" id="<?php echo $twitter_id; ?>" name="<?php echo $twitter_id; ?>" value="gallery" /><label for="<?php echo $twitter_id; ?>">Gallery Card</label>
					<!--<input type="radio" id="<?php echo $twitter_id; ?>" name="<?php echo $twitter_id; ?>" value="player" /><label for="<?php echo $twitter_id; ?>">Player</label>-->
					<input type="radio" id="<?php echo $twitter_id; ?>" name="<?php echo $twitter_id; ?>" value="product" /><label for="<?php echo $twitter_id; ?>">Product Card</label>
					<!--<input type="radio" id="<?php echo $twitter_id; ?>" name="<?php echo $twitter_id; ?>" value="app" /><label for="<?php echo $twitter_id; ?>">App</label>-->
<?php } 
				 else { ?>
					<input type="text" id="<?php echo $twitter_id; ?>" name="<?php echo $twitter_id; ?>"  class="large-text"  value="<?php echo $twitter_value; ?>" />     <?php } ?>
				</td>
                         </tr>
                   <?php }?>
                       </table>
                  </div> <!-- Music -->   
                       
 
                 </div><!-- End Meta Box -->
     <?php
        }
}
//$prefix = '';
$prefix='twitter_cards';
$meta_box=array();
$meta = array();
$meta_box[]=array(
		'id'=>'metagroup',
		'title'=>'Twitter Cards',
		'pages'=> array('post','page'),
		'context' => 'advanced',
		'priority' => 'high',
						    
                'twitter_fields' => array(
                        array( 'id'=>$prefix.'user_name', 'name'=>'Site Main Account Name'),
                        array( 'id'=>$prefix.'post_title', 'name'=>'Title'),
                        array( 'id'=>$prefix.'post_description', 'name'=>'Description' ),
                        array( 'id'=>$prefix.'image_url', 'name'=>'Image Url' ),
                        array( 'id'=>$prefix.'card_type', 'type'=>'twitter_card_type','name'=>'Card Type' ),
			array( 'id'=>$prefix.'image_url1', 'name'=>'Image Url1' ),
			array( 'id'=>$prefix.'image_url2', 'name'=>'Image Url2' ),
			array( 'id'=>$prefix.'image_url3', 'name'=>'Image Url3' ),
			//array( 'id'=>$prefix.'image_url4', 'name'=>'Image Url4' ),
			array( 'id'=>$prefix.'domain_name', 'name'=>'Domain Name' ),
			array( 'id'=>$prefix.'label1', 'name'=>'Label1' ),
			array( 'id'=>$prefix.'data1', 'name'=>'Data1' ),
			array( 'id'=>$prefix.'label2', 'name'=>'Label2' ),
                        array( 'id'=>$prefix.'data2', 'name'=>'Data2' )
                        //array( 'id'=>$prefix.'buy_url', 'name'=>'Buy Track ' ),
                        //array( 'id'=>$prefix.'album_link', 'name'=>'Album Link')
                                          )
                                                      );
foreach( $meta_box as $meta_b )
{
	new Twitter_Box($meta_b);
}
