<header class="page-header page-header--old container">
    <div class="row align-center">
        <div class="columns medium-text-center large-10 xlarge-8">
            <div class="row">
                <div class="column small-12">
					<?php
					if ( has_post_thumbnail() ) {
						$image_id = get_post_thumbnail_id();
						echo '<div class="page-header__image">';
						echo wp_get_attachment_image( $image_id, 'full' );
						echo '</div>';
					}
					?>
					<?php
					// $label = get_field('label');
					// if ($label) {
					// 	echo '<p class="page-header__label label">'.$label.'</p>';
					// }
					?>
					<?php
					$subtitle = get_the_title();
					echo '<p class="page-header__subtitle">' . $subtitle . '</p>';
					?>
                    <h1 class="page-header__title">
						<?php the_field( 'subtitle' ); ?>
                    </h1>
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
            </div>
        </div>
    </div>
</header>