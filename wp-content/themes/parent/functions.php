<?php

if( !class_exists('Acf') )
    include_once('plugins/acf/acf.php' );

if( !class_exists('acf_repeater_plugin') )
    include_once('plugins/acf-repeater/acf-repeater.php');

function add_viewport() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />' . "\n";
}

add_action('wp_head', 'add_viewport');

function favicon_link() {
    echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />' . "\n";
}

add_action('wp_head', 'favicon_link');



if (!function_exists('css_refresh')) {

    function css_refresh() {
        wp_enqueue_script('cssrefresh', get_template_directory_uri() . '/_/js/cssrefresh.js');
    }
    if( $_SERVER['REMOTE_ADDR'] == "127.0.0.1" ){
        add_action('wp_enqueue_scripts', 'css_refresh');
    }

}
