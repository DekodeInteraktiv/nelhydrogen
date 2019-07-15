<?php

$form_popup = ( ! is_page_template( 'page-templates/contact.php' ) );
$form_id    = get_field( 'contact_form', 'options' );

if ( $form_id && function_exists( 'gravity_form' ) ) {

	$fields = array();
	$before = '';
	$after  = '';

	if ( $form_popup ) {
		$before = '<div id="contact-form" class="mfp-hide mfp-contact-form">';
		$after  = '</div>';
	}

	echo $before;

	if ( current_user_can( 'edit_options' ) ) {

		if ( get_post_type() == 'product' ) {

			$division_key = '';
			$term         = nel_get_main_term( get_the_ID(), 'product_category' );
			if ( $term ) {
				$division_key = get_field( 'division_select', $term );
				$division     = nel_get_division( $division_key );
				if ( $division ) {
					?>
                    <div class="popup-header">
                        <h3><?php echo $division['title']; ?></h3>
                        <p><?php echo do_shortcode( '[email]' . $division['email'] . '[/email]' ); ?></p>
                        <p><?php echo $division['phone']; ?></p>
                        <p><?php echo $division['fax']; ?></p>
                        <div><?php echo $division['address']; ?></div>
                    </div>
					<?php
				}
			}

		}

	}

	gravity_form( $form_id, false, false, false, $fields, true, 100 );

	echo $after;

}