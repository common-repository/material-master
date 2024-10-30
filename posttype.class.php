<?php

/**
 * Description of posttype
 *
 * @author user
 */
class MaterialMaster_PostType {

	/**
	 * Set custom post type.
	 */
	function register_post_type() {

		$labels = array(
			'name'				 => __( 'Materials', MaterialMaster::TEXT_DOMAIN ),
			'singular_name'		 => __( 'Material', MaterialMaster::TEXT_DOMAIN ),
			'all_items'			 => __( 'Materials', MaterialMaster::TEXT_DOMAIN ),
			'new_item'			 => __( 'New material', MaterialMaster::TEXT_DOMAIN ),
			'add_new'			 => __( 'Add New', MaterialMaster::TEXT_DOMAIN ),
			'add_new_item'		 => __( 'Add New material', MaterialMaster::TEXT_DOMAIN ),
			'edit_item'			 => __( 'Edit material', MaterialMaster::TEXT_DOMAIN ),
			'view_item'			 => __( 'View material', MaterialMaster::TEXT_DOMAIN ),
			'search_items'		 => __( 'Search materials', MaterialMaster::TEXT_DOMAIN ),
			'not_found'			 => __( 'No materials found', MaterialMaster::TEXT_DOMAIN ),
			'not_found_in_trash' => __( 'No materials found in trash', MaterialMaster::TEXT_DOMAIN ),
			'parent_item_colon'	 => __( 'Parent material', MaterialMaster::TEXT_DOMAIN ),
			'menu_name'			 => __( 'Material Master', MaterialMaster::TEXT_DOMAIN ),
		);

		$options = array(
			'label'					 => __( 'Material Master', MaterialMaster::TEXT_DOMAIN ),
			'description'			 => __( 'Material Master', MaterialMaster::TEXT_DOMAIN ),
			'labels'				 => $labels,
			'public'				 => true,
			'publicly_queryable'	 => true,
			'hierarchical'			 => false,
			'show_ui'				 => true,
			'show_in_menu'			 => true,
			'show_in_nav_menus'		 => true,
			'menu_position'			 => null,
			'show_in_admin_bar'		 => true,
			'show_in_nav_menus'		 => true,
			'supports'				 => array(
				//'title',
				//'editor',
				'revisions',
			),
			'can_export'			 => true,
			'has_archive'			 => true,
			'rewrite'				 => true,
			'query_var'				 => true,
			'exclude_from_search'	 => false,
			'publicly_queryable'	 => true,
			'capability_type'		 => 'material',
			'map_meta_cap'			 => true,
		);

		register_post_type( MaterialMaster::POST_TYPE, $options );
	}

	/**
	 * Set update messages.
	 * @global type $post
	 * @param type $messages
	 * @return type
	 */
	function updated_messages( $messages ) {
		global $post;

		$permalink = get_permalink( $post );

		$messages[MaterialMaster::POST_TYPE] = array(
			0	 => '', // Unused. Messages start at index 1.
			1	 => sprintf( __( 'Material updated. <a target="_blank" href="%s">View material</a>', MaterialMaster::TEXT_DOMAIN ),
					  esc_url( $permalink ) ),
			2	 => __( 'Custom field updated.', MaterialMaster::TEXT_DOMAIN ),
			3	 => __( 'Custom field deleted.', MaterialMaster::TEXT_DOMAIN ),
			4	 => __( 'Material updated.', MaterialMaster::TEXT_DOMAIN ),
			/* translators: %s: date and time of the revision */
			5	 => isset( $_GET['revision'] ) ? sprintf( __( 'Material restored to revision from %s', MaterialMaster::TEXT_DOMAIN ),
												   wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6	 => sprintf( __( 'Material published. <a href="%s">View material</a>', MaterialMaster::TEXT_DOMAIN ), esc_url( $permalink ) ),
			7	 => __( 'Material saved.', MaterialMaster::TEXT_DOMAIN ),
			8	 => sprintf( __( 'Material submitted. <a target="_blank" href="%s">Preview material</a>', MaterialMaster::TEXT_DOMAIN ),
					  esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
			9	 => sprintf( __( 'Material scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview material</a>',
					  MaterialMaster::TEXT_DOMAIN ),
					// translators: Publish box date format, see http://php.net/date
					  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
			10	 => sprintf( __( 'Material draft updated. <a target="_blank" href="%s">Preview material</a>', MaterialMaster::TEXT_DOMAIN ),
					   esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		);

		return $messages;
	}
	
	
	
	
}
