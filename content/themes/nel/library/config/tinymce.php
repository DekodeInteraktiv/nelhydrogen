<?php

function heydays_add_editor_styles() {
	add_editor_style( array( get_stylesheet_directory_uri() . '/editor-style.css?v=' . time() ) );
}

add_action( 'after_setup_theme', 'heydays_add_editor_styles' );

// Callback function to filter the MCE settings
function heydays_mce_before_init( $settings ) {

	// http://www.tinymce.com/wiki.php/Controls
	// http://codex.wordpress.org/Function_Reference/add_editor_style

	$style_formats = array(
		array(
			'title' => 'Text formats',
			'items' => array(
				array(
					'title'    => 'Lead',
					'selector' => 'p',
					'classes'  => 'lead'
				),
				array(
					'title'    => 'Meta',
					'inline'   => 'span',
					'selector' => 'p,small,span',
					'classes'  => 'meta',
				)
			)
		),
		array(
			'title' => 'Buttons',
			'items' => array(
				array(
					'title'    => 'Purple',
					'selector' => 'a',
					'classes'  => 'btn btn-a',
				),
				array(
					'title'    => 'White',
					'selector' => 'a',
					'classes'  => 'btn btn-b',
				),
				array(
					'title'    => 'Black',
					'selector' => 'a',
					'classes'  => 'btn btn-c',
				),
				array(
					'title'    => 'Small',
					'selector' => '.btn',
					'classes'  => 'btn-small',
				)
			)
		)
	);

	$settings['style_formats_merge'] = false;
	$settings['style_formats']       = json_encode( $style_formats );

	// italic -> not implemented

	$settings['block_formats'] = 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3;Header 4=h4;Header 5=h5;Header 6=h6;';
	// $settings['toolbar1']='styleselect,formatselect,bold,italic,underline,list list--bullets,numlist,blockquote,link,unlink,removeformat,dfw';
	$settings['toolbar1'] = 'styleselect,formatselect,bold,underline,list list--bullets,numlist,blockquote,|,link,unlink,|,table,charmap,superscript,subscript,|,pastetext,removeformat,undo,redo,dfw';
	$settings['toolbar2'] = '';
	$settings['toolbar3'] = '';
	$settings['toolbar4'] = '';

	return $settings;
}

add_filter( 'tiny_mce_before_init', 'heydays_mce_before_init' );


function nel_setup_acf_editors( $acf_editor ) {

	$toolbar            = heydays_mce_before_init( array() );
	$acf_editor['Full'] = array();
	$toolbar            = explode( ',', $toolbar['toolbar1'] );
	array_pop( $toolbar ); // remove distraction free writing from ACF editor
	$acf_editor['Full'][1] = $toolbar;

	return $acf_editor;

}

add_filter( 'acf/fields/wysiwyg/toolbars', 'nel_setup_acf_editors', 10, 1 );