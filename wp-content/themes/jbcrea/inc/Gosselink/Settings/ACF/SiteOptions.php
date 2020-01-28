<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 23/11/2018
 * Time: 17:31
 */

namespace Gosselink\Settings\ACF;


class SiteOptions
{
	function __construct()
	{
		add_action('acf/init', array($this, 'register_options'));
	}

	function register_options()
	{

		if (function_exists('acf_add_local_field_group')):

			acf_add_local_field_group(array(
				'key' => 'general_site_options',
				'title' => __('Options du site', 'gosselink'),
				'fields' => array(

					// IDENTITY
					array(
						'key' => 'gk_site_coords',
						'label' => __('Coordonnées', 'gosselink'),
						'type' => 'tab',
					),
					array(
						'key' => 'gk_site_location',
						'label' => __('Adresse de l\'établissement', 'gosselink'),
						'name' => 'googlemap_location',
						'type' => 'google_map',
						'instructions' => __('Positionnez votre établissement.', 'gosselink')
					),
					array(
						'key' => 'gk_site_map_link',
						'label' => __('Lien vers la carte', 'gosselink'),
						'name' => 'link_map',
						'type' => 'url',
					),
					array(
						'key' => 'gk_site_image',
						'label' => __('Photo de la société', 'gosselink'),
						'name' => 'agency_photo',
						'type' => 'image',
						'return_format' => 'url',
					),
					array(
						'key' => 'gk_site_address',
						'label' => __('Adresse du client', 'gosselink'),
						'name' => 'client_address',
						'type' => 'textarea',
						'instructions' => __('Saisissez l\'adresse telle que présente dans le pied de page(les retour chariot seront conservés tels quels).', 'gosselink'),

					),
					array(
						'key' => 'gk_site_telephone',
						'label' => __('Téléphone', 'gosselink'),
						'name' => 'phone',
						'type' => 'text',
						'instructions' => __('16 caractères maximum (exemple : 02 99 23 33 33).', 'gosselink'),
						'maxlength' => 20,
					),
					array(
						'key' => 'gk_site_fax',
						'label' => __('Fax', 'gosselink'),
						'name' => 'fax',
						'type' => 'text',
						'instructions' => __('16 caractères maximum (exemple : 02 99 23 33 33).', 'gosselink'),
						'maxlength' => 20,
					),
					array(
						'key' => 'gk_site_mail',
						'label' => __('Mail de contact principal', 'gosselink'),
						'name' => 'mail',
						'type' => 'email',
					),
					array(
						'key' => 'gk_site_infos_supp',
						'label' => __('Infos complémentaires', 'gosselink'),
						'name' => 'complementary_info',
						'type' => 'repeater',
						'layout' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'gk_site_infos_supp_title',
								'label' => __('Titre', 'gosselink'),
								'name' => 'title',
								'type' => 'text',
							),
							array(
								'key' => 'gk_site_infos_supp_text',
								'label' => __('Complément d\'informations', 'gosselink'),
								'name' => 'detail_info',
								'type' => 'wysiwyg',
							),
						),
					),

					// SOCIAL NETWORKS
					array(
						'key' => 'gk_site_networks',
						'label' => __('Réseaux sociaux', 'gosselink'),
						'type' => 'tab',
					),
					array(
						'key' => 'gk_site_networks_youtube',
						'label' => __('Youtube', 'gosselink'),
						'name' => 'youtube',
						'type' => 'url',
					),
					array(
						'key' => 'gk_site_networks_twitter',
						'label' => __('Twitter', 'gosselink'),
						'name' => 'twitter',
						'type' => 'url',
					),
					array(
						'key' => 'gk_site_networks_facebook',
						'label' => __('Facebook', 'gosselink'),
						'name' => 'facebook',
						'type' => 'url',
					),
					array(
						'key' => 'gk_site_networks_instagram',
						'label' => __('Instagram', 'gosselink'),
						'name' => 'instagram',
						'type' => 'url',
					),
					array(
						'key' => 'gk_site_networks_linkedin',
						'label' => __('Linkedin', 'gosselink'),
						'name' => 'linkedin',
						'type' => 'url',
					),
					array(
						'key' => 'gk_site_networks_tripadvisor',
						'label' => __('Tripadvisor', 'gosselink'),
						'name' => 'tripadvisor',
						'type' => 'url',
					),

                    // MAINTENANCE MODE
                    array(
                        'key' => 'gk_site_maintenance_mode',
                        'label' => __('Mode maintenance', 'gosselink'),
                        'type' => 'tab',
                    ),
                    array(
                        'key' => 'gk_site_maintenance_mode_button',
                        'label' => __('Mode maintenance', 'gosselink'),
                        'name' => 'maintenance_mode',
                        'type' => 'true_false',
                        'ui' => 1,
                        'ui_on_text' => 'Activé',
                        'ui_off_text' => 'Désactivé',
                    ),
                    array(
                        'key' => 'gk_site_maintenance_end',
                        'label' => 'Jusqu\'au',
                        'name' => 'maintenance_end',
                        'type' => 'date_time_picker',
                        'instructions' => 'Date jusqu\'à laquelle le mode maintenance sera actif. Laissez blanc pour une durée indeterminée.',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'gk_site_maintenance_mode_button',
                                    'operator' => '==',
                                    'value' => '1',
                                ),
                            ),
                        ),
                        'display_format' => 'd/m/Y H:i:s',
                        'return_format' => 'd/m/Y H:i:s',
                        'first_day' => 1,
                    ),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'gk-options-site',
						),
					),
				)
			));

		endif;
	}

}
