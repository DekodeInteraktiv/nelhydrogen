<?php

// add_filter('acf/format_value/type=wysiwyg', 'format_value_wysiwyg', 10, 3);
// function format_value_wysiwyg( $value, $post_id, $field ) {
// 	$value = apply_filters( 'the_content', $value );
// 	return $value;
// }

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title' => __( 'Global settings' ),
		'menu_title' => __( 'Global' ),
		'menu_slug'  => 'options-general',
		'icon_url'   => 'dashicons-welcome-widgets-menus'
	) );

	acf_add_options_sub_page( array(
		'title'     => 'Contact',
		'menu'      => 'Contact',
		'parent'    => 'options-general',
		'menu_slug' => 'options-contact'
	) );

	acf_add_options_sub_page( array(
		'title'     => 'Product Wizard',
		'menu'      => 'Product Wizard',
		'parent'    => 'options-general',
		'menu_slug' => 'options-product-wizard'
	) );

	acf_add_options_sub_page( array(
		'title'      => 'Admin options',
		'menu'       => 'Admin Options',
		'parent'     => 'options-general',
		'menu_slug'  => 'admin-options',
		'capability' => 'manage_options'
	) );

}


/*
Custom color selector
*/

function my_acf_load_gform_select( $field ) {
	$field['choices'] = array(); // reset choices
	$forms            = RGFormsModel::get_forms( null, 'title' );
	if ( $forms ) :
		foreach ( $forms as $form ):
			$field['choices'][ $form->id ] = $form->title;
		endforeach;
	endif;

	return $field;
}

add_filter( 'acf/load_field/name=gravityform', 'my_acf_load_gform_select' );
add_filter( 'acf/load_field/name=contact_form', 'my_acf_load_gform_select' );
add_filter( 'acf/load_field/name=product_wizard_contact_form', 'my_acf_load_gform_select' );


function my_acf_load_flag_select( $field ) {
	$field['choices'] = array(
		'NO' => 'Norway',
		'DA' => 'Denmark',
		'US' => 'United States',
	);

	return $field;
}

add_filter( 'acf/load_field/name=flag_select', 'my_acf_load_flag_select' );


// post_order

// function my_acf_set_repeater( $value, $post_id, $field ){

// 	write_log($value);
// 	write_log($post_id);
// 	write_log($field);

// 	return $value;
// }
// add_filter('acf/load_value/key=field_5ba347039450f', 'my_acf_set_repeater', 10, 3);


function my_acf_load_field_termsssss( $field ) {

	// write_log($field);
	// $screen = get_current_screen();


	if ( isset( $_GET['taxonomy'] ) && isset( $_GET['tag_ID'] ) ) {
		$term = get_term( $_GET['tag_ID'], $_GET['taxonomy'] );
		if ( $term ) {
			$field['taxonomy'] = array(
				$term->taxonomy . ':' . $term->slug
			);
		}
	} else {
		if ( isset( $_REQUEST['post_id'] ) ) {
			$term_id = str_replace( 'term_', '', $_REQUEST['post_id'] );
			$term    = get_term( $term_id, 'market' );
			if ( $term ) {
				$field['taxonomy'] = array(
					$term->taxonomy . ':' . $term->slug
				);
			}
		}
	}

	return $field;

}

add_filter( 'acf/load_field/key=field_5ba347039450f', 'my_acf_load_field_termsssss' );


// function acf_nav_menu_section_inject($field) {
// 	global $post;
// 	write_log($field);
// 	write_log('Section injection');
// 	return $field;
// }
// add_filter('acf/load_field/name=section_inject', 'acf_nav_menu_section_inject');


function my_acf_load_background_colors( $field ) {
	$field['choices'] = array(
		''            => 'Default (white)',
		'gray'        => 'Gray',
		'medium-gray' => 'Medium Gray',
		'primary'     => 'Purple',
		'secondary'   => 'Deep Purple',
		'black'       => 'Black',
	);

	return $field;
}

add_filter( 'acf/load_field/name=background_color', 'my_acf_load_background_colors' );

function my_acf_load_wysiwyg_layouts( $field ) {
	$field['choices'] = array(
		''       => 'Full width',
		'center' => 'Text centered',
		'left'   => 'Text left',
		'right'  => 'Text right'
	);

	return $field;
}

add_filter( 'acf/load_field/name=wysiwyg_layout', 'my_acf_load_wysiwyg_layouts' );


function my_acf_load_container_aspect_ratios( $field ) {
	$field['choices'] = array(
		''             => 'Content height',
		'widescreen'   => 'Widescreen',
		'landscape'    => 'Landscape',
		'windowheight' => 'Window height'
	);

	return $field;
}

add_filter( 'acf/load_field/name=container_aspect_ratio', 'my_acf_load_container_aspect_ratios' );


function my_acf_load_divisions( $field ) {
	$divisions = get_field( 'divisions', 'options' );
	if ( $divisions ) {
		$field['choices']     = [];
		$field['choices'][''] = '-- Select division --';
		foreach ( $divisions as $key => $division ) {
			$field['choices'][ $division['key'] ] = $division['title'];
		}
	}

	return $field;
}

add_filter( 'acf/load_field/name=division_select', 'my_acf_load_divisions' );


function disable_division_key_after_value( $field ) {
	if ( $field['value'] ) {
		$field['disabled'] = true; // hide field with key field_575c1072fafb8 from non admins => divisions['key']
	}

	return $field;
}

add_filter( 'acf/prepare_field/key=field_575c1072fafb8', 'disable_division_key_after_value' );


// add titles to flexible content
function my_acf_flexible_content_layout_title( $title, $field, $layout, $i ) {

	// https://www.advancedcustomfields.com/resources/acf-fields-flexible_content-layout_title/

	// remove layout title from text
	$nav_title = get_sub_field( 'title' );
	if ( $nav_title ) {
		$title = $nav_title . ' <code>#' . sanitize_title( $nav_title ) . '</code>';
	}

	// $image_id = get_sub_field('image');
	// if ( $image_id ) {
	// 	$image = wp_get_attachment_image_url( $image_id, 'thumbnail' );
	// 	$title .= '<img src="' . $image . '" height="28">';
	// }

	// // load sub field image
	// // note you may need to add extra CSS to the page t style these elements
	// $title .= '<div class="thumbnail">';
	// if( $image = get_sub_field('image') ) {
	// 	$title .= '<img src="' . $image['sizes']['thumbnail'] . '" height="36px" />';	
	// }
	// $title .= '</div>';
	// // load text sub field
	// if( $text = get_sub_field('text') ) {
	// 	$title .= '<h4>' . $text . '</h4>';
	// }


	// return
	return $title;

}

add_filter( 'acf/fields/flexible_content/layout_title/name=blocks', 'my_acf_flexible_content_layout_title', 10, 4 );