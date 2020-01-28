<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

use Gosselink\Entity\GKPage;
use Gosselink\Entity\GKOnePage;

$templates = array( 'page.twig' );

if ( is_front_page() ) {

	array_unshift( $templates, 'home.twig' );

	// WPML : language specific homepage if needed
	if ( shortcode_exists('wpml_language_switcher') ) {
		$current_language = apply_filters('wpml_current_language', NULL);
		$default_language = apply_filters( 'wpml_default_language', NULL);

		if ($current_language !== $default_language){
			array_unshift($templates, 'home-'.$current_language.'.twig'); /* Just add a home-en.twig template (or not) */
		}
	}

}elseif( is_home() ){

	array_unshift( $templates, 'blog.twig' );

}

if(function_exists('get_field') && get_field('is_one_page', 'option')){

	$page = new GKOnePage($templates);

}else{

	$page = new GKPage($templates);

	/** EXAMPLE FOR ADDING STUFF TO PAGE CONTEXT
	 *
	 *  $page->addToContext('posts', new \Timber\PostQuery());
	 *
	 */

}

$page->render();