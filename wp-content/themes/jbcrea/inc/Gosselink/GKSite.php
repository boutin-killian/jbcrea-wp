<?php

namespace Gosselink;
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 09/08/2018
 * Time: 15:22
 *
 * The main Theme Class
 *
 */

namespace Gosselink;

use Gosselink\Service\AdminService;
use Gosselink\Service\AjaxService;
use Gosselink\Service\CommentsService;
use Gosselink\Service\BlocksService;
use Gosselink\Service\MaintenanceService;
use Gosselink\Service\OnePageService;
use Gosselink\Service\SecurityService;
use Gosselink\Service\TwigService;
use Gosselink\Settings\CustomPostTypes;
use Gosselink\Settings\ACF\OptionsPages;
use Gosselink\Settings\ACF\BlogOptions;
use Timber\Site;
use Timber\Timber;

class GKSite extends Site {

	// GLOBAL OPTIONS
	const ONE_PAGE_ENABLED = true; // One page features can be totally disabled here
	const TOP_ANCHOR       = "top"; // Anchor for the first section when one page is enabled

	// SECURITY OPTIONS
	const AUTHOR_ARCHIVE_ENABLED = false;
	const SECURITY_KEY           = 'GOSSELINKRULESYOUDONT'; // Change it for every project !

	// Site services
	private $maintenance;

	function __construct() {
		parent::__construct();

		$this->initTheme();
	}

	private function initTheme() {

		// Gosselink Stuff
		new AdminService();
		new CustomPostTypes();
		new TwigService($this);
		new OptionsPages();
		new BlogOptions();
		new SecurityService();
		new AjaxService();

		$allowed_blocks = array();
		if (function_exists('get_field')) {
			$blocks_in_options = get_field('show_blocks', 'option');
			if ($blocks_in_options) {
				$allowed_blocks = $blocks_in_options;
			}
		}
		new BlocksService($allowed_blocks);

		if (function_exists('get_field') && $this::ONE_PAGE_ENABLED && get_field('is_one_page', 'option')) {
			new OnePageService($this);
		}

		if (function_exists('get_field') && get_field('disable_comments', 'option')) {
			$commentsService = new CommentsService();
			$commentsService->disable_comments();
		}

		// Theme support
		add_theme_support('post-formats', array(
			'audio',
			'video',
			'gallery',
		));
		add_theme_support('post-thumbnails');
		add_theme_support('menus');
		add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

		add_action('wp_enqueue_scripts', array($this, 'load_scripts'));
		add_action('init', array($this, 'register_menus'));
		add_action('widgets_init', array($this, 'register_sidebars'));

		// Once everything is loaded, check for maintenance mode
		MaintenanceService::check_for_maintenance();

		// Now we can make exceptions when in maintenance mode
		// if (!MaintenanceService::is_in_maintenance()){ // do some stuff }}
	}

	// Theme Scripts and Stylesheets
	function load_scripts() {
		$theme = wp_get_theme();

		wp_enqueue_style('site-styles', get_template_directory_uri() . '/dist/app.min.css', array(), $theme->Version, 'all');

		wp_register_script('site-scripts', get_template_directory_uri() . '/dist/app.min.js', array('jquery'), $theme->Version, true);

		// Inject PHP Variables into Javascript
		$data_array = array(
			'assets_path' => get_stylesheet_directory_uri() . '/static/',
			'images_path' => get_stylesheet_directory_uri() . '/static/images/',
			'ajax_url' => admin_url('admin-ajax.php'),
			'security' => wp_create_nonce('gk-nonce'),
		);

		$options = array();
		$options_keys = array(
			'is_one_page',
			'scroll_top_enabled',
			'smooth_scroll_enabled',
			'maps_google_api_key',
			'maps_snazzy',
			'maps_provider',
			'cookies_banner_enabled',
			'cookies_banner_bgcolor',
			'cookies_banner_button_color',
			'gtm_enabled',
			'gtm_id',
			'ga_enabled',
			'ga_id',
			'ga_domain',
		);
		if (function_exists('get_field')) {

			foreach ($options_keys as $key) {
				$options[$key] = get_field($key, 'options');
			}

			$maps_pin = get_field('maps_pin', 'options');
			if ($maps_pin) {
				$options['maps_pin'] = $maps_pin['url'];
				$options['maps_pin_width'] = round($maps_pin['width'] / 2);
				$options['maps_pin_height'] = round($maps_pin['height'] / 2);
			} else {
				$options['maps_pin'] = false;
			}
		}

		// Privacy Policy (WP 4.9.6+ only)
		$options['privacy_policy_url'] = '#';
		if (function_exists('get_privacy_policy_url')) {
			$options['privacy_policy_url'] = get_privacy_policy_url();
			$options['privacy_policy_id'] = get_option('wp_page_for_privacy_policy');
		}

		$data_array['options'] = $options;

		wp_localize_script('site-scripts', 'wp_data', $data_array);
		wp_enqueue_script('site-scripts');
	}

	// Declare Menus
	function register_menus() {
		register_nav_menu('main-menu', __('Menu principal', 'gosselink'));

		if (!function_exists('get_field'))
			return;

		if (get_field('footer_menu_enabled', 'options')) {
			register_nav_menu('footer-menu', __('Menu Footer', 'gosselink'));
		}

		if (get_field('sitemap_enabled', 'options')) {
			register_nav_menu('sitemap-menu', __('Menu Plan du site', 'gosselink'));
		}
	}

	// Declare Sidebars
	function register_sidebars() {
		register_sidebar(array(
			'name' => __('Sidebar', 'gosselink'),
			'id' => 'sidebar',
		));
	}

}
