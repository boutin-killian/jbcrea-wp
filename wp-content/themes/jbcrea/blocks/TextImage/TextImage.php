<?php

namespace JBCrea\Blocks\TextImage;

use JBCrea\Entity\GKBlock;
use JBCrea\Settings\ACF\TechnicalOptions;

class TextImage {

	/** @var GKBlock */
	private $block;

	/**
	 * TextImage constructor.
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
			'key' => 'gk_flexi_text_image',
			'name' => 'text_and_picture',
			'label' => __('Texte et image', 'gosselink'),
			'fields' => array(
				array(
					'key' => 'field_587ce188de772',
					'label' => __('Texte et image', 'gosselink'),
					'name' => 'text_picture',
					'type' => 'repeater',
					'instructions' => '',
					'collapsed' => 'field_587ce1dbde774',
					'layout' => 'block',
					'button_label' => __('Ajouter un bloc texte + image', 'gosselink'),
					'sub_fields' => array(
						array(
							'key' => 'field_587ce1dbde774',
							'label' => __('Paragraphe', 'gosselink'),
							'name' => 'paragraph',
							'type' => 'wysiwyg',
							'instructions' => '',
							'required' => 0,
						),
						array(
							'key' => 'field_5bc6fec0b6b48',
							'label' => 'Ajouter un bouton ?',
							'name' => 'add_button',
							'type' => 'true_false',
						),
						array(
							'key' => 'field_5bc6fed6b6b49',
							'label' => __('Bouton', 'gosselink'),
							'name' => 'button',
							'type' => 'link',
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5bc6fec0b6b48',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'return_format' => 'array',
						),
						array(
							'key' => 'field_5a0568dd926ac',
							'label' => __('Souhaitez-vous une image', 'gosselink'),
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
							'key' => 'field_34626abcbcbc232',
							'label' => __('Type d\'image', 'gosselink'),
							'name' => 'image_type',
							'type' => 'radio',
							'instructions' => '',
							'required' => 0,
							'wrapper' => array(
								'width' => '50',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'image' => __('Image', 'gosselink'),
								'slider' => __('Slider', 'gosselink'),
							),
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5a0568dd926ac',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'default_value' => 0,
							'ui' => 1,
						),
						array(
							'key' => 'field_587ce1e8de775',
							'label' => __('Image', 'gosselink'),
							'name' => 'image',
							'type' => 'image',
							'instructions' => __('Dimensions préconisées : 720 × 640', 'gosselink'),
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5a0568dd926ac',
										'operator' => '==',
										'value' => '1',
									),
									array(
										'field' => 'field_34626abcbcbc232',
										'operator' => '==',
										'value' => 'image',
									),
								),
							),
							'wrapper' => array(
								'width' => '50',
								'class' => '',
								'id' => '',
							),
						),
						array(
							'key' => 'field_58acb1e8de445',
							'label' => __('Slider', 'gosselink'),
							'name' => 'slider',
							'type' => 'repeater',
							'layout' => 'row',
							'sub_fields' => array(
								array(
									'key' => 'slider_image',
									'label' => __('Image', 'gosselink'),
									'name' => 'slider_image',
									'type' => 'image',
									'required' => 1,
									'instructions' => '',
								),
							),
							'wrapper' => array(
								'width' => '50',
								'class' => '',
								'id' => '',
							),
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5a0568dd926ac',
										'operator' => '==',
										'value' => '1',
									),
									array(
										'field' => 'field_34626abcbcbc232',
										'operator' => '==',
										'value' => 'slider',
									),
								),
							),
						),
						array(
							'key' => 'field_587ce48d876df',
							'label' => __('Position', 'gosselink'),
							'name' => 'order',
							'type' => 'select',
							'instructions' => __('Choisissez la position de votre image', 'gosselink'),
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5a0568dd926ac',
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
						TechnicalOptions::get_theme_colors() ? array(
							'key' => 'field_5b8e656c6d674',
							'label' => __('Couleur de la section', 'gosselink'),
							'name' => 'color',
							'type' => 'select',
							'choices' => TechnicalOptions::get_theme_colors(),
							'return_format' => 'value',
						) : NULL,
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
