<?php

namespace JBCrea\Entity;

use Timber\Term;

class GKTaxonomy extends GKPost
{

	/**
	 * @param array $templates
	 */
	public function __construct($templates)
	{
		parent::__construct();

		$this->templates = $templates;

		$this->addToContext('term', new Term());
	}

}