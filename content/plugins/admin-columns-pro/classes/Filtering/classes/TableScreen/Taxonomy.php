<?php

namespace ACP\Filtering\TableScreen;

use ACP\Filtering\TableScreen;

class Taxonomy extends TableScreen {

	public function __construct( array $models ) {
		parent::__construct( $models );

		add_action( "in_admin_footer", array( $this, 'render_markup' ) );
	}

	public function render_markup() {

		// We set the orderby, because filtering will only work for hierarchical taxonomies when there is no default sorting
		$orderby = ! empty( $_REQUEST['orderby'] ) ? $_REQUEST['orderby'] : 'name';

		?>
		<div class="acp_tax_filters">

			<?php parent::render_markup(); ?>

			<input type="hidden" name="orderby" value="<?php echo esc_attr( $orderby ); ?>">
			<input type="submit" name="acp_filter_action" class="button" value="<?php echo esc_attr( __( 'Filter', 'codepress-admin-columns' ) ); ?>">
		</div>
		<?php
	}

}