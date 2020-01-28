<?php

namespace JBCrea\Blocks\FAQ;

use JBCrea\Entity\GKBlock;
use JBCrea\Settings\ACF\TechnicalOptions;

class FAQ {

	/** @var GKBlock */
	private $block;

	/**
	 * FAQ constructor.
	 */
	public function __construct($block) {
		$this->block = $block;

		$this->addACFFields();
	}

	/**
	 * Deal with ACF fields for this block
	 */
	function addACFFields() {

		acf_add_local_field_group(array(
			'key' => 'gk_flexi_faq',
			'name' => 'faq',
			'label' => __('FAQ', 'gosselink'),
			'display' => 'block',
			'fields' => array(
				array(
					'key' => 'field_5b082ae6e9509',
					'label' => __('Titre du bloc "FAQ"', 'gosselink'),
					'name' => 'block_title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
				),
				array(
					'key' => 'field_5b7c1f04c15df',
					'label' => __('Texte d\'introduction', 'gosselink'),
					'name' => 'block_intro',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'basic',
					'media_upload' => 0,
					'delay' => 0,
				),
				array(
					'key' => 'field_5b068833be54c',
					'label' => __('Ajouter une image ?', 'gosselink'),
					'name' => 'wish',
					'type' => 'true_false',
					'instructions' => '',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_5b068833be54b',
					'label' => __('Image', 'gosselink'),
					'name' => 'image',
					'type' => 'image',
					'instructions' => __('Dimensions préconisées : 720 × 640', 'gosselink'),
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b068833be54c',
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
					'return_format' => 'array',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '0.6',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5b068833be54d',
					'label' => __('Position de l\'image', 'gosselink'),
					'name' => 'order',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
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
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b068833be54c',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5d08eab97567a',
					'label' => 'Format de l\'image',
					'name' => 'img_format',
					'type' => 'true_false',
					'instructions' => 'Choisissez le rendu de votre image',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b068833be54c',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => 'Pleine',
					'ui_off_text' => 'Contrainte',
				),
				array(
					'key' => 'field_5b057df1e1ecd',
					'label' => __('Questions', 'gosselink'),
					'name' => 'faq_block',
					'type' => 'repeater',
					'instructions' => '',
					'collapsed' => '',
					'min' => 0,
					'max' => 0,
					'layout' => 'row',
					'button_label' => __('Ajouter une question', 'gosselink'),
					'sub_fields' => array(
						array(
							'key' => 'field_5b057df1e1ece',
							'label' => __('Question', 'gosselink'),
							'name' => 'question',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
						),
						array(
							'key' => 'field_5b057df1e1ecf',
							'label' => __('Réponse', 'gosselink'),
							'name' => 'answer',
							'type' => 'wysiwyg',
							'instructions' => '',
							'required' => 1,
							'default_value' => '',
							'tabs' => 'all',
							'toolbar' => 'basic',
							'media_upload' => 0,
							'delay' => 0,
						),
					),
				),
				TechnicalOptions::get_theme_colors() ? array(
					'key' => 'field_5b8e9c072eac8',
					'label' => __('Couleur de la section', 'gosselink'),
					'name' => 'color',
					'type' => 'select',
					'choices' => TechnicalOptions::get_theme_colors(),
					'return_format' => 'value',
				) : NULL,
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
