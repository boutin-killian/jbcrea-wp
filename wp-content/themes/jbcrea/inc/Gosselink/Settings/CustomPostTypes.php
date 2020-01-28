<?php

namespace Gosselink\Settings;
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * User: studio21
 * Date: 19/04/2018
 * Time: 17:27
 */

class CustomPostTypes
{

	function __construct() {
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
	}

	function register_post_types() {
		//this is where you can register custom post types

		$labels = array(
			'name'                => _x( 'Projets', 'Post Type General Name', 'gosselink' ),
			'singular_name'       => _x( 'Projet', 'Post Type Singular Name', 'gosselink' ),
			'menu_name'           => __( 'Projets', 'gosselink' ),
			'parent_item_colon'   => __( 'Projet parent', 'gosselink' ),
			'all_items'           => __( 'Tous les projets', 'gosselink' ),
			'view_item'           => __( 'Voir le projet', 'gosselink' ),
			'add_new_item'        => __( 'Ajouter un nouveau projet', 'gosselink' ),
			'add_new'             => __( 'Ajouter', 'gosselink' ),
			'edit_item'           => __( 'Modifier le projet', 'gosselink' ),
			'update_item'         => __( 'Mettre à jour le projet', 'gosselink' ),
			'search_items'        => __( 'Rechercher un projet', 'gosselink' ),
			'not_found'           => __( 'Introuvable', 'gosselink' ),
			'not_found_in_trash'  => __( 'Introuvable dans la corbeille', 'gosselink' ),
		);

		$args = array(
			'label'               => __( 'projets', 'gosselink' ),
			'description'         => __( 'Projets', 'gosselink' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
			'taxonomies'          => array(  ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 24,
			'menu_icon'           => 'dashicons-format-image',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
			'rewrite'             => array(
				'slug'  =>  'projets',
				'with_front' => false
			),
		);

		register_post_type( 'project', $args );
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

}