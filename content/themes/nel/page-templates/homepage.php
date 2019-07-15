<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>

<?php get_template_part( 'partials/homepage-hero' ); ?>

<?php get_template_part( 'partials/homepage-nav' ); ?>

<?php get_template_part( 'partials/blocks' ); ?>

<?php
$featured_post = get_field( 'featured_article' );
if ( $featured_post ) :
	?>
    <!-- FEATURED POST SECTION -->
    <section class="latest-news section bg-primary container">
        <div class="row section__content">
            <div class="column">
				<?php
				$term = wp_get_post_terms( $featured_post->ID, 'category' );
				echo '<span>' . $term[0]->name . '</span>';
				echo '<h2><a title="' . esc_attr( $featured_post->post_title ) . '" href="' . get_permalink( $featured_post->ID ) . '">' . $featured_post->post_title . '</a></h2>';
				?>
            </div>
        </div>
		<?php
		if ( has_post_thumbnail( $featured_post->ID ) ) {
			$image_id = get_post_thumbnail_id( $featured_post->ID );
			$bgset    = hey_get_attachment_image_bgset( $image_id, 'full' );
			echo '<div class="bg-image lazyload" ' . $bgset . '></div>';
		}
		?>
    </section>
<?php endif; ?>

<?php get_footer(); ?>