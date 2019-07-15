<?php

$image_id = get_post_thumbnail_id();
$image    = $image_id ? wp_get_attachment_image( $image_id, 'large' ) : false;

$title = get_field( 'title' );
$terms = wp_get_post_terms( get_the_ID(), 'person_category' );

?>
<article class="Article">

    <header class="Article__header container">
        <div class="row columns">
			<?php
			if ( $terms ) {
				echo '<div class="Article__breadcrumb">' . terms_to_links( $terms ) . '</div>';
			}
			?>
            <h1 class="Article__title"><?php the_title(); ?></h1>
			<?php
			if ( $title ) {
				echo '<div class="Article__meta">' . $title . '</div>';
			}
			?>
        </div>
    </header>

    <div class="Article__content container">

        <div class="row align-center">

			<?php if ( $image ) { ?>
                <div class="Article__image columns small-12 medium-10 large-6">
					<?php echo $image; ?>
                </div>
			<?php } ?>

            <div class="columns small-12 medium-10 large-6 wysiwyg">
				<?php the_content(); ?>
            </div>

        </div>

    </div>

</article>