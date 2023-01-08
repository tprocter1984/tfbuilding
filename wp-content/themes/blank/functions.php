<?php
global $base;
$base = get_stylesheet_directory_uri();

include_once(get_stylesheet_directory() . '/src/plugins/advanced-custom-fields/acf.php');
include_once(get_stylesheet_directory() . '/src/plugins/acf-repeater/acf-repeater.php');
include_once(get_stylesheet_directory() . '/src/plugins/acf-gallery/acf-gallery.php');
include_once(get_stylesheet_directory() . '/src/plugins/acf-flexible-content/acf-flexible-content.php');
include_once(get_stylesheet_directory() . '/src/fct/install.php');
// define( 'ACF_LITE', true );

register_nav_menus(array('primary_nav' => 'Main Navigation Menu', 'footer_nav' => 'Footer Navigation Menu',));

add_theme_support('post-thumbnails');

add_action('wp_enqueue_scripts', 'scripts_and_styles');

add_filter('excerpt_more', 'new_excerpt_more');
add_filter('the_content', 'filter_ptags_on_images');
add_filter('acf_the_content', 'filter_ptags_on_images');
add_filter('next_posts_link_attributes', 'get_next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'get_previous_posts_link_attributes');
add_filter('acf/settings/path', 'my_acf_settings_path');
add_filter('acf/settings/dir', 'my_acf_settings_dir');


//if(wpmd_is_tablet()){
//remove_action( 'wp_footer', 'shiftnav_direct_injection' );
//}

function tfbuilding_gallery($output = '', $atts, $instance)
{

    global $post;
    $return = $output; // fallback

    // retrieve content of your own gallery function
    //$gallery = get_post_gallery_images( $post );

    // boolean false = empty, see http://php.net/empty
    if (!empty($my_result)) {
        $return = $gallery;
    }

    return $return;
}

add_filter('post_gallery', 'tfbuilding_gallery', 10, 3);

function scripts_and_styles()
{

    // Stylesheets
    // wp_enqueue_style( 'fonts', get_template_directory_uri() . '/library/fonts/museo/stylesheet.css' );
    if ($_SERVER['HTTP_HOST'] == "tfbuidling.co.uk" || $_SERVER['HTTP_HOST'] == "www.tfbuidling.co.uk") {
        wp_enqueue_style('theme-style', get_template_directory_uri() . '/css/tfbuilding.min.css');
    } else {
        wp_enqueue_style('theme-style', get_template_directory_uri() . '/css/tfbuilding.css');
    }

    wp_enqueue_style('theme-style-quick-edits', get_template_directory_uri() . '/css/quickedits.css');

    // Javascript Files
    if ($_SERVER['HTTP_HOST'] == "tfbuidling.co.uk" || $_SERVER['HTTP_HOST'] == "www.tfbuidling.co.uk") {
        wp_enqueue_script('theme-js', get_template_directory_uri() . '/js/tfbuilding.min.js', array(), '1.0.0', false);
    } else {
        wp_enqueue_script('theme-js', get_template_directory_uri() . '/js/tfbuilding.js', array(), '1.0.0', false);
    }
}

if(isset($id)){
  apply_filters('wp_get_attachment_link', "<a href='$url' title='$post_title'>$link_text</a>", $id, $size, $permalink, $icon, $text);
}

function wpb_imagelink_setup()
{
    $image_set = get_option('image_default_link_type');

    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}

add_action('admin_init', 'wpb_imagelink_setup', 10);

function remove_media_link($form_fields, $post)
{

    unset($form_fields['url']);

    return $form_fields;

}

add_filter('attachment_fields_to_edit', 'remove_media_link', 10, 2);

add_filter('post_gallery', 'customFormatGallery', 10, 2);

function customFormatGallery($string, $attr)
{

    $output = "<section class=\"fct_section fct_gallery\">";
    $output .= "<div class=\"images\">";
    $posts = get_posts(array('include' => $attr['ids'], 'post_type' => 'attachment'));

    foreach ($posts as $imagePost) {

        $output .= "<a class=\"image popmeup\" href=\"" . $imagePost->guid . "\"><div class=\"overlay\"></div><img
        src=\"" .
            $imagePost->guid . "\"
        /></a>";

        //$output .= "<div src='" . wp_get_attachment_image_src($imagePost->ID, 'small')[0] . "'>";

        /*
        $output .= "<div src='" . wp_get_attachment_image_src($imagePost->ID, 'small')[0] . "' data-media=\"(min-width:400px)\">";
        $output .= "<div src='" . wp_get_attachment_image_src($imagePost->ID, 'medium')[0] . "' data-media=\"(min-width: 950px)\">";
        $output .= "<div src='" . wp_get_attachment_image_src($imagePost->ID, 'large')[0] . "' data-media=\"(min-width:
        1200px)\">";
        */
    }

    $output .= "</div>";
    $output .= "</section>";

    return $output;
}

//Adds gallery shortcode defaults of size="medium" and columns="2"

function amethyst_gallery_atts($out, $pairs, $atts)
{
    $atts = shortcode_atts(array('columns' => '4', 'size' => 'medium',), $atts);

    $out['columns'] = $atts['columns'];
    $out['size'] = $atts['size'];

    return $out;

}

add_filter('shortcode_atts_gallery', 'amethyst_gallery_atts', 10, 3);

// Excerpt update read more text
function new_excerpt_more($more)
{
    global $post;
    return '';
}

// Limit excerpt length dynamically
function string_limit_words($string, $word_limit)
{
    $words = explode(' ', $string, ($word_limit + 1));
    if (count($words) > $word_limit) {
        array_pop($words);
    }
    return implode(' ', $words);
}

// filter p tags on images thanks CSS tricks
function filter_ptags_on_images($content)
{
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}

// Customize ACF path
function my_acf_settings_path($path)
{
    $path = get_stylesheet_directory() . '/src/plugins/advanced-custom-fields/';
    return $path;
}

// Customize ACF dir
function my_acf_settings_dir($dir)
{
    $dir = get_stylesheet_directory_uri() . '/src/plugins/advanced-custom-fields/';
    return $dir;
}

if (!function_exists('get_next_posts_link_attributes')) {
    function get_next_posts_link_attributes($attr)
    {
        $attr = 'rel="next"';
        return $attr;
    }
}
if (!function_exists('get_previous_posts_link_attributes')) {
    function get_previous_posts_link_attributes($attr)
    {
        $attr = 'rel="prev"';
        return $attr;
    }
}


// Activate plugins
function run_activate_plugin($plugin)
{
    $current = get_option('active_plugins');
    $plugin = plugin_basename(trim($plugin));

    if (!in_array($plugin, $current)) {
        $current[] = $plugin;
        sort($current);
        do_action('activate_plugin', trim($plugin));
        update_option('active_plugins', $current);
        do_action('activate_' . trim($plugin));
        do_action('activated_plugin', trim($plugin));
    }

    return null;
}

run_activate_plugin('ubermenu/ubermenu.php');
run_activate_plugin('contact-form-7/wp-contact-form-7.php');

