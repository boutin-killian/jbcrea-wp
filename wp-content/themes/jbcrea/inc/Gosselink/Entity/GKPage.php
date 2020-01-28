<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 17/10/2018
 * Time: 09:36
 */

namespace Gosselink\Entity;

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