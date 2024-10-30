<?php

/*
  Plugin Name: Material Master
  Version: 0.1.20150909
  Description: Material Management
  Author: YANO Yasuhiro
  Author URI: https://plus.google.com/u/0/+YANOYasuhiro/
  Plugin URI: https://github.com/yyano/wp-material-master
  Text Domain: material-master
  Domain Path: /languages
 */

/**
 * MaterialMaster
 */
class MaterialMaster {

	const TEXT_DOMAIN	 = 'material-master';
	const POST_TYPE	 = 'material';
	const TAXONOMY	 = 'material-type';
	const NOTICE_ERROR = 'material_error';

	var $shortcodes;
	var $posttype;
	var $taxonomy;
	var $acfFileds;

	/**
	 * construct
	 */
	function __construct() {

		require_once 'posttype.class.php';
		$this->posttype = new MaterialMaster_PostType();

		require_once 'taxonomy.class.php';
		$this->taxonomy = new MaterialMaster_Taxonomy();

		require_once 'acf_fields.class.php';
		$this->acfFileds = new MaterialMaster_ACF();
		// Need 'Advanced Custom Fields' plugin.
		if ( function_exists( "register_field_group" ) ) {
			$this->acfFileds->register_field_group();
		}

		// Onetime hooks
		register_activation_hook( __FILE__, array(
			&$this,
			'plugin_activation' ) );

		register_deactivation_hook( __FILE__, array(
			&$this,
			'plugin_deactivation' ) );

		register_uninstall_hook( __FILE__, array(
			'MaterialMaster',
			'plugin_uninstall' ) );

		// Any-time Action/filter
		add_action( 'init', array(
			$this,
			'material_init' ) );

		add_filter( 'post_updated_messages', array(
			&$this->posttype,
			'updated_messages' ) );

		add_action( 'admin_notices', array(
			$this,
			'show_admin_notices' ) );

		add_action( 'wp_terms_checklist_args', array(
			$this->taxonomy,
			'set_wp_terms_checklist_args' ) );

		// Shortcodes.
		$this->acfFileds->set_shortcodes();

		// Admin screen
		require_once 'admin.class.php';
		$admin = new MaterialMaster_Admin();
		
		// ShortCodes
		require_once 'shortcode.class.php';
		$shortcode = new MaterialMaster_Shortcode();
	}

	/**
	 * Plugin activation.
	 */
	function plugin_activation() {
		$groups = array(
			'material_viewer',
			'material_editor',
			'material_creater',
		);

		//add role group.
		foreach ( $groups as $group ) {
			add_role( $group, ucfirst( str_replace( '_', ' ', $group ) ) );
		}

		$groups[] = 'administrator';

		//add role
		foreach ( $groups as $group ) {
			$wpRoles = new WP_Roles();
			$role	 = $wpRoles->get_role( $group );

			switch ( $group ) {
				case 'administrator':
				case 'material_creater':
					$role->add_cap( 'delete_material' );

					$role->add_cap( 'edit_private_materials' );
					$role->add_cap( 'read_private_materials' );

					$role->add_cap( 'delete_materials' );
					$role->add_cap( 'delete_private_materials' );
					$role->add_cap( 'delete_published_materials' );
					$role->add_cap( 'delete_others_materials' );

					$role->add_cap( 'publish_materials' );

				case 'material_editor':
					$role->add_cap( 'edit_material' );
					$role->add_cap( 'edit_materials' );
					$role->add_cap( 'edit_published_materials' );
					$role->add_cap( 'edit_others_materials' );

				case 'material_viewer':
					$role->add_cap( 'read_material' );
					$role->add_cap( 'read' );

				default:
					break;
			}
		}
	}

	/**
	 * Plugin deactivation.
	 */
	function plugin_deactivation() {
		
	}

	/**
	 * Plugin uninstall.
	 */
	function plugin_uninstall() {
		$groups = array(
			'material_viewer',
			'material_editor',
			'material_creater',
		);

		foreach ( $groups as $group ) {
			remove_role( $group );
		}
	}

	/**
	 * initialize
	 */
	function material_init() {
		$this->posttype->register_post_type();
		$this->taxonomy->register_taxonomy();
	}

	/**
	 * Show admin notice messages.
	 */
	function show_admin_notices() {
		if ( $messages = get_transient( self::NOTICE_ERROR ) ) {
			echo '<div class="error"><ul>';
			foreach ( $messages as $message ) {
				printf( '<li>%s</li>', $message );
			}
			echo '</ul></div>';
		}
	}

}

if ( class_exists( 'MaterialMaster' ) ) {
	$MaterialMaster = new MaterialMaster();
}


/*
 * Todo
 *　done		・カテゴリーのラジオボタン化
 *				→ コードの整理
 *　done		・入力値チェック
 *　・一覧出力
 *　done		・slug代入
 *　done		・タイトル代入
 *	done	・本文代入
 * 
 */