<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');

function my_acf_settings_path( $path ) {

    // update path
    $path = get_stylesheet_directory() . '/_/acf/';

    var_dump($path);

    // return
    return $path;

}


// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir( $dir ) {

    // update path
    $dir = get_stylesheet_directory_uri() . '/acf/';

    var_dump($path);

    // return
    return $dir;

}


// 3. Hide ACF field group menu item
//add_filter('acf/settings/show_admin', '__return_false');


// 4. Include ACF

$path = $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/tfbuilding/acf/acf.php';
include_once( $path );
