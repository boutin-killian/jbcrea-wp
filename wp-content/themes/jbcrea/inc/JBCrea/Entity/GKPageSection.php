<?php

namespace JBCrea\Entity;

use Timber\Post;

class GKPageSection extends GKPage
{
	/**
	 * @var string $id
	 */
	private $id;

	/**
	 * @var string $class
	 */
	private $class;

	/**
	 * @var string $nextLink
	 */
	private $nextLink = "";

	/**
	 * @var boolean $isPopup
	 */
	private $isPopup = false;

	/**
	 * GKPageSection constructor.
	 * @param \WP_Post $post
	 * @param string $id
	 * @param string $class
	 */
	public function __construct($post, $id, $class)
	{
		$template = get_page_template_slug($post);

		if ($template !== ''){
			$template = 'pages/' . str_replace('.php', '.twig', strtolower($template));
		}else if ($post->ID == get_option('page_for_posts')){
			$template = 'blog.twig';
		}else{
			$template = 'page.twig';
		}

		parent::__construct(array($template));

		$this->post = new Post($post);
		$this->id = $id;
		$this->class = $class;

		$this->addToContext( 'post', $this->post );
		$this->addToContext( 'one_page_section' , true );
		$this->addToContext( 'section' , $this );
        $this->addToContext( 'data' , get_fields($this->post) );
	}

	/**
	 * @return string
	 */
	public function getLink()
	{
		return "#" . $this->getId();
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getClass()
	{
		return $this->class;
	}

	/**
	 * @param string $class
	 */
	public function setClass($class)
	{
		$this->class = $class;
	}

	/**
	 * @return string
	 */
	public function getNextLink()
	{
		return $this->nextLink;
	}

	/**
	 * @param string $nextLink
	 */
	public function setNextLink($nextLink)
	{
		$this->nextLink = $nextLink;
	}

	/**
	 * @return bool
	 */
	public function isPopup()
	{
		return $this->isPopup;
	}

	/**
	 * @param bool $isPopup
	 */
	public function setIsPopup($isPopup)
	{
		$this->isPopup = $isPopup;
	}

}