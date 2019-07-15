<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php get_template_part( 'partials/header' ); ?>

	<?php if ( $post->post_content && ! get_field( 'hide_header' ) ) : ?>
        <div class="container">
            <div class="row entry-content pad-bottom align-center">
                <div class="columns medium-10 large-8 wysiwyg">
					<?php the_content(); ?>
                </div>
            </div>
        </div>
	<?php endif; ?>

	<?php get_template_part( 'partials/blocks' ); ?>

	<?php
	if ( get_post_type() == 'cision_post' ) {

		?>

        <div class="container">
            <div class="row align-center">
                <div class="columns medium-10 large-8">
					<?php
					$attachments = get_post_meta( get_the_ID(), 'cision_files', true );
					if ( $attachments ) {
						?>
                        <div class="row columns pad-bottom">
							<?php
							echo '<h4>' . _x( 'Related documents', 'Documents attached to Cision article', 'nel' ) . '</h4>';
							echo '<ul class="filelist cision-filelist">';
							foreach ( $attachments as $key => $attachment ) {
								echo '<li class="file"><a class="icon-file" title="' . __( 'Download', 'nel' ) . '" target="_blank" href="' . $attachment['url'] . '">' . $attachment['title'] . ' (' . pathinfo( $attachment['filename'], PATHINFO_EXTENSION ) . ')</a></li>';
							}
							echo '</ul>';
							?>
                        </div>
						<?php
					}
					?>
                    <div class="row columns pad-bottom">
                        <h4><?php _ex( 'Share on', 'Social sharing links', 'nel' ); ?></h4>
                        <div class="share-links">
							<?php get_share_links(); ?>
                        </div>
						<?php
						$cision_attributes = get_post_meta( get_the_ID(), 'cision_attributes', true );
						if ( $cision_attributes ) {
							if ( isset( $cision_attributes['CisionWireUrl'] ) ) {
								?>
                                <p class="small meta mt">
									<?php
									echo __( 'This article was originally posted on news.cision.com.', 'nel' );
									echo '<a target="_blank" rel="noopener noreferrer" href="' . $cision_attributes['CisionWireUrl'] . '">' . __( 'View original article', 'nel' ) . '</a>';
									?>
                                </p>
								<?php
							}
						}
						?>
                    </div>

                </div>
            </div>
        </div>

		<?php

	}
	?>

</article>