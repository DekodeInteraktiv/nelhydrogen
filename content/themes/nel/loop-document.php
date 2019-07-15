<?php
global $post;

$type      = '';
$type_name = '';
$doc_terms = wp_get_post_terms( $post->ID, 'media_category' );
$download  = wp_get_attachment_url( $post->ID );

if ( $doc_terms ) {

	$term      = $doc_terms[0];
	$type      = $term->slug;
	$type_name = $term->name;

	if ( get_field( 'category_short_title', $term ) ) {
		$type_name = get_field( 'category_short_title', $term );
	}

	$color = get_field( 'category_color', $term );

}

$ext = pathinfo( $download, PATHINFO_EXTENSION );

?>
<a href="<?php echo $download; ?>" class="column document-list__item" data-filter="<?php echo $type; ?>">
    <div class="Report Report--<?php echo $color; ?> document-list__report">
        <div class="Report__content">
            <div class="Report__logo">
				<?php echo hey_get_inline_svg( '/images/logo.svg' ); ?>
            </div>
            <div class="Report__title">
                <strong class="Report__edition"><?php echo $post->post_title; ?></strong><br>
                <span class="Report__year"><?php echo $type_name; ?></span>
            </div>
        </div>
    </div>
    <p class="document-list__details">
		<?php echo strtoupper( $ext ); ?><br>
		<?php
		$publish_date = get_field( 'publish_date', $post->ID, false );
		echo date( 'd.m.Y', $publish_date ? strtotime( $publish_date ) : $post->post_date );
		?><br>
        <strong class="document-list__download"><?php _e( 'Download', 'nel' ); ?>
            (<?php echo human_filesize( get_attached_file( $post->ID ) ); ?>)</strong>
    </p>
</a>