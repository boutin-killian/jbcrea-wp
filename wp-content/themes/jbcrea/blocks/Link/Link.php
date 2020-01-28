<?php

namespace JBCrea\Blocks\Link;

use JBCrea\Entity\GKBlock;
use JBCrea\Settings\ACF\TechnicalOptions;

class Link
{

	/** @var GKBlock */
	private $block;

	/**
	 * Link constructor.
	 */
	public function __construct($block)
	{
		$this->block = $block;

		$this->addACFFields();
	}


	/**
	 * Deal with ACF fields for this block
	 */
	function addACFFields()
	{
		acf_add_local_field_group(array(
			'key' => 'gk_flexi_link',
			'name' => 'link_block',
			'label' => __('Bloc lien', 'gosselink'),
			'display' => 'block',
			'fields' => array(
				array(
					'key' => 'field_5bf2c9faa4545',
					'label' => __('Titre du bloc "Liens"', 'gosselink'),
					'name' => 'block_links_title',
					'type' => 'text',
					'instructions' => '',
				),
				array(
					'key' => 'field_5bf2ca1ca4546',
					'label' => __('Description du bloc "Liens"', 'gosselink'),
					'name' => 'description_links_block',
					'type' => 'wysiwyg',
					'instructions' => '',
					'tabs' => 'all',
					'toolbar' => 'full',
				),
				array(
					'key' => 'field_6f5d64hj2fds',
					'label' => __('Ajouter une image', 'gosselink'),
					'name' => 'wish',
					'type' => 'true_false',
					'instructions' => '',
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'default_value' => 0,
					'ui' => 1,
				),
				array(
					'key' => 'field_655dz5e4645s',
					'label' => __('Position de l\'image', 'gosselink'),
					'name' => 'order',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_6f5d64hj2fds',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						1 => __('Droite', 'gosselink'),
						2 => __('Gauche', 'gosselink'),
					),
					'default_value' => array(
						0 => 1,
					),
				),
				array(
					'key' => 'field_95fdg4945sfe',
					'label' => __('Image', 'gosselink'),
					'name' => 'image',
					'type' => 'image',
					'instructions' => __('Dimensions préconisées : 720 × 640', 'gosselink'),
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_6f5d64hj2fds',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'max_size' => '0.6',
				),
				array(
					'key' => 'field_6a58546dsf56',
					'label' => 'Format de l\'image',
					'name' => 'img_format',
					'type' => 'true_false',
					'instructions' => 'Choisissez le rendu de votre image',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_6f5d64hj2fds',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => 'Pleine',
					'ui_off_text' => 'Contrainte',
				),
				TechnicalOptions::get_theme_colors() ? array(
					'key' => 'field_6b5eae656de',
					'label' => __('Couleur de la section', 'gosselink'),
					'name' => 'color',
					'type' => 'select',
					'choices' => TechnicalOptions::get_theme_colors(),
					'return_format' => 'value',
				) : NULL,
				array(
					'key' => 'field_5891b48c70da9',
					'label' => __('Insérer un lien dans votre page', 'gosselink'),
					'name' => 'link',
					'type' => 'repeater',
					'instructions' => __('Mettez à la disposition des internautes vos documents (format PDF) en les 
                    téléchargeant ci-dessus. Vous pouvez également insérer une brève description (facultatif).', 'gosselink'),
					'collapsed' => '',
					'min' => 1,
					'max' => 4,
					'layout' => 'block',
					'button_label' => __('Ajouter un nouveau lien', 'gosselink'),
					'sub_fields' => array(
						array(
							'key' => 'field_5891b547731ac',
							'label' => __('Intitulé du lien', 'gosselink'),
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
						),
						array(
							'key' => 'field_5891b4af70daa',
							'label' => __('Intitulé du lien', 'gosselink'),
							'name' => 'link_title',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
							'default_value' => __('Voir le lien', 'gosselink'),
						),
						array(
							'key' => 'field_5891b564731ad',
							'label' => __('Description du lien', 'gosselink'),
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
						),
						array(
							'key' => 'field_5891b4ce70dab',
							'label' => __('Description du lien', 'gosselink'),
							'name' => 'link_description',
							'type' => 'textarea',
							'instructions' => __('Détaillez brièvement le lien qui sera inséré sur la page.', 'gosselink'),
							'new_lines' => 'wpautop',
						),
						array(
							'key' => 'field_5891b57c731ae',
							'label' => __('Adresse', 'gosselink'),
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
						),
						array(
							'key' => 'field_5891b50070dac',
							'label' => __('Adresse du lien', 'gosselink'),
							'name' => 'url_link',
							'type' => 'url',
							'instructions' => '',
							'required' => 1,
						),
						array(
							'key' => 'field_58a172f7a0771',
							'label' => __('Ouvrir le lien dans un nouvel onglet', 'gosselink'),
							'name' => 'target',
							'type' => 'true_false',
							'ui' => 1,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
					),
				),
			),
			'min' => '',
			'max' => '',
			'location' => array(
				array(
					array(
						'param' => 'block',
						'operator' => '==',
						'value' => 'acf/' . $this->block->slug,
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		));
	}
}
