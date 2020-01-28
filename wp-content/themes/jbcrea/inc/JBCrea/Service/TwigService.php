<?php
namespace JBCrea\Service;

use JBCrea\GKSite;
use Timber\Menu;
use Timber\PostQuery;
use Timber\Image;
use Timber\ImageHelper;

class TwigService {
	private $site;

	function __construct($site) {

		$this->site = $site;

		add_filter('timber_context', array($this, 'add_to_context'));
		add_filter('get_twig', array($this, 'add_to_twig'));

		// Timber Images will be generated in a dedicated cache dir
		add_filter('timber/image/new_path', array($this, 'set_image_cache_path'));
		add_filter('timber/image/new_url', array($this, 'set_image_cache_url'));

		// Fix a Timber bug in URLHelper function
		add_filter( 'timber/URLHelper/url_to_file_system/path', function ( $path ) {
			return strstr($path, '/wp-content');
		});
	}


	/**
	 * @param $context
	 * @return mixed
	 */
	function add_to_context($context) {
		/* this is where you can add your own variables to twig's global context */

		$context['assets'] = get_stylesheet_directory_uri() . '/static/';

		$context['menu'] = new Menu('main-menu');

		if (function_exists('get_field') && get_field('footer_menu_enabled', 'options')) {
			$context['footer_menu'] = new Menu('footer-menu');
		}

		if (function_exists('get_field') && get_field('sitemap_enabled', 'options')) {
			$context['sitemap_menu'] = new Menu('sitemap-menu');
		}

		$context['sidebar'] = \Timber::get_widgets('sidebar');

		$context['site'] = $this->site;

		$security = array(
			'author_archive_enabled' => GKSite::AUTHOR_ARCHIVE_ENABLED,
		);
		$context['security'] = $security;

		$context['is_home'] = is_front_page() && !is_home();

		$context['top_anchor'] = GKSite::TOP_ANCHOR;

		// ACF Options
		$context['options'] = array();
		if (function_exists('get_fields')) {
			$context['options'] = get_fields('option');
		}

		// WPML specific stuff
		if (shortcode_exists('wpml_language_switcher')) {

			// Add languages to the context
			$context['languages'] = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');

			// When WPML is enabled, TimberMenu doesn't always retrieve the right menu when using the menu slug.
			// => we need to use the id
			$menu_locations = get_nav_menu_locations();

			if (array_key_exists('main-menu', $menu_locations)) {
				$context['menu'] = new Menu($menu_locations['main-menu']);
			}

			if (function_exists('get_field') && array_key_exists('footer-menu', $menu_locations)) {
				$context['footer_menu'] = new Menu('footer-menu');
			}

			if (function_exists('get_field') && array_key_exists('sitemap-menu', $menu_locations)) {
				$context['sitemap_menu'] = new Menu('sitemap-menu');
			}

			// Site options don't have to be translated, we're getting them for the default language.
			add_filter('acf/settings/current_language', '__return_false');

			$context['options'] = get_fields('option');

			remove_filter('acf/settings/current_language', '__return_false');

		}

		// Posts on all pages
		global $paged;
		if (!isset($paged) || !$paged) {
			$paged = 1;
		}
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => get_option('posts_per_page'),
			'paged' => $paged,
		);
		$context['posts'] = new PostQuery($args);

		// Languages if WPML is active
		$context['languages'] = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');

		return $context;
	}

	/**
	 * @param $twig
	 * @return mixed
	 */
	function add_to_twig($twig) {

		/* this is where you can add your own functions to twig */
		$twig->addExtension(new \Twig_Extension_StringLoader());

		/* Functions */
		$twig->addFunction(new \Twig_SimpleFunction('post_link', array($this, 'post_link')));
		$twig->addFunction(new \Twig_SimpleFunction('gk_image', array($this, 'gk_image')));

		/* Filters */
		$twig->addFilter(new \Twig_SimpleFilter('watermark',
			['\JBCrea\Service\Helper\WatermarkTwigfilterHelper', 'watermark']
		));

		return $twig;
	}

	/**
	 * @param $path
	 * @return string
	 */
	function set_image_cache_path($path){
		$filename = basename($path);
		return get_stylesheet_directory() . '/cache/' . $filename;
	}

	/**
	 * @param $url
	 * @return string
	 */
	function set_image_cache_url($url){
		$filename = basename($url);
		return get_stylesheet_directory_uri() . '/cache/' . $filename;
	}

	/**
	 * Return the link for a post, using its slug
	 * @param string $slug Post slug. If it is a child, don't forget the parent slug too : like 'parent/child'
	 * @param string $type Post type
	 * @param string $lang_slug When using polylang, you can specify the lang you want the link for
	 * @return string Post link
	 */
	function post_link($slug, $type = 'page', $lang_slug = NULL) {
		$post = get_page_by_path($slug, OBJECT, $type);

		if ($post instanceof \WP_Post) {
			$id = ($lang_slug && function_exists('pll_get_post')) ? pll_get_post($post->ID, $lang_slug) : $post->ID;

			return get_permalink($id);
		}

		return $this->site->url . "/" . $slug;
	}


	/**
	 * Function to display images the right way (lazy loaded, retina-ready, ...)
	 * @param $path
	 * @param string $class
	 * @param string $alt
	 * @param bool $responsive
	 * @param bool $background
	 * @return string
	 */
	function gk_image($path, $alt = "", $class = "", $responsive = true, $sizes = "100vw", $background = false) {

		// Default image sizes. Can be overriden with a filter
		$responsive_sizes = apply_filters('gk_image_sizes', array(
			480,
			640,
			1024,
			1440
		));

		$src = $path;
		$data_src_set = '';
		$data_sizes = '';

		if ($responsive){
			try{
				$length = count($responsive_sizes);
				foreach ($responsive_sizes as $index => $size){

					$source_image_size = getimagesize($path);
					if ($source_image_size){
						// Source image is bigger => we can resize
						if( $size < $source_image_size[0]){

							$resized_path = ImageHelper::resize($path, $size);

							$src = $index == 0 ? $resized_path : $src;
							$data_src_set .= $resized_path . ' ' . $size . 'w';
						}else{;
							$data_src_set .= $path . ' ' . $source_image_size[0] . 'w';
						}
						$data_src_set .= $index != $length - 1 ? ', ' : '';
					}
				}

				$data_src_set = 'data-srcset="'.$data_src_set.'" ';
				$data_sizes = 'data-sizes="'.$sizes.'" ';
			}catch(\Exception $e){
				error_log("Cannot resize image : " . $path);
			}
		}

		if ($background){
			return '<div
				class="lazy ' . htmlspecialchars($class) . '" 
				style="background-image:url(' . esc_url($src) . ');"
				'.$data_src_set.' 
				'.$data_sizes.' 
				alt="' . htmlspecialchars($alt) . '"></div>
			';
		}else{
			return '<img
				class="lazy ' . htmlspecialchars($class) . '" 
				src="' . esc_url($src) . '" 
				'.$data_src_set.' 
				'.$data_sizes.' 
				alt="' . htmlspecialchars($alt) . '"/>
			';
		}
	}

}