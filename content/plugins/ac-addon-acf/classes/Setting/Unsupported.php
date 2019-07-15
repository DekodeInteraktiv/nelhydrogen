<?php

namespace ACA\ACF\Setting;

use AC;

/**
 * @property \ACA\ACF\Column $column
 */
class Unsupported extends AC\Settings\Column {

	protected function define_options() {
		return array( 'unsupported' );
	}

	public function create_view() {
		$view = new AC\View( array(
			'label'   => false,
			'setting' => $this->get_message(),
		) );

		return $view;
	}

	public function get_message() {
		ob_start();
		?>
		<div class="msg" style="display: block;background-color:#ffba002e">
			<p>
				<strong><?php _e( 'This ACF field is not supported', 'codepress-admin-columns' ); ?></strong>
			</p>

			<p>
				<?php _e( 'This specific ACF field type is not supported in this integration. Although the column may work, it could lead to unexpected behavior. Sorting, Filtering and Inline Editing are disabled for this field.', 'codepress-admin-columns' ); ?>
			</p>

		</div>
		<?php
		return ob_get_clean();
	}

}