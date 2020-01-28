<?php

namespace JBCrea\Entity;

use Timber\PostQuery;

class GKArchive extends GKPost
{

	/**
	 * @param array $templates
	 */
	public function __construct($templates)
	{
		parent::__construct();

		$this->templates = $templates;

		$this->addToContext('posts', new PostQuery());
	}

}