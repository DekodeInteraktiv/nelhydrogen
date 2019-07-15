<?php
/*
Template Name: Hydrogen
*/
?>
<?php get_header(); ?>

<?php
if ( ! post_password_required() ) {
	?>

    <article>

        <div class="bg-black">
            <div id="scrollmagic" class="bg-black loading">

                <div class="sm-panels">
					<?php

					$panels = nel_get_hydrogen_slides();
					foreach ( $panels as $key => $panel ) {
						if ( isset( $panel['before'] ) ) {
							echo $panel['before'];
						}
						// .section
						?>
                        <div class="trigger-top-<?php echo $key; ?> sm-panel <?php echo $panel['classes']; ?>">
                            <div class="container content-wrap text-<?php echo $key; ?> trigger-<?php echo $key; ?>">
								<?php echo $panel['content']; ?>
                            </div>
                        </div>
						<?php
						if ( isset( $panel['after'] ) ) {
							echo $panel['after'];
						}

					}

					?>
                    <div class="outro-trigger"></div>
                </div>

                <div class="text-flicker">
					<?php
					foreach ( $panels as $key => $panel ) {
						echo '<div class="before text-panel text-panel-' . $key . '">
							<div class="row align-center">
								<div class="columns medium-8 large-6">' . $panel['subtitle'] . '</div>
							</div>
						</div>';
					}
					?>
                </div>

                <div class="sm-scene">

                    <div class="inner">

                        <div id="space" class="galaxy galaxy-scrollmagic"></div>

                        <div id="illustrations">

                            <div class="sun-scene">
                                <div class="sun"></div>
                                <div class="sun-label"><?php _e( '¾ of the Sun is made from hydrogen.', 'nel' ); ?></div>
                            </div>

                            <div class="earth-scene">

                                <div class="earth">
                                    <img class="globe"
                                         src="<?php echo get_template_directory_uri(); ?>/images/hydrogen/earth.png"
                                         alt="Globe">
                                    <img class="filter"
                                         src="<?php echo get_template_directory_uri(); ?>/images/hydrogen/earth-red.png"
                                         alt="Globe">
                                    <img class="renewable"
                                         src="<?php echo get_template_directory_uri(); ?>/images/hydrogen/energy-fossil.png"
                                         alt="Fossil fuel">
                                    <img class="fossil"
                                         src="<?php echo get_template_directory_uri(); ?>/images/hydrogen/energy-renewable.png"
                                         alt="Renewable energy">
                                    <div class="counter-year h3"></div>
                                    <div class="counter-co2">
										<?php _e( 'CO<sub>2</sub> concentration (ppm)', 'nel' ); ?><br><span
                                                class="count h3"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="water-cycle-wrap">
                                <div class="water-cycle">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/hydrogen/water-cycle.png"
                                         alt="Renewable energy">
                                </div>
                            </div>

                            <div class="energy-density">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/hydrogen/energy-density.png"
                                     alt="Energy density">
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="bg-default sm-panels-after">
			<?php get_template_part( 'partials/blocks' ); ?>
        </div>

    </article>

<?php } else {

	get_template_part( 'partials/post-password' );

} ?>


<?php get_footer(); ?>