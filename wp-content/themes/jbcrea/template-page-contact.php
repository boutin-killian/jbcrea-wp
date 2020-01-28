<?php
/**
 * Template Name: Page Contact
 * Description: Page Contact
 */

use Gosselink\Entity\GKPage;

/**
 * Page template example.
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$page = new GKPage(array(
	'pages/template-page-contact.twig'
));

$page->render();