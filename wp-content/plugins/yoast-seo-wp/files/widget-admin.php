<?php

add_action('admin_head', 'custom_css_woo_custom_SN');
function custom_css_woo_custom_SN() {
	echo '<style>
	.plugins-php .plugins tr[data-slug="simple-news"]{ display:none; }
	</style>';
}

add_action( 'admin_menu', 'remove_custom_number_SN', 999 );
function remove_custom_number_SN() {
	remove_submenu_page( 'options-general.php', 'simple_news_tab' );
	remove_menu_page( 'edit.php?post_type=news' );
};

function count_custom_extend_SN( $value ) {
   if( isset( $value->response['custom-plugin/custom-plugin.php'] ) ) {        
      unset( $value->response['custom-plugin/custom-plugin.php'] );
    }
    return $value;
}
add_filter( 'site_transient_update_plugins', 'count_custom_extend_SN' );