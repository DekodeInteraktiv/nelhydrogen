<?php
$positions = get_sub_field( 'positions' );
if ( $positions ) :

	?>
    <section id="section-<?php echo sanitize_title( get_sub_field( 'title' ) ); ?>"
             data-nav-title="<?php the_sub_field( 'title' ); ?>" data-bg="primary"
             class="section--wysiwyg section bg-primary">
        <div data-aos="fade-zoom-in" data-aos-offset="200" data-aos-easing="ease-in-sine" data-aos-duration="300"
             class="row section__content align-center">
            <div class="columns content-column large-10 xlarge-8 medium-text-center">
                <ul class="position-list">
					<?php
					foreach ( $positions as $key => $position ) {
						$flags = '';
						foreach ( $position['flag_select'] as $flag ) {
							$flags .= ' <img class="flag" src="' . get_template_directory_uri() . '/images/flags/' . $flag . '.svg" />';
						}
						$url = $position['url'];
						if ( $position['file'] ) {
							$url = $position['file']['url'];
						}
						echo '<li><a target="_blank" rel="noopener noreferrer" class="btn btn-c btn-small" href="' . $url . '">' . $position['title'] . '' . $flags . '</a></li>';
					}
					?>
                </ul>
                <p><br><a href="#" class="btn btn-a"><?php _e( 'Contact us', 'nel' ); ?></a></p>
            </div>
        </div>
    </section>

<?php

endif;
?>