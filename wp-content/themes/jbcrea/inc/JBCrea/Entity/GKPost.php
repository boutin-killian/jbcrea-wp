<?php

namespace JBCrea\Entity;

use Timber\Post;
use Timber\Timber;

class GKPost
{

	/**
	 * @var Post $post
	 */
	protected $post;

	/**
	 * @var array $templates
	 */
	protected $templates = array();

	/**
	 * @var array $context
	 */
	protected $context = array();

	/**
	 * GKPost constructor.
	 */
	public function __construct()
	{
		$this->post = new Post();

		$this->templates = array(
			'single-' . $this->post->ID . '.twig',
			'single-' . $this->post->post_type . '.twig',
			'single.twig'
		);

		$this->context = Timber::get_context();

		$this->addToContext( 'post', $this->post );
	}

	public function render(){
		Timber::render( $this->templates, $this->context );
	}

	public function __toString()
	{
		return Timber::compile($this->templates, $this->context) ?: '';
	}

	/**
	 * @return Post
	 */
	public function getPost()
	{
		return $this->post;
	}

	/**
	 * @param Post $post
	 */
	public function setPost($post)
	{
		$this->post = $post;
	}

	/**
	 * @return array
	 */
	public function getTemplates()
	{
		return $this->templates;
	}

	/**
	 * @param array $template
	 */
	public function addTemplate($template)
	{
		$this->templates[] = $template;
	}

	/**
	 * @return array
	 */
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * @param $key
	 * @param $value
	 */
	public function addToContext($key, $value)
	{
		$this->context[$key] = $value;
	}


}