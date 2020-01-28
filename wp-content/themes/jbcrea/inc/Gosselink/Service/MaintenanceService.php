<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 22/08/2019
 * Time: 10:49
 */

namespace Gosselink\Service;

use Gosselink\Entity\GKPage;
use Timber\Timber;

class MaintenanceService
{

	/**
	 * Tells if the site should be in maintenance mode when enabled
	 * @return bool
	 */
	public static function is_in_maintenance(){

		// Check du mode maintenance
		if (function_exists('get_field') && get_field('maintenance_mode', 'option')){

			// Check sur le user
			if( !is_user_logged_in() || !current_user_can( 'edit_pages' ) ) {

				// Check sur la page
				if( !is_admin() && !self::is_valid_page()){
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Show the maintenance page if necessary
	 */
	public static function check_for_maintenance(){

		if (!self::is_in_maintenance())
			return;

		self::render_maintenance();

		// Check if end date of maintenance mode is future
		$end = get_field('maintenance_end', 'option');
		$date_end = new \DateTime($end);
		$now = new \DateTime();

		if ($end !== ''){

			// There's a date set
			if ( $date_end < $now ) {

				// Update ACF field to disable maintenance mode if end date is past
				update_field('maintenance_mode', '0', 'option');
				update_field('maintenance_end', '', 'option');
			}
		}
	}

	/**
	 * Check if the current page should be shown even in maintenance mode
	 * @return bool
	 */
	public static function is_valid_page() {
		return in_array($GLOBALS['pagenow'], array(
			'wp-login.php',
			'wp-register.php'
		));
	}

	/**
	 * Rendering the maintenance page
	 */
	private static function render_maintenance(){

		$page = new GKPage(array('maintenance.twig'));
		$page->render();
		die();

	}
}