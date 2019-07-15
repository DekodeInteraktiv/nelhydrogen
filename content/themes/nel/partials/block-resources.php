<?php
$resources = get_field( 'resources' );
if ( $resources ) :
	?>
    <section id="resources" data-magellan-target="resources" class="section">
        <div class="row section__content align-middle">
            <div class="columns large-6">
                <img src="<?php echo get_template_directory_uri(); ?>/images/Brochures.png"
                     alt="<?php _e( 'Brochure icon', 'nel' ); ?>"/>
            </div>
            <div class="columns large-6">
                <h3><?php _e( 'Resources', 'nel' ); ?></h3>
                <p>
                <ul>
					<?php foreach ( $resources as $key => $resource ) {
						$title = ( $resource['title'] ) ? $resource['title'] : $resource['file']['title'];
						?>
                        <li>
                            <a target="_blank" href="<?php echo $resource['file']['url']; ?>"><?php echo $title; ?></a>
                        </li>
					<?php } ?>
                </ul>
                </p>
                <p>
                    <a href="<?php echo home_url( '/about/#documents-and-brochures' ); ?>"><?php _e( 'Visit our brochure section', 'nel' ); ?></a>
                </p>
            </div>
        </div>
    </section>
<?php
endif;
?>