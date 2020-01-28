<?php

namespace JBCrea\Service;

use JBCrea\GKSite;

class AdminService
{
	function __construct() {

        add_action( 'login_enqueue_scripts', array( $this, 'load_login_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );
		add_action( 'admin_init', array( $this, 'load_admin_theme' ) );
		add_filter( 'get_user_option_admin_color', array( $this, 'set_default_admin_theme') );
		remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
		add_filter( 'login_headerurl', array($this, 'change_login_url') );
		add_filter('upload_mimes', array($this, 'manage_mime_types') );

		// Allow editor to edit Menus (= view Apparence menu, but hide some of its items)
		$role_object = get_role( 'editor' );
		$role_object->add_cap( 'edit_theme_options' );
		add_action('admin_head', array($this,'hide_menus'));

	}

	// Admin Scripts and Stylesheets
	function load_login_scripts() {
		$theme = wp_get_theme();
		wp_enqueue_style('admin-styles', get_template_directory_uri() . '/dist/admin.min.css', array(), $theme->Version, 'all');
	}

    function load_admin_scripts() {
        $theme = wp_get_theme();
        wp_register_script( 'admin-scripts', get_template_directory_uri() . '/dist/admin.min.js', array('jquery'), $theme->Version, true );

	    $data_array = array(
		    'security' => wp_create_nonce(GKSite::SECURITY_KEY),
	    );
        wp_localize_script( 'admin-scripts', 'admin_data', $data_array );
        wp_enqueue_script( 'admin-scripts' );
    }

	// Admin Theme
	function load_admin_theme() {
		wp_admin_css_color(
			'gosselink',
			'JBCrea',
			get_template_directory_uri() . '/dist/admin.min.css',
			array('#222', '#333', '#01a29a', '#38c1ba'),
			array()
		);
	}

	function set_default_admin_theme() {
		return 'gosselink';
	}

	function change_login_url($url) {
		return 'https://www.gosselink.fr';
	}


	/**
	 * Allow SVG and other mime types
	 * @param $mimes
	 * @return mixed
	 */
	function manage_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}


	/**
	 * Hide Menus for editor
	 */
	function hide_menus() {

		$subpath = site_url( '', 'relative');

		if (current_user_can('editor')) {
			remove_submenu_page( 'themes.php', 'themes.php' ); // hide the theme selection submenu
			remove_submenu_page( 'themes.php', 'widgets.php' ); // hide the widgets submenu
			remove_submenu_page( 'themes.php', 'customize.php?return='.urlencode($subpath).'%2Fwp-admin%2F' ); // hide the customizer submenu
			remove_submenu_page( 'themes.php', 'customize.php?return='.urlencode($subpath).'%2Fwp-admin%2Ftools.php' ); // hide the customizer submenu
			remove_submenu_page( 'themes.php', 'customize.php?return='.urlencode($subpath).'%2Fwp-admin%2Ftools.php&#038;autofocus%5Bcontrol%5D=background_image' ); // hide the background submenu
		}

	}
}