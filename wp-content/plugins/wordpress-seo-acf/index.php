<?php 
/*
Plugin Name: Wordpress SEO ACF Extension
Version: 1.0
Author: PushON Ltd
Author URI: http://www.pushon.co.uk
Description: This plugin adds functionality so that Wordpress SEO looks at Custom Fields as part of it's page check
*/

function add_custom_content_to_analysis( $content ) {
	global $post;
	$custom = get_post_custom( $post->ID );
	$custom_content = '';
	foreach( $custom as $field )
	{
		$custom_content .= $field[0].' ';
	}
	return $content . ' ' . $custom_content;
}
add_filter( 'wpseo_pre_analysis_post_content', 'add_custom_content_to_analysis' );

