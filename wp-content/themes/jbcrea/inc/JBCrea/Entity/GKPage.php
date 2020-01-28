<?php

namespace JBCrea\Entity;

class GKPage extends GKPost
{
	/**
	 * @param array $templates
	 */
	public function __construct($templates)
	{
		parent::__construct();

		$this->templates = $templates;
	}

}