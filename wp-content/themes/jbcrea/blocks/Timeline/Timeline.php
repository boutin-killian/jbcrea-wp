<?php

namespace Gosselink\Blocks\Timeline;

use Gosselink\Entity\GKBlock;

class Timeline
{

	/** @var GKBlock */
	private $block;

	/**
	 * Timeline constructor.
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
			'key' => 'gk_flexi_timeline',
			'name' => 'timeline',
			'label' => __('Frise historique', 'gosselink'),
			'display' => 'row',
			'fields' => array(
				array(
					'key' => 'field_5d026f4985558',
					'label' => __('Titre de la frise', 'gosselink'),
					'name' => 'title_timeline_section',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
				),
				array(
					'key' => 'field_5d026f6485559',
					'label' => __('Texte d\'introduction de la frise', 'gosselink'),
					'name' => 'text_timeline_section',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
				),
				array(
					'key' => 'field_57179f475c6d4',
					'label' => __('Historique', 'gosselink'),
					'name' => 'timeline_block',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'collapsed' => 'field_57179f595c6d5',
					'min' => 0,
					'max' => 0,
					'layout' => 'block',
					'button_label' => 'Ajouter un élément',
					'sub_fields' => array(
						array(
							'key' => 'field_57179f595c6d5',
							'label' => __('Date', 'gosselink'),
							'name' => 'dated',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '50',
								'class' => '',
								'id' => '',
							),
						),
						array(
							'key' => 'field_5b0808f061448',
							'label' => __('Titre de l\'événement', 'gosselink'),
							'name' => 'event_title',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '50',
								'class' => '',
								'id' => '',
							),
						),
						array(
							'key' => 'field_57179f645c6d6',
							'label' => __('Evénement', 'gosselink'),
							'name' => 'event',
							'type' => 'wysiwyg',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'new_lines' => 'br',
						),
						array(
							'key' => 'field_571a23b812ca6',
							'label' => __('Image', 'gosselink'),
							'name' => 'event_image',
							'type' => 'image',
							'instructions' => '',
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
