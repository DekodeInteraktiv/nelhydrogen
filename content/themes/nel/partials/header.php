<?php

if ( is_tax() ) {
	$acf_id = get_queried_object();
} else {
	$acf_id = get_the_ID();
}

if ( ! get_field( 'hide_header', $acf_id ) ) :

	global $post;

	$title     = get_the_title();
	$intro     = '';
	$post_type = get_post_type();

	if ( is_tax( 'cision_category' ) ) {

		$post  = get_page_by_template( 'page-templates/cision-feed.php' );
		$title = $post->post_title;
		$intro = $post->post_excerpt;

	} elseif ( is_tax() ) {

		$term  = get_queried_object();
		$intro = $term->description;
		$title = $term->name;
		// $title = get_tax_type_object_title($term);


	} elseif ( is_404() ) {

		$title = __( 'Error', 'nel' );

	} elseif ( in_array( $post_type, array( 'post', 'cision_post' ) ) ) {

		$intro = $post->post_excerpt;

	} else {

		$intro = get_field( 'intro', $acf_id );

	}

	?>
    <header class="container page-header medium-text-center">
        <div class="row align-center">
            <div class="columns medium-text-center large-10 xlarge-8">
                <div class="row">
                    <div class="column small-12">
						<?php

						/*
						Featured image
						*/

						$image_id = false;

						if ( is_tax() ) {

						} elseif ( get_post_type() == 'post' ) {

							$terms = wp_get_post_terms( get_the_ID(), 'category' );
							if ( $terms ) {
								$term_links  = array_map( function ( $item ) {
									return '<a href="' . get_term_link( $item ) . '">' . $item->name . '</a>';
								}, $terms );
								$term_links  = implode( ', ', $term_links );
								$meta_string = sprintf( __( 'Published %s in %s', 'nel' ), get_the_date(), $term_links );
							} else {
								$meta_string = sprintf( __( 'Published %s', 'nel' ), get_the_date() );
							}

							echo '<div class="page-header__meta meta">' . $meta_string . '</div>';

						}

						if ( is_tax() ) {

							$image_id = get_field( 'featured_image', $acf_id );

						} elseif ( has_post_thumbnail() ) {

							if ( get_field( 'featured_image', $acf_id ) ) {
								$image_id = get_post_thumbnail_id();
							}

						}

						if ( $image_id ) {
							echo '<div class="page-header__image">';
							echo wp_get_attachment_image( $image_id, 'full' );
							echo '</div>';
						}

						/*
						Breadcrumbs
						*/
						get_template_part( 'partials/breadcrumbs' );

						/*
						Header label
						*/
						if ( get_post_type() == 'page' && ! is_tax() ) {
							$label = get_field( 'label' );
							if ( $label ) {
								echo '<p class="page-header__label label">' . $label . '</p>';
							}
						}

						/*
						Main title
						*/
						?>
                        <h1 class="page-header__title"><?php echo apply_filters( 'the_title', $title ); ?></h1>
						<?php

						/*
						Intro
						*/
						if ( $intro != '' ) {
							?>
                            <div class="page-header__intro lead"><?php echo $intro; ?></div>
							<?php
						}

						?>
                    </div>
                </div>
            </div>
        </div>

		<?php

		ob_start();

		if ( is_tax( 'market' ) ) {
			get_template_part( 'partials/section-nav-market' );
		} elseif ( is_page_template( 'page-templates/documents.php' ) ) {
			get_template_part( 'partials/document-filter-nav' );
		} elseif ( is_page_template( 'page-templates/cision-feed.php' ) || is_tax( 'cision_category' ) ) {
			get_template_part( 'partials/cision-category-nav' );
		}

		$nav = ob_get_contents();
		ob_end_clean();

		if ( $nav ) {
			?>
            <div class="row page-header__nav">
                <div class="columns small-12"><?php echo $nav; ?></div>
            </div>
			<?php
		}

		?>
    </header>

<?php
endif;
?>