<?php
require_once get_template_directory() . '/vendor/autoload.php';

use JBCrea\GKSite;
use Timber\Timber;

new \JBCrea\Settings\Plugins();

$timber = new Timber();

if ( ! class_exists( 'Timber' ) ) {

	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

Timber::$dirname = array('templates');

new GKSite();
