<?php
$features     = get_field( 'features' );
$applications = get_field( 'applications_list' );
$resources    = get_field( 'resources' );

if ( $features || $applications || $resources ) :

	?>
    <div class="section section--columns bg-secondary">
        <div class="section__content row">
			<?php if ( $features ) { ?>
                <div id="features" data-magellan-target="features"
                     class="section__column columns small-12 medium-6 large-4">
                    <h3 class="section__column-title"><?php _e( 'Features', 'nel' ); ?></h3>
                    <ul class="media-list media-list--dark media-list--bullets">
						<?php
						foreach ( $features as $key => $feature ) {
							?>
                            <li class="media-list__item">
								<?php echo $feature->name; ?>
                            </li>
							<?php
						}
						?>
                    </ul>
                </div>
			<?php } ?>

			<?php if ( $applications ) { ?>
                <div id="applications" data-magellan-target="applications"
                     class="section__column columns small-12 medium-6 large-4">
                    <h3 class="section__column-title"><?php _e( 'Applications', 'nel' ); ?></h3>
                    <ul class="media-list media-list--dark media-list--bullets">
						<?php
						foreach ( $applications as $key => $application ) {

							if ( ! $application['title'] && ! $application['market'] ) {
								continue;
							}

							$image = '';
							if ( $application['market'] ) {
								$image_ref = get_field( 'featured_image', $application['market'] );
								$image     = wp_get_attachment_image( $image_ref['id'], 'large' );
							}

							$title = $application['title'] ? $application['title'] : $application['market']->name;

							?>
                            <li class="media-list__item">
								<?php echo $title; ?>
                            </li>
							<?php
						}
						?>
                    </ul>
                </div>
			<?php } ?>

			<?php
			if ( $resources ) :
				?>
                <div id="resources" data-magellan-target="resources" class="section__column columns small-12 large-4">
                    <h3 class="section__column-title"><?php _e( 'Resources', 'nel' ); ?></h3>
                    <ul class="media-list media-list--dark">
						<?php foreach ( $resources as $key => $resource ) {
							$title = ( $resource['title'] ) ? $resource['title'] : $resource['file']['title'];
							?>
                            <li class="media-list__item">
                                <a class="media-list__container" target="_blank"
                                   href="<?php echo $resource['file']['url']; ?>">
                                    <div class="media-list__text">
										<?php echo $title; ?>
                                    </div>
                                </a>
                            </li>
						<?php } ?>
                    </ul>
                    <footer class="section__column-footer">
						<?php
						$about_page = get_field( 'page_about', 'options' );
						if ( $about_page ) {
							?>
                            <a class="btn btn-d btn-small"
                               href="<?php echo get_permalink( $about_page->ID ) . '#documents-and-brochures'; ?>"><?php _e( 'Visit our brochure section', 'nel' ); ?></a>
							<?php
						}
						?>
                    </footer>
                </div>
			<?php
			endif;
			?>

        </div>
    </div>
<?php

endif;
