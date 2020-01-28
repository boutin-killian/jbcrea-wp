<?php
namespace JBCrea\Service;

use JBCrea\Entity\GKPageSection;
use JBCrea\GKSite;
use Timber\Timber;

class AjaxService
{
	function __construct() {

		// Ajax to get a post content
		add_action( 'wp_ajax_post_content', array($this, 'get_post_content') );
		add_action( 'wp_ajax_nopriv_post_content', array($this, 'get_post_content') );


		// Delete Timber Cache
		add_action( 'wp_ajax_admin_delete_timber_cache', array($this, 'admin_delete_timber_cache') );
		add_action( 'wp_ajax_nopriv_admin_delete_timber_cache', array($this, 'admin_delete_timber_cache') );

	}

	function get_post_content(){

		$ID = $_POST['ID'];
		$nonce = $_POST['security'];

		if ($ID === null || !is_numeric($ID)){
			error_log("ID is invalid");
			die( 'Wrong request' );
		}

		if ( ! wp_verify_nonce( $nonce, 'gk-nonce' ) ){
			error_log("Nonce is invalid");
			die ( 'Busted!');
		}

		$page = new GKPageSection(get_post($ID), "", "");
		$page->setIsPopup(true);

		echo $page;

		die();
	}


	/**
	 * Admin Only : deletes timber image cache
	 */
	function admin_delete_timber_cache() {

		check_ajax_referer( GKSite::SECURITY_KEY, 'security' );

		$loader = new \TimberLoader();
		$loader->clear_cache_timber();
		$loader->clear_cache_twig();

		$files = glob(apply_filters('timber/image/new_path', '*'));
		foreach($files as $file){ // iterate files
			if(is_file($file))
				unlink($file); // delete file
		}

		echo 'DONE';

		wp_die(); // this is required to terminate immediately and return a proper response
	}
}


