<?php
$events = get_sub_field( 'event' );
if ( $events ) :

	?>
    <section id="section-<?php echo sanitize_title( get_sub_field( 'title' ) ); ?>"
             data-nav-title="<?php the_sub_field( 'title' ); ?>" data-bg="black" class="section section-timeline">
        <div class="section__content">
            <header class="row columns medium-text-center">
                <h2><?php _ex( 'Timeline', 'Timeline section title', 'nel' ); ?></h2>
            </header>
            <div class="timeline">

				<?php

				$count = 0;
				foreach ( $events as $key => $event ) {
					if ( $count % 2 ) {
						$oddeven  = "odd";
						$aos_desc = 'fade-left';
						$aos_date = 'fade-right';
					} else {
						$oddeven  = "even";
						$aos_desc = 'fade-right';
						$aos_date = 'fade-left';
					}
					$count ++;
					?>
                    <div class="row <?php echo $oddeven; ?>">
                        <div data-aos="<?php echo $aos_date; ?>" class="year">
                            <h3><?php echo $event['date']; ?></h3>
                        </div>
                        <div data-aos="<?php echo $aos_desc; ?>" class="desc">
							<?php echo $event['description']; ?>
                        </div>
                        <div class="line"></div>
                    </div>
					<?php
				}

				?>

            </div>
        </div>
    </section>

<?php
endif;
