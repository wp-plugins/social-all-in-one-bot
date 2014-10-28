<?php
if ( !defined( 'ABSPATH' ) ) exit;

function schema_twitter_card() {
        global $post;
	$tweet_name = get_option('__saiob_twittercardskeys');
	$twitter_user_name = $tweet_name[4];
        $prefix = 'twitter_cards';
       // Get the twitter cards values for schema
        $twitter_card_user_name = get_post_meta( $post->ID, $prefix.'user_name', true );
        $twitter_title = get_post_meta( $post->ID, $prefix.'post_title', true );
        $twitter_description = get_post_meta( $post->ID, $prefix.'post_description', true );
        $twitter_image_url = get_post_meta( $post->ID, $prefix.'image_url', true );
	$twitter_image_url1 = get_post_meta( $post->ID, $prefix.'image_url1', true );
	$twitter_image_url2 = get_post_meta( $post->ID, $prefix.'image_url2', true );
	$twitter_image_url3 = get_post_meta( $post->ID, $prefix.'image_url3', true );
        $twitter_card_type = get_post_meta( $post->ID, $prefix.'card_type', true );
	$twitter_domain_name = get_post_meta( $post->ID, $prefix.'domain_name', true );
	$twitter_card_product_label1 = get_post_meta( $post->ID, $prefix.'label1', true );
	$twitter_card_product_data1 = get_post_meta( $post->ID, $prefix.'data1', true );
	$twitter_card_product_label2 = get_post_meta( $post->ID, $prefix.'label2', true );
	$twitter_card_product_data2 = get_post_meta( $post->ID, $prefix.'data2', true );

        $schema_twitter_card = '';
		$schema_twitter_card .= '<meta name="twitter:card" value="'.$twitter_card_type.'"/>';
		$schema_twitter_card .= '<meta name="twitter:site" value="@'.$twitter_card_user_name.'" />
				<meta name="twitter:creator" value="@'.$twitter_user_name.'" />';
		$schema_twitter_card .= '<meta name="twitter:title" value="'.$twitter_title.'"/>
				<meta name="twitter:description" value="'.$twitter_description.'"/>';
	if ($twitter_card_type == 'summary' || $twitter_card_type == 'large_image_summary' || $twitter_card_type == 'photo') {
		$schema_twitter_card .=	'<meta name="twitter:image" value="'.$twitter_image_url.'" />';
	}
	else if($twitter_card_type == 'gallery') {
                $schema_twitter_card .= '<meta name="twitter:image0:src" value="'.$twitter_image_url.'" />
					<meta name="twitter:image1:src" value="'.$twitter_image_url1.'" />
					<meta name="twitter:image2:src" value="'.$twitter_image_url2.'" />
					<meta name="twitter:image3:src" value="'.$twitter_image_url3.'" />';
	}
	else if ($twitter_card_type == 'product') {
                $schema_twitter_card .= '<meta name="twitter:image" value="'.$twitter_image_url.'" />';
		$schema_twitter_card .= '<meta name="twitter:domain" value="'.$twitter_domain_name.'" />';
		$schema_twitter_card .= '<meta name="twitter:label1" value="'.$twitter_card_product_label1.' "/>
					<meta name="twitter:data1" value="'.$twitter_card_product_data1.'" />
					<meta name="twitter:label2" value="'.$twitter_card_product_label2.'" />
                                        <meta name="twitter:data2" value="'.$twitter_card_product_data2.'" />';
        }

        //return  $text.$schema_twitter_card;
	echo $schema_twitter_card;
}

function twitter_card_schema_add_meta() {
global $post;
$prefix = 'twitter_cards';
$google_seo_music_name = get_post_meta( $post->ID, $prefix.'user_name', true );
if( $google_seo_music_name != '' && !is_home() ) {
add_filter( "wp_head", "schema_twitter_card" );
}
}
add_action( 'wp', 'twitter_card_schema_add_meta' );

