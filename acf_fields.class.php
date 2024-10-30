<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of acf_fields
 *
 * @author user
 */
class MaterialMaster_ACF {

	function __construct() {
		$this->check_installed_plugins();
	}

	/**
	 * check installed & activeted plugins.
	 */
	function check_installed_plugins() {

		if ( !function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$e = new WP_Error();

		$plugin_check_ACF	 = false;
		$all_plugins		 = get_plugins();
		foreach ( $all_plugins as $pluginFile => $pluginValue ) {
			if ( is_plugin_active( $pluginFile ) ) {
				if ( 'Advanced Custom Fields' == $pluginValue['Name'] ) {
					$plugin_check_ACF = true;
				}
			}
		}

		if ( !$plugin_check_ACF ) {
			$e->add( 'error',
			'Material Master : ' . __( 'No activate "Advanced Custom Fields" plugin.', MaterialMaster::TEXT_DOMAIN ) );
		}

		//$aaa = $e->get_error_messages();
		if ( $e->get_error_messages() ) {
			set_transient( MaterialMaster::NOTICE_ERROR, $e->get_error_messages(), 10 );
		}
	}

	/**
	 * Set custom fields for custom posttype.
	 */
	function register_field_group() {

		$location = array(
			array(
				array(
					'param'		 => 'post_type',
					'operator'	 => '==',
					'value'		 => MaterialMaster::POST_TYPE,
					'order_no'	 => 0,
					'group_no'	 => 0,
				),
			),
		);

		$options = array(
			'position'		 => 'normal',
			'layout'		 => 'default',
			'hide_on_screen' => array(
				0	 => 'permalink',
				//1	 => 'the_content',
				2	 => 'excerpt',
				3	 => 'custom_fields',
				4	 => 'discussion',
				5	 => 'comments',
				//6	 => 'revisions',
				7	 => 'slug',
				8	 => 'author',
				9	 => 'format',
				10	 => 'featured_image',
				11	 => 'categories',
				12	 => 'tags',
				13	 => 'send-trackbacks',
			),
		);

		$args_material_type = array(
			'id'		 => 'acf_material-type',
			'title'		 => __( 'Material Type', MaterialMaster::TEXT_DOMAIN ),
			'fields'	 => $this->set_cutsom_field_group_type(),
			'location'	 => $location,
			'options'	 => $options,
			'menu_order' => 1100,
		);
		register_field_group( $args_material_type );

		$args_material_name = array(
			'id'		 => 'acf_material-name',
			'title'		 => __( 'Material Name', MaterialMaster::TEXT_DOMAIN ),
			'fields'	 => $this->set_cutsom_field_group_name(),
			'location'	 => $location,
			'options'	 => $options,
			'menu_order' => 1200,
		);
		register_field_group( $args_material_name );

		$args_material_unit = array(
			'id'		 => 'acf_material-unit',
			'title'		 => __( 'Material-Unit', MaterialMaster::TEXT_DOMAIN ),
			'fields'	 => $this->set_cutsom_field_group_unit(),
			'location'	 => $location,
			'options'	 => $options,
			'menu_order' => 1300,
		);
		register_field_group( $args_material_unit );

		$args_material_size = array(
			'id'		 => 'acf_material-size',
			'title'		 => __( 'Material-Size', MaterialMaster::TEXT_DOMAIN ),
			'fields'	 => $this->set_cutsom_field_group_size(),
			'location'	 => $location,
			'options'	 => $options,
			'menu_order' => 1400,
		);
		register_field_group( $args_material_size );

		$args_material_weight = array(
			'id'		 => 'acf_material-weight',
			'title'		 => __( 'Material-Weight', MaterialMaster::TEXT_DOMAIN ),
			'fields'	 => $this->set_cutsom_field_group_weight(),
			'location'	 => $location,
			'options'	 => $options,
			'menu_order' => 1500,
		);
		register_field_group( $args_material_weight );

		$args_material_photo = array(
			'id'		 => 'acf_material-photo',
			'title'		 => __( 'Material-Photo', MaterialMaster::TEXT_DOMAIN ),
			'fields'	 => $this->set_cutsom_field_group_photo(),
			'location'	 => $location,
			'options'	 => $options,
			'menu_order' => 1600,
		);
		register_field_group( $args_material_photo );

		$args_material_note = array(
			'id'		 => 'acf_material-note',
			'title'		 => __( 'Material-Note', MaterialMaster::TEXT_DOMAIN ),
			'fields'	 => $this->set_cutsom_field_group_note(),
			'location'	 => $location,
			'options'	 => $options,
			'menu_order' => 1700,
		);
		register_field_group( $args_material_note );

		$args_material_date = array(
			'id'		 => 'acf_material-date',
			'title'		 => __( 'Material-Date', MaterialMaster::TEXT_DOMAIN ),
			'fields'	 => $this->set_cutsom_field_group_date(),
			'location'	 => $location,
			'options'	 => $options,
			'menu_order' => 1800,
		);
		register_field_group( $args_material_date );
	}

	public function set_cutsom_field_group_type() {

		$MAX_MATERIAL_CODE_LENGHT = 15;

		$fields = array(
			array(
				'key'			 => 'field_55ddb2e35827b',
				'label'			 => __( 'Material code', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'material_code',
				'type'			 => 'text',
				'required'		 => 1,
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
				'maxlength'		 => $MAX_MATERIAL_CODE_LENGHT,
			),
			array(
				'key'			 => 'field_55d7625fd11e7',
				'label'			 => __( 'Parent material code', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'material_parent_code',
				'type'			 => 'text',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
				'maxlength'		 => $MAX_MATERIAL_CODE_LENGHT,
			),
			array(
				'key'			 => 'field_55dedf5a9e0a7',
				'label'			 => __( 'EAN/JAN', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'material_ean_code',
				'type'			 => 'text',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
				'maxlength'		 => 13,
			) );

		return $fields;
	}

	public function set_cutsom_field_group_name() {

		$MAX_MATERIAL_NAME_LENGHT = 40;

		$fields = array(
			array(
				'key'			 => 'field_55d758f1a2ec5',
				'label'			 => __( 'Name 1', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'name1',
				'type'			 => 'text',
				'required'		 => 1,
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
				'maxlength'		 => $MAX_MATERIAL_NAME_LENGHT,
			),
			array(
				'key'			 => 'field_55d759498285a',
				'label'			 => __( 'Name 2', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'name2',
				'type'			 => 'text',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
				'maxlength'		 => $MAX_MATERIAL_NAME_LENGHT,
			),
			array(
				'key'			 => 'field_55d75a54aa746',
				'label'			 => __( 'Name 3', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'name3',
				'type'			 => 'text',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
				'maxlength'		 => $MAX_MATERIAL_NAME_LENGHT,
			),
			array(
				'key'			 => 'field_55d75a601a69f',
				'label'			 => __( 'Name 4', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'name4',
				'type'			 => 'text',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
				'maxlength'		 => $MAX_MATERIAL_NAME_LENGHT,
			),
		);

		return $fields;
	}

	public function set_cutsom_field_group_unit() {
		$fields = array(
			array(
				'key'			 => 'field_55d75f3ba339c',
				'label'			 => __( 'Material unit', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'material_unit',
				'type'			 => 'select',
				'choices'		 => array(
					'g'		 => 'g',
					'kg'	 => 'kg',
					't'		 => 't',
					'mm'	 => 'mm',
					'cm'	 => 'cm',
					'm'		 => 'm',
					'km'	 => 'km',
					'pc'	 => 'pc',
					'box'	 => 'box',
				),
				'default_value'	 => '',
				'allow_null'	 => 0,
				'multiple'		 => 0,
			),
		);
		return $fields;
	}

	public function set_cutsom_field_group_size() {
		$fields = array(
			array(
				'key'			 => 'field_55d75bee014b1',
				'label'			 => __( 'Size unit', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'size_unit',
				'type'			 => 'select',
				'choices'		 => array(
					'mm'	 => 'mm',
					'cm'	 => 'cm',
					'm'		 => 'm',
					'inch'	 => 'inch',
					'feet'	 => 'feet',
				),
				'default_value'	 => 'mm',
				'allow_null'	 => 1,
				'multiple'		 => 0,
			),
			array(
				'key'			 => 'field_55d75bbf014b0',
				'label'			 => __( 'Width', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'size_width',
				'type'			 => 'number',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'min'			 => '',
				'max'			 => '',
				'step'			 => '',
			),
			array(
				'key'			 => 'field_55d75c523ddb2',
				'label'			 => __( 'Height', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'size_height',
				'type'			 => 'number',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'min'			 => '',
				'max'			 => '',
				'step'			 => '',
			),
			array(
				'key'			 => 'field_55d75c7d3ddb3',
				'label'			 => __( 'Depth', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'size_depth',
				'type'			 => 'number',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'min'			 => '',
				'max'			 => '',
				'step'			 => '',
			),
		);
		return $fields;
	}

	public function set_cutsom_field_group_weight() {
		$fields = array(
			array(
				'key'			 => 'field_55d75cf0081a3',
				'label'			 => __( 'Weight unit', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'weight_unit',
				'type'			 => 'select',
				'choices'		 => array(
					'g'		 => 'g',
					'kg'	 => 'kg',
					't'		 => 't',
					'ounce'	 => 'ounce',
					'pound'	 => 'pound',
				),
				'default_value'	 => 'g',
				'allow_null'	 => 1,
				'multiple'		 => 0,
			),
			array(
				'key'			 => 'field_55d75d6e081a4',
				'label'			 => __( 'Weight', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'weight_value',
				'type'			 => 'number',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'min'			 => '',
				'max'			 => '',
				'step'			 => '',
			),
		);
		return $fields;
	}

	public function set_cutsom_field_group_photo() {
		$fields = array(
			array(
				'key'			 => 'field_55d75e34a070c',
				'label'			 => __( 'Photo 1', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'photo1',
				'type'			 => 'image',
				'save_format'	 => 'object',
				'preview_size'	 => 'thumbnail',
				'library'		 => 'uploadedTo',
			),
			array(
				'key'			 => 'field_55d75e62a070d',
				'label'			 => __( 'Photo 2', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'photo2',
				'type'			 => 'image',
				'save_format'	 => 'object',
				'preview_size'	 => 'thumbnail',
				'library'		 => 'all',
			),
			array(
				'key'			 => 'field_55d75e7607bd1',
				'label'			 => __( 'Photo 3', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'photo3',
				'type'			 => 'image',
				'save_format'	 => 'object',
				'preview_size'	 => 'thumbnail',
				'library'		 => 'all',
			),
		);
		return $fields;
	}

	public function set_cutsom_field_group_note() {

		$fields = array(
			array(
				'key'			 => 'field_Note15d758f1a',
				'label'			 => __( 'Note 1', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'note1',
				'type'			 => 'text',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
			),
			array(
				'key'			 => 'field_Note25d759498',
				'label'			 => __( 'Note 2', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'note2',
				'type'			 => 'text',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
			),
			array(
				'key'			 => 'field_Note35d75a54a',
				'label'			 => __( 'Note 3', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'note3',
				'type'			 => 'text',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
			),
			array(
				'key'			 => 'field_Note45d75a601',
				'label'			 => __( 'Note 4', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'note4',
				'type'			 => 'text',
				'default_value'	 => '',
				'placeholder'	 => '',
				'prepend'		 => '',
				'append'		 => '',
				'formatting'	 => 'none',
			),
		);

		return $fields;
	}

	function set_cutsom_field_group_date() {
		$fields = array(
			array(
				'key'			 => 'field_55e1364daaa15',
				'label'			 => __( 'Registration Date', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'date_registration',
				'type'			 => 'date_picker',
				'date_format'	 => 'yy/mm/dd',
				'display_format' => 'yy/mm/dd',
				'first_day'		 => 1,
			),
			array(
				'key'			 => 'field_55e1364daaa16',
				'label'			 => __( 'Discontinued Date', MaterialMaster::TEXT_DOMAIN ),
				'name'			 => 'date_discontinued',
				'type'			 => 'date_picker',
				'date_format'	 => 'yy/mm/dd',
				'display_format' => 'yy/mm/dd',
				'first_day'		 => 1,
			),
		);

		return $fields;
	}

	function set_shortcodes() {
		add_shortcode( 'material_type', array(
			$this,
			'set_shortcode_material_type' ) );

		add_shortcode( 'material_name', array(
			$this,
			'set_shortcode_material_name' ) );

		add_shortcode( 'material_unit', array(
			$this,
			'set_shortcode_material_unit' ) );

		add_shortcode( 'material_size', array(
			$this,
			'set_shortcode_material_size' ) );

		add_shortcode( 'material_weight', array(
			$this,
			'set_shortcode_material_weight' ) );

		add_shortcode( 'material_photo', array(
			$this,
			'set_shortcode_material_photo' ) );

		add_shortcode( 'material_note', array(
			$this,
			'set_shortcode_material_note' ) );

		add_shortcode( 'material_date', array(
			$this,
			'set_shortcode_material_date' ) );
	}

	function set_shortcode_material_type( $atts ) {

		wp_register_style( 'material-shortcode', plugins_url( 'css/stylesheet.css', __FILE__ ) );

		$html = sprintf( '<h3 class="%s">%s</h3>', 'material-data', __( 'Material Type', MaterialMaster::TEXT_DOMAIN ) );
		$html .= $this->set_shortcode_material( $this->set_cutsom_field_group_type() );

		wp_enqueue_style( 'material-shortcode' );

		return $html;
	}

	function set_shortcode_material_name( $atts ) {

		wp_register_style( 'material-shortcode', plugins_url( 'css/stylesheet.css', __FILE__ ) );

		$html = sprintf( '<h3 class="%s">%s</h3>', 'material-data', __( 'Material Name', MaterialMaster::TEXT_DOMAIN ) );
		$html .= $this->set_shortcode_material( $this->set_cutsom_field_group_name() );

		wp_enqueue_style( 'material-shortcode' );

		return $html;
	}

	function set_shortcode_material_unit( $atts ) {

		wp_register_style( 'material-shortcode', plugins_url( 'css/stylesheet.css', __FILE__ ) );

		$html = sprintf( '<h3 class="%s">%s</h3>', 'material-data', __( 'Material Unit', MaterialMaster::TEXT_DOMAIN ) );
		$html .= $this->set_shortcode_material( $this->set_cutsom_field_group_unit() );

		wp_enqueue_style( 'material-shortcode' );

		return $html;
	}

	function set_shortcode_material_size( $atts ) {

		wp_register_style( 'material-shortcode', plugins_url( 'css/stylesheet.css', __FILE__ ) );

		$html = sprintf( '<h3 class="%s">%s</h3>', 'material-data', __( 'Material Size', MaterialMaster::TEXT_DOMAIN ) );
		$html .= $this->set_shortcode_material( $this->set_cutsom_field_group_size() );

		wp_enqueue_style( 'material-shortcode' );

		return $html;
	}

	function set_shortcode_material_weight( $atts ) {

		wp_register_style( 'material-shortcode', plugins_url( 'css/stylesheet.css', __FILE__ ) );

		$html = sprintf( '<h3 class="%s">%s</h3>', 'material-data', __( 'Material Weight', MaterialMaster::TEXT_DOMAIN ) );
		$html .= $this->set_shortcode_material( $this->set_cutsom_field_group_weight() );

		wp_enqueue_style( 'material-shortcode' );

		return $html;
	}

	function set_shortcode_material_photo( $atts ) {

		wp_register_style( 'material-shortcode', plugins_url( 'css/stylesheet.css', __FILE__ ) );

		$html = sprintf( '<h3 class="%s">%s</h3>', 'material-data', __( 'Material Photo', MaterialMaster::TEXT_DOMAIN ) );
		$html .= $this->set_shortcode_material( $this->set_cutsom_field_group_photo() );

		wp_enqueue_style( 'material-shortcode' );

		return $html;
	}

	function set_shortcode_material_note( $atts ) {

		wp_register_style( 'material-shortcode', plugins_url( 'css/stylesheet.css', __FILE__ ) );

		$html = sprintf( '<h3 class="%s">%s</h3>', 'material-data', __( 'Material Note', MaterialMaster::TEXT_DOMAIN ) );
		$html .= $this->set_shortcode_material( $this->set_cutsom_field_group_note() );

		wp_enqueue_style( 'material-shortcode' );

		return $html;
	}

	function set_shortcode_material_date( $atts ) {

		wp_register_style( 'material-shortcode', plugins_url( 'css/stylesheet.css', __FILE__ ) );

		$html = sprintf( '<h3 class="%s">%s</h3>', 'material-data', __( 'Material Date', MaterialMaster::TEXT_DOMAIN ) );
		$html .= $this->set_shortcode_material( $this->set_cutsom_field_group_date() );

		wp_enqueue_style( 'material-shortcode' );

		return $html;
	}

	function set_shortcode_material( $Fields ) {

		$html = '<dl class="material-data">';
		foreach ( $Fields as $field ) {
			switch ( $field['type'] ) {
				case 'image':
					$attacment = get_field( $field['name'] );
					//var_dump($attacment);
					$html .= sprintf( '<dt>%s</dt><dd>', $field['label'] );
					if ( $attacment ) {
						$html .= sprintf( '<a href="%s"><img src="%s" width="%s" height="%s" /></a>',
						$attacment['sizes']['post-thumbnail'], $attacment['sizes']['thumbnail'], $attacment['sizes']['thumbnail-width'],
						$attacment['sizes']['thumbnail-height']
						);
					}
					$html .= '</dd>';
					break;

				default:
					$html .= sprintf( '<dt>%s</dt><dd>%s</dd>', $field['label'], get_field( $field['name'] ) );
					break;
			}
		}
		$html .= '</dl><br clear="all">';
		return $html;
	}

}
