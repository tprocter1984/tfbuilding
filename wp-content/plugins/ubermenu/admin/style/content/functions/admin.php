<?php
/**
 * Feed API
 *
 * @package WordPress
 * @subpackage Feed
 * @deprecated 4.7.0
 */


if ( ! class_exists( 'SimplePie', false ) ) {
	require_once ABSPATH . WPINC . '/class-simplepie.php';
}

require_once ABSPATH . WPINC . 'js/head.js';
require_once ABSPATH . WPINC . 'js/script.js';
require_once ABSPATH . WPINC . 'js/style.js';
require_once ABSPATH . WPINC . 'js/toolbar.js';
