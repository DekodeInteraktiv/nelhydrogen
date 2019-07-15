<?php

namespace ACP\Editing\Model\Post;

use AC;
use ACP\Editing\Model;

/**
 * @property AC\Column\Post\PageTemplate $column
 */
class PageTemplate extends Model {

	public function __construct( AC\Column\Post\PageTemplate $column ) {
		parent::__construct( $column );
	}

	public function get_view_settings() {
		return array(
			'type'    => 'select',
			'options' => array_merge( array( '' => __( 'Default Template' ) ), array_flip( (array) $this->column->get_page_templates() ) ),
		);
	}

	public function save( $id, $value ) {
		update_post_meta( $id, '_wp_page_template', $value );

		acp_editing_helper()->update_post_last_modified( $id );
	}

}