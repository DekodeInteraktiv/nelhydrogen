<?php

/* 
Debug Bar for Gravity Forms No-Conflict Mode
*/
add_filter( 'gform_noconflict_scripts', 'debug_bar_add_gf_noconflict' );
add_filter( 'gform_noconflict_styles', 'debug_bar_add_gf_noconflict' );
function debug_bar_add_gf_noconflict( $items ) {
	$items[] = 'debug-bar';

	return $items;
}

//

add_filter( 'gform_pre_render', 'nel_set_gform_division' );
add_filter( 'gform_pre_validation', 'nel_set_gform_division' );
add_filter( 'gform_pre_submission_filter', 'nel_set_gform_division' );
add_filter( 'gform_admin_pre_render', 'nel_set_gform_division' );

function nel_set_gform_division( $form ) {

	foreach ( $form['fields'] as &$field ) {

		if ( $field->type == 'select' && $field->inputName == 'division' ) {

			// Situation | Situation | Kontakttyp
			$choices   = array(
				array(
					'text'  => 'Select',
					'value' => '',
				)
			);
			$divisions = get_field( 'divisions', 'options' );
			foreach ( $divisions as $division ) {
				$choices[] = array(
					'text'  => $division['title'],
					'value' => $division['key']
				);
			}

			$field->choices      = $choices;
			$field->defaultValue = '';
			$field->cssClass     = 'division-select';

		}

		// Render shortcodes for checkob labels
		if ( $field->type == 'checkbox' ) {
			foreach ( $field->choices as $key => $choice ) {
				$field->choices[ $key ]['text'] = do_shortcode( $choice['text'] );
			}
		}

		// if ($field->inputName == 'product_id') {
		// 	if (get_post_type()=='product') {
		// 		global $post;
		// 		write_log($post->post_title);
		// 		write_log($field);
		// 	}
		// }

		// if ($field->inputName == 'product_name') {

		// }

	}

	return $form;

}


//

function nel_get_gform_division_field( $form ) {
	foreach ( $form['fields'] as $field ) {
		if ( $field->type == 'select' && $field->inputName == 'division' ) {
			return $field;
		}
	}
}

function nel_send_notification_to_correct_division( $notification, $form, $entry ) {

	$field = nel_get_gform_division_field( $form );

	if ( $field && isset( $entry[ $field->id ] ) ) {
		$division_key = $entry[ $field->id ];
		$division     = nel_get_division( $division_key );
		if ( $division ) {
			$notification['to'] = $division['email'];
		} else {
			$notification['message'] = 'Could not find division. ' . print_r( $entry, true );
		}
	}

	return $notification;

}

add_filter( 'gform_notification', 'nel_send_notification_to_correct_division', 10, 3 );


function product_wizard_form_custom_header( $tag, $form ) {
	$product_wizard_contact_form = get_field( 'product_wizard_contact_form', 'options' );
	if ( $product_wizard_contact_form && $product_wizard_contact_form == $form['id'] ) {
		if ( get_post_type() == 'product' ) {
			$tag .= '
			<header class="gform_heading gform_heading--custom">
				<div class="gform_heading__text">
					<h3>' . __( 'Product inquiry' ) . '<br>
					<span class="primary">' . get_the_title() . '</span></h3>
				</div>';
			if ( has_post_thumbnail() ) {
				$image_id = get_post_thumbnail_id();
				$tag      .= '<div class="gform_heading__image">';
				$tag      .= wp_get_attachment_image( $image_id, 'medium' );
				$tag      .= '</div>';
			}
			$tag .= '</header>';
		}
	}

	return $tag;
}

add_filter( 'gform_form_tag', 'product_wizard_form_custom_header', 10, 2 );

function custom_confirmation( $confirmation, $form, $entry, $ajax ) {
	if ( isset( $confirmation['redirect'] ) ) {
		return $confirmation;
	}
	$message = '<div class="gform-confirmation-outer-wrap">';
	$message .= $confirmation;
	$message .= '</div>';

	return $message;
}

add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );




