<?php

namespace JBCrea\Entity;

use Timber\Timber;

class GKBlock {

	/**
	 * Logical Name (like "TextImage")
	 * @var
	 */
	private $name;

	/**
	 * Display title (like "Text & Image")
	 * @var
	 */
	private $title;

	public  $slug;
	private $path;
	private $abs_path;
	public  $category;
	private $description;
	private $icon;
	private $keywords;

	const TEMPLATE_FILE = "template.twig";

	public function __construct($name) {
		if (!function_exists("acf_register_block")) {
			return;
		}

		$this->name = $name;
		$this->slug = "gk-" . sanitize_title($name);
		$this->path = "blocks" . DIRECTORY_SEPARATOR . sanitize_file_name($this->name);
		$this->abs_path = get_stylesheet_directory() . DIRECTORY_SEPARATOR . $this->path;

		if (file_exists($this->abs_path . DIRECTORY_SEPARATOR . self::TEMPLATE_FILE)) {
			// Get infos from file
			$file_headers = get_file_data($this->abs_path . DIRECTORY_SEPARATOR . self::TEMPLATE_FILE, [
				'title' => 'Title',
				'category' => 'Category',
				'description' => 'Description',
				'icon' => 'Icon',
				'keywords' => 'Keywords',
			]);

			if (empty($file_headers['title'])) {
				die(_e('Ce bloc nécessite un "Title": ' . $this->name));
			}
			if (empty($file_headers['category'])) {
				die(_e('Ce bloc nécessite une "Category": ' . $this->name));
			}

			$this->title = $file_headers['title'];
			$this->category = array(
				'slug' => strtolower(sanitize_title($file_headers['category'])),
				'title' => $file_headers['category'],
			);
			$this->description = $file_headers['description'];
			$this->icon = $file_headers['icon'];
			$this->keywords = $file_headers['keywords'];

			add_filter('block_categories', array($this, 'register_category'), 10, 2);
			add_action('init', array($this, 'register'), 10);
		} else {
			error_log("Le fichier " . $this->path . DIRECTORY_SEPARATOR . self::TEMPLATE_FILE . " n'existe pas. Le bloc ne peut donc pas etre cree. Si ce bloc n'existe plus, il suffit de revalider les blocs Gutenberg des options techniques pour ne plus afficher ce message d'erreur.");
		}
	}

	/**
	 * Register the block category
	 * @param $categories
	 * @param $post
	 * @return array
	 */
	public function register_category($categories, $post) {
		return array_unique(array_merge(
			$categories,
			array(
				array(
					'slug' => $this->category['slug'],
					'title' => $this->category['title'],
				),
			)
		), SORT_REGULAR);
	}

	/**
	 * Register the block itself
	 */
	public function register() {

		// Register a new block
		$data = [
			'name' => $this->slug,
			'title' => $this->title,
			'description' => $this->description,
			'category' => $this->category['slug'],
			'icon' => $this->icon,
			'mode' => 'edit',
			'align' => '',
			'keywords' => explode(' ', $this->keywords),
			'supports' => array('mode' => false),
			'post_types' => array(),
			'render_template' => '',
			'render_callback' => array($this, 'render'),
			'enqueue_style' => false,
			'enqueue_script' => false,
			'enqueue_assets' => false,
		];

		acf_register_block($data);

		// Registering ACF Fields
		try {
			$classname = "\\JBCrea\\Blocks\\{$this->name}\\{$this->name}";
			new $classname($this);
		} catch (Exception $e) {
			error_log("Block " . $this->name . " : class not found => " . $classname);
		}
	}

	/**
	 * Render the block
	 * @param $block
	 */
	public function render($block) {
		$context = Timber::get_context();

		$context["block"] = $block;

		Timber::render(DIRECTORY_SEPARATOR.$this->path.DIRECTORY_SEPARATOR.self::TEMPLATE_FILE, $context);
	}
}
