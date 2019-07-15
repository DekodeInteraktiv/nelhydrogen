<?php

namespace ACP\Settings\Column;

use AC;

class FeaturedImageDisplay extends AC\Settings\Column
	implements AC\Settings\FormatValue {

	/**
	 * @var string
	 */
	private $featured_image_display;

	protected function define_options() {
		return array(
			'featured_image_display' => 'true_false',
		);
	}

	public function create_view() {
		$select = $this->create_element( 'select' );

		$select->set_attribute( 'data-refresh', 'column' )
		       ->set_options( array(
			       'count'      => _x( 'Count', 'Number/count of items' ),
			       'title'      => __( 'Title' ),
			       'true_false' => __( 'True / False', 'codepress-admin-columns' ),
		       ) );

		$view = new AC\View( array(
			'label'   => __( 'Field Type', 'codepress-admin-columns' ),
			'setting' => $select,
		) );

		return $view;
	}

	public function get_featured_image_display() {
		return $this->featured_image_display;
	}

	/**
	 * @param $featured_image_display
	 *
	 * @return bool
	 */
	public function set_featured_image_display( $featured_image_display ) {
		$this->featured_image_display = $featured_image_display;

		return true;
	}

	public function format( $value, $original_value ) {
		switch ( $this->get_featured_image_display() ) {
			case 'count':
				$value = count( $value );

				break;
			case 'title':
				$values = array();

				foreach ( $value as $id ) {
					$post = get_post( $id );
					$values[] = ac_helper()->html->link( get_edit_post_link( $post ), $post->post_title );
				}

				$value = implode( ac_helper()->html->divider(), $values );

				break;
			case 'true_false':
				$value = count( $value ) ? ac_helper()->icon->yes() : false;

				break;

		}

		return $value;
	}

}