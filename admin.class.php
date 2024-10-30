<?php

/**
 * Description of shortcodes
 *
 * @author user
 */
class MaterialMaster_Admin {

	function __construct() {
		add_filter( 'manage_' . MaterialMaster::POST_TYPE . '_posts_columns', array(
			$this,
			'set_posts_columns' ) );

		add_action( 'manage_' . MaterialMaster::POST_TYPE . '_posts_custom_column',
			  array(
			$this,
			'edit_posts_columns' ), 10, 2 );

		add_filter( 'manage_edit-' . MaterialMaster::POST_TYPE . '_sortable_columns',
			  array(
			$this,
			'sort_posts_columns'
		) );

		add_action( 'restrict_manage_posts', array(
			$this,
			'filter_posts_columns' ) );

		add_filter( 'bulk_actions-edit-' . MaterialMaster::POST_TYPE, array(
			$this,
			'set_custom_bulk_actions' ) );

		add_action( 'admin_head', array(
			$this,
			'set_admin_head' ) );

		add_action( 'admin_head-post-new.php', array(
			$this,
			'set_admin_head_post' ) );

		add_action( 'admin_head-post.php', array(
			$this,
			'set_admin_head_post' ) );
		add_filter( 'post_row_actions', array(
			$this,
			'set_row_action' ) );

		add_filter( 'wp_insert_post_data', array(
			$this,
			'save_insert_post_data' ), 99, 2 );

		add_filter( 'wp_insert_post_empty_content', array(
			$this,
			'save_pre_post_data' ), 99, 2 );
	}

	function set_posts_columns( $columns ) {

		$newColumns['cb']	 = $columns['cb'];
		$newColumns['title'] = __( 'Material code', MaterialMaster::TEXT_DOMAIN );
		$newColumns['name']	 = __( 'Name', MaterialMaster::TEXT_DOMAIN );
		$newColumns['type']	 = __( 'Material type', MaterialMaster::TEXT_DOMAIN );
		$newColumns['date']	 = $columns['date'];
		return $newColumns;
	}

	function edit_posts_columns( $column, $post_id ) {

		switch ( $column ) {
			case 'name':
				$value = get_post_meta( $post_id, 'name1', true );
				echo $value;
				break;

			case 'type':
				$term = get_the_terms( $post_id, MaterialMaster::TAXONOMY );
				echo $term[0]->name;
				break;

			default:
				break;
		}
	}

	function sort_posts_columns( $columns ) {
		$columns['name'] = 'material_name';
		$columns['type'] = 'material_type';
		return $columns;
	}

	function filter_posts_columns() {
		global $typenow;
		if ( MaterialMaster::POST_TYPE == $typenow ) {

			$args = array(
				'hide_empty'	 => false,
				'hierarchical'	 => true,
				'name'			 => MaterialMaster::TAXONOMY,
				'taxonomy'		 => MaterialMaster::TAXONOMY,
				'value_field'	 => 'name',
			);
			wp_dropdown_categories( $args );
		}
	}

	function set_custom_bulk_actions( $actions ) {
		unset( $actions['edit'] );
		unset( $actions['trash'] );

		return $actions;
	}

	function set_row_action( $actions ) {
		global $post;
		if ( MaterialMaster::POST_TYPE == $post->post_type ) {
			unset( $actions['inline hide-if-no-js'] );
			//unset( $actions['trash'] );
		}
		return $actions;
	}

	function set_admin_head( $param ) {
		$screen = get_current_screen();
		if ( MaterialMaster::POST_TYPE == $screen->post_type ) {
			add_filter( 'months_dropdown_results', '__return_empty_array' );
		}
	}

	function save_insert_post_data( $data, $postarr ) {
		if ( isset( $_POST['post_type'] ) && MaterialMaster::POST_TYPE == $_POST['post_type'] ) {
			$data['post_content'] = '[material_type]' . "\r\n<hr />\r\n" .
					'[material_name]' . "\r\n<hr />\r\n" .
					'[material_unit]' . "\r\n<hr />\r\n" .
					'[material_size]' . "\r\n<hr />\r\n" .
					'[material_weight]' . "\r\n<hr />\r\n" .
					'[material_photo]' . "\r\n<hr />\r\n" .
					'[material_note]' . "\r\n<hr />\r\n" .
					'[material_date]' . "\r\n";

			//Custom Fileds ... Material name1
			$data['post_name']	 = esc_attr( $_POST['fields']['field_55ddb2e35827b'] );
			//Custom Fileds ... Material code
			$data['post_title']	 = esc_attr( $_POST['fields']['field_55d758f1a2ec5'] );
		}

		return $data;
	}

	function save_pre_post_data( $maybe_empty, $postarr ) {

		$e = new WP_Error();

		//var_dump( $postarr );
		if ( isset( $_POST['fields']['field_55ddb2e35827b'] ) ) {
			$materialCode = $_POST['fields']['field_55ddb2e35827b'];

			if ( "" == $materialCode ) {
				return $maybe_empty;
			}
		} else {
			return $maybe_empty;
		}

		// get, now edit post id
		$nowPostId = $postarr['ID'];
		if ( 0 == $nowPostId ) {
			$nowPostId = $postarr['post_parent'];
		}

		// check material code already?
		$query = array(
			'metakey'	 => 'material_code',
			'meta_value' => esc_attr( $materialCode ),
			'post_type'	 => MaterialMaster::POST_TYPE,
		);

		$result = new WP_Query( $query );
		foreach ( $result->posts as $post ) {

			if ( $post->ID != $nowPostId ) {
				if ( $materialCode == get_post_meta( $post->ID, 'material_code', true ) ) {

					$materialLink = sprintf( '<a href="%s">%s</a>' . "\r\n", $post->guid, $post->post_title
					);

					$e->add( 'error',
			  'Material Master : ' .
							__( 'Material code is already : ', MaterialMaster::TEXT_DOMAIN )
							. $materialLink );
				}
			}
		}

		if ( $e->get_error_messages() ) {
			set_transient( MaterialMaster::NOTICE_ERROR, $e->get_error_messages(), 5 );
		}
		return $maybe_empty;
	}

	function set_admin_head_post() {

		global $post;
		if ( MaterialMaster::POST_TYPE == $post->post_type ) {
			echo '<style type="text/css">#material-type-tabs .hide-if-no-js {display:none;}</style>';
		}

		return;
	}

}
