<?php

namespace JBCrea\Settings\ACF;

use JBCrea\GKSite;
use Timber\Timber;

class TechnicalOptions {
	function __construct() {
		add_action('acf/init', array($this, 'register_options'));

		add_action('acf/input/admin_head', array($this, 'timber_options_metabox'), 20);
	}

	function register_options() {

		if (function_exists('acf_add_local_field_group')):

			// Look into views/blocks
			$dir = get_template_directory() . "/blocks/";
			$blocks = array_diff(scandir($dir), array('..', '.'));

			$choicesBlocks = array();
			foreach ($blocks as $block) {
				$choicesBlocks[$block] = $block;
			}

			// Technical Options Page
			/////////////////////////////
			acf_add_local_field_group(array(
				'key' => 'gk_tech_options',
				'title' => __('Options techniques', 'gosselink'),
				'fields' => array(

					// Maps Options Panel
					////////////////////////
					array(
						'key' => 'gk_tech_options_maps_panel',
						'label' => __('Cartes', 'gosselink'),
						'name' => '',
						'type' => 'tab',
					),
					array(
						'key' => 'gk_tech_options_maps_key',
						'label' => __('Google API Key', 'gosselink'),
						'name' => 'maps_google_api_key',
						'type' => 'text',
						'required' => 0,
						'instructions' => __('Requis pour les champs Maps ACF', 'gosselink'),
					),
					array(
						'key' => 'gk_tech_options_maps_provider',
						'label' => __('Map Provider', 'gosselink'),
						'name' => 'maps_provider',
						'type' => 'radio',
						'required' => 1,
						'choices' => array(
							'openstreetmap' => 'OpenStreetMap',
							'google' => 'Google Maps',
						),
						'allow_null' => 1,
						'other_choice' => 0,
						'save_other_choice' => 0,
						'default_value' => 'openstreetmap',
						'layout' => 'horizontal',
						'return_format' => 'value',
					),
					array(
						'key' => 'gk_tech_options_maps_pin',
						'label' => __('Pin personnalisé', 'gosselink'),
						'name' => 'maps_pin',
						'type' => 'image',
						'instructions' => __('Fournir une image Retina. L\'ancre doit se situer en bas et au milieu de l\'image', 'gosselink'),
						'return_format' => 'array',
						'preview_size' => 'thumbnail',
						'library' => 'all',
						'mime_types' => 'png,jpg',
					),
					array(
						'key' => 'gk_tech_options_maps_snazzy',
						'label' => __('Code Snazzy Maps', 'gosselink'),
						'name' => 'maps_snazzy',
						'type' => 'textarea',
						'conditional_logic' => array(
							array(
								array(
									'field' => 'maps_provider',
									'operator' => '==',
									'value' => 'google',
								),
							),
						),
					),

					// Forms Options Panel
					////////////////////////
					array(
						'key' => 'gk_tech_options_forms_panel',
						'label' => __('Formulaires', 'gosselink'),
						'name' => '',
						'type' => 'tab',
					),
					array(
						'key' => 'gk_tech_options_contact_form',
						'label' => __('Formulaire de contact', 'gosselink'),
						'name' => 'contact_form',
						'type' => 'text',
						'required' => 0,
					),

					// Footer & Analytics Options Panel
					////////////////////////
					array(
						'key' => 'gk_tech_options_analytics_panel',
						'label' => __('Footer & Analytics', 'gosselink'),
						'name' => '',
						'type' => 'tab',
					),
					// Footer menu
					array(
						'key' => 'gk_tech_options_footer_menu_enabled',
						'label' => __('Footer menu', 'gosselink'),
						'name' => 'footer_menu_enabled',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),
					// Cookies Banner
					array(
						'key' => 'gk_tech_options_cookie_banner_enabled',
						'label' => __('Bannière cookies', 'gosselink'),
						'name' => 'cookies_banner_enabled',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),
					// Cookies banner background color
					array(
						'key' => 'gk_tech_options_cookie_banner_bg',
						'label' => __('Couleur de fond', 'gosselink'),
						'instructions' => __('Couleur de fond de la bannière (la couleur du texte s\'adapte automatiquement)', 'gosselink'),
						'name' => 'cookies_banner_bgcolor',
						'type' => 'color_picker',
						'conditional_logic' => array(
							array(
								array(
									'field' => 'gk_tech_options_cookie_banner_enabled',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'default_value' => '#11a09a',
					),
					// Cookies banner button color
					array(
						'key' => 'gk_tech_options_cookie_button_color',
						'label' => __('Couleur du bouton', 'gosselink'),
						'instructions' => __('Couleur de fond du bouton Accepter (la couleur du texte s\'adapte automatiquement)', 'gosselink'),
						'name' => 'cookies_banner_button_color',
						'type' => 'color_picker',
						'conditional_logic' => array(
							array(
								array(
									'field' => 'gk_tech_options_cookie_banner_enabled',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'default_value' => '#FFFFFF',
					),
					// Footer JS
					array(
						'key' => 'gk_tech_options_footer_js',
						'label' => __('Javascript du footer', 'gosselink'),
						'name' => 'footer_js',
						'type' => 'textarea',
						'required' => 0,
					),
					// Google Tag Manager
					array(
						'key' => 'gk_tech_options_gtm_enabled',
						'label' => __('Google Tag Manager', 'gosselink'),
						'name' => 'gtm_enabled',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),
					array(
						'key' => 'gk_tech_options_gtm_id',
						'label' => __('Code GTM', 'gosselink'),
						'name' => 'gtm_id',
						'type' => 'text',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'gk_tech_options_gtm_enabled',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
					),
					// Google Analytics
					array(
						'key' => 'gk_tech_options_ga_enabled',
						'label' => __('Google Analytics', 'gosselink'),
						'name' => 'ga_enabled',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),
					array(
						'key' => 'gk_tech_options_ga_id',
						'label' => __('Code UA', 'gosselink'),
						'name' => 'ga_id',
						'type' => 'text',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'gk_tech_options_ga_enabled',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
					),
					array(
						'key' => 'gk_tech_options_ga_domain',
						'label' => __('Domaine des cookies GA', 'gosselink'),
						'name' => 'ga_domain',
						'type' => 'text',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'gk_tech_options_ga_enabled',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
					),

					// Various Options Panel
					////////////////////////
					array(
						'key' => 'gk_tech_options_various_panel',
						'label' => __('Options diverses', 'gosselink'),
						'name' => '',
						'type' => 'tab',
					),
					// Favicon
					array(
						'key' => 'gk_tech_options_favicon',
						'label' => __('Favicon', 'gosselink'),
						'name' => 'favicon',
						'type' => 'image',
						'instructions' => __('Format carré, 512x512px recommandé', 'gosselink'),
						'return_format' => 'array',
						'preview_size' => 'thumbnail',
						'library' => 'all',
						'mime_types' => 'png,jpg',
					),

					// Disable comments
					array(
						'key' => 'gk_tech_options_disable_comments',
						'label' => __('Commentaires désactivés', 'gosselink'),
						'name' => 'disable_comments',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),
					// Site Map
					array(
						'key' => 'gk_tech_options_sitemap_enabled',
						'label' => __('Plan du site', 'gosselink'),
						'instructions' => __('Ajoute un menu dédié au plan du site. La page associée reste à créer (un template dédié est disponible).', 'gosselink'),
						'name' => 'sitemap_enabled',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),
					// Smooth Scroll
					array(
						'key' => 'gk_tech_options_smooth_scroll_enabled',
						'label' => __('Smooth scroll', 'gosselink'),
						'name' => 'smooth_scroll_enabled',
						'type' => 'true_false',
						'default_value' => 1,
						'ui' => 1,
					),
					// Scroll Top
					array(
						'key' => 'gk_tech_options_scroll_top_enabled',
						'label' => __('Scroll top', 'gosselink'),
						'name' => 'scroll_top_enabled',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'gk_tech_options_smooth_scroll_enabled',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
					),
					// Blocks Gutenberg
					/////////////////
					array(
						'key' => 'gk_tech_options_blocks_panel',
						'label' => __('Blocs Gutenberg', 'gosselink'),
						'name' => '',
						'type' => 'tab',
						'parent' => 'gk_tech_options',
					),
					// Blocks to show
					array(
						'key' => 'gk_tech_options_show_blocks',
						'label' => 'Blocs à afficher',
						'name' => 'show_blocks',
						'type' => 'checkbox',
						'required' => 0,
						'choices' => $choicesBlocks,
						'allow_custom' => 0,
						'default_value' => $choicesBlocks,
						'layout' => 'vertical',
						'toggle' => 0,
						'return_format' => 'value',
						'save_custom' => 0,
					),
					// Colors used in flexible content
					array(
						'key' => 'gk_tech_options_flexible_colors',
						'label' => __('Couleurs utilisés pour les blocs', 'gosselink'),
						'name' => 'flexible_colors',
						'type' => 'repeater',
						'default_value' => 1,
						'ui' => 1,
						'sub_fields' => array(
							array(
								'key' => 'gk_tech_options_flexible_colors_id',
								'label' => __('Classe', 'gosselink'),
								'name' => 'flexible_color_class',
								'type' => 'text',
								'instructions' => '',
								'required' => 1,
							),
							array(
								'key' => 'gk_tech_options_flexible_colors_name',
								'label' => __('Nom', 'gosselink'),
								'name' => 'flexible_color_name',
								'type' => 'text',
								'instructions' => '',
								'required' => 1,
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'gk-technical-options',
						),
					),
				),
			));

			if (GKSite::ONE_PAGE_ENABLED) {

				// One Page Panel
				/////////////////
				acf_add_local_field(array(
					'key' => 'gk_tech_options_one_page_panel',
					'label' => __('Options One Page', 'gosselink'),
					'name' => '',
					'type' => 'tab',
					'parent' => 'gk_tech_options',
				));
				// One Page Check
				acf_add_local_field(array(
					'key' => 'gk_tech_options_is_one_page',
					'label' => __('One page', 'gosselink'),
					'name' => 'is_one_page',
					'type' => 'true_false',
					'default_value' => 0,
					'ui' => 1,
					'parent' => 'gk_tech_options',
				));
				// One Page Instructions
				acf_add_local_field(array(
					'key' => 'gk_tech_options_one_page_instructions',
					'type' => 'message',
					'default_value' => 0,
					'ui' => 1,
					'message' => __('Sélectionner les pages qui constitueront les sections de votre page d\'accueil', 'gosselink') . "\n" .
						__('Pour ouvrir une page en popup, ajoutez la classe "open-popup" à votre lien, puis ajouter l\'attribut "data-post-id" correspondant à l\'ID de votre page (automatique pour les liens du menu et du footer)', 'gosselink')
				,
					'new_lines' => 'wpautop',
					'esc_html' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'gk_tech_options_is_one_page',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'parent' => 'gk_tech_options',
				));
				// One Page Sections (Repeater)
				acf_add_local_field(array(
					'key' => 'gk_tech_options_one_page_sections',
					'label' => __('Liste des sections', 'gosselink'),
					'name' => 'one_page_sections',
					'type' => 'repeater',
					'conditional_logic' => array(
						array(
							array(
								'field' => 'gk_tech_options_is_one_page',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'parent' => 'gk_tech_options',
				));
				// One page repeater's fields
				acf_add_local_field(array(
					'key' => 'gk_tech_options_one_page_section_page',
					'label' => __('Page', 'gosselink'),
					'name' => 'one_page_section_page',
					'type' => 'post_object',
					'required' => 1,
					'post_type' => array(
						0 => 'page',
					),
					'taxonomy' => array(),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'object',
					'ui' => 1,
					'parent' => 'gk_tech_options_one_page_sections',
				));
				acf_add_local_field(array(
					'key' => 'gk_tech_options_one_page_section_id',
					'label' => __('ID', 'gosselink'),
					'name' => 'one_page_section_id',
					'type' => 'text',
					'required' => 1,
					'parent' => 'gk_tech_options_one_page_sections',
				));
				acf_add_local_field(array(
					'key' => 'gk_tech_options_one_page_section_class',
					'label' => __('Classes CSS', 'gosselink'),
					'name' => 'one_page_section_class',
					'type' => 'text',
					'instructions' => __('En complément du slug de la page', 'gosselink'),
					'parent' => 'gk_tech_options_one_page_sections',
				));
				acf_add_local_field(array(
					'key' => 'gk_tech_options_one_page_redirect',
					'label' => __('Redirection de toutes les pages vers la home', 'gosselink'),
					'instructions' => __('Si cette option n\'est pas activée, penser à désactiver l\'indexation des pages indésirables avec Yoast.', 'gosselink'),
					'name' => 'one_page_redirect',
					'type' => 'true_false',
					'default_value' => 0,
					'ui' => 1,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'gk_tech_options_is_one_page',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'parent' => 'gk_tech_options',
				));
			}

		endif;
	}

	/**
	 * Get colors from technical options
	 */
	public static function get_theme_colors() {

		$colors = array();

		if (function_exists('get_field')) {

			// Site options don't have to be translated, we're getting them for the default language.
			add_filter('acf/settings/current_language', '__return_false');

			$i = 0;
			while (get_field('flexible_colors_' . $i . '_flexible_color_class', 'options')) {
				$colors[get_field('flexible_colors_' . $i . '_flexible_color_class', 'options')] = get_field('flexible_colors_' . $i . '_flexible_color_name', 'options');
				$i++;
			}

			remove_filter('acf/settings/current_language', '__return_false');
		}

		if (sizeof($colors) == 0) {
		    return false;
        }

		return $colors;
	}

	/**
	 * Display an extra meta box for special timber actions (like delete image cache, etc.)
	 */
	function timber_options_metabox() {

		$screen = get_current_screen();
		if ($screen->id !== 'options-du-site_page_gk-technical-options')
			return;

		add_meta_box(
			'custom-timber-actions-acf',
			__('Timber', 'gosselink'),
			array($this, 'timber_options_content'),
			'acf_options_page',
			'side',
			'high'
		);
	}

	/**
	 * Output the HTML for the call-to-action metabox.
	 */
	function timber_options_content() {
		?>
        <div id="timber-actions">
            <div class="acf-label">
                <label><?php _e('Effacer le cache', 'gosselink'); ?></label>
                <p class="description"><?php _e('Efface les images générées et le cache des templates', 'gosselink'); ?></p>
            </div>

            <div id="timber-action">
                <span class="spinner"></span>
                <input type="button" value="<?php _e('Effacer', 'gosselink'); ?>"
                       class="button button-primary button-large" id="timber_delete_cache" name="delete_cache">
            </div>

        </div>
		<?php
	}

}
