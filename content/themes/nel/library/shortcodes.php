<?php

function wpe_secure_mail( $atts, $content = null ) {
	return '<a title="' . __( 'Open email client', 'nel' ) . '" class="email" href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
}

add_shortcode( 'email', 'wpe_secure_mail' );

function wpe_privacy_link( $atts, $content = null ) {
	$policy_page_id = get_option( 'wp_page_for_privacy_policy' );
	if ( ! empty( $policy_page_id ) && get_post_status( $policy_page_id ) === 'publish' ) {
		return '<a title="' . esc_attr( $content ) . '" rel="noopener noreferrer" target="_blank" href="' . get_permalink( $policy_page_id ) . '">' . $content . '</a>';
	}

	return $content;
}

add_shortcode( 'privacy_link', 'wpe_privacy_link' );

function sh_render_video_popup( $atts, $content ) {
	$id = md5( $atts['url'] );

	return '
	<a class="btn btn-a btn-play open-popup-link-video" href="#' . $id . '">' . $content . '</a>
	<div id="' . $id . '" class="mfp-hide">
		<div class="video-wrap">
			<video controls>
				<source src="' . $atts['url'] . '" type="video/mp4">
				Your browser does not support HTML5 video.
			</video>
		</div>
	</div>';
}

add_shortcode( 'video-popup', 'sh_render_video_popup' );

/*
Prevent Wordpress from replacing quotes and screwing up nested shortcodes
*/
remove_filter( 'the_content', 'wptexturize' );

function wpe_data_row( $atts, $content = null ) {
	return '<div class="data-row medium-text-center data-row-' . $atts['type'] . ' row small-up-1 medium-up-3">' . apply_filters( 'the_content', $content ) . '</div>';
}

add_shortcode( 'row', 'wpe_data_row' );

function wpe_data_column( $atts, $content = null ) {
	return '<div class="column"><span class="title">' . $atts['value'] . '</span><span class="description">' . $atts['text'] . '</span></div>';
}

add_shortcode( 'column', 'wpe_data_column' );


function wpe_grid_column( $atts, $content = null ) {
	return '<div class="column small-12 large-6 wysiwyg">' . apply_filters( 'the_content', $content ) . '</div>';
}

add_shortcode( 'grid-column', 'wpe_grid_column' );

function wpe_grid_row( $atts, $content = null ) {
	return '<div class="row">' . apply_filters( 'the_content', $content ) . '</div>';
}

add_shortcode( 'grid-row', 'wpe_grid_row' );


function wpe_get_template_as_var( $template, $atts = array() ) {

	global $tmpl_atts;
	$tmpl_atts = $atts;

	ob_start();
	get_template_part( $template );
	$content = ob_get_contents();
	ob_end_clean();

	return $content;

}

function wpe_render_cision_form() {
	return wpe_get_template_as_var( 'partials/cision-form' );
}

add_shortcode( 'cision-form', 'wpe_render_cision_form' );

function wpe_render_chart() {
	return wpe_get_template_as_var( 'partials/manamind-shareholders' );
}

add_shortcode( 'shareholders', 'wpe_render_chart' );


function wpe_render_people( $atts ) {
	return wpe_get_template_as_var( 'partials/people', $atts );
}

add_shortcode( 'people', 'wpe_render_people' );


function wpe_render_ir_feed( $atts, $content ) {
	if ( isset( $atts['id'] ) ) {
		ob_start();
		if ( $atts['id'] == 'chart' ) {
			get_template_part( 'partials/manamind', 'chart' );
		} elseif ( $atts['id'] == 'tabs' ) {
			get_template_part( 'partials/manamind', 'tabs' );
		} elseif ( $atts['id'] == 'cision_minifeed' ) {
			get_template_part( 'partials/cision', 'minifeed' );
		} else {
			get_manamind_feed( $atts['id'] );
		}
		$return = ob_get_contents();
		ob_end_clean();

		return $return;//print_r($atts, TRUE);
	}
}

add_shortcode( 'ir_feed', 'wpe_render_ir_feed' );


function wpe_render_webcast( $atts, $content ) {
	return '<div class="aspect small-aspect-webcast webcast-embed"><div class="aspect-content">' . $content . '</div></div>';
}

add_shortcode( 'webcast', 'wpe_render_webcast' );


function nel_render_scroll_button( $atts = array(), $content = null ) {
	$defaults = array(
		'title' => 'Scroll down'
	);
	$atts     = wp_parse_args( $atts, $defaults );

	return "<button data-component='ScrollIndicator' title='{$atts['title']}' class='btn btn-a btn-circle scrollto'>&darr;</button>";
}

add_shortcode( 'scroll_button', 'nel_render_scroll_button' );
