<?php

namespace JBCrea\Service;

use JBCrea\Entity\GKBlock;

class BlocksService
{
	private $custom_blocks;

	function __construct($blocksNames) {

		$this->custom_blocks = array();

		// First, add our own blocks
		foreach ($blocksNames as $name){
			$block = new GKBlock($name);
			$this->custom_blocks[] = "acf/" . $block->slug;
		}

		// Then remove all WP blocks except those needed
		add_filter( 'allowed_block_types', array($this, 'allowed_block_types') );

	}

	/**
	 * Keep only needed blocks
	 * See https://rudrastyh.com/gutenberg/remove-default-blocks.html
	 * @param $allowed_blocks
	 * @return array
	 */
	function allowed_block_types($allowed_blocks) {

		$allowed_blocks = array_merge(
			$this->custom_blocks,
			array(
				'core/image',
				'core/paragraph',
				'core/heading',
				'core/list',
				'core/gallery',
				'core/quote',
				'core/audio',
				'core/cover',
				'core/file',
				'core/video',
				'core/html',
				'core/button',
				'core/text-columns',
				'core/shortcode',
				//'core/archives',
				//'core/categories',
				//'core/latest-comments',
				//'core/latest-posts',
				//'core/calendar',
				//'core/rss',
				//'core/search',
				//'core/embed',
				//'core-embed/twitter',
				'core-embed/youtube',
				//'core-embed/facebook',
				//'core-embed/instagram',
				//'core-embed/wordpress',
				//'core-embed/soundcloud',
				//'core-embed/spotify',
				//'core-embed/flickr',
				//'core-embed/vimeo',
			)
		);

		return $allowed_blocks;

	}


}