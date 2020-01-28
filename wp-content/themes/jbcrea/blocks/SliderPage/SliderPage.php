<?php

namespace JBCrea\Blocks\SliderPage;

use JBCrea\Entity\GKBlock;

class SliderPage
{

	/** @var GKBlock */
	private $block;

	/**
	 * SliderPage constructor.
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
			'key' => 'group_gk_slider',
			'name' => 'slider_page',
			'label' => __('Slider', 'gosselink'),
			'fields' => array(
				array(
					'key' => 'field_gk_slider_slider',
					'label' => __('Slider', 'gosselink'),
					'name' => 'gk_slider',
					'type' => 'repeater',
					'instructions' => __('Insérez un diaporama.', 'gosselink'),
					'collapsed' => 'slider_image',
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_slider_image',
							'label' => __('Image', 'gosselink'),
							'name' => 'slider_image',
							'type' => 'image',
							'required' => 1,
							'instructions' => '',
						),
						array(
							'key' => 'slider_show_details',
							'label' => 'Afficher détails',
							'name' => 'slider_show_details',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'default_value' => 0,
							'ui' => 1,
						),
						array(
							'key' => 'slider_title',
							'label' => 'Titre',
							'name' => 'slider_title',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'slider_show_details',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'tabs' => 'all',
							'toolbar' => 'basic',
							'media_upload' => 0,
							'delay' => 0,
						),
						array(
							'key' => 'slider_description',
							'label' => 'Description',
							'name' => 'slider_description',
							'type' => 'wysiwyg',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'slider_show_details',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'tabs' => 'all',
							'toolbar' => 'basic',
							'media_upload' => 0,
							'delay' => 0,
						),
						array(
							'key' => 'slider_link',
							'label' => 'Lien',
							'name' => 'slider_link',
							'type' => 'link',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'slider_show_details',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'return_format' => 'array',
						),
					),
				),
			),
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
