<?php

function nel_save_cision_article() {

	if ( isset( $_POST['article']['attributes']['Id'] ) ) {

		$cision_id = $_POST['article']['attributes']['Id'];

		// check if post exists
		global $wpdb;
		$query       = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'cision_id' AND meta_value = '{$cision_id}'";
		$post_id     = $wpdb->get_var( $query );
		$post_exists = ( $post_id ) ? is_string( get_post_status( $post_id ) ) : false;

		if ( ! $post_exists ) {

			$timestamp    = strtotime( $_POST['article']['attributes']['PublishDateUtc'] );
			$publish_date = date( 'Y-m-d H:i:s', $timestamp );

			$postarr = array(
				'post_type'     => 'cision_post',
				'post_date_gmt' => $publish_date,
				'post_content'  => $_POST['article']['body'],
				'post_title'    => $_POST['article']['title'],
				'post_status'   => 'publish',
			);

			$post_id = wp_insert_post( $postarr );

			if ( $post_id ) {

				// set cision id
				update_post_meta( $post_id, 'cision_id', $cision_id );

				// 
				update_post_meta( $post_id, 'cision_attributes', $_POST['article']['attributes'] );

				// save attachment links
				if ( count( $_POST['article']['attachments'] ) ) {
					update_post_meta( $post_id, 'cision_files', $_POST['article']['attachments'] );
				}

				// set category
				$term_slug = sanitize_title( $_POST['article']['attributes']['InformationType'] );
				wp_set_object_terms( $post_id, array( $term_slug ), 'cision_category', false );

				// Clear cache once the new article is saved
				if ( function_exists( 'rocket_clean_domain' ) ) {
					rocket_clean_domain();
				}

				$return = array(
					'message'   => 'Post created',
					'ID'        => $post_id,
					'cision_id' => $cision_id,
					'permalink' => get_permalink( $post_id ),
				);

				wp_send_json_success( $return );

			} else {

				$return = array(
					'message' => 'ID not returned from wp_insert_post',
				);

				wp_send_json_error( $return );

			}

		} else {

			$return = array(
				'message'   => 'Post exists',
				'cision_id' => $cision_id,
				'permalink' => get_permalink( $post_id ),
			);

			wp_send_json_success( $return );

		}

	}

	exit;

}

add_action( "wp_ajax_save_cision_article", "nel_save_cision_article" );
add_action( "wp_ajax_nopriv_save_cision_article", "nel_save_cision_article" );


function nel_get_ajax_form() {

	$form_id = $_GET['form_id'];

	if ( $form_id ) {

		$product_wizard_contact_form = get_field( 'product_wizard_contact_form', 'options' );
		$fields                      = array();

		if ( $form_id == $product_wizard_contact_form && isset( $_POST['product_ids'] ) ) {

			global $post;
			$post = get_post( $_POST['product_ids'][0] );
			setup_postdata( $post );

			$fields = array(
				'product_id'   => get_the_ID(),
				'product_name' => get_the_title(),
			);

		}

		echo '<div class="mfp-contact-form">';
		gravity_form( $form_id, false, false, false, $fields, true, 100 );
		echo '</div>';

		exit;

	}

	exit;
}

add_action( "wp_ajax_get_ajax_form", "nel_get_ajax_form" );
add_action( "wp_ajax_nopriv_get_ajax_form", "nel_get_ajax_form" );