<?php

namespace JBCrea\Blocks\Quote;

use JBCrea\Entity\GKBlock;

class Quote {

	/** @var GKBlock */
	private $block;

	/**
	 * Quote constructor.
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
			'key' => 'group_gk_quote',
			'name' => 'quote',
			'label' => __('Citation', 'gosselink'),
			'fields' => array(
				array(
					'key' => 'field_gk_quote',
					'label' => __('La citation', 'gosselink'),
					'name' => 'quote',
					'type' => 'textarea',
					'instructions' => '',
					'wrapper' => array(
						'width' => '60',
						'class' => '',
						'id' => '',
					),
				),
				array(
					'key' => 'field_gk_name',
					'label' => __('Le nom', 'gosselink'),
					'name' => 'name',
					'type' => 'text',
					'instructions' => 'Le nom de la personne à qui appartient cette citation',
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
