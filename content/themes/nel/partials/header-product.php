<header class="page-header container">
    <div class="row align-middle">

        <div class="text-column column small-12 medium-6 large-6">
			<?php
			$label    = get_field( 'label' );
			$subtitle = get_field( 'subtitle' );
			if ( $label ) {
				echo '<p class="page-header__label label">' . $label . '</p>';
			}
			?>
            <h1 class="page-header__title">
				<?php the_title(); ?>
            </h1>
			<?php
			if ( $subtitle ) {
				echo '<p class="page-header__subtitle">' . $subtitle . '</p>';
			}
			?>
            <div class="wysiwyg page-header__excerpt">
				<?php
				if ( ! $post->post_content ) {
					the_excerpt();
				} else {
					the_content();
				}
				?>
            </div>
        </div>

        <div class="image-column columns small-12 medium-6 large-6">
			<?php
			if ( has_post_thumbnail() ) {
				$image_id = get_post_thumbnail_id();
				echo '<div class="page-header__image">';
				echo wp_get_attachment_image( $image_id, 'large' );
				echo '</div>';
			}
			?>
        </div>

    </div>
</header>