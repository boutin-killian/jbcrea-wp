<?php

namespace JBCrea\Blocks\Download;

use JBCrea\Entity\GKBlock;
use JBCrea\Settings\ACF\TechnicalOptions;

class Download
{

	/** @var GKBlock */
	private $block;

	/**
	 * Download constructor.
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
			'key' => 'gk_flexi_download',
			'name' => 'download_block',
			'label' => __('Bloc de téléchargement', 'gosselink'),
			'display' => 'block',
			'fields' => array(
				array(
					'key' => 'field_5bf2cda28aa01',
					'label' => __('Titre du bloc "Téléchargements"', 'gosselink'),
					'name' => 'block_download_title',
					'type' => 'text',
					'instructions' => '',
				),
				array(
					'key' => 'field_5bf2cdf98aa02',
					'label' => __('Description du bloc "Téléchargements"', 'gosselink'),
					'name' => 'description_download_block',
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
					'key' => 'field_8z9g3d255hj6',
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
					'key' => 'field_6451xsf53q94f',
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
					'key' => 'field_5q9ds4f225d',
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
					'key' => 'field_5b8e656c6d674',
					'label' => __('Couleur de la section', 'gosselink'),
					'name' => 'color',
					'type' => 'select',
					'choices' => TechnicalOptions::get_theme_colors(),
					'return_format' => 'value',
				) : NULL,
				array(
					'key' => 'field_5891b63b48682',
					'label' => __('Le document à télécharger', 'gosselink'),
					'name' => 'download',
					'type' => 'repeater',
					'instructions' => __('Mettez à la disposition des internautes vos documents (format PDF) en les 
                    téléchargeant ci-dessus. Vous pouvez également insérer une brève description (facultatif).', 'gosselink'),
					'collapsed' => '',
					'min' => 1,
					'max' => 4,
					'layout' => 'block',
					'button_label' => __('Ajouter un téléchargement', 'gosselink'),
					'sub_fields' => array(
						array(
							'key' => 'field_5891b67348683',
							'label' => __('Le titre du document', 'gosselink'),
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
						),
						array(
							'key' => 'field_5891b69448684',
							'label' => __('Titre du document à télécharger', 'gosselink'),
							'name' => 'doc_title',
							'type' => 'text',
							'instructions' => __('Indiquez le nom de votre document à télécharger.', 'gosselink'),
							'required' => 1,
							'default_value' => __('Télécharger le document', 'gosselink'),
						),
						array(
							'key' => 'field_5891b6aa48685',
							'label' => __('Description du document à télécharger', 'gosselink'),
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
							'required' => 0,
						),
						array(
							'key' => 'field_5891b6bb48686',
							'label' => __('Description du document', 'gosselink'),
							'name' => 'doc_description',
							'type' => 'textarea',
							'instructions' => '',
						),
						array(
							'key' => 'field_5891b6d448687',
							'label' => __('Document à téléchargement', 'gosselink'),
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
						),
						array(
							'key' => 'field_5891b6da48688',
							'label' => __('Document à télécharger', 'gosselink'),
							'name' => 'doc_link',
							'type' => 'file',
							'instructions' => __('Télécharger le document dans la bibliothèque de médias.', 'gosselink'),
							'required' => 1,
							'return_format' => 'url',
							'library' => 'all',
							'min_size' => '',
							'max_size' => 30,
							'mime_types' => '',
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
