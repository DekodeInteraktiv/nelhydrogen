<?php

if ( is_tax() ) {
	$acf_id = get_queried_object();
} else {
	$acf_id = get_the_ID();
}

$faqs = get_field( 'faq', $acf_id );
if ( $faqs ) {
	?>
    <div id="faq" class="section">
        <div class="section__content">
            <header class="row text-center section__header">
                <div class="column">
                    <h3><?php _e( 'Frequently asked questions', 'nel' ); ?></h3>
                </div>
            </header>
            <div class="row">
                <div class="column">
                    <ul class="accordion" data-accordion data-allow-all-closed="true" data-multi-expand="true">
						<?php
						foreach ( $faqs as $key => $faq ) {
							?>
                            <li class="accordion-item" data-accordion-item>
                                <a href="#" class="accordion-title"><?php echo $faq['title']; ?></a>
                                <div class="accordion-content" data-tab-content>
									<?php echo $faq['content']; ?>
                                </div>
                            </li>
							<?php
						}
						?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
	<?php
}
?>