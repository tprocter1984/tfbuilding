<?php

global $base;
$base = get_stylesheet_directory_uri();

include('functions-acf.php');

function call_stylesheets()
{

    global $base;
    wp_enqueue_style('style', $base . '/style.css');

}

function call_javascript()
{

    global $base;
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', $base . '/_/js/jquery-1.11.0.min.js');
    wp_enqueue_script('waypoints', $base . '/_/js/waypoints.min.js');
    wp_enqueue_script('sticky', $base . '/_/js/waypoints-sticky.min.js');
    wp_enqueue_script('custom', $base . '/_/js/scripts.js', "", "", true);

}

function remove_head_links()
{
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
}

function theme_setup()
{

    add_image_size( 'work-banner', 1200, 400, true );
    add_theme_support( 'post-thumbnails' );

    register_nav_menus(array(
        'primary' => __('Top Navigation')
    ));

}

/**
 * Register Custom Fields
 */
function add_fields() {

    if(function_exists("register_field_group"))
    {
        register_field_group(array (
            'id' => 'acf_extra-information',
            'title' => 'Extra Information',
            'fields' => array (
                array (
                    'key' => 'field_53fb94a7ab142',
                    'label' => 'Sub Heading',
                    'name' => 'sub_heading',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'html',
                    'maxlength' => '',
                ),
                array (
                    'key' => 'field_53fb94e9ab143',
                    'label' => 'Intro Image',
                    'name' => 'intro_image',
                    'type' => 'image',
                    'required' => 1,
                    'save_format' => 'object',
                    'preview_size' => 'large',
                    'library' => 'all',
                ),
                array (
                    'key' => 'field_53fb9509ab144',
                    'label' => 'Content Image',
                    'name' => 'content_image',
                    'type' => 'image',
                    'required' => 1,
                    'save_format' => 'object',
                    'preview_size' => 'large',
                    'library' => 'all',
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                        'order_no' => 0,
                        'group_no' => 0,
                    ),
                ),
            ),
            'options' => array (
                'position' => 'acf_after_title',
                'layout' => 'default',
                'hide_on_screen' => array (
                    0 => 'excerpt',
                    1 => 'custom_fields',
                    2 => 'discussion',
                    3 => 'comments',
                    4 => 'slug',
                    5 => 'author',
                    6 => 'format',
                    7 => 'tags',
                    8 => 'send-trackbacks',
                ),
            ),
            'menu_order' => 0,
        ));
    }

}


/**
 * Add Actions
 */
add_action('init', 'remove_head_links');
add_action('after_setup_theme', 'theme_setup');
add_action('wp_enqueue_scripts', 'call_javascript');
add_action('wp_enqueue_scripts', 'call_stylesheets');