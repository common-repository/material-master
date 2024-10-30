<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of taxonomy
 *
 * @author user
 */
class MaterialMaster_Taxonomy {

	function register_taxonomy() {

		$labels = array(
			'name'						 => __( 'Material types', MaterialMaster::TEXT_DOMAIN ),
			'singular_name'				 => _x( 'Material type', 'taxonomy general name', MaterialMaster::TEXT_DOMAIN ),
			'search_items'				 => __( 'Search material types', MaterialMaster::TEXT_DOMAIN ),
			'popular_items'				 => __( 'Popular material types', MaterialMaster::TEXT_DOMAIN ),
			'all_items'					 => __( 'All material types', MaterialMaster::TEXT_DOMAIN ),
			'parent_item'				 => __( 'Parent material type', MaterialMaster::TEXT_DOMAIN ),
			'parent_item_colon'			 => __( 'Parent material type:', MaterialMaster::TEXT_DOMAIN ),
			'edit_item'					 => __( 'Edit material type', MaterialMaster::TEXT_DOMAIN ),
			'update_item'				 => __( 'Update material type', MaterialMaster::TEXT_DOMAIN ),
			'add_new_item'				 => __( 'New material type', MaterialMaster::TEXT_DOMAIN ),
			'new_item_name'				 => __( 'New material type', MaterialMaster::TEXT_DOMAIN ),
			'separate_items_with_commas' => __( 'Material types separated by comma', MaterialMaster::TEXT_DOMAIN ),
			'add_or_remove_items'		 => __( 'Add or remove material types', MaterialMaster::TEXT_DOMAIN ),
			'choose_from_most_used'		 => __( 'Choose from the most used material types', MaterialMaster::TEXT_DOMAIN ),
			'menu_name'					 => __( 'Material types', MaterialMaster::TEXT_DOMAIN ),
		);

		$args = array(
			'hierarchical'		 => true,
			'public'			 => true,
			'show_in_nav_menus'	 => true,
			'show_ui'			 => true,
			'show_admin_column'	 => true,
			'query_var'			 => true,
			'rewrite'			 => false,
			'capabilities'		 => array(
				'manage_terms'	 => 'edit_materials',
				'edit_terms'	 => 'edit_materials',
				'delete_terms'	 => 'edit_materials',
				'assign_terms'	 => 'edit_materials'
			),
			'labels'			 => $labels,
		);

		register_taxonomy( 'material-type', MaterialMaster::POST_TYPE, $args );
	}

	function set_wp_terms_checklist_args( $args, $post_id = null ) {
		$args['checked_ontop'] = false;
		$args['walker'] = new MaterialMaster_Taxonomy_Checklist();
		return $args;
	}	
}

//thnks http://liginc.co.jp/programmer/archives/4137
//thnks http://chaika.hatenablog.com/entry/2015/06/08/210000
require_once(ABSPATH . '/wp-admin/includes/template.php');
class MaterialMaster_Taxonomy_Checklist extends Walker_Category_Checklist{

	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

		if ( $args['taxonomy'] == 'category' ){
			$args['name'] = 'post_category';
		} else {
			$args['name'] = 'tax_input['.$args['taxonomy'].']';
		}

		$output .= "\n<li id='{$args['taxonomy']}-{$category->term_id}'>";
		$output .= '<label class="selectit">';
		$output	.= '<input value="' . $category->term_id . '" type="radio" name="'.$args['name'].'[]" id="in-'.$args['taxonomy'].'-' . $category->term_id . '"' . checked( in_array( $category->term_id, $args['selected_cats'] ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters('the_category', $category->name )) . '</label>';
	}
}




