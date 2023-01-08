<?php


/**
* Insert Headers and Footers Class
*/
class InsertHeadersAndFooters2 {
	/**
	* Constructor
	*/
	public function __construct() {
		$file_data = get_file_data( __FILE__, array( 'Version' => 'Version' ) );

		// Plugin Details
		$this->plugin                           = new stdClass;
		$this->plugin->name                     = 'ihafplugin'; // Plugin Folder
		$this->plugin->displayName              = 'Insert Headers and Footers'; // Plugin Name
		$this->plugin->version                  = $file_data['Version'];
		$this->plugin->folder                   = plugin_dir_path( __FILE__ );
		$this->plugin->url                      = plugin_dir_url( __FILE__ );
		$this->plugin->db_welcome_dismissed_key = $this->plugin->name . '_welcome_dismissed_key';
		$this->body_open_supported              = function_exists( 'wp_body_open' ) && version_compare( get_bloginfo( 'version' ), '5.2', '>=' );

		// Hooks
		add_action( 'admin_init', array( &$this, 'registerSettings2' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'initCodeMirror2' ) );
		add_action( 'admin_menu', array( &$this, 'adminPanelsAndMetaBoxes2' ) );
		add_action( 'admin_notices', array( &$this, 'dashboardNotices2' ) );
		add_action( 'wp_ajax_' . $this->plugin->name . '_dismiss_dashboard_notices', array( &$this, 'dismissDashboardNotices2' ) );

		// Frontend Hooks
		add_action( 'wp_head', array( &$this, 'frontendHeader2' ) );
		add_action( 'wp_footer', array( &$this, 'frontendFooter2' ) );
		if ( $this->body_open_supported ) {
			add_action( 'wp_body_open', array( &$this, 'frontendBody2' ), 1 );
		}
	}

	/**
	 * Show relevant notices for the plugin
	 */
	function dashboardNotices2() {
		global $pagenow;

		if (
			! get_option( $this->plugin->db_welcome_dismissed_key )
			&& current_user_can( 'manage_options' )
		) {
			if ( ! ( 'options-general.php' === $pagenow && isset( $_GET['page'] ) && 'ihafplugin' === $_GET['page'] ) ) {
				$setting_page = admin_url( 'options-general.php?page=' . $this->plugin->name );
				// load the notices view
				include_once( $this->plugin->folder . '/views/dashboard-notices.php' );
			}
		}
	}

	/**
	 * Dismiss the welcome notice for the plugin
	 */
	function dismissDashboardNotices2() {
		check_ajax_referer( $this->plugin->name . '-nonce', 'nonce' );
		// user has dismissed the welcome notice
		update_option( $this->plugin->db_welcome_dismissed_key, 1 );
		exit;
	}

	/**
	* Register Settings
	*/
	function registerSettings2() {
		register_setting( $this->plugin->name, 'ihaf_insert_header_plugin', 'trim' );
		register_setting( $this->plugin->name, 'ihaf_insert_footer_plugin', 'trim' );
		register_setting( $this->plugin->name, 'ihaf_insert_body_plugin', 'trim' );
	}

	/**
	* Register the plugin settings panel
	*/
	function adminPanelsAndMetaBoxes2() {
		add_submenu_page( 'options-general.php', $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, array( &$this, 'adminPanel2' ) );
	}

	/**
	* Output the Administration Panel
	* Save POSTed data from the Administration Panel into a WordPress option
	*/
	function adminPanel2() {
		/*
		 * Only users with manage_options can access this page.
		 *
		 * The capability included in add_settings_page() means WP should deal
		 * with this automatically but it never hurts to double check.
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'Sorry, you are not allowed to access this page.', 'ihafplugin' ) );
		}

		// only users with `unfiltered_html` can edit scripts.
		if ( ! current_user_can( 'unfiltered_html' ) ) {
			$this->errorMessage = '<p>' . __( 'Sorry, only have read-only access to this page. Ask your administrator for assistance editing.', 'ihafplugin' ) . '</p>';
		}

		// Save Settings
		if ( isset( $_REQUEST['submit'] ) ) {
			// Check permissions and nonce.
			if ( ! current_user_can( 'unfiltered_html' ) ) {
				// Can not edit scripts.
				wp_die( __( 'Sorry, you are not allowed to edit this page.', 'ihafplugin' ) );
			} elseif ( ! isset( $_REQUEST[ $this->plugin->name . '_nonce' ] ) ) {
				// Missing nonce
				$this->errorMessage = __( 'nonce field is missing. Settings NOT saved.', 'ihafplugin' );
			} elseif ( ! wp_verify_nonce( $_REQUEST[ $this->plugin->name . '_nonce' ], $this->plugin->name ) ) {
				// Invalid nonce
				$this->errorMessage = __( 'Invalid nonce specified. Settings NOT saved.', 'ihafplugin' );
			} else {
				// Save
				// $_REQUEST has already been slashed by wp_magic_quotes in wp-settings
				// so do nothing before saving
				update_option( 'ihaf_insert_header_plugin', $_REQUEST['ihaf_insert_header_plugin'] );
				update_option( 'ihaf_insert_footer_plugin', $_REQUEST['ihaf_insert_footer_plugin'] );
				update_option( 'ihaf_insert_body_plugin', isset( $_REQUEST['ihaf_insert_body_plugin'] ) ? $_REQUEST['ihaf_insert_body_plugin'] : '' );
				update_option( $this->plugin->db_welcome_dismissed_key, 1 );
				$this->message = __( 'Settings Saved.', 'ihafplugin' );
			}
		}

		// Get latest settings
		$this->settings = array(
			'ihaf_insert_header_plugin' => esc_html( wp_unslash( get_option( 'ihaf_insert_header_plugin' ) ) ),
			'ihaf_insert_footer_plugin' => esc_html( wp_unslash( get_option( 'ihaf_insert_footer_plugin' ) ) ),
			'ihaf_insert_body_plugin'   => esc_html( wp_unslash( get_option( 'ihaf_insert_body_plugin' ) ) ),
		);

		// Load Settings Form
		include_once( $this->plugin->folder . '/views/settings.php' );
	}

	/**
	 * Enqueue and initialize CodeMirror for the form fields.
	 */
	function initCodeMirror2() {
		// Make sure that we don't fatal error on WP versions before 4.9.
		if ( ! function_exists( 'wp_enqueue_code_editor' ) ) {
			return;
		}

		global $pagenow;

		if ( ! ( 'options-general.php' === $pagenow && isset( $_GET['page'] ) && 'ihafplugin' === $_GET['page'] ) ) {
			return;
		}

		$editor_args = array( 'type' => 'text/html' );

		if ( ! current_user_can( 'unfiltered_html' ) || ! current_user_can( 'manage_options' ) ) {
			$editor_args['codemirror']['readOnly'] = true;
		}

		// Enqueue code editor and settings for manipulating HTML.
		$settings = wp_enqueue_code_editor( $editor_args );

		// Bail if user disabled CodeMirror.
		if ( false === $settings ) {
			return;
		}

		// Custom styles for the form fields.
		$styles = '.CodeMirror{ border: 1px solid #ccd0d4; }';

		wp_add_inline_style( 'code-editor', $styles );

		wp_add_inline_script( 'code-editor', sprintf( 'jQuery( function() { wp.codeEditor.initialize( "ihaf_insert_header_plugin", %s ); } );', wp_json_encode( $settings ) ) );
		wp_add_inline_script( 'code-editor', sprintf( 'jQuery( function() { wp.codeEditor.initialize( "ihaf_insert_body_plugin", %s ); } );', wp_json_encode( $settings ) ) );
		wp_add_inline_script( 'code-editor', sprintf( 'jQuery( function() { wp.codeEditor.initialize( "ihaf_insert_footer_plugin", %s ); } );', wp_json_encode( $settings ) ) );
	}

	/**
	* Outputs script / CSS to the frontend header
	*/
	function frontendHeader2() {
		$this->output2( 'ihaf_insert_header_plugin' );
	}

	/**
	* Outputs script / CSS to the frontend footer
	*/
	function frontendFooter2() {
		$this->output2( 'ihaf_insert_footer_plugin' );
	}

	/**
	* Outputs script / CSS to the frontend below opening body
	*/
	function frontendBody2() {
		$this->output2( 'ihaf_insert_body_plugin' );
	}

	/**
	* Outputs the given setting, if conditions are met
	*
	* @param string $setting Setting Name
	* @return output
	*/
	function output2( $setting ) {
		// Ignore admin, feed, robots or trackbacks
		if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {
			return;
		}

		// provide the opportunity to Ignore ihaf - both headers and footers via filters
		if ( apply_filters( 'disable_ihaf', false ) ) {
			return;
		}

		// provide the opportunity to Ignore ihaf - footer only via filters
		if ( 'ihaf_insert_footer_plugin' === $setting && apply_filters( 'disable_ihaf_footer', false ) ) {
			return;
		}

		// provide the opportunity to Ignore ihaf - header only via filters
		if ( 'ihaf_insert_header_plugin' === $setting && apply_filters( 'disable_ihaf_header', false ) ) {
			return;
		}

		// provide the opportunity to Ignore ihaf - below opening body only via filters
		if ( 'ihaf_insert_body_plugin' === $setting && apply_filters( 'disable_ihaf_body', false ) ) {
			return;
		}

		// Get meta
		$meta = get_option( $setting );
		if ( empty( $meta ) ) {
			return;
		}
		if ( trim( $meta ) === '' ) {
			return;
		}

		// Output
		echo wp_unslash( $meta );
	}
}

$ihaf = new InsertHeadersAndFooters2();
