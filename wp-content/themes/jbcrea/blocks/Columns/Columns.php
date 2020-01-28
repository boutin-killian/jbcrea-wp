<?php

namespace Gosselink\Blocks\Columns;

use Gosselink\Entity\GKBlock;
use Gosselink\Settings\ACF\TechnicalOptions;

class Columns
{

	/** @var GKBlock */
	private $block;

	/**
	 * Columns constructor.
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
			'key' => 'gk_flexi_columns',
			'name' => 'text_column',
			'label' => __('Texte (en colonne 1, 2, 3 ou 4)', 'gosselink'),
			'display' => 'block',
			'fields' => array(
				array(
					'key' => 'field_5b97dd1b82ca3',
					'label' => __('Titre de la section', 'gosselink'),
					'name' => 'section_title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
				),
				array(
					'key' => 'field_58a16f174efa8',
					'label' => __('Texte', 'gosselink'),
					'name' => 'text',
					'type' => 'repeater',
					'instructions' => '',
					'collapsed' => '',
					'min' => 1,
					'max' => 4,
					'layout' => 'block',
					'button_label' => __('Ajouter une colonne', 'gosselink'),
					'sub_fields' => array(
						array(
							'key' => 'field_5e29b8a554d1e',
							'label' => __('Titre','gosselink'),
							'name' => 'block_titre',
							'type' => 'text',
							'required' => 0,
							'conditional_logic' => 0,
						),
						array(
							'key' => 'field_5e29b88954d1d',
							'label' => __('Image','gosselink'),
							'name' => 'block_image',
							'type' => 'image',
							'required' => 0,
							'conditional_logic' => 0,
							'return_format' => 'array',
							'preview_size' => 'medium',
							'library' => 'all',
						),
						array(
							'key' => 'field_58a16f264efa9',
							'label' => __('Texte en colonnes', 'gosselink'),
							'name' => 'block_column',
							'type' => 'wysiwyg',
							'required' => 1,
							'default_value' => '',
							'tabs' => 'all',
							'toolbar' => 'full',
							'media_upload' => 1,
							'delay' => 0,
						),
					),
				),
				TechnicalOptions::get_theme_colors() ? array(
					'key' => 'field_5b97ddbd9229f',
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
