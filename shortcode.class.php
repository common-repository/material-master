<?php

/**
 * Description of shortcode
 *
 * @author user
 */
class MaterialMaster_Shortcode {

	const SHORTCODE_MATERIAL_LIST = 'Material-List';

	function __construct() {
		add_shortcode( self::SHORTCODE_MATERIAL_LIST, array(
			$this,
			'set_shortcode_material_list' ) );
	}

	function set_shortcode_material_list( $atts ) {

		$atts = shortcode_atts( array(
			'type'			 => null,
			'sort_field'	 => 'material_code',
			'sort_direction' => 'ASC',
				), $atts, self::SHORTCODE_MATERIAL_LIST );

		$args = array(
			'post_type' => MaterialMaster::POST_TYPE,
			'meta_key' => $atts['sort_field'],
			'orderby' => 'meta_value_num',
			'order' => $atts['sort_direction'],
		);

		if ( !is_null( $atts['type'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy'			 => MaterialMaster::TAXONOMY,
					'field'				 => 'name',
					'terms'				 => $atts['type'],
					'include_children'	 => false,
				) );
		}

		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			$posts = $query->get_posts();

			$html .= '<table>' . "\r\n";
			$html .= '<tr>';
			$html .= '<th>code</th>'
					. '<th>name</th>'
					. '<th>type</th>';
			$html .= '</tr>' . "\r\n";
			$html .= '<tbody>' . "\r\n";

			foreach ( $posts as $post ) {
				$terms = get_the_terms( $post->ID, MaterialMaster::TAXONOMY );
				var_dump( $terms );

				$html .= sprintf( '<tr><td><a href="%s">%s</a></td>'
						. '<td>%s<br />%s</td>'
						. '<td>%s</td>'
						. '</tr>' . "\r\n", $post->guid, get_post_meta( $post->ID, 'material_code', true ),
													  get_post_meta( $post->ID, 'name1', true ), get_post_meta( $post->ID, 'name2', true ), $terms[0]->name
				);
			}

			$html .= '</tbody>' . "\r\n";
			$html .= '</table>' . "\r\n";
		}

		return $html;
	}

}
